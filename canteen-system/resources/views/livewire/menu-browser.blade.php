<div>
    <!-- Menu Items Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($menuItems as $item)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                <!-- Image -->
                <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                    @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" 
                             alt="{{ $item->name }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-4">
                    <!-- Category Badge -->
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($item->category === 'main_course') bg-green-100 text-green-800
                            @elseif($item->category === 'appetizer') bg-yellow-100 text-yellow-800
                            @elseif($item->category === 'dessert') bg-pink-100 text-pink-800
                            @elseif($item->category === 'beverage') bg-blue-100 text-blue-800
                            @elseif($item->category === 'snack') bg-gray-100 text-gray-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($item->category)) }}
                        </span>
                        @if(!$item->is_available)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Out of Stock
                            </span>
                        @endif
                    </div>

                    <!-- Name and Vendor -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $item->name }}</h3>
                    <p class="text-sm text-gray-500 mb-2">by {{ $item->user->name }}</p>

                    <!-- Description -->
                    @if($item->description)
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $item->description }}</p>
                    @endif

                    <!-- Price and Action -->
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-gray-900">${{ number_format($item->price, 2) }}</span>
                        
                        @if($item->is_available)
                            <button wire:click="$dispatch('add-to-cart', { menuItemId: {{ $item->id }} })"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span>Add to Cart</span>
                            </button>
                        @else
                            <button disabled 
                                    class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-medium cursor-not-allowed">
                                Unavailable
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No menu items found</h3>
                <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($menuItems->hasPages())
        <div class="mt-8">
            {{ $menuItems->links() }}
        </div>
    @endif
</div>