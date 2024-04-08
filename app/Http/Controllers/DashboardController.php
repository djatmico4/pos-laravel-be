<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getTotals()
    {
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();

        // $totalCategories = Product::select('category', DB::raw('count(*) as total'))
        //     ->groupBy('category')
        //     ->get();

        $totalCategories = Product::select('category')
            ->distinct()
            ->get()
            ->count();
        // $totalCategories = Product::select(DB::raw('COUNT(DISTINCT category) as total_categories'))
        //     ->first()
        //     ->total_categories;

        return [
            'total_products' => $totalProducts,
            'total_users' => $totalUsers,
            'total_orders' => $totalOrders,
            'total_categories' => $totalCategories,
        ];
    }

    public function showDashboard(Request $request)
    {
        $totals = $this->getTotals();

        // Definisikan array yang berisi nama-nama hari
        $daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

        // Inisialisasi data penjualan harian, bulanan, dan tahunan
        $dailySales = Order::selectRaw('DATE(transaction_time) as date, SUM(total_price) as total_sales')
            ->groupBy('date')
            ->paginate(10);

        $monthlySales = Order::selectRaw('DATE_FORMAT(transaction_time, "%Y-%m") as month, SUM(total_price) as total_sales')
            ->groupBy('month')
            ->paginate(10);

        $yearlySales = Order::selectRaw('YEAR(transaction_time) as year, SUM(total_price) as total_sales')
            ->groupBy('year')
            ->paginate(10);

        // Periksa apakah parameter 'period' ada dalam request
        //$selectedPeriod = $request->has('period') ? $request->period : 'day';

        // Return the view with the correct view name
        return view('pages.app.dashboard-pos', compact('totals', 'dailySales', 'monthlySales', 'yearlySales', 'daysOfWeek'));
    }
}
