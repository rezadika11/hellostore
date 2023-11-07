@extends('user.layouts.main')
@section('title', 'Pembayaran')
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
    <div class="checkout-area pt-95 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="billing-info-wrap">
                        <h3>Detail Pembayaran</h3>
                        <form action="{{ route('frontend.prosesPembayaran') }}" method="POST" id="order"
                            enctype="multipart/form-data">
                            @csrf
                            @php
                                $totalSubtotal = 0;
                            @endphp
                            @foreach ($cart as $item)
                                <input type="hidden" name="id_produk[]" value="{{ $item->id_produk }}">
                                @php
                                    $diskon = $item->harga_asli - ($item->diskon / 100) * $item->harga_asli;
                                    $totalSubtotal += $diskon * $item->jumlah;
                                @endphp
                                <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                            @endforeach
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name')
                                            is-invalid
                                        @enderror"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Provinsi</label>
                                        <input type="text" name="provinsi"
                                            class="form-control @error('provinsi')
                                        is-invalid
                                    @enderror"
                                            value="{{ old('provinsi') }}">
                                        @error('provinsi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Kabupaten</label>
                                        <input type="text" name="kabupaten"
                                            class=" @error('kabupaten')
                                        is-invalid
                                    @enderror"
                                            value="{{ old('kabupaten') }}">
                                        @error('kabupaten')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Kecamatan</label>
                                        <input type="text" name="kecamatan"
                                            class="form-control @error('kecamatan')
                                        is-invalid
                                    @enderror"
                                            value="{{ old('kecamatan') }}">
                                        @error('kecamatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Alamat</label>
                                        <input type="text"
                                            class="billing-address form-control @error('alamat')
                                        is-invalid
                                    @enderror"
                                            name="alamat" value="{{ old('alamat') }}"
                                            placeholder="Nomor rumah, jalan, rt/rw desa" type="text">
                                        @error('alamat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Kode pos</label>
                                        <input type="number" name="kode_pos"
                                            class="form-control @error('kode_pos')
                                        is-invalid
                                    @enderror"
                                            value="{{ old('kode_pos') }}">
                                        @error('kode_pos')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>No Hp</label>
                                        <input type="number" name="no_hp"
                                            class="form-control @error('no_hp')
                                        is-invalid
                                    @enderror"
                                            value="{{ old('no_hp') }}">
                                        @error('no_hp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Bukti Pembayaran</label>
                                        <input type="file" name="gambar"
                                            class="form-control @error('gambar')
                                        is-invalid
                                    @enderror"
                                            value="{{ old('gambar') }}">
                                        @error('gambar')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="your-order-area">
                        <h3>Order</h3>
                        <div class="your-order-wrap gray-bg-4">
                            <div class="your-order-product-info">
                                <div class="your-order-top">
                                    <ul>
                                        <li>Produk</li>
                                        <li>Subtotal</li>
                                    </ul>
                                </div>
                                <div class="your-order-middle">
                                    <ul>
                                        @php
                                            $totalSubtotal = 0;
                                        @endphp
                                        @foreach ($cart as $item)
                                            <li><span class="order-middle-left">{{ $item->name }} x
                                                    {{ $item->jumlah }}</span> <span class="order-price">Rp.
                                                    {{ format_uang($item->harga) }} </span></li>
                                            @php
                                                $diskon = $item->harga_asli - ($item->diskon / 100) * $item->harga_asli;
                                                $totalSubtotal += $diskon * $item->jumlah;
                                            @endphp
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="your-order-total">
                                    <ul>
                                        <li class="order-total">Total</li>
                                        <li>Rp. {{ format_uang($totalSubtotal) }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="payment-method">
                                <div class="payment-accordion element-mrg">
                                    <div class="panel-group" id="accordion">
                                        <div class="panel payment-accordion">
                                            <div class="panel-heading" id="method-one">
                                                <h4 class="panel-title">
                                                    <a data-bs-toggle="collapse">
                                                        Silahkan Transfer BRI ke No Rek. 7808765544
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Place-order mt-25">
                            @if ($data)
                                <a class="btn-hover"
                                    onclick="event.preventDefault(); document.getElementById('order').submit();">Order</a>
                            @else
                                <a class="btn-hover" href="{{ route('frontend.index') }}">Order</a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
