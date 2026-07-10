<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\HomepageSection;
use App\Services\Catalog\ImageUploadService;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
    }

    public function index()
    {
        $sections = HomepageSection::ordered()->get();

        $stats = [
            'total' => $sections->count(),
            'visible' => $sections->where('is_visible', true)->count(),
        ];

        return view('admin.cms.homepage.index', compact('sections', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->imageUploadService->store($request->file('image'), 'cms/homepage')['path'];
        }

        $data['sort_order'] = (HomepageSection::max('sort_order') ?? 0) + 1;

        HomepageSection::create($data);

        return back()->with('success', 'Section added.');
    }

    public function update(Request $request, HomepageSection $homepage_section)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $this->imageUploadService->delete($homepage_section->image_path);
            $data['image_path'] = $this->imageUploadService->store($request->file('image'), 'cms/homepage')['path'];
        }

        $homepage_section->update($data);

        return back()->with('success', 'Section updated.');
    }

    public function destroy(HomepageSection $homepage_section)
    {
        $this->imageUploadService->delete($homepage_section->image_path);
        $homepage_section->delete();

        return back()->with('success', 'Section removed.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:cms_homepage_sections,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            HomepageSection::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'type' => 'required|in:hero_slider,featured_categories,best_sellers,promotional_banner,testimonials,newsletter,custom_html',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $data['is_visible'] = $request->boolean('is_visible');

        unset($data['image']);

        return $data;
    }
}
