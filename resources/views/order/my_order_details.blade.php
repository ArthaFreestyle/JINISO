<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('output.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    </head>
    <body>
        <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
            <div id="top-bar" class="flex justify-between items-center px-4 mt-[60px]">
                <a href="{{ route('front.check_booking') }}">
                    <img src="{{ asset('assets/images/icons/back.svg') }}" class="w-10 h-10" alt="icon">
                </a>
                <p class="font-bold text-lg leading-[27px]">Booking Details</p>
                <div class="dummy-btn w-10"></div>
            </div>
            <section id="your-order" class="accordion flex flex-col rounded-[20px] p-4 pb-5 gap-5 mx-4 bg-white overflow-hidden transition-all duration-300 has-[:checked]:!h-[66px]">
                <label class="group flex items-center justify-between">
                    <h2 class="font-bold text-xl leading-[30px]">Your Order</h2>
                    <img src="{{ asset('assets/images/icons/arrow-up.svg') }}" class="w-7 h-7 transition-all duration-300 group-has-[:checked]:rotate-180" alt="icon">
                    <input type="checkbox" class="hidden">
                </label>
                <div class="flex items-center gap-[14px]">
                    <div class="flex shrink-0 w-20 h-20 rounded-[20px] bg-[#D9D9D9] p-1 overflow-hidden">
                        <img src="{{ Storage::url($order->product->thumbnail) }}" class="w-full h-full object-contain" alt="">
                    </div>
                    <h3 class="font-bold text-lg leading-6">{{ $order->product->product_name }}</h3>
                </div>
                <hr class="border-[#EAEAED]">
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Brand</p>
                    <p class="font-bold">JINISO</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Price</p>
                    <p class="font-bold">Rp {{ number_format($order->subtotal,0,',','.') }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Quantity</p>
                    <p class="font-bold">{{ $order->quantity }} Pcs</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Product Size</p>
                    <p class="font-bold">{{ $order->size->size }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Grand Total</p>
                    <p class="font-bold text-2xl leading-9 text-[#07B704]">Rp {{ number_format($order->order->total_amount,0,',','.') }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Checkout At</p>
                    <p class="font-bold">{{ date("d F Y", strtotime($order->order->order_date)) }}</p>
                </div>

                @if ($order->order->status == 'Paid')
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Status</p>
                    <p class="rounded-full p-[6px_14px] bg-[#2A2A2A] font-bold text-sm leading-[21px] text-white">PENDING</p>
                </div>
                @else
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Status</p>
                    <p class="rounded-full p-[6px_14px] bg-[#07B704] font-bold text-sm leading-[21px] text-white">SUCCESS</p>
                </div>
                @endif
                
                    
                
            </section>
            <section id="customer" class="accordion flex flex-col rounded-[20px] p-4 pb-5 gap-5 mx-4 bg-white overflow-hidden transition-all duration-300 has-[:checked]:!h-[66px] mb-10">
                <label class="group flex items-center justify-between">
                    <h2 class="font-bold text-xl leading-[30px]">Customer</h2>
                    <img src="{{ asset('assets/images/icons/arrow-up.svg') }}" class="w-7 h-7 transition-all duration-300 group-has-[:checked]:rotate-180" alt="icon">
                    <input type="checkbox" class="hidden">
                </label>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/delivery.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Booking ID</p>
                        <p class="font-bold">{{ $order->order->order_id }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/user.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Name</p>
                        <p class="font-bold">{{ $order->order->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/call.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Phone No.</p>
                        <p class="font-bold">{{ $order->order->phone }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/sms.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Email</p>
                        <p class="font-bold">{{ $order->order->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/house-2.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Delivery to</p>
                        <p class="font-bold">{{ $order->order->address }}</p>
                    </div>
                </div>
                <hr class="border-[#EAEAED]">
                <a href="#" class="rounded-full p-[12px_20px] text-center w-full bg-[#C5F277] font-bold">Call Customer Service</a>
                <hr class="border-[#EAEAED]">
                <div class="flex items-center gap-[10px]">
                    <img src="{{ asset('assets/images/icons/shield-tick.svg') }}" class="w-8 h-8 flex shrink-0" alt="icon">
                    <p class="leading-[26px]">Kami melindungi data privasi anda dengan baik bantuan Ultraman.</p>
                </div>
            </section>
            <section class="accordion flex flex-col rounded-[20px] p-4 pb-5 gap-5 mx-4 bg-white overflow-visible transition-all duration-300 mb-10">
                <form action="{{ route('productrating') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input type="text" name="product" value="{{ $order->product->product_id }}" hidden>
                    <!-- Input komentar -->
                    <label for="comment" class="text-lg font-semibold">Your Comment</label>
                    <textarea id="comment" name="comment" cols="60" rows="6" class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Write your comment here..."></textarea>
                    
                    <!-- Rating -->
                    <label for="rating" class="text-lg font-semibold">Rating (1-5)</label>
                    <select id="rating" name="rating" class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">1 - Poor</option>
                        <option value="2">2 - Fair</option>
                        <option value="3">3 - Good</option>
                        <option value="4">4 - Very Good</option>
                        <option value="5">5 - Excellent</option>
                    </select>
                    
                    <!-- Submit button -->
                    <button type="submit" class="srounded-full p-[12px_20px] text-center w-full bg-[#C5F277] font-bold">Submit</button>
                </form>
            </section>
        </div>

        <script src="{{ asset('js/accordion.js') }}"></script>
    </body>
</html>