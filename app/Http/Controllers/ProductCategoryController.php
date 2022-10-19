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

    public function show($id)
    {

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

    public function store(Request $request)
    {
        if($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon masukan nama kategori',
                'status'    => false
            ];
        } elseif($request->detail == NULL) {
            $json = [
                'msg'       => 'Mohon masukan detail kategori',
                'status'    => false
            ];
        } else {
            try{
                DB::transaction(function() use($request) {
                    DB::table('product_categories')->insert([
                        'created_at' => date('Y-m-d H:i:s'),
                        'name' => $request->name,
                        'detail' => $request->detail,
                    ]);
                });

                $json = [
                    'msg' => 'Kategori berhasil ditambahkan',
                    'status' => true
                ];
            } catch(Exception $e) {
                $json = [
                    'msg'       => 'error',
                    'status'    => false,
                    'e'         => $e
                ];
            }
        }

        return Response::json($json);
    }

    public function update(Request $request, $id)
    {
        if($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon masukan nama kategori',
                'status'    => false
            ];
        } elseif($request->detail == NULL) {
            $json = [
                'msg'       => 'Mohon masukan detail kategori',
                'status'    => false
            ];
        } else {
            try{
                DB::transaction(function() use($request, $id) {
                    DB::table('product_categories')->where('id', $id)->update([
                        'updated_at' => date('Y-m-d H:i:s'),
                        'name' => $request->name,
                        'detail' => $request->detail,
                    ]);
                });

                $json = [
                    'msg' => 'Produk berhasil disunting',
                    'status' => true
                ];
            } catch(Exception $e) {
                $json = [
                    'msg'       => 'error',
                    'status'    => false,
                    'e'         => $e
                ];
            }
        }

        return Response::json($json);
    }

    public function destroy($id)
    {
        try{
            DB::transaction(function() use($id){
                DB::table('product_categories')->where('id', $id)->delete();
            });

            $json = [
                'msg' => 'Kategori berhasil dihapus',
                'status' => true
            ];
        } catch(Exception $e){
            $json = [
                'msg' => 'error',
                'status' => false,
                'e' => $e,
            ];
        };

        return Response::json($json);
    }
}
