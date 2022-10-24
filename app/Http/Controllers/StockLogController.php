<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class StockLogController extends Controller
{
    public function index()
    {
        $productNames = DB::table('products')->get();
        $upplierNames = DB::table('suppliers')->get();
        $adminNames = DB::table('users')->get();

        $data = [
            'productNames'      => $productNames,
            'upplierNames'      => $upplierNames,
            'script'            => 'components.scripts.stockLog'
        ];

        return view('pages.stockLog', $data);
    }

    public function show($id)
    {
        $data = DB::table('stock_logs')
            ->join('products', 'products.id', '=', 'stock_logs.product_id')
            //->join('suppliers', 'suppliers.id', '=', 'stock_logs.supplier_id')
            ->join('users', 'users.id', '=', 'stock_logs.user_id')
            //->join('members', 'members.id', '=', 'stock_logs.member_id')
            ->select([
                'stock_logs.*', 'products.name as product_name', 'users.name as user_name'
            ])
            ->orderBy('stock_logs.id', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
