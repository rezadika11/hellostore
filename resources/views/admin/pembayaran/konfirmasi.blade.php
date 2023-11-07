@extends('admin.layouts.main')
@section('title', 'Konfirmasi Pembayaran')
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
                        <form action="{{ route('pembayaran.update', $pembayaran->id_user) }}" method="POST" id="simpan">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 row">
                                <label for="kategori" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-6">
                                    <select
                                        class="form-select flex-grow-1 @error('status')
                                        is-invalid
                                    @enderror"
                                        name="status">
                                        <option selected disabled>Plih Status</option>
                                        @foreach ($status as $key => $val)
                                            <option value="{{ $key }}"
                                                {{ old('status', $pembayaran->status) == $key ? 'selected' : '' }}>
                                                {{ $val }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="id_pembayaran" value="{{ $pembayaran->id_pembayaran }}">
                            <input type="hidden" name="id_user" value="{{ $pembayaran->id_user }}">
                            <div class="mb-3 row">
                                <label for="no_resi" class="col-sm-2 col-form-label">Nomor resi</label>
                                <div class="col-sm-6">
                                    <input type="text" name="no_resi"
                                        class="form-control @error('no_resi')
                                        is-invalid
                                    @enderror"
                                        placeholder="Nomor Resi" value="{{ old('no_resi') }}">
                                    @error('no_resi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="shipping" class="col-sm-2 col-form-label">Pengiriman</label>
                                <div class="col-sm-6">
                                    <input type="text" name="shipping"
                                        class="form-control @error('shipping')
                                        is-invalid
                                    @enderror"
                                        placeholder="Nomor Resi" value="{{ old('shipping') }}">
                                    @error('shipping')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary"
                            onclick="event.preventDefault(); document.getElementById('simpan').submit();"><i
                                class="fa-solid fa-floppy-disk"></i>
                            Simpan</button>
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-light"><i
                                class="fa-solid fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
@push('js')
    <script>
        function preview() {
            imgPreview.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endpush
