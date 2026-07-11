<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;
use App\Models\Sales\OrderItem;
use App\Services\Catalog\ImageUploadService;
use Illuminate\Http\Request;

class StorefrontReviewController extends Controller
{
    public function __construct(protected ImageUploadService $images)
    {
    }

    /**
     * Can the current customer review this product, and do they already
     * have a review for it? Only customers with a delivered order containing
     * this product may review it.
     */
    public function eligibility(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $user = $request->user();

        $existingReview = Review::where('product_id', $product->id)->where('user_id', $user->id)->first();

        return response()->json([
            'can_review' => $this->hasDeliveredPurchase($user->id, $product->id),
            'existing_review' => $existingReview ? [
                'id' => $existingReview->id,
                'rating' => $existingReview->rating,
                'title' => $existingReview->title,
                'body' => $existingReview->body,
                'photo_url' => $existingReview->photo_url,
                'status' => $existingReview->status,
            ] : null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:catalog_products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'body' => 'required|string|max:2000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'remove_photo' => 'nullable|boolean',
        ]);

        $user = $request->user();

        if (! $this->hasDeliveredPurchase($user->id, $data['product_id'])) {
            return response()->json([
                'message' => 'You can only review products from your delivered orders.',
            ], 403);
        }

        $existing = Review::where('product_id', $data['product_id'])->where('user_id', $user->id)->first();
        $photoPath = $existing->photo_path ?? null;

        if ($request->hasFile('photo')) {
            if ($photoPath) {
                $this->images->delete($photoPath);
            }
            $photoPath = $this->images->storeRaw($request->file('photo'), "reviews/{$data['product_id']}")['path'];
        } elseif ($request->boolean('remove_photo') && $photoPath) {
            $this->images->delete($photoPath);
            $photoPath = null;
        }

        $review = Review::updateOrCreate(
            ['product_id' => $data['product_id'], 'user_id' => $user->id],
            [
                'customer_name' => trim("{$user->first_name} {$user->last_name}") ?: $user->first_name,
                'rating' => $data['rating'],
                'title' => $data['title'] ?? null,
                'body' => $data['body'],
                'photo_path' => $photoPath,
                'status' => 'pending',
            ]
        );

        return response()->json([
            'message' => 'Thanks! Your review has been submitted and will appear once approved.',
            'data' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'title' => $review->title,
                'body' => $review->body,
                'photo_url' => $review->photo_url,
                'status' => $review->status,
            ],
        ], $review->wasRecentlyCreated ? 201 : 200);
    }

    protected function hasDeliveredPurchase(int $userId, int $productId): bool
    {
        return OrderItem::where('product_id', $productId)
            ->whereHas('order', fn ($q) => $q->where('user_id', $userId)->where('status', 'delivered'))
            ->exists();
    }
}
