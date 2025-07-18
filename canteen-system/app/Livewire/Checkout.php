<?php

namespace App\Livewire;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Checkout extends Component
{
    public $cartItems = [];
    public $customerName = '';
    public $customerEmail = '';
    public $customerPhone = '';
    public $deliveryType = 'pickup';
    public $paymentMethod = 'online';
    public $deliveryAddress = '';
    public $notes = '';
    public $deliveryTime = '';
    
    public $isProcessing = false;
    public $showSuccess = false;
    public $orderId = null;

    public function mount()
    {
        $this->cartItems = session()->get('cart', []);
        
        if (Auth::check()) {
            $this->customerName = Auth::user()->name;
            $this->customerEmail = Auth::user()->email;
        }

        // Guests can only use online payment
        if (!Auth::check()) {
            $this->paymentMethod = 'online';
        }
    }

    public function rules()
    {
        $rules = [
            'customerName' => 'required|string|max:255',
            'customerEmail' => 'required|email|max:255',
            'customerPhone' => 'nullable|string|max:20',
            'deliveryType' => 'required|in:pickup,delivery',
            'paymentMethod' => 'required|in:online,on_site',
            'notes' => 'nullable|string|max:1000',
        ];

        if ($this->deliveryType === 'delivery') {
            $rules['deliveryAddress'] = 'required|string|max:500';
            $rules['deliveryTime'] = 'required|date|after:now';
        }

        // Guests can only use online payment
        if (!Auth::check()) {
            $rules['paymentMethod'] = 'required|in:online';
        }

        return $rules;
    }

    public function placeOrder()
    {
        $this->validate();

        if (empty($this->cartItems)) {
            $this->addError('cart', 'Your cart is empty');
            return;
        }

        $this->isProcessing = true;

        try {
            DB::beginTransaction();

            // Calculate total
            $totalAmount = collect($this->cartItems)->sum('total');

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $this->customerName,
                'customer_email' => $this->customerEmail,
                'customer_phone' => $this->customerPhone,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'delivery_type' => $this->deliveryType,
                'payment_method' => $this->paymentMethod,
                'payment_status' => $this->paymentMethod === 'online' ? 'pending' : 'pending',
                'delivery_address' => $this->deliveryType === 'delivery' ? $this->deliveryAddress : null,
                'notes' => $this->notes,
                'delivery_time' => $this->deliveryType === 'delivery' ? $this->deliveryTime : null,
            ]);

            // Create order items
            foreach ($this->cartItems as $item) {
                $menuItem = MenuItem::find($item['id']);
                
                if (!$menuItem || !$menuItem->is_available) {
                    throw new \Exception("Item {$item['name']} is no longer available");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);
            }

            // Broadcast order placed event
            event(new OrderPlaced($order));

            DB::commit();

            // Clear cart
            session()->forget('cart');

            $this->orderId = $order->id;
            $this->showSuccess = true;
            $this->isProcessing = false;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->isProcessing = false;
            $this->addError('order', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function getCartTotal()
    {
        return collect($this->cartItems)->sum('total');
    }

    public function render()
    {
        return view('livewire.checkout', [
            'cartTotal' => $this->getCartTotal(),
        ]);
    }
}