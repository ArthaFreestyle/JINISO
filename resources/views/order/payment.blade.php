<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('output.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    </head>
    <body>
        <form class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
            <div id="top-bar" class="flex justify-between items-center px-4 mt-[60px]">
                <a href="/">
                    <img src="{{ asset('assets/images/icons/back.svg') }}" class="w-10 h-10" alt="icon">
                </a>
                <p class="font-bold text-lg leading-[27px]">Review & Payment</p>
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
                        <img src="{{ Storage::url($product->thumbnail) }}" class="w-full h-full object-contain" alt="">
                    </div>
                    <h3 class="font-bold text-lg leading-6">{{ $product->product_name }}</h3>
                </div>
                <hr class="border-[#EAEAED]">
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Brand</p>
                    <p class="font-bold">JINISO</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Price</p>
                    <p class="font-bold">Rp {{ number_format($product->price,0,',','.') }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Quantity</p>
                    <p class="font-bold">{{ $oderData['quantity'] }} Pcs</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Product Size</p>
                    <p class="font-bold">{{ $oderData['product_size'] }}</p>
                </div>
            </section>
            <section id="customer" class="accordion flex flex-col rounded-[20px] p-4 pb-5 gap-5 mx-4 bg-white overflow-hidden transition-all duration-300 has-[:checked]:!h-[66px]">
                <label class="group flex items-center justify-between">
                    <h2 class="font-bold text-xl leading-[30px]">Customer</h2>
                    <img src="{{ asset('assets/images/icons/arrow-up.svg') }}" class="w-7 h-7 transition-all duration-300 group-has-[:checked]:rotate-180" alt="icon">
                    <input type="checkbox" class="hidden">
                </label>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/user.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Name</p>
                        <p class="font-bold">{{ $oderData['name'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/call.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Phone No.</p>
                        <p class="font-bold">{{ $oderData['phone'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/sms.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Email</p>
                        <p class="font-bold">{{ $oderData['email'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/house-2.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Delivery to</p>
                        <p class="font-bold">{{ $oderData['address'] }}</p>
                    </div>
                </div>
            </section>
            <section id="payment-details" class="accordion flex flex-col rounded-[20px] p-4 pb-5 gap-5 mx-4 bg-white overflow-hidden transition-all duration-300 has-[:checked]:!h-[66px]">
                <label class="group flex items-center justify-between">
                    <h2 class="font-bold text-xl leading-[30px]">Payment Details</h2>
                    <img src="{{ asset('assets/images/icons/arrow-up.svg') }}" class="w-7 h-7 transition-all duration-300 group-has-[:checked]:rotate-180" alt="icon">
                    <input type="checkbox" class="hidden">
                </label>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Sub Total</p>
                    <p class="font-bold">Rp {{ number_format($oderData['sub_total_amount'],0,',','.') }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Promo Code</p>
                    <p class="font-bold">{{ $oderData['promo_code'] }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Discount</p>
                    <p class="font-bold text-[#FF1943]">- Rp {{ number_format($oderData['discount'],0,',','.') }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">PPN 11%</p>
                    <p class="font-bold">Rp {{ number_format($oderData['total_tax'],0,',','.') }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Delivery</p>
                    <p class="font-bold">Rp 0</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Grand Total</p>
                    <p class="font-bold text-2xl leading-9 text-[#07B704]">Rp {{ number_format($oderData['grand_total_amount'],0,',','.') }}</p>
                </div>
            </section>
            <div id="bottom-nav" class="relative flex h-[100px] w-full shrink-0 mt-5">
                <div class="fixed bottom-5 w-full max-w-[640px] z-30 px-4">
                    <div class="flex items-center justify-between rounded-full bg-[#2A2A2A] p-[10px] pl-6">
                        <div class="flex flex-col gap-[2px] mr-2">
                            <p class="text-white">Apakah Data anda sudah benar?</p>
                        </div>
                        <button type="button" class="rounded-full p-[12px_20px] bg-[#C5F277] font-bold text-nowrap" id="pay-button">
                            buy Now
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
        <script src="js/accordion.js"></script>
        <script src="js/payment.js"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(){
              // SnapToken acquired from previous step
              snap.pay('<?=$snapToken?>', {
                // Optional
                onSuccess: function(result){
                    window.location.replace("{{ route('front.payment_confirm') }}");;
                },
                // Optional
                onPending: function(result){
                  /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result){
                  /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
              });
            };
          </script>
    </body>
</html>