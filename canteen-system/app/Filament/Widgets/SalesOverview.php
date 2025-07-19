<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Expense;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');
        
        // Base queries
        $ordersQuery = Order::query();
        $menuItemsQuery = MenuItem::query();
        $expensesQuery = Expense::query();
        
        // Filter by user if not admin
        if (!$isAdmin) {
            $ordersQuery->whereHas('orderItems.menuItem', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
            $menuItemsQuery->where('user_id', $user->id);
            $expensesQuery->where('user_id', $user->id);
        }
        
        // Today's stats
        $todayRevenue = (clone $ordersQuery)
            ->whereDate('created_at', Carbon::today())
            ->where('payment_status', 'paid')
            ->sum('total_amount');
            
        $todayOrders = (clone $ordersQuery)
            ->whereDate('created_at', Carbon::today())
            ->count();
            
        // This month's stats
        $monthlyRevenue = (clone $ordersQuery)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
            
        $monthlyExpenses = (clone $expensesQuery)
            ->whereMonth('expense_date', Carbon::now()->month)
            ->whereYear('expense_date', Carbon::now()->year)
            ->sum('amount');
            
        // Total stats
        $totalMenuItems = $menuItemsQuery->count();
        $totalRevenue = (clone $ordersQuery)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
            
        return [
            Stat::make('Today\'s Revenue', '$' . number_format($todayRevenue, 2))
                ->description('Revenue for today')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
                
            Stat::make('Today\'s Orders', $todayOrders)
                ->description('Orders placed today')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),
                
            Stat::make('Monthly Revenue', '$' . number_format($monthlyRevenue, 2))
                ->description('Revenue this month')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),
                
            Stat::make('Monthly Expenses', '$' . number_format($monthlyExpenses, 2))
                ->description('Expenses this month')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
                
            Stat::make('Total Menu Items', $totalMenuItems)
                ->description($isAdmin ? 'All menu items' : 'Your menu items')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('gray'),
                
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description('All-time revenue')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('success'),
        ];
    }
}