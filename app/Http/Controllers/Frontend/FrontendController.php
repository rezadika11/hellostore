<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Kategori;
use App\Models\Order;
use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Slider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    public function index()
    {
        $slider = Slider::latest()->get();
        $produkBaru = Produk::latest()->take(12)->get();
        return view('user.index', compact('slider', 'produkBaru'));
    }

    public function kategori($slug)
    {
        $kategori = Kategori::where('slug', $slug)
            ->with('produk')
            ->orderBy('id_kategori', 'desc')
            ->paginate(1);

        return view('user.produk_kategori', compact('kategori', 'slug'));
    }

    public function produkDetail($slug)
    {
        $produk = Produk::where('slug', $slug)->with('kategori')->first();
        $produkTerkait = Produk::latest()->take(6)->get();

        return view('user.detail_produk', compact('produk', 'produkTerkait'));
    }


    public function produkTambahCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $produk = Cart::where('id_produk', $request->id_produk)->first();

            if (isset($produk->quantity)) {
                Cart::where('id_produk', $produk->id_produk)->update([
                    'id_user' => Auth::user()->id,
                    'id_produk' => $request->id_produk,
                    'harga' => $produk->harga + $request->harga,
                    'quantity' => $produk->quantity + $request->quantity
                ]);
            } else {
                Cart::insert([
                    'id_user' => Auth::user()->id,
                    'id_produk' => $request->id_produk,
                    'harga' => $request->harga,
                    'quantity' => $request->quantity
                ]);
            }

            DB::commit();
            Toastr::success('Produk berhasil ke keranjang', 'Sukses');
            return redirect(route('frontend.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Produk gagal ke keranjang', 'Gagal');
            return back()->withInput();
        }
    }

    public function totalCart()
    {
        $cart = Cart::select('id_produk', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('id_produk')
            ->where('id_user', Auth::user()->id)
            ->get()->count();

        return response()->json($cart);
    }

    public function orderCart()
    {
        $cart = Cart::join('produk', 'cart.id_produk', 'produk.id_produk')
            ->select('cart.id_cart', 'produk.id_produk', 'produk.name', 'produk.harga as harga_asli', 'cart.harga', 'produk.gambar', 'produk.stok', 'produk.diskon', 'cart.id_user', DB::raw('SUM(cart.quantity) as jumlah'))
            ->groupBy('produk.id_produk', 'produk.name', 'cart.harga', 'produk.gambar', 'produk.harga', 'produk.stok', 'produk.diskon', 'cart.id_cart', 'cart.id_user')
            ->where('cart.id_user', Auth::user()->id)
            ->get();

        return view('user.cart', compact('cart'));
    }

    public function  updateTotalCart(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            Cart::where('id_produk', $id)->update([
                'id_user' => Auth::user()->id,
                'id_produk' => $request->id_produk,
                'harga' => $request->harga * $request->quantity,
                'quantity' => $request->quantity
            ]);

            DB::commit();
            return response()->json('Data berhasil disimpan', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return response()->json('Data gagal disimpan', 404);
        }
    }

    public function deleteCart($id)
    {
        DB::beginTransaction();
        try {
            $cart = Cart::where('id_cart', $id)->delete();
            DB::commit();
            return response()->json('Data berhasil dihapus', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return response()->json('Data gagal dihapus', 404);
        }
    }

    public function pembayaran($id)
    {
        $cart = Cart::join('produk', 'cart.id_produk', 'produk.id_produk')
            ->select('cart.id_cart', 'produk.id_produk', 'produk.name', 'produk.harga as harga_asli', 'cart.harga', 'produk.gambar', 'produk.stok', 'produk.diskon', 'cart.id_user', DB::raw('SUM(cart.quantity) as jumlah'))
            ->groupBy('produk.id_produk', 'produk.name', 'cart.harga', 'produk.gambar', 'produk.harga', 'produk.stok', 'produk.diskon', 'cart.id_cart', 'cart.id_user')
            ->where('cart.id_user', $id)
            ->get();

        $data = [];
        foreach ($cart as $val) {
            if ($val->id_user) {
                $data = $val->id_user;
            }
        }

        return view('user.pembayaran', compact('cart', 'data'));
    }

    public function prosesPembayaran(Request $request)
    {

        $validate = $request->validate([
            'name' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'alamat' => 'required',
            'kode_pos' => 'required',
            'no_hp' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'provinsi.required' => 'Provinsi tidak boleh kosong',
            'kabupaten.required' => 'Kabupaten tidak boleh kosong',
            'kecamatan.required' => 'Kecamatan tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'kode_pos.required' => 'Kode pos tidak boleh kosong',
            'no_hp.required' => 'No Hp tidak boleh kosong',
            'gambar.required' => 'Bukti pembayaran tidak boleh kosong',
            'gambar.mimes' => 'Bukti pembayaran harus format jpeg/png.jpg',
            'gambar.max' => 'Bukti pembayaran tidak boleh lebih dari 2 mb',
        ]);

        DB::beginTransaction();
        try {
            $cart = Cart::where('id_user', Auth::user()->id)->get();
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
            Storage::putFileAs('\bukti', $request->file('gambar'), $namaok);

            foreach ($cart as $value) {
                $dataToInsert[] = [
                    'id_user' => $value->id_user,
                    'id_produk' => $value->id_produk,
                    'harga' => $value->harga,
                    'quantity' => $value->quantity,
                    'name' => $request->name,
                    'provinsi' => $request->provinsi,
                    'kabupaten' => $request->kabupaten,
                    'kecamatan' => $request->kecamatan,
                    'alamat' => $request->alamat,
                    'kode_pos' => $request->kode_pos,
                    'no_hp' => $request->no_hp,
                    'gambar' => $namaok,
                ];
            }

            Order::insert($dataToInsert);
            Cart::where('id_user', Auth::user()->id)->delete();
            DB::commit();
            Toastr::success('Pembayaran berhasil', 'Sukses');
            return redirect(route('frontend.detailPembayaran'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Pembayaran gagal', 'Gagal');
            return back()->withInput();
        }
    }

    public function detailPembayaran()
    {
        $pembayaran = Order::select('order.id_user', 'order.name', 'order.gambar as bukti', 'order.status', 'konfirmasi_pembayaran.no_resi', 'konfirmasi_pembayaran.shipping')
            ->leftJoin('konfirmasi_pembayaran', 'order.id_user', '=', 'konfirmasi_pembayaran.id_user')
            ->selectRaw('SUM(order.harga) as total_harga, SUM(order.quantity) as total_quantity')
            ->groupBy('order.id_user', 'order.name', 'order.gambar', 'order.status', 'konfirmasi_pembayaran.no_resi', 'konfirmasi_pembayaran.shipping')
            ->where('order.id_user', Auth::user()->id)
            ->get();


        return view('user.detail_pembayaran', compact('pembayaran'));
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

    public function getImageProdukBaru($filename)
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
