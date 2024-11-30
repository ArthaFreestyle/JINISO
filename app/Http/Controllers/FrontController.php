<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use app\Models\Category;
use app\Models\Products;

class FrontController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function index()
    {
        $data = $this->frontService->getFrontPageData();
        return view('front.index',$data);
    }

    public function category(Category $category)
    {
        $data = $this->frontService->getCategoryPageData($category);
        return view('front.category',$data);
    }

    public function details(Products $product)
    {
        $data = $this->frontService->getProductPageData($product);
        return view('front.details',$data);
    }




}
