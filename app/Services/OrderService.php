<?php 
namespace App\Services;

use App\Models\Orders;
use App\Models\OrderDetails;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductsRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\PromoCodeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService{

        protected $orderRepository;
        protected $promoCodeRepository;
        protected $productRepository;
        protected $categoryRepository;

        public function __construct(OrderRepositoryInterface $orderRepository, PromoCodeRepositoryInterface $promoCodeRepository, ProductsRepositoryInterface $productsRepository, CategoryRepositoryInterface $categoryRepository)
        {
            $this->orderRepository = $orderRepository;
            $this->promoCodeRepository = $promoCodeRepository;
            $this->productRepository = $productsRepository;
            $this->categoryRepository = $categoryRepository;
        }

        public function beginOrder(array $data)
        {
            $dataOrder = [
                'product_id' => $data['product_id'],
                'size_id' => $data['size_id'],
                'product_size' => $data['product_size'],
            ];

            $this->orderRepository->saveToSession($dataOrder);
        }

        public function getOrderDetails(){
            $oderData = $this->orderRepository->getOrderDataFromSession();
            $product = $this->productRepository->find($oderData['product_id']);
            $discount = $oderData['discount'] ?? 0;

            $quantity = isset($oderData['quantity']) ? $oderData['quantity'] : 1;
            $subTotalAmout = $product->price * $quantity;

            $taxRate = 0.11;
            $totalTax = $subTotalAmout * $taxRate;

            $grandTotalAmount = $subTotalAmout + $totalTax - $discount;

            $oderData['sub_total_amount'] = $subTotalAmout;
            $oderData['total_tax'] = $totalTax;
            $oderData['grand_total_amount'] = $grandTotalAmount;

            return compact('product', 'oderData');
        }

        public function applyPromoCode(string $code,int $subTotalAmout){
            $promoCode = $this->promoCodeRepository->findByCode($code);

            if($promoCode){
                $discount = $promoCode->discount_amount;
                $grandTotalAmount = $subTotalAmout - $discount;
                $promoCodeId = $promoCode->id;
                return compact('promoCodeId', 'discount', 'grandTotalAmount');
            }
            return ['error' => 'Invalid Promo Code'];
        }

        public function saveBookingTransaction(array $data)
        {
            $this->orderRepository->saveToSession($data);
        }

        public function updateBookingTransaction(array $data)
        {
            $this->orderRepository->updateSessionData($data);
        }

        public function paymentConfirm(array $validated){
            $orderData = $this->orderRepository->getOrderDataFromSession();
            try{
                DB::transaction(function() use ($validated,&$newOrderId,$orderData){
                    $validated['user_id'] = auth()->id();
                    $validated['product_id'] = $orderData['product_id'];
                    $validated['size_id'] = $orderData['size_id'];
                    $validated['quantity'] = $orderData['quantity'];
                    $validated['sub_total_amount'] = $orderData['sub_total_amount'];
                    $validated['grand_total_amount'] = $orderData['grand_total_amount'];
                    $validated['discound_amount'] = $orderData['total_discount_amount'];
                    $validated['promo_code_id'] = $orderData['promo_code_id'];
                    $validated['status'] = 'Paid';
                    $validated['address'] = $orderData['address'];
                    $validated['email'] = $orderData['email'];
                    $validated['phone'] = $orderData['phone'];
                    $validated['name'] = $orderData['name'];
                    $validated['city'] = $orderData['city'];
                    $validated['postal_code'] = $orderData['post_code'];

                    $newTransaction = $this->orderRepository->createTransaction($validated);
                    $newOrderId = $newTransaction->order_id;
                });
            
            }catch(\Exception $e){
                Log::error($e->getMessage());
                return ['error' => 'Failed to save transaction'];
            }
            session()->forget('orderData');
            return $newOrderId;
        }

        public function getOrders(){
            return Orders::with('details')->where('user_id', auth()->id())->latest()->get();
        }

        public function getOrderDetailsById($orderId){
            return OrderDetails::where('order_detail_id', $orderId)->first();
        }


}

