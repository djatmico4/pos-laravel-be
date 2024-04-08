@extends('layouts.app')

@section('title', 'Range Report')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Sales Range Report</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Sales Range Report</a></div>
                    <div class="breadcrumb-item">Sales Range Report Data</div>
                </div>
            </div>
            <div class="section-body">
                {{-- <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div> --}}
                <h2 class="section-title">Sales Range Report Data</h2>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pilih Rentang Tanggal</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('report.filter') }}" method="GET">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                {{-- <label>Dari Tanggal</label> --}}
                                                <input type="date" name="date_from"
                                                    value="{{ old('date_from') ?? request()->query('date_from') }}"
                                                    class="form-control datepicker">
                                            </div>
                                            @error('date_from')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">sampai</span>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                {{-- <label>Ke Tanggal</label> --}}
                                                <input type="date" name="date_to"
                                                    value="{{ old('date_to') ?? request()->query('date_to') }}"
                                                    class="form-control datepicker">
                                            </div>
                                            @error('date_to')
                                                <div class="alert alert-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                                Filter
                                            </button>
                                        </div>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                                Filter
                                                </button>
                                            </div>
                                        </div>
                                    </div> --}}
                                </form>
                                {{-- <div class="clearfix mb-3"></div> --}}
                                @if ($orders ?? '')
                                    @if (count($orders) > 0)
                                        <div class="table-responsive">
                                            <table class="table-striped table">
                                                <tr>
                                                    <th>Transaction Time</th>
                                                    <th>Metode Pembayaran</th>
                                                    <th>Total Price</th>
                                                    <th>Total Item</th>
                                                    <th>kasir</th>
                                                </tr>
                                                @forelse ($orders as $order)
                                                    <tr>
                                                        <td>
                                                            <a
                                                                href="{{ route('order.show', $order->id) }}">{{ $order->transaction_time }}</a>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="{{ route('order.show', $order->id) }}">{{ $order->payment_method }}</a>
                                                        </td>
                                                        <td>
                                                            @currency($order->total_price)
                                                        </td>
                                                        <td>
                                                            {{ $order->total_item }}
                                                        </td>
                                                        <td>
                                                            {{ $order->kasir->name }}

                                                        </td>

                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td>"No Order in this Date!"</td>
                                                    </tr>
                                                @endforelse

                                            </table>
                                        </div>
                                        <div class="float-right">
                                            {{ $orders->withQueryString()->links() }}
                                        </div>

                                        <form action="{{ route('report.download') }}" method="GET">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="date" hidden name="date_from"
                                                            value="{{ old('date_from') ?? request()->query('date_from') }}"
                                                            class="form-control datepicker">
                                                    </div>
                                                    @error('date_from')
                                                        <div class="alert alert-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="date" hidden name="date_to"
                                                            value="{{ old('date_to') ?? request()->query('date_to') }}"
                                                            class="form-control datepicker">
                                                    </div>
                                                    @error('date_to')
                                                        <div class="alert alert-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row float-left">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary btn-lg btn-block"
                                                            tabindex="4">
                                                            Download
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    @endif
                                @endif
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
