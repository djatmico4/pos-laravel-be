<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;

class SalesReportController extends Controller
{

    public function index()
    {
        return view('pages.reports.index');
    }

    public function filter(Request $request)
    {
        $this->validate($request, [
            'date_from'  => 'required',
            'date_to'    => 'required',
        ]);

        $date_from  = $request->date_from;
        $date_to    = $request->date_to;

        //get data donation by range date
        $orders = Order::with('kasir')
            ->whereDate('created_at', '>=', $request->date_from)
            ->whereDate('created_at', '<=', $request->date_to)
            ->paginate(10);

        // dd($orders);

        return view('pages.reports.index', compact('orders'));
    }

    public function download(Request $request)
    {
        $this->validate($request, [
            'date_from'  => 'required',
            'date_to'    => 'required',
        ]);

        $date_from  = $request->date_from;
        $date_to    = $request->date_to;

        return (new SalesReportExport)->forRange($date_from, $date_to)->download('report-orders.xlsx');
    }

    public function salesReport(Request $request)
    {
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

        // Kembalikan tampilan dengan data yang diperlukan
        return view('pages.reports.sales-report', compact('dailySales', 'monthlySales', 'yearlySales'));
    }
}
