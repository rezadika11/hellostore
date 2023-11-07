@extends('user.layouts.main')
@section('title', 'Detail Produk')
@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('frontend.index') }}">Home</a>
                    </li>
                    <li class="active">@yield('title')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="shop-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details">
                        <div class="product-details-img">
                            <div class="tab-content jump">
                                <div id="shop-details-1" class="tab-pane large-img-style">
                                    <img src="{{ route('frontend.getImageProdukBaru', $produk->gambar) }}" alt="">
                                    @if ($produk->diskon)
                                        <span class="dec-price">-{{ $produk->diskon }}%</span>
                                    @else
                                        <span class="dec-price">New</span>
                                    @endif
                                    <div class="img-popup-wrap">
                                        <a class="img-popup"
                                            href="{{ route('frontend.getImageProdukBaru', $produk->gambar) }}"><i
                                                class="pe-7s-expand1"></i></a>
                                    </div>
                                </div>
                                <div id="shop-details-2" class="tab-pane active large-img-style">
                                    <img src="{{ route('frontend.getImageProdukBaru', $produk->gambar) }}" alt="">
                                    @if ($produk->diskon)
                                        <span class="dec-price">-{{ $produk->diskon }}%</span>
                                    @else
                                        <span class="dec-price">New</span>
                                    @endif
                                    <div class="img-popup-wrap">
                                        <a class="img-popup"
                                            href="{{ route('frontend.getImageProdukBaru', $produk->gambar) }}"><i
                                                class="pe-7s-expand1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-content ml-70">
                        <h2>{{ $produk->name }}</h2>
                        <div class="product-details-price">
                            @if ($produk->diskon)
                                <span>Rp.
                                    {{ format_uang($produk->harga - ($produk->diskon / 100) * $produk->harga) }}</span>
                                <span class="old">Rp.
                                    {{ format_uang($produk->harga) }}</span>
                            @else
                                <span>Rp. {{ format_uang($produk->harga) }}</span>
                            @endif
                        </div>
                        <p>{{ $produk->deskripsi }}</p>
                        <div class="pro-details-list">
                            <ul>
                                <li><b>Kategori</b> : {{ $produk->kategori->name }}</li>
                                <li><b>Stok</b>: {{ $produk->stok }}</li>
                                <li><b>Berat</b>: {{ $produk->berat }} </li>
                            </ul>
                        </div>
                        <div class="pro-details-quality">
                            @if (Auth::check())
                                <form action="{{ route('frontend.produkTambahCart') }}" method="POST" id="addCart">
                                    @csrf
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="quantity" value="1">
                                    </div>
                                    <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                                    <input type="hidden" name="harga" value="{{ $produk->harga }}">

                                    <div class="pro-details-cart btn-hover">
                                        <button type="submit" class="btn"
                                            style="background-color: #a749ff; color:white; hover:#3e0277">Add to
                                            cart</button>
                                    </div>
                                </form>
                            @else
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box" type="text" name="quantity" value="1">
                                </div>

                                <div class="pro-details-cart btn-hover">
                                    <a href="{{ route('login') }}">Add To Cart</a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="related-product-area pb-95">
        <div class="container">
            <div class="section-title text-center mb-50">
                <h2>Produk Terkait</h2>
            </div>
            <div class="related-product-active owl-carousel owl-dot-none">
                @foreach ($produkTerkait as $item)
                    <div class="card">
                        <div class="product-wrap">
                            <div class="product-img">
                                <a href="{{ route('frontend.produkDetail', $item->slug) }}">
                                    <img class="default-img"
                                        src="{{ route('frontend.getImageProdukBaru', $item->gambar) }}" alt=""
                                        height="250">
                                </a>
                                @if ($item->diskon)
                                    <span class="pink">-{{ $item->diskon }}%</span>
                                @else
                                    <span class="purple">New</span>
                                @endif
                                <div class="product-action">
                                    <div class="pro-same-action pro-cart">
                                        <a title="Add To Cart" href="#"><i class="fa-solid fa-cart-shopping"></i>
                                            Add to
                                            cart</a>
                                    </div>
                                    <div class="pro-same-action pro-quickview">
                                        <a title="Quick View" href="{{ route('frontend.produkDetail', $item->slug) }}"><i
                                                class="fa-regular fa-eye"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="product-content text-center">
                                    <h3><a
                                            href="{{ route('frontend.produkDetail', $item->slug) }}">{{ $item->name }}</a>
                                    </h3>
                                    <div class="product-price">
                                        @if ($item->diskon)
                                            <span>Rp.
                                                {{ format_uang($item->harga - ($item->diskon / 100) * $item->harga) }}</span>
                                            <span class="old">Rp.
                                                {{ format_uang($item->harga) }}</span>
                                        @else
                                            <span>Rp. {{ format_uang($item->harga) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
