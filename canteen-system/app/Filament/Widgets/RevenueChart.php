<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Revenue';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');
        
        // Get last 12 months
        $months = collect(range(11, 0))->map(function ($monthsBack) {
            return Carbon::now()->subMonths($monthsBack);
        });
        
        $revenueData = $months->map(function ($month) use ($isAdmin, $user) {
            $query = Order::query()
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->where('payment_status', 'paid');
                
            if (!$isAdmin) {
                $query->whereHas('orderItems.menuItem', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }
            
            return $query->sum('total_amount');
        });
        
        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $revenueData->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $months->map(fn ($month) => $month->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}