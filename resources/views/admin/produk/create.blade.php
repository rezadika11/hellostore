@extends('admin.layouts.main')
@section('title', 'Tambah Produk')
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
                        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" id="simpan">
                            @csrf
                            <div class="mb-3 row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-6">
                                    <input type="text" name="name"
                                        class="form-control @error('name')
                                        is-invalid
                                    @enderror"
                                        placeholder="Nama Produk" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-6">
                                    <select
                                        class="form-select flex-grow-1 @error('kategori')
                                        is-invalid
                                    @enderror"
                                        name="kategori">
                                        <option selected disabled>Plih Kategori</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id_kategori }}"
                                                {{ old('kategori') == $item->id_kategori ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="image" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img src="" width="150" class="img-fluid" height="100" alt=""
                                        id="imgPreview">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                                <div class="col-sm-6">
                                    <input type="file" name="gambar"
                                        class="form-control @error('gambar')
                                        is-invalid
                                    @enderror"
                                        placeholder="gambar" value="{{ old('gambar') }}" onchange="preview()">
                                    @error('gambar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-6">
                                    <textarea
                                        class="form-control @error('deskripsi')
                                        is-invalid
                                    @enderror"
                                        name="deskripsi" cols="15" rows="8">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="berat" class="col-sm-2 col-form-label">Berat</label>
                                <div class="col-sm-6">
                                    <input type="number" name="berat"
                                        class="form-control @error('berat')
                                        is-invalid
                                    @enderror"
                                        placeholder="Berat" value="{{ old('berat') }}">
                                    @error('berat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                <div class="col-sm-6">
                                    <input type="number" name="harga"
                                        class="form-control @error('harga')
                                        is-invalid
                                    @enderror"
                                        placeholder="Harga" value="{{ old('harga') }}">
                                    @error('harga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="diskon" class="col-sm-2 col-form-label">Diskon</label>
                                <div class="col-sm-6">
                                    <input type="number" name="diskon"
                                        class="form-control @error('diskon')
                                        is-invalid
                                    @enderror"
                                        placeholder="Diskon" value="{{ old('diskon') }}">
                                    @error('diskon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                                <div class="col-sm-6">
                                    <input type="number" name="stok"
                                        class="form-control @error('stok')
                                        is-invalid
                                    @enderror"
                                        placeholder="Stok" value="{{ old('stok') }}">
                                    @error('stok')
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
                        <a href="{{ route('produk.index') }}" class="btn btn-sm btn-light"><i
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
