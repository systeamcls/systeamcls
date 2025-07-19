<div>
    @if($showSuccess)
        <!-- Success Message -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Order placed successfully!</h3>
                    <div class="mt-2 text-sm text-green-700">
                        <p>Your order #{{ $orderId }} has been placed and will be processed shortly. You will receive updates via email.</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('menu') }}" class="text-sm font-medium text-green-800 hover:text-green-700">
                            Continue Shopping →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Order Form -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Information</h2>
                
                <form wire:submit="placeOrder" class="space-y-6">
                    <!-- Customer Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Customer Details</h3>
                        
                        <div>
                            <label for="customerName" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="customerName" wire:model="customerName" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" 
                                   required>
                            @error('customerName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="customerEmail" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" id="customerEmail" wire:model="customerEmail" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            @error('customerEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="customerPhone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" id="customerPhone" wire:model="customerPhone" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            @error('customerPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Delivery Options -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Delivery Options</h3>
                        
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <input id="pickup" name="deliveryType" type="radio" value="pickup" wire:model.live="deliveryType" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                                <label for="pickup" class="ml-3 block text-sm font-medium text-gray-700">
                                    Pickup
                                    <span class="text-gray-500 block text-xs">Free</span>
                                </label>
                            </div>
                            <div>
                                <input id="delivery" name="deliveryType" type="radio" value="delivery" wire:model.live="deliveryType" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                                <label for="delivery" class="ml-3 block text-sm font-medium text-gray-700">
                                    Delivery
                                    <span class="text-gray-500 block text-xs">$2.99</span>
                                </label>
                            </div>
                        </div>

                        @if($deliveryType === 'delivery')
                            <div>
                                <label for="deliveryAddress" class="block text-sm font-medium text-gray-700">Delivery Address</label>
                                <textarea id="deliveryAddress" wire:model="deliveryAddress" rows="3" 
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" 
                                          required></textarea>
                                @error('deliveryAddress') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <div>
                            <label for="deliveryTime" class="block text-sm font-medium text-gray-700">Preferred Delivery/Pickup Time</label>
                            <input type="datetime-local" id="deliveryTime" wire:model="deliveryTime" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            @error('deliveryTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Payment Options -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Payment Method</h3>
                        
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <input id="online" name="paymentMethod" type="radio" value="online" wire:model.live="paymentMethod" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                                <label for="online" class="ml-3 block text-sm font-medium text-gray-700">
                                    Online Payment
                                    <span class="text-gray-500 block text-xs">Credit/Debit Card, PayPal</span>
                                </label>
                            </div>
                            
                            @auth
                                <div>
                                    <input id="on_site" name="paymentMethod" type="radio" value="on_site" wire:model.live="paymentMethod" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                                    <label for="on_site" class="ml-3 block text-sm font-medium text-gray-700">
                                        Pay On-Site
                                        <span class="text-gray-500 block text-xs">Cash or Card at pickup/delivery</span>
                                    </label>
                                </div>
                            @else
                                <div class="text-sm text-gray-500">
                                    <p>Pay On-Site option available for registered users only.</p>
                                    <a href="{{ route('register') }}" class="text-red-600 hover:text-red-500">Register here</a>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Special Instructions -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Special Instructions (Optional)</label>
                        <textarea id="notes" wire:model="notes" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" 
                                  placeholder="Any special requests or dietary requirements..."></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove>Place Order</span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                
                @if(count($cartItems) > 0)
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-md overflow-hidden">
                                    @if($item['image'])
                                        <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $item['name'] }}</h4>
                                    <p class="text-sm text-gray-500">by {{ $item['vendor'] }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="border-t border-gray-200 pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Subtotal</span>
                                <span>${{ number_format($this->getSubtotal(), 2) }}</span>
                            </div>
                            @if($deliveryType === 'delivery')
                                <div class="flex justify-between text-sm">
                                    <span>Delivery Fee</span>
                                    <span>$2.99</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Total</span>
                                <span>${{ number_format($this->getTotal(), 2) }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8 9H19M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
                        <p class="text-gray-500 mb-4">Add some items to your cart before checkout.</p>
                        <a href="{{ route('menu') }}" class="text-red-600 hover:text-red-500 font-medium">
                            Browse Menu →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>