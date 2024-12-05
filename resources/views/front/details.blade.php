<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('output.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    </head>
    <body>
        <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
            <div id="top-bar" class="flex justify-between items-center px-4 mt-[60px]">
                <a href="/">
                    <img src="{{ asset('assets/images/icons/back.svg') }}" class="w-10 h-10" alt="icon">
                </a>
                <p class="font-bold text-lg leading-[27px]">Look Details</p>
                <div class="dummy-btn w-10"></div>
            </div>
            <section id="gallery" class="flex flex-col gap-[10px]">
                <div class="flex w-full h-[250px] shrink-0 overflow-hidden px-4">
                    <img id="main-thumbnail" src="{{ asset('storage/'.$product->images()->latest()->first()->image ) }}" class="w-full h-full object-contain object-center" alt="thumbnail">
                </div>
                <div class="swiper w-full overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach ($product->images as $photo)
                        <div class="swiper-slide !w-fit py-[2px]">
                            <label class="thumbnail-selector flex flex-col shrink-0 w-20 h-20 rounded-[20px] p-[10px] bg-white transition-all duration-300 hover:ring-2 hover:ring-[#FFC700] has-[:checked]:ring-2 has-[:checked]:ring-[#FFC700]">
                                <input type="radio" name="image" class="hidden" checked>
                                <img src="{{ asset('storage/'.$photo->image)}}" class="w-full h-full object-contain" alt="thumbnail">
                            </label>
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </section>
            <section id="info" class="flex flex-col gap-[14px] px-4">
                <div class="flex items-center justify-between">
                    <h1 id="title" class="font-bold text-2xl leading-9">{{ $product->product_name }}</h1>
                    <div class="flex flex-col items-end shrink-0">
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('assets/images/icons/Star 1.svg') }}" class="w-[26px] h-[26px]" alt="star">
                            <span class="font-semibold text-xl leading-[30px]">4.5</span>
                        </div>
                        <p class="text-sm leading-[21px] text-[#878785]">(18,485 reviews)</p>
                    </div>
                </div>
                <p id="desc" class="leading-[30px]">{{ $product->description }}</p>
            </section>
            <div id="brand" class="flex items-center gap-4 px-4">
                <div class="w-[70px] h-[70px] rounded-[20px] bg-white overflow-hidden">
                    <img src="{{ asset('assets/images/logos/jiniso.webp') }}" class="w-full h-full object-contain" alt="brand logo">
                </div>
                <div class="flex flex-col">
                    <h2 class="text-sm leading-[21px]">Brand</h2>
                    <div class="flex items-center gap-1">
                        <h3 class="font-bold text-lg leading-[27px]">Jiniso Indonesia</h3>
                        <img src="{{ asset('assets/images/icons/arrow-left.svg') }}" class="w-5 h-5" alt="icon">
                    </div>
                </div>
            </div>
            <form action="{{ route('front.save_order',$product->slug) }}" method="POST" class="flex flex-col gap-3">
                @csrf
                <div class="flex flex-col gap-3 px-4">
                    <h2 class="font-bold">Choose Size</h2>
                    <div class="flex items-center flex-wrap gap-[10px]">
                        @foreach ($product->sizes as $size)
                        <label class="relative flex justify-center min-w-[83px] w-fit rounded-2xl ring-1 ring-[#2A2A2A] p-[14px] transition-all duration-300 has-[:checked]:bg-white has-[:checked]:ring-2 has-[:checked]:ring-[#FFC700] hover:ring-2 hover:ring-[#FFC700]">
                            <input type="radio" data-size-id="{{ $size->id}}" name="product_size" value="{{ $size->size }}" class="absolute top-1/2 left-1/2 opacity-0" required>
                            <span class="font-semibold">{{ $size->size }}</span>
                        </label>
                        @endforeach
                    </div>

                    <input type="text" name="size_id" hidden>
                </div>
                <div id="form-bottom-nav" class="relative flex h-[100px] w-full shrink-0 mt-5">
                    <div class="fixed bottom-5 w-full max-w-[640px] z-30 px-4">
                        <div class="flex items-center justify-between rounded-full bg-[#2A2A2A] p-[10px] pl-6">
                            <div class="flex flex-col gap-[2px]">
                                <p class="font-bold text-[20px] leading-[30px] text-white">Rp {{ number_format($product->price,0,',','.') }}</p>
                                <p class="text-sm leading-[21px] text-[#878785]">piece of product</p>
                            </div>
                            <button type="submit" style="background-color: #a78bfa;" class="rounded-full p-[12px_20px] bg-[#C5F277] font-bold">
                                Buy Now
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="{{ asset('js/details.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sizeRadios = document.querySelectorAll('input[name="product_size"]');
                const sizeIdInput = document.querySelector('input[name="size_id"]');


                sizeRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const selectedSizeId = this.getAttribute('data-size-id');
                        sizeIdInput.value = selectedSizeId;
                        
                    });
                });
            });
        </script>
    </body>
</html>