<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\ProductImage::class;
    public function definition(): array
    {
        return [
            'image' => $this->faker->imageUrl(640, 480, 'products'),
            'product_id' => Products::factory(),
        ];
    }
}
