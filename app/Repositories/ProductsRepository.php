<?php 

namespace App\Repositories;

use App\Models\Products;
use App\Repositories\Contracts\ProductsRepositoryInterface;

class ProductsRepository implements ProductsRepositoryInterface
{
    public function getPopularProducts($limit = 4)
    {
        return Products::where('isPopular', true)->take($limit)->get();
    }

    public function searchByName(string $keyword)
    {
        return Products::where('name', 'like', "%",$keyword,"%")->get();
    }

    public function getAllNewProducts()
    {
        return Products::latest()->get();
    }

    public function find($id)
    {
        return Products::findOrFail($id);
    }

    public function getPrice($ticketId)
    {
        $product = $this->find($ticketId);
        return $product ? $product->price : 0;
    }
}