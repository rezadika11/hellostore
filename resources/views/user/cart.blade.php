@extends('user.layouts.main')
@section('title', 'Keranjang')
@push('css')
    <style>
        /* .btn-checkout {
                                                                                                                                            background-color: #a749ff;
                                                                                                                                            font-family: "Poppins", sans-serif;
                                                                                                                                            border-radius: 20%;
                                                                                                                                        } */
    </style>
@endpush
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
    <div class="cart-main-area pt-90 pb-100">
        <div class="container">
            <h3 class="cart-page-title">Keranjang</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    {{-- <form action="{{ route('frontend.prosesCheckout') }}" method="POST" id="checkout">
                        @csrf --}}
                    <div class="table-content table-responsive cart-table-content">
                        <table class="tableCart">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Produk</th>
                                    <th>Harga Satuan</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalSubtotal = 0;
                                @endphp
                                @if ($cart)
                                    @foreach ($cart as $item)
                                        <tr>
                                            <td class="product-thumbnail">
                                                <img src="{{ route('frontend.getImageProdukBaru', $item->gambar) }}"
                                                    alt="" class="img-fluid" style="height:70px">
                                            </td>
                                            <td class="product-name"><a href="#">{{ $item->name }}</a></td>
                                            @php
                                                $diskon = $item->harga_asli - ($item->diskon / 100) * $item->harga_asli;
                                            @endphp
                                            <td class="product-price-cart"><span class="amount">Rp.
                                                    {{ format_uang($diskon) }}</span>
                                            </td>
                                            <td>
                                                <input type="number" id="quantity" name="quantity"
                                                    data-harga="{{ $diskon }}" data-id="{{ $item->id_produk }}"
                                                    data-stok="{{ $item->stok }}" value="{{ $item->jumlah }}">
                                            </td>
                                            <td class="product-subtotal">Rp. {{ format_uang($item->harga) }}
                                            </td>
                                            <td class="product-remove">
                                                <a
                                                    onclick="deleteData('{{ route('frontend.deleteCart', $item->id_cart) }}')"><i
                                                        class="fa fa-times text-danger"></i></a>
                                            </td>
                                        </tr>
                                        @php
                                            $totalSubtotal += $diskon * $item->jumlah;
                                        @endphp
                                    @endforeach
                                @else
                                    <td colspan="8">Belum ada produk dikeranjang</td>
                                @endif
                                <tr class="bg-light">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="3" class="product-subtotal">Total: Rp.
                                        {{ format_uang($totalSubtotal) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- </form> --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    @if (Auth::check())
                                        <a href="{{ route('frontend.pembayaran', Auth::user()->id) }}"
                                            class="btn btn-checkout">Proses
                                            Ke
                                            Pembayaran</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-checkout">Proses
                                            Ke
                                            Pembayaran</a>
                                    @endif

                                </div>
                            </div>
                        </div>
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let previousValue = $("#quantity").val();
            $(document).on('input', '#quantity', function() {
                let id_produk = $(this).data('id');
                let harga = $(this).data('harga');
                let jumlah = parseInt($(this).val());
                let stok = parseInt($(this).data('stok'));
                if (jumlah < 1) {
                    alert('Jumlah tidak boleh kurang dari 1');
                    $(this).val(previousValue);
                    return;
                }
                if (jumlah > stok) {
                    alert('Jumlah melebihi stok produk');
                    $(this).val(previousValue);
                    return;
                }

                let data = {
                    id_produk: id_produk,
                    harga: harga,
                    quantity: jumlah
                };
                $.ajax({
                    type: 'POST',
                    url: `{{ url('/totalcart/') }}/${id_produk}`, // Ganti dengan URL yang sesuai
                    data: data,
                    success: function(data) {
                        $('.tableCart').load(location.href + ' .tableCart')
                    },
                    error: function(error) {
                        alert('Terjadi error')
                    }
                });
            });
        });

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        $('.tableCart').load(location.href + ' .tableCart')
                        $('body').load(location.href)
                        toastr.success('Berhasil hapus data keranjang');
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }
    </script>
@endpush
