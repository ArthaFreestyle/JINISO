<?php 

namespace App\Repositories\Contracts;

interface ProductsRepositoryInterface
{
    public function getPopularProducts($limit);
    public function getAllNewProducts();

    public function searchByName(string $keyword);

    public function find($id);

    public function getPrice($ticketId);
}