@extends('admin.layouts.main')
@section('title', 'Tambah Kategori')
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
                        <form action="{{ route('kategori.store') }}" method="POST" id="simpan">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Nama Kategori</label>
                                <div class="col-md-6">
                                    <input type="text" name="name"
                                        class="form-control @error('name')
                                        is-invalid
                                    @enderror"
                                        placeholder="Nama Kategori">
                                    @error('name')
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
                        <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-light"><i
                                class="fa-solid fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
@push('js')
@endpush
