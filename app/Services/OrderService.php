<?php 
namespace App\Services;

use App\Models\Orders;
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
            $products = $this->productRepository->find($oderData['product_id']);

            $quantity =isset($oderData['quantity']) ? $oderData['quantity'] : 1;
            $subTotalAmout = $products->price * $quantity;

            $taxRate = 0.11;
            $totalTax = $subTotalAmout * $taxRate;

            $grandTotalAmount = $subTotalAmout + $totalTax;

            $oderData['sub_total_amount'] = $subTotalAmout;
            $oderData['total_tax'] = $totalTax;
            $oderData['grand_total_amount'] = $grandTotalAmount;

            return compact('products', 'oderData');
        }

        public function applyPromoCode(string $code,int $subTotalAmout){
            $promoCode = $this->promoCodeRepository->findByCode($code);

            if($promoCode){
                $discount = $promoCode->discount_rate;
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
                DB::transaction(function() use ($validated,$orderData){
                    $validated['user_id'] = auth()->id();
                    $validated['product_id'] = $orderData['product_id'];
                    $validated['size_id'] = $orderData['size_id'];
                    $validated['quantity'] = $orderData['quantity'];
                    $validated['sub_total_amount'] = $orderData['sub_total_amount'];
                    $validated['grand_total_amount'] = $orderData['grand_total_amount'];
                    $validated['discound_amount'] = $orderData['discount_amount'];
                    $validated['promo_code_id'] = $orderData['promo_code_id'];
                    $validated['status'] = 'pending';

                    $newTransaction = $this->orderRepository->createTransaction($validated);
                });
            }catch(\Exception $e){
                Log::error($e->getMessage());
                return ['error' => 'Failed to save transaction'];
            }
        }


}

