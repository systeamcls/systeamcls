<div>
    <!-- Cart Button -->
    <div class="fixed bottom-4 right-4 z-50">
        <button wire:click="toggleCart" 
                class="bg-red-500 hover:bg-red-600 text-white rounded-full p-4 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 9H19M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6"></path>
            </svg>
            @if(count($cartItems) > 0)
                <span class="bg-yellow-400 text-red-900 rounded-full px-2 py-1 text-xs font-bold min-w-[1.5rem] text-center">
                    {{ array_sum(array_column($cartItems, 'quantity')) }}
                </span>
            @endif
        </button>
    </div>

    <!-- Cart Overlay -->
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-hidden" x-data="{ show: @entangle('isOpen') }" 
             x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            
            <!-- Background overlay -->
            <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="toggleCart"></div>
            
            <!-- Cart panel -->
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div class="w-screen max-w-md" x-show="show" 
                     x-transition:enter="transform transition ease-in-out duration-500" 
                     x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                     x-transition:leave="transform transition ease-in-out duration-500" 
                     x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                    
                    <div class="h-full flex flex-col bg-white shadow-xl">
                        <!-- Header -->
                        <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900">Shopping Cart</h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button wire:click="toggleCart" 
                                            class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Cart Items -->
                            <div class="mt-8">
                                <div class="flow-root">
                                    @if(count($cartItems) > 0)
                                        <ul class="-my-6 divide-y divide-gray-200">
                                            @foreach($cartItems as $index => $item)
                                                <li class="py-6 flex">
                                                    <div class="flex-shrink-0 w-16 h-16 border border-gray-200 rounded-md overflow-hidden">
                                                        @if($item['image'])
                                                            <img src="{{ Storage::url($item['image']) }}" 
                                                                 alt="{{ $item['name'] }}" 
                                                                 class="w-full h-full object-center object-cover">
                                                        @else
                                                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="ml-4 flex-1 flex flex-col">
                                                        <div>
                                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                                <h3>{{ $item['name'] }}</h3>
                                                                <p class="ml-4">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                                            </div>
                                                            <p class="mt-1 text-sm text-gray-500">by {{ $item['vendor'] }}</p>
                                                        </div>
                                                        <div class="flex-1 flex items-end justify-between text-sm">
                                                            <div class="flex items-center space-x-2">
                                                                <button wire:click="decrementQuantity({{ $index }})" 
                                                                        class="p-1 text-gray-400 hover:text-gray-500">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                                    </svg>
                                                                </button>
                                                                <span class="text-gray-700 font-medium">{{ $item['quantity'] }}</span>
                                                                <button wire:click="incrementQuantity({{ $index }})" 
                                                                        class="p-1 text-gray-400 hover:text-gray-500">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            <div class="flex">
                                                                <button wire:click="removeFromCart({{ $index }})" 
                                                                        class="font-medium text-red-600 hover:text-red-500">
                                                                    Remove
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-center py-12">
                                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 9H19M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
                                            <p class="text-gray-500">Start adding some delicious items!</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        @if(count($cartItems) > 0)
                            <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>Subtotal</p>
                                    <p>${{ number_format($this->getCartTotal(), 2) }}</p>
                                </div>
                                <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                                <div class="mt-6">
                                    <a href="{{ route('checkout') }}" 
                                       class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 w-full">
                                        Checkout
                                    </a>
                                </div>
                                <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                                    <p>
                                        or 
                                        <button wire:click="toggleCart" 
                                                class="text-red-600 font-medium hover:text-red-500">
                                            Continue Shopping<span aria-hidden="true"> &rarr;</span>
                                        </button>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@script
<script>
    // Listen for cart events
    $wire.on('cart-updated', () => {
        // Optional: Show toast notification
        console.log('Cart updated');
    });

    $wire.on('cart-error', (event) => {
        alert(event.message);
    });
</script>
@endscript