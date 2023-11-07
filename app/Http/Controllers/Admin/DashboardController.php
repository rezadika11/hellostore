<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Order;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::where('role', 0)->count();
        $order = Order::count();
        $produk = Produk::count();
        $kat = Kategori::count();
        return view('admin.dashboard', compact('user', 'order', 'produk', 'kat'));
    }
}
