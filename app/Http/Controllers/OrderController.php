<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\storeOrderRequest;
use App\Models\Products;
use App\Models\Orders;
use App\Services\OrderService;
use App\Models\OrderDetails;
use App\Http\Requests\storeCustomerDataRequest;
use App\Http\Requests\storePaymentRequest;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function saveOrder(storeOrderRequest $request, Products $product)
    {
        $validated = $request->validated();
        $validated['product_id'] = $product->product_id;
        $this->orderService->beginOrder($validated);

        return redirect()->route('front.booking', $product->slug);
    }

    public function booking()
    {
        $data = $this->orderService->getOrderDetails();


        return view('order.order', $data);
    }

    public function customerData()
    {
        $data = $this->orderService->getOrderDetails();
        return view('order.customer_data', $data);
    }

    public function saveCustomerData(storeCustomerDataRequest $request)
    {
        $validated = $request->validated();
        $this->orderService->updateBookingTransaction($validated);

        return redirect()->route('front.payment');
    }

    public function paymentConfirm()
    {
        $validated = [];
        $data = $this->orderService->paymentConfirm($validated);
        return redirect()->route('front.order_finished',$data);
    }

    public function payment()
    {
        $data = $this->orderService->getOrderDetails();
        
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;


        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $data['oderData']['grand_total_amount'],
            ),
            'customer_details' => array(
                'first_name' => $data['oderData']['name'],
                'email' => $data['oderData']['email'],
            ),
        );
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $data['snapToken'] = $snapToken;

        return view('order.payment', $data);
    }

    public function orderFinished(Orders $orders)
    {
        return view('order.order_finished', compact('orders'));
    }

    public function checkBooking()
    {
        $orders = $this->orderService->getOrders();
        return view('order.my_order', compact('orders'));
    }

    public function checkBookingDetails(OrderDetails $orderDetails)
    {
        $order = $this->orderService->getOrderDetailsById($orderDetails->order_detail_id);
        return view('order.my_order_details', compact('order'));
    }

}
