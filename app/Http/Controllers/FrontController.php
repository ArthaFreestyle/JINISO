<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use app\Models\Category;
use app\Models\Products;
use App\Services\FrontService;

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
        return view('front.category',$category);
    }

    public function details(Products $product)
    {
        return view('front.details',$product);
    }




}
