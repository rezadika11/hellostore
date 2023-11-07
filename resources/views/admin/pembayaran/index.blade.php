@extends('admin.layouts.main')
@section('title', 'Data Pembayaran')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3> @yield('title')</h3>
                </div>
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Pembeli</th>
                                        <th>Total Produk</th>
                                        <th>Total Harga</th>
                                        <th>Bukti Pembayaran</th>
                                        <th>No Resi</th>
                                        <th>Pengiriman</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
@push('js')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script>
        let table;

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

        $(function() {
            table = $('#datatables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('pembayaran.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'total_produk'
                    },
                    {
                        data: 'total_harga'
                    },
                    {
                        data: 'bukti'
                    },
                    {
                        data: 'no_resi'
                    },
                    {
                        data: 'pengiriman'
                    },
                    {
                        data: 'status'
                    }, {
                        data: 'aksi'
                    }
                ]
            });
        });
    </script>
@endpush
