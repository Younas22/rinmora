<?php

namespace Database\Seeders;

use App\Models\Catalog\Attribute;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Collection;
use App\Models\Catalog\InventoryMovement;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect(['Tote Bags', 'Crossbody', 'Mini Bags', 'Clutches', 'Backpacks'])
            ->map(fn ($name) => Category::create(['name' => $name, 'status' => true]));

        $brands = collect(['Rinmora Signature', 'Rinmora Studio'])
            ->map(fn ($name) => Brand::create(['name' => $name, 'status' => true]));

        $collections = collect([
            ['name' => 'Summer Essentials', 'type' => 'manual'],
            ['name' => 'New Arrivals', 'type' => 'automatic'],
            ['name' => 'Everyday Carry', 'type' => 'manual'],
        ])->map(fn ($c) => Collection::create($c + ['status' => true]));

        $color = Attribute::create(['name' => 'Color', 'display_type' => 'color_swatch', 'use_for_variants' => true]);
        foreach (['Cognac Brown' => '#8B5A2B', 'Ivory' => '#F5F0E6', 'Black' => '#000000'] as $value => $hex) {
            $color->values()->create(['value' => $value, 'swatch_color' => $hex]);
        }

        $size = Attribute::create(['name' => 'Size', 'display_type' => 'dropdown', 'use_for_variants' => true]);
        foreach (['Small', 'Medium', 'Large'] as $i => $value) {
            $size->values()->create(['value' => $value, 'sort_order' => $i]);
        }

        Attribute::create(['name' => 'Material', 'display_type' => 'button', 'use_for_variants' => false])
            ->values()->createMany([
                ['value' => 'Full-Grain Leather'],
                ['value' => 'Canvas'],
                ['value' => 'Vegan Leather'],
            ]);

        $products = Product::factory()
            ->count(10)
            ->sequence(fn ($s) => [
                'category_id' => $categories[$s->index % $categories->count()]->id,
                'brand_id' => $brands[$s->index % $brands->count()]->id,
                'collection_id' => $s->index % 3 === 0 ? $collections->random()->id : null,
            ])
            ->create();

        // A couple of products get variants
        foreach ($products->take(3) as $product) {
            foreach (['Cognac Brown', 'Ivory'] as $colorValue) {
                $product->variants()->create([
                    'sku' => $product->sku.'-'.strtoupper(substr($colorValue, 0, 2)),
                    'price' => null,
                    'quantity' => fake()->numberBetween(0, 30),
                    'option_values' => ['Color' => $colorValue],
                ]);
            }
        }

        // Reviews across all statuses
        $statuses = ['approved', 'approved', 'approved', 'pending', 'pending', 'reported', 'rejected'];
        foreach ($statuses as $i => $status) {
            Review::create([
                'product_id' => $products->random()->id,
                'customer_name' => fake()->firstName().' '.substr(fake()->lastName(), 0, 1).'.',
                'rating' => fake()->numberBetween(2, 5),
                'title' => fake()->sentence(4),
                'body' => fake()->sentence(15),
                'status' => $status,
            ]);
        }

        // A couple of inventory movements
        foreach ($products->take(2) as $product) {
            InventoryMovement::create([
                'product_id' => $product->id,
                'type' => 'add',
                'quantity_change' => 20,
                'reason' => 'restock',
                'notes' => 'Initial stock seed.',
            ]);
        }
    }
}
