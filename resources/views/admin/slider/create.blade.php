@extends('admin.layouts.main')
@section('title', 'Tambah Slider')
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
                        <form action="{{ route('slider.store') }}" method="POST" id="simpan" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 row">
                                <label for="title" class="col-sm-2 col-form-label">Judul</label>
                                <div class="col-sm-6">
                                    <input type="text" name="title"
                                        class="form-control @error('title')
                                        is-invalid
                                    @enderror"
                                        placeholder="Judul" value="{{ old('title') }}">
                                    @error('title')
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
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary"
                            onclick="event.preventDefault(); document.getElementById('simpan').submit();"><i
                                class="fa-solid fa-floppy-disk"></i>
                            Simpan</button>
                        <a href="{{ route('slider.index') }}" class="btn btn-sm btn-light"><i
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
