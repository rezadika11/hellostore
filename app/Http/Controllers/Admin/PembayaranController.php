<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konfrimasi_Pembayaran;
use App\Models\Order;
use App\Models\Pembayaran;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $orders = Order::select('order.id_user', 'order.name', 'order.gambar as bukti', 'order.status', 'konfirmasi_pembayaran.no_resi', 'konfirmasi_pembayaran.shipping')
        //     ->leftJoin('konfirmasi_pembayaran', 'order.id_user', '=', 'konfirmasi_pembayaran.id_user')
        //     ->selectRaw('SUM(order.harga) as total_harga, SUM(order.quantity) as total_quantity')
        //     ->groupBy('order.id_user', 'order.name', 'order.gambar', 'order.status', 'konfirmasi_pembayaran.no_resi', 'konfirmasi_pembayaran.shipping')
        //     ->get();
        // dd($orders);
        return view('admin.pembayaran.index');
    }

    public function data()
    {
        $pembayaran = Order::select('order.id_user', 'order.name', 'order.gambar as bukti', 'order.status', 'konfirmasi_pembayaran.no_resi', 'konfirmasi_pembayaran.shipping')
            ->leftJoin('konfirmasi_pembayaran', 'order.id_user', '=', 'konfirmasi_pembayaran.id_user')
            ->selectRaw('SUM(order.harga) as total_harga, SUM(order.quantity) as total_quantity')
            ->groupBy('order.id_user', 'order.name', 'order.gambar', 'order.status', 'konfirmasi_pembayaran.no_resi', 'konfirmasi_pembayaran.shipping')
            ->get();

        return datatables()
            ->of($pembayaran)
            ->addIndexColumn()
            ->addColumn('pembeli', function ($pembayaran) {
                return $pembayaran->name;
            })
            ->addColumn('total_produk', function ($pembayaran) {
                return $pembayaran->total_quantity;
            })
            ->addColumn('total_harga', function ($pembayaran) {
                return "Rp. " . format_uang($pembayaran->total_harga);
            })
            ->addColumn('bukti', function ($pembayaran) {
                return '<a href="' . route('pembayaran.getImagePembayaran', $pembayaran->bukti) . '" target="_blank"><img src=' . route('pembayaran.getImagePembayaran', $pembayaran->bukti) . ' width="40" height="40">';
            })
            ->addColumn('no_resi', function ($pembayaran) {
                if ($pembayaran->status == 'belum') {
                    return '';
                } else {
                    return $pembayaran->no_resi;
                }
            })
            ->addColumn('pengiriman', function ($pembayaran) {
                if ($pembayaran->status == 'belum') {
                    return '';
                } else {
                    return $pembayaran->shipping;
                }
            })
            ->addColumn('status', function ($pembayaran) {
                if ($pembayaran->status == 'belum') {
                    return '<span class="badge bg-primary">' . $pembayaran->status . '</span>';
                } else {
                    return '<span class="badge bg-success">' . $pembayaran->status . '</span>';
                }
            })
            ->addColumn('aksi', function ($pembayaran) {
                return '
                   <a href="/admin/pembayaran/' . $pembayaran->id_user . '/edit" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                ';
            })
            ->rawColumns(['aksi', 'bukti', 'status'])
            ->make(true);
    }

    public function getImagePembayaran($filename)
    {
        $path = storage_path('app/bukti/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $pembayaran = Order::where('id_user', $id)->first();
        $status = [
            'belum' => 'belum',
            'konfirmasi' => 'konfirmasi',
        ];
        return view('admin.pembayaran.konfirmasi', compact('pembayaran', 'status'));
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
            'no_resi' => 'required',
            'shipping' => 'required',
        ], [
            'no_resi.required' => 'No Resi tidak boleh kosong',
            'shipping.required' => 'Pengiriman tidak boleh kosong',
        ]);

        DB::beginTransaction();
        try {
            Order::where('id_user', $id)
                ->update([
                    'status' => $request->status,
                ]);
            Konfrimasi_Pembayaran::insert([
                'no_resi' => $request->no_resi,
                'shipping' => $request->shipping,
                'id_user' => $request->id_user
            ]);

            DB::commit();
            Toastr::success('Status berhasil diupdate', 'Sukses');
            return redirect(route('pembayaran.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Status gagal diupdate', 'Gagal');
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
        //
    }
}
