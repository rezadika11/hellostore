<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.slider.index');
    }

    public function data()
    {
        $slider = Slider::orderBy('id_slider', 'desc')->get();

        return datatables()
            ->of($slider)
            ->addIndexColumn()
            ->addColumn('gambar', function ($slider) {
                return '<img src=' . route('slider.getImage', $slider->gambar) . ' width="60" height="40">';
            })
            ->addColumn('aksi', function ($slider) {
                return '
                   <a href="/admin/slider/' . $slider->id_slider . '/edit" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <button onclick="modalHapus(`' . route('slider.destroy', $slider->id_slider) . '`)"  class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                ';
            })
            ->rawColumns(['gambar', 'aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'deskripsi' => 'required|max:500',
            'gambar' => 'required|mimes:png,jpg,jpeg|max:2048',
        ], [
            'title.required' => 'Judul tidak boleh kosong',
            'gambar.required' => 'Gambar tidak boleh kosong',
            'gambar.mimes' =>  'Format gambar harus JPG/PNG/JPEG',
            'gambar.max' => 'Ukuran gambar tidak melebihi 2 MB',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'deskripsi.max' => 'Deskripsi maksimal 500 kata'
        ]);

        DB::beginTransaction();
        try {
            $ekstensi = $request->gambar->extension();
            $nama = $request->gambar->getClientOriginalName();
            $sekarang = date('mdYHis') . Auth::user()->id;
            $ekstensifile = explode('.', $nama);
            $ekstensifileupload = $ekstensifile[count($ekstensifile) - 1];
            if ($ekstensi == 'bin' and $ekstensi != $ekstensifileupload) {
                $namaok = $sekarang . "." . $ekstensifileupload;
            } else {
                $namaok = $sekarang . "." . $ekstensi;
            }
            Storage::putFileAs('\slider', $request->file('gambar'), $namaok);

            Slider::insert([
                'title' => $request->title,
                'deskripsi' => $request->deskripsi,
                'gambar' => $namaok
            ]);
            DB::commit();
            Toastr::success('Slider berhasil disimpan', 'Sukses');
            return redirect(route('slider.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Slider gagal disimpan', 'Gagal');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::where('id_slider', $id)->first();
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'gambar' => 'mimes:png,jpg,jpeg|max:2048',
            'deskripsi' => 'required|max:500'
        ], [
            'title.required' => 'Judul tidak boleh kosong',
            'title.unique' => 'Judul sudah ada',
            'gambar.mimes' =>  'Format gambar harus JPG/PNG/JPEG',
            'gambar.max' => 'Ukuran gambar tidak melebihi 2 MB',
            'deskripsi.max' => 'Deskripsi maksimal 500 kata',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong'
        ]);

        $slider = Slider::where('id_slider', $id)->first();
        DB::beginTransaction();
        try {
            if ($request->hasFile('gambar')) {
                $ekstensi = $request->gambar->extension();
                $nama = $request->gambar->getClientOriginalName();
                $sekarang = date('mdYHis') . Auth::user()->id;
                $ekstensifile = explode('.', $nama);
                $ekstensifileupload = $ekstensifile[count($ekstensifile) - 1];
                if ($ekstensi == 'bin' and $ekstensi != $ekstensifileupload) {
                    $namaok = $sekarang . "." . $ekstensifileupload;
                } else {
                    $namaok = $sekarang . "." . $ekstensi;
                }
                Storage::putFileAs('\slider', $request->file('gambar'), $namaok);


                if (File::exists(storage_path('app/slider/' . $slider->gambar))) {
                    File::delete(storage_path('app/slider/' . $slider->gambar));

                    Slider::where('id_slider', $id)
                        ->update([
                            'title' => $request->title,
                            'gambar' => $namaok,
                            'deskripsi' => $request->deskripsi,
                        ]);
                }
            } else {
                Slider::where('id_slider', $id)
                    ->update([
                        'title' => $request->title,
                        'deskripsi' => $request->deskripsi,

                    ]);
            }
            DB::commit();
            Toastr::success('Slider berhasil diupdate', 'Sukses');
            return redirect(route('slider.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Slider gagal diupdate', 'Gagal');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::where('id_slider', $id)->first();
        DB::beginTransaction();
        try {

            if (File::exists(storage_path('app/slider/' . $slider->gambar))) {
                File::delete(storage_path('app/slider/' . $slider->gambar));
                $slider = Slider::find($id);
                $slider->delete();
            }
            DB::commit();
            Toastr::success('Slider berhasil dihapus', 'Sukses');
            return redirect(route('slider.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Slider gagal dihapus', 'Gagal');
            return back()->withInput();
        }
    }

    public function getImage($filename)
    {
        $path = storage_path('app/slider/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
