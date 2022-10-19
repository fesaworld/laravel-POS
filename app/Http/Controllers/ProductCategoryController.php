<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $data = [
            'script' => 'components.scripts.productCategory'
        ];

        return view('pages.productCategory', $data);
    }

    public function show($id) {

        if(is_numeric($id))
        {
            $data = DB::table('product_categories')->where('id', $id)->first();

            return Response::json($data);
        }

        $data = DB::table('product_categories')
            ->select(['product_categories.*'])
            ->orderBy('product_categories.id', 'desc');

        return DataTables::of($data)
            ->addColumn(
                'action',
                function($row) {
                    $data = [
                        'id' => $row->id
                    ];

                    return view('components.buttons.productDetail', $data);
                }
            )
            ->addIndexColumn()
            ->make(true);
    }
}
