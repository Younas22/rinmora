<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $price = fake()->randomFloat(2, 45, 320);
        $name = fake()->unique()->words(3, true);
        $name = ucwords($name);

        return [
            'name' => $name,
            'short_description' => fake()->sentence(10),
            'description' => fake()->paragraphs(3, true),
            'price' => $price,
            'compare_at_price' => fake()->boolean(40) ? round($price * 1.25, 2) : null,
            'cost_per_item' => round($price * 0.45, 2),
            'sku' => 'RIN-'.strtoupper(fake()->bothify('???-###')),
            'barcode' => fake()->boolean(30) ? fake()->ean13() : null,
            'quantity' => fake()->numberBetween(0, 120),
            'low_stock_threshold' => 10,
            'weight' => fake()->randomFloat(2, 0.3, 2.5),
            'dimensions' => fake()->numberBetween(20, 45).' x '.fake()->numberBetween(10, 25).' x '.fake()->numberBetween(15, 35).' cm',
            'meta_title' => $name.' | Rinmora',
            'meta_description' => fake()->sentence(15),
            'tags' => fake()->randomElements(['leather', 'summer', 'gift', 'bestseller', 'handcrafted'], fake()->numberBetween(0, 3)),
            'status' => fake()->randomElement(['active', 'active', 'active', 'draft']),
            'is_featured' => fake()->boolean(20),
            'is_visible' => true,
        ];
    }
}
