<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Media;
use App\Services\Catalog\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
    }

    public function index(Request $request)
    {
        $query = Media::query();

        $folder = $request->get('folder', 'all');
        if ($folder !== 'all') {
            $query->where('folder', $folder);
        }

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        if ($search = $request->get('search')) {
            $query->where('original_name', 'like', "%{$search}%");
        }

        $media = $query->latest()->paginate(16)->withQueryString();

        $folderCounts = Media::select('folder', DB::raw('count(*) as cnt'))->groupBy('folder')->pluck('cnt', 'folder');
        $storageByType = Media::select('type', DB::raw('sum(size) as total'))->groupBy('type')->pluck('total', 'type');

        $stats = [
            'total' => Media::count(),
            'total_size' => Media::sum('size'),
            'by_folder' => $folderCounts,
            'by_type_size' => $storageByType,
        ];

        return view('admin.cms.media.index', compact('media', 'stats', 'folder', 'type', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|max:25600',
            'folder' => 'nullable|in:images,videos,documents,products,banners',
        ]);

        foreach ($request->file('files') as $file) {
            $mime = $file->getMimeType();
            $type = match (true) {
                str_starts_with($mime, 'image/') => 'image',
                str_starts_with($mime, 'video/') => 'video',
                default => 'document',
            };
            $folder = $request->input('folder') ?: ($type === 'image' ? 'images' : ($type === 'video' ? 'videos' : 'documents'));

            if ($type === 'image') {
                $stored = $this->imageUploadService->store($file, 'cms/media');
                $path = $stored['path'];
                $thumbPath = $stored['thumb_path'];
            } else {
                $ext = $file->getClientOriginalExtension();
                $path = 'cms/media/'.Str::uuid().'.'.$ext;
                Storage::disk('public_uploads')->put($path, file_get_contents($file->getRealPath()));
                $thumbPath = null;
            }

            Media::create([
                'path' => $path,
                'thumb_path' => $thumbPath,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $mime,
                'size' => $file->getSize(),
                'type' => $type,
                'folder' => $folder,
            ]);
        }

        return back()->with('success', count($request->file('files')) === 1 ? '1 file uploaded.' : count($request->file('files')).' files uploaded.');
    }

    public function update(Request $request, Media $medium)
    {
        $data = $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'original_name' => 'nullable|string|max:255',
            'folder' => 'nullable|in:images,videos,documents,products,banners',
        ]);

        $medium->update(array_filter($data, fn ($v) => $v !== null));

        return back()->with('success', 'File updated.');
    }

    public function destroy(Media $medium)
    {
        $this->imageUploadService->delete($medium->path);
        if ($medium->thumb_path) {
            Storage::disk('public_uploads')->delete($medium->thumb_path);
        }
        $medium->delete();

        return back()->with('success', 'File deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:cms_media,id',
        ]);

        $items = Media::whereIn('id', $request->ids)->get();
        foreach ($items as $item) {
            $this->imageUploadService->delete($item->path);
            if ($item->thumb_path) {
                Storage::disk('public_uploads')->delete($item->thumb_path);
            }
            $item->delete();
        }

        return back()->with('success', count($request->ids).' files deleted.');
    }

    public function bulkMove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:cms_media,id',
            'folder' => 'required|in:images,videos,documents,products,banners',
        ]);

        Media::whereIn('id', $request->ids)->update(['folder' => $request->folder]);

        return back()->with('success', count($request->ids).' files moved.');
    }
}
