@extends('user.layouts.main')
@section('title', 'Kategori')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <h3> Kategori: {{ ucwords($slug) }}</h3>
        </div>
    </div>
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('frontend.index') }}">Home</a>
                    </li>
                    <li class="active">{{ $slug }} </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="shop-area pt-95 pb-100">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="shop-top-bar">
                    <div class="select-shoing-wrap">
                        {{-- <div class="shop-select">
                            <select>
                                <option value="">Sort by newness</option>
                                <option value="">A to Z</option>
                                <option value=""> Z to A</option>
                                <option value="">In stock</option>
                            </select>
                        </div> --}}
                        <p> Showing
                            {{ $kategori->firstItem() }}
                            to
                            {{ $kategori->lastItem() }}
                            of
                            {{ $kategori->total() }}
                            entries</p>
                    </div>
                    <div class="shop-tab nav">
                        <a class="active" href="#shop-1" data-bs-toggle="tab">
                            <i class="fa fa-table"></i>
                        </a>
                        {{-- <a href="#shop-2" data-bs-toggle="tab">
                            <i class="fa fa-list-ul"></i>
                        </a> --}}
                    </div>
                </div>
                <div class="shop-bottom-area mt-35">
                    <div class="tab-content jump">
                        <div id="shop-1" class="tab-pane active">
                            <div class="row">
                                @foreach ($kategori as $data)
                                    @foreach ($data->produk as $item)
                                        <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6">
                                            <div class="product-wrap mb-25">
                                                <div class="card">
                                                    <div class="product-img">
                                                        <a href="product-details.html">
                                                            <img class="default-img"
                                                                src="{{ route('frontend.getImageProdukBaru', $item->gambar) }}"
                                                                alt="" height="250">
                                                        </a>
                                                        @if ($item->diskon)
                                                            <span class="pink">-{{ $item->diskon }}%</span>
                                                        @else
                                                            <span class="purple">New</span>
                                                        @endif
                                                        <div class="product-action">
                                                            <div class="pro-same-action pro-cart">
                                                                @if (Auth::check())
                                                                    @php
                                                                        $idUser = Auth::user()->id;
                                                                        if ($item->harga) {
                                                                            $harga = $item->harga - ($item->diskon / 100) * $item->harga;
                                                                        } else {
                                                                            $harga = $item->harga;
                                                                        }
                                                                    @endphp

                                                                    <form class="form-produk" method="POST"
                                                                        action="{{ route('frontend.produkTambahCart') }}"
                                                                        id="tambahCart">
                                                                        @csrf
                                                                        <input type="hidden" id="id_produk"
                                                                            name="id_produk" value="{{ $item->id_produk }}">
                                                                        @php
                                                                            if ($item->diskon) {
                                                                                $harga = $item->harga - ($item->diskon / 100) * $item->harga;
                                                                            } else {
                                                                                $harga = $item->harga;
                                                                            }
                                                                        @endphp
                                                                        <input type="hidden" id="harga" name="harga"
                                                                            value="{{ $harga }}">
                                                                        <input type="hidden" id="quantity" name="quantity"
                                                                            value="1">
                                                                        <button class="btn text-white" type="submit"
                                                                            title="Add To Cart"><i
                                                                                class="fa-solid fa-cart-shopping"></i> Add
                                                                            to
                                                                            cart</button>
                                                                    </form>
                                                                @else
                                                                    <a title="Add To Cart" href="{{ route('login') }}"><i
                                                                            class="fa-solid fa-cart-shopping"></i> Add to
                                                                        cart</a>
                                                                @endif
                                                            </div>
                                                            <div class="pro-same-action pro-quickview">
                                                                <a title="Quick View"
                                                                    href="{{ route('frontend.produkDetail', $item->slug) }}"><i
                                                                        class="fa-regular fa-eye"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="product-content text-center">
                                                            <h3><a href="product-details.html">{{ $item->name }}</a>
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
                                        </div>
                                    @endforeach
                                @endforeach

                            </div>
                        </div>
                        {{-- <div id="shop-2" class="tab-pane">
                            @foreach ($kategori as $data)
                                @foreach ($data->produk as $item)
                                    <div class="shop-list-wrap mb-30">
                                        <div class="row">
                                            <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6">
                                                <div class="product-wrap">
                                                    <div class="product-img">
                                                        <a href="product-details.html">
                                                            <a href="product-details.html">
                                                                <img class="default-img"
                                                                    src="{{ route('frontend.getImageProdukBaru', $item->gambar) }}"
                                                                    alt="" height="250">
                                                            </a>
                                                        </a>
                                                        @if ($item->diskon)
                                                            <span class="pink">-{{ $item->diskon }}%</span>
                                                        @else
                                                            <span class="purple">New</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8 col-lg-7 col-md-7 col-sm-6">
                                                <div class="shop-list-content">
                                                    <h3><a href="#">{{ $item->name }}</a></h3>
                                                    <div class="product-list-price">
                                                        @if ($item->diskon)
                                                            <span>Rp.
                                                                {{ format_uang($item->harga - ($item->diskon / 100) * $item->harga) }}</span>
                                                            <span class="old">Rp.
                                                                {{ format_uang($item->harga) }}</span>
                                                        @else
                                                            <span>Rp. {{ format_uang($item->harga) }}</span>
                                                        @endif
                                                    </div>
                                                    <p>{{ $item->deskripsi }}</p>
                                                    <div class="shop-list-btn btn-hover">
                                                        <a href="#">ADD TO CART</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div> --}}
                    </div>
                    <div class="pro-pagination-style text-center mt-30">
                        {{-- <ul>
                            <li><a class="prev" href="#"><i class="fa fa-angle-double-left"></i></a></li>
                            <li><a class="active" href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a class="next" href="#"><i class="fa fa-angle-double-right"></i></a></li>
                        </ul> --}}
                        {{ $kategori->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
