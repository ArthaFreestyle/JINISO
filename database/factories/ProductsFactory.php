<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use App\Models\ProductReviews;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Products::class;
    public function definition(): array
    {
        $productName = $this->faker->words(2, true);
        return [
            'product_name' => $productName,
            'slug' => Str::slug($productName),
            'thumbnail' => $this->faker->imageUrl(640, 480, 'products'),
            'description' => $this->faker->paragraph, 
            'price' => $this->faker->numberBetween(10000, 1000000), 
            'stock' => $this->faker->numberBetween(1, 100), 
            'isPopular' => $this->faker->boolean, 
            'category_id' => Category::factory(), 
        ];
    }

    public function configure(){
        return $this->afterCreating(function(\App\Models\Products $product){
            ProductImage::factory()->count(3)->create([
                'product_id' => $product->product_id
            ]);
            ProductReviews::factory()->count(3)->create([
                'product_id' => $product->product_id
            ]);
        });
    }
}
