<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $price = (float) $this->price;
        $compareAt = $this->compare_at_price !== null ? (float) $this->compare_at_price : null;
        $discountPercent = ($compareAt && $compareAt > $price)
            ? (int) round((($compareAt - $price) / $compareAt) * 100)
            : null;

        $reviewsAvg = $this->reviews_avg_rating !== null ? round((float) $this->reviews_avg_rating, 1) : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $price,
            'compare_at_price' => $compareAt,
            'discount_percent' => $discountPercent,
            'is_featured' => (bool) $this->is_featured,
            'is_new' => $this->created_at ? $this->created_at->gt(now()->subDays(21)) : false,
            'stock_status' => $this->stock_status,
            'quantity' => $this->quantity,
            'rating' => $reviewsAvg,
            'reviews_count' => $this->whenCounted('reviews'),
            'category' => $this->whenLoaded('category', fn () => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null),
            'brand' => $this->whenLoaded('brand', fn () => $this->brand ? [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
            ] : null),
            'images' => $this->whenLoaded('images', fn () => $this->images->map(fn ($image) => [
                'id' => $image->id,
                'url' => $image->url,
                'thumb_url' => $image->thumb_url,
            ])->values()),
            'variants' => $this->whenLoaded('variants', fn () => $this->variants->map(fn ($variant) => [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'label' => $variant->label,
                'price' => $variant->price !== null ? (float) $variant->price : null,
                'quantity' => $variant->quantity,
                'option_values' => $variant->option_values ?? [],
            ])->values()),
        ];
    }
}
