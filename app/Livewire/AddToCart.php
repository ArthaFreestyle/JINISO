<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public $product;
    public $quantity = 1;

    protected $rules = [
        'quantity' => 'required|integer|min:1',
    ];

    public function validateQuantity()
    {
        // Validasi manual untuk quantity jika pengguna memasukkan angka langsung
        if ($this->quantity < 1) {
            $this->quantity = 1; // Reset ke 1 jika kurang dari minimal
            session()->flash('message', 'Quantity tidak valid. Minimum 1.');
        }
    }

    public function addToCart()
    {
        $this->validate();
        // Validasi jika pengguna belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Validasi apakah produk tersedia
        if (!$this->product) {
            session()->flash('message', 'Produk tidak ditemukan!');
            return;
        }

        // Mengecek jika produk sudah ada dalam keranjang, maka tambahkan quantity-nya
        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $this->product->product_id)
                    ->first();

        if ($cart) {
            // Jika produk sudah ada, update quantity
            $cart->quantity += $this->quantity;
            $cart->save();
        } else {
            // Jika produk belum ada, buat entri baru
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->product_id, // Ensure this is not null
                'quantity' => $this->quantity,
            ]);
        }

        // Setelah menambahkan ke keranjang, reset quantity
        $this->quantity = 1;

        // Tampilkan pesan sukses
        // session()->flash('message', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
