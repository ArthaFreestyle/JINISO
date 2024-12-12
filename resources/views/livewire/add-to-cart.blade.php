<div>
    {{-- Menampilkan kontrol quantity --}}
    <div class="flex items-center space-x-2">
        {{-- Input untuk memilih quantity --}}
        <input 
            type="number" 
            min="1" 
            class="border border-gray-300 rounded w-[60px] text-center"
            wire:model="quantity" 
            wire:change="validateQuantity"
            placeholder="1" />

        {{-- Ikon cart --}}
        <img 
            src="assets/images/icons/cart.svg" 
            class="w-[24px] h-[24px] cursor-pointer" 
            alt="cart"
            wire:click="addToCart" />
    </div>
</div>
