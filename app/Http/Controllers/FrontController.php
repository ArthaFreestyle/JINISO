<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
use App\Models\Cart;
use App\Services\FrontService;
use App\Models\ProductReviews;

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

    public function cart()
    {
        // Get cart items for the logged-in user
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            // Access the related product's price
            $totalPrice += $item->product->price * $item->quantity;
    }

        return view('front.cart', compact('cartItems', 'totalPrice'));
    }

    public function deleteCart(Cart $cart)
    {
        $cart->delete();
        return redirect()->route('cart');
    }

    public function productRating(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,product_id',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required'
        ]);

        $productReview = new ProductReviews();
        $productReview->user_id = auth()->id();
        $productReview->product_id = $request->product;
        $productReview->rating = $request->rating;
        $productReview->review = $request->comment;
        $productReview->save();

        return redirect('/');
    }



}
