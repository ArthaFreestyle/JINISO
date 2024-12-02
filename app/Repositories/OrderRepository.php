<?php 

namespace App\Repositories;

use App\Models\Orders;
use Illuminate\Support\Facades\Session;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function createTransaction(array $data)
    {
        return Orders::create($data);
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