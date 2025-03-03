<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\OrderService;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\PromoCodeRepositoryInterface;
use App\Repositories\Contracts\ProductsRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Orders;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;
    protected $orderRepository;
    protected $promoCodeRepository;
    protected $productRepository;
    protected $categoryRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = Mockery::mock(OrderRepositoryInterface::class);
        $this->promoCodeRepository = Mockery::mock(PromoCodeRepositoryInterface::class);
        $this->productRepository = Mockery::mock(ProductsRepositoryInterface::class);
        $this->categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);

        $this->orderService = new OrderService(
            $this->orderRepository,
            $this->promoCodeRepository,
            $this->productRepository,
            $this->categoryRepository
        );
    }

    #[Test]
    public function it_saves_order_to_session()
    {
        $orderData = [
            'product_id' => 1,
            'size_id' => 2,
            'product_size' => 'L',
        ];
        $this->orderRepository->shouldReceive('saveToSession')
            ->once()
            ->with($orderData);

        $this->orderService->beginOrder($orderData);
    }

    #[Test]
    public function it_retrieves_order_details_correctly()
    {
        $orderSessionData = [
            'product_id' => 1,
            'quantity' => 2,
            'discount' => 5000
        ];

        $productMock = (object)[
            'price' => 10000
        ];

        $this->orderRepository->shouldReceive('getOrderDataFromSession')
            ->once()
            ->andReturn($orderSessionData);

        $this->productRepository->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($productMock);

        $result = $this->orderService->getOrderDetails();

        $this->assertEquals(20000, $result['oderData']['sub_total_amount']);  // 10000 * 2
        $this->assertEquals(2200, $result['oderData']['total_tax']);          // 20000 * 11%
        $this->assertEquals(17200, $result['oderData']['grand_total_amount']); // (20000 + 2200 - 5000)
    }

    #[Test]
    public function it_applies_promo_code_correctly()
    {
        $promoMock = (object)[
            'id' => 1,
            'discount_amount' => 5000
        ];

        $this->promoCodeRepository->shouldReceive('findByCode')
            ->once()
            ->with('PROMO50')
            ->andReturn($promoMock);

        $result = $this->orderService->applyPromoCode('PROMO50', 20000);

        $this->assertEquals(1, $result['promoCodeId']);
        $this->assertEquals(5000, $result['discount']);
        $this->assertEquals(15000, $result['grandTotalAmount']);
    }

    #[Test]
    public function it_fails_to_apply_invalid_promo_code()
    {
        $this->promoCodeRepository->shouldReceive('findByCode')
            ->once()
            ->with('INVALID')
            ->andReturn(null);
        $result = $this->orderService->applyPromoCode('INVALID', 20000);

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Invalid Promo Code', $result['error']);
    }

    #[Test]
    public function it_confirms_payment_and_creates_transaction()
{
    $orderData = [
        'product_id' => 1,
        'size_id' => 2,
        'quantity' => 1,
        'sub_total_amount' => 10000,
        'grand_total_amount' => 11000,
        'total_discount_amount' => 0,
        'promo_code_id' => null,
        'address' => 'Test Address',
        'email' => 'test@example.com',
        'phone' => '08123456789',
        'name' => 'John Doe',
        'city' => 'Jakarta',
        'post_code' => '12345',
    ];
    session(['orderData' => $orderData]);

    $this->assertNotEmpty(session('orderData'));
    $this->orderRepository->shouldReceive('getOrderDataFromSession')
        ->once()
        ->andReturn(session('orderData'));
    DB::shouldReceive('transaction')
        ->once()
        ->andReturnUsing(function ($callback) use (&$newOrderId) {
            return $callback();
        });

    $this->orderRepository
        ->shouldReceive('createTransaction')
        ->once()
        ->andReturn((object) ['order_id' => 99]);
    $result = $this->orderService->paymentConfirm([]);

    $this->assertIsInt($result);
    $this->assertEquals(99, $result);
}

    #[Test]
    public function it_handles_payment_failure_gracefully()
    {
        $orderData = ['product_id' => 1];
        $this->orderRepository->shouldReceive('getOrderDataFromSession')
            ->once()
            ->andReturn($orderData);
        DB::shouldReceive('transaction')
            ->once()
            ->andThrow(new \Exception('Database error'));
        Log::shouldReceive('error')
            ->once()
            ->with('Database error');

        $result = $this->orderService->paymentConfirm([]);

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Failed to save transaction', $result['error']);
    }
}
