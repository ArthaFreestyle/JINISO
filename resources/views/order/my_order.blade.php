<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
        <div id="top-bar" class="flex justify-between items-center px-4 mt-[60px]">
            <a href="/">
                <img src="{{ asset('assets/images/icons/back.svg') }}" class="w-10 h-10" alt="icon">
            </a>
            <p class="font-bold text-lg leading-[27px]">My Orders</p>
            <div class="dummy-btn w-10"></div>
        </div>
        <section id="fresh" class="flex flex-col gap-4 px-4 mb-[111px]">
            <div class="flex items-center justify-between">
                <a href="#" class="rounded-full p-[6px_14px] border border-[#2A2A2A] text-xs leading-[18px]">
                    View All
                </a>
            </div>
            <div class="flex flex-col gap-4">
                @foreach ($orders as $order)
                    <a href="{{ route('front.check_booking_details',$order->details->first()->order_detail_id) }}">
                        <div
                            class="flex items-center rounded-3xl p-[10px_16px_16px_10px] gap-[14px] bg-white transition-all duration-300 hover:ring-2 hover:ring-[#FFC700]">
                            <div class="w-20 h-20 flex shrink-0 rounded-2xl bg-[#D9D9D9] overflow-hidden">
                                <img src="{{ Storage::url($order->details->first()->product->thumbnail) }}" class="w-full h-full object-cover"
                                    alt="thumbnail">
                            </div>
                            <div class="flex w-full items-center justify-between gap-[14px]">
                                <div class="flex flex-col gap-[6px]">
                                    <h3 class="font-bold leading-[20px]">{{ $order->details->first()->product->product_name }}</h3>
                                    <p class="text-sm leading-[21px] text-[#878785]">{{ $order->details->first()->quantity }}</p>
                                </div>
                                <div class="flex flex-col gap-1 items-end shrink-0">
                                    <p class="font-semibold text-sm leading-[21px]">Rp {{ number_format($order->total_amount,0,',','.') }}</p>
                                    @if ($order->status == 'Paid')
                                        <p  class="font-bold leading-[18px] ">{{ $order->status }}</p>
                                    @else  
                                        <img src="{{ asset('assets/images/icons/verify.svg') }}" class="w-6 h-6" alt="icon">
                                        <p  class="font-bold leading-[18px] ">{{ $order->status }}</p>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        </section>
    </div>
</body>

</html>
