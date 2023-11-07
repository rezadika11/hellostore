<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.produk.index');
    }

    public function data()
    {
        $produk = Produk::with('kategori')->orderBy('id_produk', 'desc')->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('gambar', function ($produk) {
                if (empty($produk->gambar)) {
                    return '';
                }
                return '<img src=' . route('produk.getImage', $produk->gambar) . ' width="40" height="40">';
            })
            ->addColumn('kategori', function ($produk) {
                return $produk->kategori->name;
            })
            ->addColumn('harga', function ($produk) {
                return "Rp. " . format_uang($produk->harga);
            })
            ->addColumn('berat', function ($produk) {
                return $produk->berat . " gram";
            })
            ->addColumn('diskon', function ($produk) {
                return format_uang($produk->diskon) . "%";
            })
            ->addColumn('aksi', function ($produk) {
                return '
                   <a href="/admin/produk/' . $produk->id_produk . '/edit" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <button onclick="modalHapus(`' . route('produk.destroy', $produk->id_produk) . '`)"  class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i> Hapus</button>
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
        $kategori = Kategori::latest()->get();
        return view('admin.produk.create', compact('kategori'));
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
            'name' => 'required',
            'kategori' => 'required',
            'gambar' => 'required|mimes:png,jpg,jpeg|max:2048',
            'berat' => 'required|max:10',
            'harga' => 'required',
            'stok' => 'required'
        ], [
            'name.required' => 'Nama produk tidak boleh kosong',
            'kategori.required' => 'Kategori tidak boleh kosong',
            'gambar.required' => 'Gambar tidak boleh kosong',
            'gambar.mimes' =>  'Format gambar harus JPG/PNG/JPEG',
            'gambar.max' => 'Ukuran gambar tidak melebihi 2 MB',
            'berat.required' => 'Berat produk tidak boleh kosong',
            'harga.required' => 'Harga produk tidak boleh kosong',
            'stok.required' => 'Stok produk tidak boleh kosong',
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
            Storage::putFileAs('\produk', $request->file('gambar'), $namaok);

            Produk::insert([
                'name' => ucwords($request->name),
                'slug' => Str::slug($request->name),
                'gambar' => $namaok,
                'id_kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'berat' => $request->berat,
                'harga' => $request->harga,
                'diskon' => $request->diskon,
                'stok' => $request->stok,
            ]);

            DB::commit();
            Toastr::success('Produk berhasil disimpan', 'Sukses');
            return redirect(route('produk.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Produk gagal disimpan', 'Gagal');
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
        $kategori = Kategori::latest()->get();
        $data = Produk::where('id_produk', $id)->first();
        return view('admin.produk.edit', compact('data', 'kategori'));
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
            'name' => 'required',
            'kategori' => 'required',
            'gambar' => 'mimes:png,jpg,jpeg|max:2048',
            'berat' => 'required|max:10',
            'harga' => 'required',
            'stok' => 'required'
        ], [
            'name.required' => 'Nama produk tidak boleh kosong',
            'kategori.required' => 'Kategori tidak boleh kosong',
            'gambar.mimes' =>  'Format gambar harus JPG/PNG/JPEG',
            'gambar.max' => 'Ukuran gambar tidak melebihi 2 MB',
            'berat.required' => 'Berat produk tidak boleh kosong',
            'harga.required' => 'Harga produk tidak boleh kosong',
            'stok.required' => 'Stok produk tidak boleh kosong',
        ]);

        $produk = Produk::where('id_produk', $id)->first();
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
                Storage::putFileAs('\produk', $request->file('gambar'), $namaok);


                if (File::exists(storage_path('app/produk/' . $produk->gambar))) {
                    File::delete(storage_path('app/produk/' . $produk->gambar));

                    Produk::where('id_produk', $id)
                        ->update([
                            'name' => ucwords($request->name),
                            'slug' => Str::slug($request->name),
                            'gambar' => $namaok,
                            'id_kategori' => $request->kategori,
                            'deskripsi' => $request->deskripsi,
                            'berat' => $request->berat,
                            'harga' => $request->harga,
                            'diskon' => $request->diskon,
                            'stok' => $request->stok,
                        ]);
                }
            } else {
                Produk::where('id_produk', $id)
                    ->update([
                        'name' => ucwords($request->name),
                        'slug' => Str::slug($request->name),
                        'id_kategori' => $request->kategori,
                        'deskripsi' => $request->deskripsi,
                        'berat' => $request->berat,
                        'harga' => $request->harga,
                        'diskon' => $request->diskon,
                        'stok' => $request->stok,
                    ]);
            }
            DB::commit();
            Toastr::success('Produk berhasil diupdate', 'Sukses');
            return redirect(route('produk.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Produk gagal diupdate', 'Gagal');
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
        $produk = Produk::where('id_produk', $id)->first();
        DB::beginTransaction();
        try {

            if (File::exists(storage_path('app/produk/' . $produk->gambar))) {
                File::delete(storage_path('app/produk/' . $produk->gambar));
                $produk = Produk::find($id);
                $produk->delete();
            }
            DB::commit();
            Toastr::success('Produk berhasil dihapus', 'Sukses');
            return redirect(route('produk.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Produk gagal dihapus', 'Gagal');
            return back()->withInput();
        }
    }

    public function getImage($filename)
    {
        $path = storage_path('app/produk/' . $filename);

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
