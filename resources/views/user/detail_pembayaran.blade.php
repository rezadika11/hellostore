@extends('user.layouts.main')
@section('title', 'Detail Pembayaran')
@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">@yield('title') </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cart-main-area pt-90 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    {{-- <form action="{{ route('frontend.prosesCheckout') }}" method="POST" id="checkout">
                        @csrf --}}
                    <div class="table-content table-responsive cart-table-content">
                        <table class="tableCart">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Total</th>
                                    <th>No Resi</th>
                                    <th>Pengiriman</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembayaran as $item)
                                    <tr class="bg-light">
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $item->total_quantity }}</td>
                                        <td>Rp. {{ format_uang($item->total_harga) }}</td>
                                        <td>
                                            @if ($item->no_resi)
                                                {{ $item->no_resi }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->shipping)
                                                {{ $item->shipping }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
