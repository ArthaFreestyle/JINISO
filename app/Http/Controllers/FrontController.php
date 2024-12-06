<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
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
        return view('front.category',compact('category'));
    }

    public function details(Products $product)
    {

        return view('front.details',compact('product'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $data = $this->frontService->searchProducts($keyword);
        return view('front.search',compact('data','keyword'));
    }




}
