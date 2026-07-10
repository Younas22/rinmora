<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'short_description' => $this->short_description,
            'price' => $price,
            'compare_at_price' => $compareAt,
            'discount_percent' => $discountPercent,
            'is_featured' => (bool) $this->is_featured,
            'is_new' => $this->created_at ? $this->created_at->gt(now()->subDays(21)) : false,
            'stock_status' => $this->stock_status,
            'rating' => $reviewsAvg,
            'reviews_count' => $this->whenCounted('reviews'),
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ]),
            'image_url' => $this->coverImage?->url ?? $this->images->first()?->url,
        ];
    }
}
