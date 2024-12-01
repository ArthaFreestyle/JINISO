<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\storeOrderRequest;
use App\Models\Products;
use App\Services\OrderService;
use App\Http\Requests\storeCustomerDataRequest;
use App\Http\Requests\storePaymentRequest;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function saveOrder(storeOrderRequest $request,Products $products)
    {
        $validated = $request->validated();
        $validated['product_id'] = $products->id;
        $this->orderService->beginOrder($validated);

        return redirect()->route('front.booking', $products->slug);
    }

    public function booking()
    {
        $data = $this->orderService->getOrderDetails();
        return view('order.order',$data);
    }

    public function getCustomerData()
    {
        $data = $this->orderService->getOrderDetails();
        return view('order.customer_data',$data);
    }

    public function saveCustomerData(storeCustomerDataRequest $request)
    {
        $validated = $request->validated();
        $this->orderService->updateBookingTransaction($validated);

        return redirect()->route('front.payment');
    }

    public function paymentConfirm(storePaymentRequest $request)
    {
        $validated = $request->validated();
        $this->orderService->paymentConfirm($validated);

        return redirect()->route('front.order_finished');
    }

    public function orderFinished(ProductTransaction $productTransaction){
        dd($productTransaction);
    }
 
}
