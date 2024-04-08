<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesReportExport implements  FromQuery, WithMapping, WithHeadings
{

    use Exportable;

    public function forRange(String $start, String $end)
    {
        $this->start = $start;
        $this->end = $end;
        return $this;
    }

    public function query()
    {
        return Order::query()->with('kasir')->whereBetween('transaction_time', [$this->start, $this->end]);
    }

    public function map($order): array
    {

         static $rowNumber = 0; // Membuat variabel static untuk menyimpan nomor urutan
        return [
            ++$rowNumber, // Menggunakan variabel $rowNumber yang ditingkatkan setiap kali map dipanggil
            Carbon::parse($order->transaction_time)->format('d-m-Y H:i:s'),
            $order->payment_method,
            $order->total_price,
            $order->kasir->name
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Transaksi',
            'Metode Pembayaran',
            'Total Sales',
            'Kasir',
        ];
    }
}
