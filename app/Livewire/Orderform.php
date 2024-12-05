<?php

namespace App\Livewire;

use App\Services\OrderService;
use Livewire\Component;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class Orderform extends Component
{
    public Products $product;
    public $orderData;
    public $subTotalAmount;
    public $promoCode = null;
    public $promoCodeId = null;
    public $quantity = 1;
    public $discount = 0;
    public $totalDiscountAmount = 0;
    public $grandTotalAmount;
    public $name;
    public $email;

    protected $orderService;


    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function mount(Products $product,$orderData)
    {
        $this->product = $product;
        $this->orderData = $orderData;
        $this->subTotalAmount = $product->price;
        $this->grandTotalAmount = $product->price;
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updatedQuantity()
    {
        $this->validateOnly('quantity',[
            'quantity' => 'required|numeric|max:'.$this->product->stock
        ],
        [
            'quantity.max' => 'Stock tidak cukup!'
        ]);

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->subTotalAmount = $this->product->price * $this->quantity;
        $this->grandTotalAmount = $this->subTotalAmount - $this->discount;
    }

    public function incrementQuantity()
    {
        if($this->quantity < $this->product->stock){
            $this->quantity++;
            $this->calculateTotal();
        }
    }

    public function decrementQuantity()
    {
        if($this->quantity > 1){
            $this->quantity--;
            $this->calculateTotal();
        }
    }

    public function updatedPromoCode()
    {
        $this->applyPromoCode();
    }

    public function applyPromoCode()
    {
        if(!$this->promoCode){
            $this->resetDiscount();
            return;
        }

        $result = $this->orderService->applyPromoCode($this->promoCode,$this->subTotalAmount);

        if(isset($result['error'])){
            session()->flash('error',$result['error']);
            $this->resetDiscount();
        }else{
            session()->flash('message','Promo Code Applied');
            $this->discount = $result['discount'];
            $this->calculateTotal();
            $this->promoCodeId = $result['promoCodeId'];
            $this->totalDiscountAmount = $result['discount']; 
        }
    }

    protected function resetDiscount()
    {
        $this->discount = 0;
        $this->promoCodeId = null;
        $this->calculateTotal();
        $this->totalDiscountAmount = 0;
    }

    public function rules(){
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'quantity' => 'required|numeric|max:'.$this->product->stock,
        ];
    }

    public function gatherBookingData(array $validatedData)
    {
        return [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'quantity' => $this->quantity,
            'sub_total_amount' => $this->subTotalAmount,
            'total_discount_amount' => $this->totalDiscountAmount,
            'grand_total_amount' => $this->grandTotalAmount,
            'promo_code_id' => $this->promoCodeId,
            'promo_code' => $this->promoCode,
            'discount' => $this->discount,
            
        ];
    }

    public function submit(){
        $validatedData = $this->validate();
        $bookingData = $this->gatherBookingData($validatedData);

        $this->orderService->updateBookingTransaction($bookingData);

        return redirect()->route('front.customer_data');
    }
    
    public function render()
    {
        return view('livewire.orderform');
    }
}
