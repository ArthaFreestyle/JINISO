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
    public function render()
    {
        return view('livewire.orderform');
    }
}
