<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $user = DB::table('model_has_roles')
        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->join('users', 'users.id', '=', 'model_has_roles.model_id')
        ->where('roles.name','<>', 'Super Admin')->count();

        $kategori = DB::table('product_categories')->count();
        $produk = DB::table('products')->count();
        $supplier = DB::table('suppliers')->count();
        $member = DB::table('members')->count();

        $total = DB::table('stock_logs')->sum('total');
        $total = number_format($total);

        $produkTersedia = DB::table('products')
            ->where('deleted_at', NULL)
            ->where('status', 'Aktif')
            ->count();

        $produkTidakTersedia = DB::table('products')->get()
            ->where('deleted_at', NULL)
            ->where('status', 'Non-Aktif')
            ->count();



        // dd($data);


        return view('pages.dashboard', compact('user','kategori', 'produk', 'supplier', 'member', 'total', 'produkTersedia', 'produkTidakTersedia'));
    }
}
