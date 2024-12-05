<?php 

namespace App\Repositories;

use App\Models\OrderDetails;
use App\Models\Orders;
use Illuminate\Support\Facades\Session;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function createTransaction(array $data)
    {
        $order = Orders::create([
            'user_id' => $data['user_id'],
            'promo_code_id' => $data['promo_code_id'],
            'order_date' => now(),
            'total_amount' => $data['grand_total_amount'],
            'status' => $data['status'],
            'address' => $data['address'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'name' => $data['name'],
            'postal_code' => $data['postal_code'],
            'city' => $data['city'],
        ]);

        $oderId = Orders::orderBy('order_id', 'desc')->first()->order_id;
        OrderDetails::create([
            'order_id' => $oderId,
            'product_id' => $data['product_id'],
            'product_size_id' => $data['size_id'],
            'quantity' => $data['quantity'],
            'price' => $data['sub_total_amount'],
            'subtotal' => $data['grand_total_amount'],

        ]);

        return $order;
    }

    public function saveToSession(array $data)
    {
        Session::put('orderData', $data);
    }

    public function updateSessionData(array $data)
    {
        $orderData = session('orderData', []);
        $orderData = array_merge($orderData, $data);
        Session::put('orderData', $orderData);
    }

    public function getOrderDataFromSession()
    {
        return session('orderData', []);
    }
}