<?php

namespace App\Services\Catalog;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageUploadService
{
    protected ?ImageManager $manager = null;

    protected function manager(): ImageManager
    {
        return $this->manager ??= new ImageManager(new Driver());
    }

    /**
     * Store an uploaded image plus a resized thumbnail sharing the same base name,
     * so the thumb can always be derived from the original path later (see
     * ProductImage::getThumbUrlAttribute()).
     *
     * @return array{path: string, thumb_path: string}
     */
    public function store(UploadedFile $file, string $directory): array
    {
        $uuid = Str::uuid();
        $ext = $file->getClientOriginalExtension();
        $path = "{$directory}/{$uuid}.{$ext}";
        $thumbPath = $this->thumbPathFor($path);

        Storage::disk('public_uploads')->put($path, file_get_contents($file->getRealPath()));

        $thumb = $this->manager()->read($file->getRealPath())->cover(400, 400);
        Storage::disk('public_uploads')->put($thumbPath, (string) $thumb->encode());

        return ['path' => $path, 'thumb_path' => $thumbPath];
    }

    /**
     * Store an uploaded file as-is, with no image processing or thumbnail.
     * Used for video uploads, which Intervention Image cannot touch.
     *
     * @return array{path: string}
     */
    public function storeRaw(UploadedFile $file, string $directory): array
    {
        $uuid = Str::uuid();
        $ext = $file->getClientOriginalExtension();
        $path = "{$directory}/{$uuid}.{$ext}";

        Storage::disk('public_uploads')->put($path, file_get_contents($file->getRealPath()));

        return ['path' => $path];
    }

    /**
     * Delete a stored image and its derived thumbnail (if any).
     */
    public function delete(?string $path): void
    {
        if (!$path) {
            return;
        }

        foreach ([$path, $this->thumbPathFor($path)] as $target) {
            if (Storage::disk('public_uploads')->exists($target)) {
                Storage::disk('public_uploads')->delete($target);
            }
        }
    }

    public function thumbPathFor(string $path): string
    {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        return ($dir !== '.' ? "{$dir}/" : '')."{$filename}-thumb.{$ext}";
    }
}
