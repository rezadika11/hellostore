<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kategori.index');
    }

    public function data()
    {
        $kategori = Kategori::orderBy('id_kategori', 'desc')->get();

        return datatables()
            ->of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                return '
                   <a href="/admin/kategori/' . $kategori->id_kategori . '/edit" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <button onclick="modalHapus(`' . route('kategori.destroy', $kategori->id_kategori) . '`)"  class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kategori.create');
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
            'name' => 'required|unique:kategori,name',
        ], [
            'name.required' => 'Kategori tidak boleh kosong',
            'name.unique' => 'Kategori sudah ada',
        ]);

        DB::beginTransaction();
        try {
            Kategori::insert([
                'name' => ucwords($request->name),
                'slug' => Str::slug($request->name)
            ]);
            DB::commit();
            Toastr::success('Kategori berhasil disimpan', 'Sukses');
            return redirect(route('kategori.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Kategori gagal disimpan', 'Gagal');
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
        $data = Kategori::where('id_kategori', $id)->first();
        return view('admin.kategori.edit', compact('data'));
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
            'name' => ['required', Rule::unique('kategori', 'name')->ignore($id, 'id_kategori')],
        ], [
            'name.required' => 'Kategori tidak boleh kosong',
            'name.unique' => 'Kategori sudah ada',
        ]);

        DB::beginTransaction();
        try {
            Kategori::where('id_kategori', $id)
                ->update([
                    'name' => ucwords($request->name),
                    'slug' => Str::slug($request->name)
                ]);
            DB::commit();
            Toastr::success('Kategori berhasil diupdate', 'Sukses');
            return redirect(route('kategori.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Kategori gagal diupdate', 'Gagal');
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
        $produk = Produk::where('id_kategori', $id)->first();
        DB::beginTransaction();
        try {
            if (File::exists(storage_path('app/gambar/' . $produk->gambar))) {
                File::delete(storage_path('app/gambar/' . $produk->gambar));

                $produk = Produk::where('id_kategori', $id)->delete();
                $kategori = Kategori::where('id_kategori', $id)->delete();
            }

            DB::commit();
            Toastr::success('Kategori berhasil dihapus', 'Sukses');
            return redirect(route('kategori.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Kategori gagal dihapus', 'Gagal');
            return back()->withInput();
        }
    }
}
