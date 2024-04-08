@extends('layouts.app')

@section('title', 'Report Data')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Sales Report</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Sales Report</a></div>
                    <div class="breadcrumb-item">Sales Report Data</div>
                </div>
            </div>
            <div class="section-body">
                {{-- <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div> --}}
                <h2 class="section-title">Sales Report Data</h2>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daily Sales</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dailySales as $dailySale)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($dailySale->date)->format('d F Y') }}</td>
                                                    <td>{{ formatCurrency($dailySale->total_sales) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $dailySales->links() }}
                                {{-- </form> --}}

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Monthly Sales</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($monthlySales as $monthlySale)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($monthlySale->month)->format('F Y') }}</td>
                                                    <td>{{ formatCurrency($monthlySale->total_sales) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $monthlySales->links() }}
                                {{-- </form> --}}

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Yearly Sales</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Year</th>
                                                <th>Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($yearlySales as $yearlySale)
                                                <tr>
                                                    <td>{{ $yearlySale->year }}</td>
                                                    <td>{{ formatCurrency($yearlySale->total_sales) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $yearlySales->links() }}
                                {{-- </form> --}}

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
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    {{-- <script src="assets/js/page/forms-advanced-forms.js"></script> --}}
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
