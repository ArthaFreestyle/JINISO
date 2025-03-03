<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Products;
use App\Models\Cart;
use App\Models\User;
use App\Models\ProductReviews;
use App\Services\FrontService;
use PHPUnit\Framework\Attributes\Test;
use Mockery;

class FrontTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
public function it_shows_front_page()
{
    $response = $this->get(route('front.index'));
    $response->assertStatus(200);
    $response->assertViewIs('front.index');
    $response->assertViewHas('categories');
    $response->assertViewHas('popularProducts');
    $response->assertViewHas('newProducts');
}

    #[Test]
    public function it_shows_category_page()
    {
        $category = Category::factory()->create();

        $response = $this->get(route('front.category', $category));
        $response->assertStatus(200);
        $response->assertViewIs('front.category');
        $response->assertViewHas('category', fn ($viewCategory) => $viewCategory->id === $category->id);
    }

    #[Test]
    public function it_shows_product_details_page()
    {
        $product = Products::factory()->create();

        try {
            $response = $this->get(route('front.details', $product));
            $response->assertStatus(200);
            $response->assertViewIs('front.details');
            $response->assertViewHas('product', fn ($viewProduct) => $viewProduct->product_id === $product->product_id);
        } catch (\Exception $e) {
            $this->fail("Exception occurred: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    #[Test]
    public function it_searches_products()
    {
        
        $product = Products::factory()->create(['product_name' => 'Test Product']);
        $response = $this->get('/search?keyword=Test');
        $response->assertStatus(200);
        $response->assertViewIs('front.search');
        $response->assertViewHas('data', function ($data) use ($product) {
            return $data->contains($product);
        });
        $response->assertViewHas('keyword', 'Test');
    }

    #[Test]
    public function it_shows_cart_for_authenticated_user()
    {
        $this->actingAs($this->user);
        $product = Products::factory()->create(['price' => 100]);
        $cart = Cart::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $product->product_id,
            'quantity' => 2,
        ]);

        $response = $this->get(route('cart'));
        $response->assertStatus(200);
        $response->assertViewIs('front.cart');
        $response->assertViewHas('cartItems', fn ($items) => $items->count() === 1 && $items[0]->id === $cart->id);
        $response->assertViewHas('totalPrice', 200); // 100 * 2
    }

    #[Test]
    public function it_deletes_cart_item()
    {
        $this->actingAs($this->user);
        $cart = Cart::factory()->create(['user_id' => $this->user->id]);

        $response = $this->post(route('cart.delete', $cart));
        $response->assertRedirect(route('cart'));
        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    #[Test]
    public function it_adds_product_rating()
    {
        $this->actingAs($this->user);
        $product = Products::factory()->create();

        $response = $this->post(route('productrating'), [
            'product' => $product->product_id,
            'rating' => 4,
            'comment' => 'Great product!',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('product_reviews', [
            'user_id' => $this->user->id,
            'product_id' => $product->product_id,
            'rating' => 4,
            'review' => 'Great product!',
        ]);
    }

    #[Test]
    public function it_validates_product_rating_request()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('productrating'), [
            'product' => '', 
            'rating' => 6,   
            'comment' => '', 
        ]);

        $response->assertSessionHasErrors(['product', 'rating', 'comment']);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}