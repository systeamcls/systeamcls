<?php

namespace App\Livewire;

use App\Models\MenuItem;
use Livewire\Attributes\On;
use Livewire\Component;

class ShoppingCart extends Component
{
    public $cartItems = [];
    public $isOpen = false;

    public function mount()
    {
        $this->loadCart();
    }

    #[On('add-to-cart')]
    public function addToCart($menuItemId)
    {
        $menuItem = MenuItem::find($menuItemId);
        
        if (!$menuItem || !$menuItem->is_available) {
            $this->dispatch('cart-error', message: 'Item is not available');
            return;
        }

        $existingItemIndex = collect($this->cartItems)->search(function ($item) use ($menuItemId) {
            return $item['id'] == $menuItemId;
        });

        if ($existingItemIndex !== false) {
            $this->cartItems[$existingItemIndex]['quantity']++;
            $this->cartItems[$existingItemIndex]['total'] = 
                $this->cartItems[$existingItemIndex]['quantity'] * $this->cartItems[$existingItemIndex]['price'];
        } else {
            $this->cartItems[] = [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'price' => $menuItem->price,
                'quantity' => 1,
                'total' => $menuItem->price,
                'tenant_name' => $menuItem->user->name,
            ];
        }

        $this->saveCart();
        $this->dispatch('cart-updated', count: $this->getCartCount());
        $this->dispatch('cart-success', message: 'Item added to cart');
    }

    public function updateQuantity($index, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeItem($index);
            return;
        }

        $this->cartItems[$index]['quantity'] = $quantity;
        $this->cartItems[$index]['total'] = $quantity * $this->cartItems[$index]['price'];
        $this->saveCart();
        $this->dispatch('cart-updated', count: $this->getCartCount());
    }

    public function removeItem($index)
    {
        unset($this->cartItems[$index]);
        $this->cartItems = array_values($this->cartItems);
        $this->saveCart();
        $this->dispatch('cart-updated', count: $this->getCartCount());
    }

    public function clearCart()
    {
        $this->cartItems = [];
        $this->saveCart();
        $this->dispatch('cart-updated', count: 0);
    }

    public function toggleCart()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function getCartCount()
    {
        return collect($this->cartItems)->sum('quantity');
    }

    public function getCartTotal()
    {
        return collect($this->cartItems)->sum('total');
    }

    private function loadCart()
    {
        $this->cartItems = session()->get('cart', []);
    }

    private function saveCart()
    {
        session()->put('cart', $this->cartItems);
    }

    public function render()
    {
        return view('livewire.shopping-cart', [
            'cartCount' => $this->getCartCount(),
            'cartTotal' => $this->getCartTotal(),
        ]);
    }
}