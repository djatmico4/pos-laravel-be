@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard - CODAPOS</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total User</h4>
                            </div>
                            <div class="card-body">
                                {{ $totals['total_users'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fa-solid fa-box fa-xl" style="color: #FFFFFF;"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Products</h4>
                            </div>
                            <div class="card-body">
                                {{ $totals['total_products'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fa-solid fa-cart-flatbed fa-xl" style="color: #FFFFFF;"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Orders</h4>
                            </div>
                            <div class="card-body">
                                {{ $totals['total_orders'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fa-solid fa-table-list fa-xl" style="color: #FFFFFF;"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Category</h4>
                            </div>
                            <div class="card-body">
                                {{ $totals['total_categories'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <button id="btnDay" class="btn btn-primary">Day</button>
                                    <button id="btnMonth" class="btn btn-danger">Month</button>
                                    <button id="btnYear" class="btn btn-warning">Year</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart2" height="182"></canvas>
                            <div class="statistic-details mt-sm-4">
                                {{-- <div class="row">
                                    @if ($selectedPeriod === 'day')
                                        @foreach ($dailySales as $sale)
                                            <div class="col-md-3 col-6">
                                                <div class="statistic-details-item">
                                                    <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> {{ $sale->total_sales }}%</span>
                                                    <div class="detail-value">${{ $sale->total_sales }}</div>
                                                    <div class="detail-name">{{ $daysOfWeek[date('w', strtotime($sale->date))] }}'s Sales</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @elseif ($selectedPeriod === 'month')
                                        @foreach ($monthlySales as $sale)
                                            <div class="col-md-3 col-6">
                                                <div class="statistic-details-item">
                                                    <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> {{ $sale->total_sales }}%</span>
                                                    <div class="detail-value">${{ $sale->total_sales }}</div>
                                                    <div class="detail-name">{{ date('F Y', strtotime($sale->month)) }}'s Sales</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @elseif ($selectedPeriod === 'year')
                                        @foreach ($yearlySales as $sale)
                                            <div class="col-md-3 col-6">
                                                <div class="statistic-details-item">
                                                    <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> {{ $sale->total_sales }}%</span>
                                                    <div class="detail-value">${{ $sale->total_sales }}</div>
                                                    <div class="detail-name">{{ $sale->year }}'s Sales</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>

    {{-- <script>
        // Mendefinisikan array yang berisi nama-nama hari
        var daysOfWeek = {!! json_encode($daysOfWeek) !!};

        // Mendapatkan data penjualan harian, bulanan, dan tahunan dari PHP menggunakan blade directive
        var dailySalesData = {!! json_encode($dailySales->pluck('total_sales')) !!};
        var monthlySalesData = {!! json_encode($monthlySales->pluck('total_sales')) !!};
        var yearlySalesData = {!! json_encode($yearlySales->pluck('total_sales')) !!};

        // Menyimpan referensi ke tombol-tombol
        var btnDay = document.getElementById('btnDay');
        var btnMonth = document.getElementById('btnMonth');
        var btnYear = document.getElementById('btnYear');

        // Mendengarkan klik pada tombol "Day"
        btnDay.addEventListener('click', function() {
            updateChart('Day', daysOfWeek, dailySalesData, 'rgba(63,82,227,.8)'); // Warna biru
        });

        // Mendengarkan klik pada tombol "Month"
        btnMonth.addEventListener('click', function() {
            updateChart('Month', {!! json_encode($monthlySales->pluck('month')) !!}, monthlySalesData, 'rgba(254,86,83,.7)'); // Warna merah
        });

        // Mendengarkan klik pada tombol "Year"
        btnYear.addEventListener('click', function() {
            updateChart('Year', {!! json_encode($yearlySales->pluck('year')) !!}, yearlySalesData, 'rgba(87,75,144,.5)'); // Warna kuning
        });

        // Fungsi untuk memperbarui grafik berdasarkan data yang diberikan
        function updateChart(label, labels, data, color) {
            myChart.data.datasets[0].label = label + ' Sales'; // Update label dataset
            myChart.data.labels = labels; // Update label sumbu x
            myChart.data.datasets[0].data = data; // Update data penjualan
            myChart.data.datasets[0].backgroundColor = color; // Update warna dataset
            myChart.update(); // Perbarui grafik
        }

        // Membuat objek Chart.js
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: daysOfWeek, // Gunakan variabel `daysOfWeek` di sini sebagai label default
                datasets: [{
                    label: 'Daily Sales',
                    data: dailySalesData, // Gunakan variabel `dailySalesData` di sini sebagai data penjualan harian default
                    borderWidth: 2,
                    backgroundColor: 'rgba(83, 56, 125, 0.8)', // Warna biru
                    borderColor: 'transparent',
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(83, 56, 125, 0.8)',
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script> --}}

    {{-- <script>
        // Mendefinisikan array yang berisi nama-nama hari
        var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

        // Mendapatkan data tanggal dari PHP menggunakan blade directive
        var dates = {!! json_encode($dailySales->pluck('date')->map(function($date) use ($daysOfWeek) {
            // Mengonversi format tanggal menjadi nama hari
            return $daysOfWeek[date('w', strtotime($date))];
        })) !!};

        // Sisipkan kode Chart.js di sini, gunakan variabel `dates` sebagai label
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates, // Gunakan variabel `dates` di sini sebagai label
                datasets: [{
                    label: 'Daily Sales',
                    data: {!! json_encode($dailySales->pluck('total_sales')) !!},
                    borderWidth: 2,
                    backgroundColor: 'rgba(63,82,227,.8)',
                    borderColor: 'transparent',
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                },{
                    label: 'Monthly Sales',
                    data: {!! json_encode($monthlySales->pluck('total_sales')) !!},
                    borderWidth: 2,
                    backgroundColor: 'rgba(254,86,83,.7)',
                    borderColor: 'transparent',
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
                },{
                    label: 'Yearly Sales',
                    data: {!! json_encode($yearlySales->pluck('total_sales')) !!},
                    borderWidth: 2,
                    backgroundColor: 'rgba(87,75,144,.5)',
                    borderColor: 'transparent',
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(87,75,144,.8)',
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script> --}}

    <script>
        // Mendefinisikan array yang berisi nama-nama hari
        var daysOfWeek = {!! json_encode($daysOfWeek) !!};

        // Mendapatkan data penjualan harian, bulanan, dan tahunan dari PHP menggunakan blade directive
        var dailySalesData = {!! json_encode($dailySales->pluck('total_sales')) !!};
        var monthlySalesData = {!! json_encode($monthlySales->pluck('total_sales')) !!};
        var yearlySalesData = {!! json_encode($yearlySales->pluck('total_sales')) !!};

        // Menyimpan referensi ke tombol-tombol
        var btnDay = document.getElementById('btnDay');
        var btnMonth = document.getElementById('btnMonth');
        var btnYear = document.getElementById('btnYear');

        // Mendengarkan klik pada tombol "Day"
        btnDay.addEventListener('click', function() {
            updateChart('Day', daysOfWeek, dailySalesData, 'rgba(83, 56, 125, 0.8)'); // Warna ungu
        });

        // Mendengarkan klik pada tombol "Month"
        btnMonth.addEventListener('click', function() {
            updateChart('Month', {!! json_encode($monthlySales->pluck('month')) !!}, monthlySalesData, 'rgba(254,86,83,.7)'); // Warna merah
        });

        // Mendengarkan klik pada tombol "Year"
        btnYear.addEventListener('click', function() {
            updateChart('Year', {!! json_encode($yearlySales->pluck('year')) !!}, yearlySalesData, 'rgba(255, 255, 0, 0.8)'); // Warna kuning
        });

        // Fungsi untuk memperbarui grafik berdasarkan data yang diberikan
        function updateChart(label, labels, data, color) {
            myChart.data.datasets[0].label = label + ' Sales'; // Update label dataset
            myChart.data.labels = labels; // Update label sumbu x
            myChart.data.datasets[0].data = data; // Update data penjualan
            myChart.data.datasets[0].backgroundColor = color; // Update warna dataset
            myChart.update(); // Perbarui grafik
        }

        // Membuat objek Chart.js
        var ctx = document.getElementById("myChart2").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: daysOfWeek, // Gunakan variabel `daysOfWeek` di sini sebagai label default
                datasets: [{
                    label: 'Daily Sales',
                    data: dailySalesData, // Gunakan variabel `dailySalesData` di sini sebagai data penjualan harian default
                    borderWidth: 2,
                    backgroundColor: 'rgba(83, 56, 125, 0.8)',
                    borderColor: 'transparent',
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(83, 56, 125, 0.8)',
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endpush
