@extends('user.layouts.main')
@section('title', 'Home')
@push('css')
    <style>
        .carousel-item .custom-carousel-content {
            width: 50%;
            transform: translate(0%, -10%);
        }

        .custom-carousel-content {
            text-align: start;
        }

        .custom-carousel-content h1 {
            font-size: 40px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 30px;
        }

        .custom-carousel-content h1 span {
            color: #fbff00;
        }

        .custom-carousel-content p {
            font-size: 18px;
            font-weight: 400;
            color: #fff;
            margin-bottom: 30px;
        }

        .custom-carousel-content .btn-slider {
            border: 1px solid #fff;
            border-radius: 0px;
            padding: 8px 26px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>
@endpush
@section('content')
    <div class="slider-area">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($slider as $item)
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $loop->index }}"
                        class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide 1"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($slider as $item)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ route('frontend.getSliderImage', $item->gambar) }}" class="d-block w-100"
                            alt="..." style="max-height: 750px">
                        <div class="carousel-caption d-none d-md-block">
                            <div class="custom-carousel-content">
                                <h1>
                                    <span>{{ $item->title }}</span>
                                </h1>
                                <p>
                                    {{ $item->deskripsi }}
                                </p>
                                <div>
                                    <a href="#" class="btn btn-slider">
                                        Buy
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="suppoer-area pt-100 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="support-wrap mb-30 support-1">
                        <div class="support-icon">
                            <img class="animated" src="{{ asset('frontend/assets/img/icon-img/support-1.png') }}"
                                alt="">
                        </div>
                        <div class="support-content">
                            <h5>Free Shipping</h5>
                            <p>Free shipping on all order</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="support-wrap mb-30 support-2">
                        <div class="support-icon">
                            <img class="animated" src="{{ asset('frontend/assets/img/icon-img/support-2.png') }}"
                                alt="">
                        </div>
                        <div class="support-content">
                            <h5>Support 24/7</h5>
                            <p>Free shipping on all order</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="support-wrap mb-30 support-3">
                        <div class="support-icon">
                            <img class="animated" src="{{ asset('frontend/assets/img/icon-img/support-3.png') }}"
                                alt="">
                        </div>
                        <div class="support-content">
                            <h5>Money Return</h5>
                            <p>Free shipping on all order</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="support-wrap mb-30 support-4">
                        <div class="support-icon">
                            <img class="animated" src="{{ asset('frontend/assets/img/icon-img/support-4.png') }}"
                                alt="">
                        </div>
                        <div class="support-content">
                            <h5>Order Discount</h5>
                            <p>Free shipping on all order</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-area pb-60">
        <div class="container">
            <div class="section-title text-center">
                <h2>Produk</h2>
            </div>
            <div class="product-tab-list nav pt-30 pb-55 text-center">
                <a href="#product-1" data-bs-toggle="tab">
                    <h4>Terbaru</h4>
                </a>
                <a href="#product-2" data-bs-toggle="tab">
                    <h4>Promo</h4>
                </a>
            </div>
            <div class="tab-content jump">
                <div class="tab-pane active" id="product-1">
                    <div class="row">
                        @foreach ($produkBaru as $item)
                            <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6">
                                <div class="product-wrap mb-25">
                                    <div class="card">
                                        <div class="product-img">
                                            <a href="{{ route('frontend.produkDetail', $item->slug) }}">
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
                                                            <input type="hidden" id="id_produk" name="id_produk"
                                                                value="{{ $item->id_produk }}">
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
                                                                    class="fa-solid fa-cart-shopping"></i> Add to
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
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="tab-pane " id="product-2">
                    <div class="row">
                        @foreach ($produkBaru as $item)
                            @if ($item->diskon)
                                <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6">
                                    <div class="product-wrap mb-25">
                                        <div class="product-img">
                                            <a href="{{ route('frontend.produkDetail', $item->slug) }}">
                                                <img class="default-img"
                                                    src="{{ route('frontend.getImageProdukBaru', $item->gambar) }}"
                                                    alt="" height="250">
                                            </a>
                                            <span class="pink">-{{ $item->diskon }}%</span>
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
                                                            <input type="hidden" id="id_produk" name="id_produk"
                                                                value="{{ $item->id_produk }}">
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
                                                                    class="fa-solid fa-cart-shopping"></i> Add to
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

                                        <div class="product-content text-center">
                                            <h3><a
                                                    href="{{ route('frontend.produkDetail', $item->slug) }}">{{ $item->name }}</a>
                                            </h3>
                                            <div class="product-price">
                                                <span>Rp.
                                                    {{ format_uang($item->harga - ($item->diskon / 100) * $item->harga) }}</span>
                                                <span class="old">Rp.
                                                    {{ format_uang($item->harga) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        // $(document).ready(function() {
        // $.post('{{ route('frontend.produkTambahCart') }}', $('.form-produk').serialize())
        //     .done(response => {
        //         toastr.success('Berhasil tambah keranjang', 'Sukses');
        //     })
        //     .fail(errors => {
        //         alert('Tidak dapat menyimpan data');
        //         return;
        //     });
        //     $('#tambahCart').click(function() {
        //         $('#form-produk').on('submit', function(e) {
        //             event.preventDefault();
        //             var formData = $(this).serialize();
        //             $.ajax({
        //                 type: "POST",
        //                 url: "{{ route('frontend.produkTambahCart') }}", // Specify the URL to handle the form submission.
        //                 data: formData,
        //                 success: function(response) {
        //                     // Handle the response from the server.
        //                     console.log(response);
        //                     // You can update the page with the response data or perform other actions.
        //                 }
        //             });
        //         });
        //     })
        // })
    </script>
@endpush
