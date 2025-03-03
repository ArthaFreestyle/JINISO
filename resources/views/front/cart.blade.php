<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
</head>

<body>
    <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
        <div id="top-bar" class="flex justify-between items-center px-4 mt-[60px]">
            <img src="{{ asset('assets/images/logos/jiniso.webp') }}" class="flex shrink-0 h-10 w-10 rounded-full" alt="logo">
            <div class="flex items-center gap-4 sm:gap-2">
                <a href="#">
                    <img src="{{ asset('assets/images/icons/notification.svg') }}" class="w-10 h-10" alt="notification">
                </a>
                <a href="#">
                    <img src="assets/images/icons/cart.svg" class="w-10 h-10" alt="cart">
                </a>
                @if (Auth()->user())
                    <a href="{{ route('logout') }}" class="bg-purple-400 px-4 py-5 rounded-full text-sm font-semibold hover:bg-purple-600">
                        Logout
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-purple-400 px-4 py-5 rounded-full text-sm font-semibold hover:bg-purple-600">
                        Login
                    </a>
                @endif
            </div>
        </div>

        <!-- Cart Section -->
        <section id="cart" class="flex flex-col gap-4 px-4 py-6">
            <h2 class="font-bold text-xl">Your Cart</h2>

            @if (isset($cartItems) && count($cartItems) > 0)
            <div class="flex flex-col gap-4">
                @foreach ($cartItems as $item)
                    <div class="flex items-center justify-between bg-white rounded-xl p-4 shadow-md hover:ring-2 hover:ring-[#FFC700]">
                        <!-- Product Image -->
                        <div class="flex items-center gap-4">
                            <img src="{{ Storage::url($item->product->thumbnail) }}" class="w-20 h-20 object-cover rounded-lg" alt="product-image">
                            <div class="flex flex-col">
                                <h3 class="font-semibold text-lg">{{ $item['name'] }}</h3>
                                <p class="text-sm text-[#878785]">{{ $item['category_name'] }}</p>
                            </div>
                        </div>

                        <!-- Quantity & Price -->
                        <div class="flex items-center gap-2">
                            <input type="number" min="1" value="{{ $item['quantity'] }}" class="w-12 p-2 text-center rounded-md bg-gray-100">
                            <p class="font-semibold">Rp {{ number_format($item->product->price * $item['quantity'], 0, ',', '.') }}</p>
                        </div>

                        <!-- Remove Button -->
                        <form action="{{ route('cart.delete',$item->id) }}" method="POST" class="ml-4">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <img src="{{ asset('assets/images/icons/trash.svg') }}" class="w-6 h-6" alt="remove">
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <!-- Total Price -->
            <div class="flex justify-between items-center bg-white p-4 rounded-xl shadow-md mt-6">
                <h3 class="font-semibold text-lg">Total</h3>
                <p class="font-bold text-lg">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
            </div>

            <!-- Checkout Button -->
            <div class="mt-6 flex justify-center">
                <a href="#" class="bg-purple-400 px-8 py-3 rounded-full text-sm font-semibold text-white hover:bg-purple-600">
                    Checkout
                </a>
            </div>
        @else
            <p>Your cart is empty. Start shopping now!</p>
        @endif
        </section>

        <!-- Bottom Navigation -->
        <div id="bottom-nav" class="relative flex h-[100px] w-full shrink-0">
            <nav class="fixed bottom-5 w-full max-w-[640px] px-4 z-30">
                <div class="grid grid-flow-col auto-cols-auto items-center justify-between rounded-full bg-[#2A2A2A] p-2 px-[30px]">
                    <a href="{{ route('front.index') }}" class="flex shrink-0 -mx-[22px]">
                        <div style="background-color: #a78bfa;" class="flex items-center rounded-full gap-[10px] p-[12px_16px]">
                            <img src="assets/images/icons/3dcube.svg" class="w-6 h-6" alt="icon">
                            <span class="font-bold text-sm leading-[21px]">Browse</span>
                        </div>
                    </a>
                    <a href="#" class="mx-auto w-full">
                        <img src="assets/images/icons/bag-2-white.svg" class="w-6 h-6" alt="icon">
                    </a>
                    <a href="#" class="mx-auto w-full">
                        <img src="assets/images/icons/star-white.svg" class="w-6 h-6" alt="icon">
                    </a>
                    <a href="#" class="mx-auto w-full">
                        <img src="assets/images/icons/24-support-white.svg" class="w-6 h-6" alt="icon">
                    </a>
                </div>
            </nav>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/index.js"></script>
</body>

</html>
