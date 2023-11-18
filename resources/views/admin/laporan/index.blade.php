@extends('admin.layouts.main')
@section('title', 'Laporan')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3>Laporan Pendapatan {{ tanggal_indonesia($tglAwal) }} -
                        {{ tanggal_indonesia($tglAkhir) }}</h3>
                </div>
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-sm btn-primary" onclick="updatePeriode()"><i
                                class="fa-solid fa-pen-to-square"></i> Ubah
                            Periode</button>
                        <a class="btn btn-sm btn-warning" href="{{ route('laporan.export_pdf', [$tglAwal, $tglAkhir]) }}"
                            target="_blank"><i class="fa-solid fa-file-pdf"></i> Cetak</a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="true" width="50">No</th>
                                        <th data-ordering="true">Tanggal</th>
                                        <th data-ordering="true">Penjualan</th>
                                        <th data-ordering="true">Pembelian</th>
                                        <th data-ordering="true">Pendapatan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </main>
    @include('admin.laporan.modal-ubah')
@endsection
@push('js')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
            $(".flatpickr").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d",
            });

            table = $('#datatables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                searching: false,
                ajax: {
                    url: '{{ route('laporan.data', [$tglAwal, $tglAkhir]) }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'penjualan'
                    },
                    {
                        data: 'pembelian'
                    },
                    {
                        data: 'pendapatan'
                    }
                ],
                bSort: false,
                bPaginate: false,
            });

        });

        function updatePeriode() {
            $('#modal-ubah').modal('show');
        }
    </script>
@endpush
