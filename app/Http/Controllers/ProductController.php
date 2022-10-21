<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        $productCategories = DB::table('product_categories')->get();
        $productSuppliers = DB::table('suppliers')->get();

        $data = [
            'productCategories' => $productCategories,
            'productSuppliers' => $productSuppliers,
            'script'            => 'components.scripts.product'
        ];

        return view('pages.product', $data);
    }

    public function show($id) {
        if(is_numeric($id)) {
            $data = DB::table('products')->where('id', $id)->first();

            $data->price_buy = number_format($data->price_buy);
            $data->price_sell = number_format($data->price_sell);

            return Response::json($data);
        }

        $data = DB::table('products')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->join('suppliers', 'suppliers.id', '=', 'products.product_supplier_id')
            ->select([
                'products.*', 'product_categories.name as product_category', 'suppliers.name as product_supplier'
            ])
            ->orderBy('products.id', 'desc');

        return DataTables::of($data)

            ->editColumn('image', function($row){
                $data = array('image' => $row->image);

                return view('components.images.images', $data);
            })

            ->editColumn(
                'price_buy',
                function($row) {
                    return number_format($row->price_buy);
                }
            )

            ->editColumn(
                'price_sell',
                function($row) {
                    return number_format($row->price_sell);
                }
            )

            ->addColumn(
                'action',
                function($row) {
                    $data = [
                        'id' => $row->id
                    ];

                    return view('components.buttons.product', $data);
                }
            )
            ->addIndexColumn()
            ->make(true);
    }

    public function destroy($id)
    {
        try{
            $fileName = DB::table('products')->where('id', $id)->get()->first()->image;
            $pleaseRemove = base_path('public/assets/image/').$fileName;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }

            DB::transaction(function() use($id){
                DB::table('products')->where('id', $id)->delete();
            });

            $json = [
                'msg' => 'Produk berhasil dihapus',
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

    public function store(Request $request)
    {
        if($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon masukan nama produk',
                'status'    => false
            ];
        } elseif(!$request->has('product_category_id')) {
            $json = [
                'msg'       => 'Mohon pilih kategori produk',
                'status'    => false
            ];
        } elseif($request->detail == NULL) {
            $json = [
                'msg'       => 'Mohon masukan detail produk',
                'status'    => false
            ];
        } elseif($request->priceBuy == NULL) {
            $json = [
                'msg'       => 'Mohon masukan harga beli produk',
                'status'    => false
            ];
        } elseif($request->priceSell == NULL) {
            $json = [
                'msg'       => 'Mohon masukan harga jual produk',
                'status'    => false
            ];
        } elseif($request->stok == NULL) {
            $json = [
                'msg'       => 'Mohon masukan jumlah produk',
                'status'    => false
            ];
        } else {
            try{
            if($request->file('image'))
            {
                $post_image = $request->file('image');
                $extension  = $post_image->getClientOriginalExtension();
                $featuredImageName  = date('YmdHis').'.'.$extension;
                $destination = base_path('public/assets/image/');
                $post_image->move($destination, $featuredImageName);

                DB::transaction(function() use($request, $featuredImageName) {
                    DB::table('products')->insert([
                        'created_at' => date('Y-m-d H:i:s'),
                        'name' => $request->name,
                        'product_category_id' => $request->product_category_id,
                        'product_supplier_id' => $request->product_supplier_id,
                        'detail' => $request->detail,
                        'price_buy' => str_replace(',','',$request->priceBuy),
                        'price_sell' => str_replace(',','',$request->priceSell),
                        'stok' => $request->stok,
                        'image' => $featuredImageName,

                    ]);
                });
            } else {
                DB::transaction(function() use($request) {
                    DB::table('products')->insert([
                        'created_at' => date('Y-m-d H:i:s'),
                        'name' => $request->name,
                        'product_category_id' => $request->product_category_id,
                        'product_supplier_id' => $request->product_supplier_id,
                        'detail' => $request->detail,
                        'priceBuy' => str_replace(',','',$request->priceBuy),
                        'priceSell' => str_replace(',','',$request->priceSell),
                        'stok' => $request->stok,
                    ]);
                });
            }
                $json = [
                    'msg' => 'Produk berhasil ditambahkan',
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
                'msg'       => 'Mohon masukan nama produk',
                'status'    => false
            ];
        } elseif(!$request->has('product_category_id')) {
            $json = [
                'msg'       => 'Mohon pilih kategori produk',
                'status'    => false
            ];
        } elseif($request->detail == NULL) {
            $json = [
                'msg'       => 'Mohon masukan detail produk',
                'status'    => false
            ];
        } elseif($request->price_buy == NULL) {
            $json = [
                'msg'       => 'Mohon masukan harga beli produk',
                'status'    => false
            ];
        } elseif($request->price_sell == NULL) {
            $json = [
                'msg'       => 'Mohon masukan harga jual produk',
                'status'    => false
            ];
        } elseif($request->stok == NULL) {
            $json = [
                'msg'       => 'Mohon masukan jumlah produk',
                'status'    => false
            ];
        } else {
            try{
                if($request->file('image'))
                {
                    $post_image = $request->file('image');
                    $fileName = DB::table('products')->where('id', $id)->get()->first()->image;

                    if($fileName)
                    {
                        $pleaseRemove = base_path('public/assets/image/').$fileName;

                        if(file_exists($pleaseRemove)) {
                            unlink($pleaseRemove);
                        }
                    }

                    $extension  = $post_image->getClientOriginalExtension();
                    $featuredImageName  = date('YmdHis').'.'.$extension;
                    $destination = base_path('public/assets/image/');
                    $post_image->move($destination, $featuredImageName);

                    DB::transaction(function() use($request, $id, $featuredImageName) {
                        DB::table('products')->where('id', $id)->update([
                            'updated_at' => date('Y-m-d H:i:s'),
                            'name' => $request->name,
                            'product_category_id' => $request->product_category_id,
                            'product_supplier_id' => $request->product_supplier_id,
                            'detail' => $request->detail,
                            'price_buy' => str_replace(',','',$request->price_buy),
                            'price_sell' => str_replace(',','',$request->price_sell),
                            'stok' => $request->stok,
                            'image'=> $featuredImageName,
                        ]);
                    });

                } else {
                    DB::transaction(function() use($request, $id) {
                        DB::table('products')->where('id', $id)->update([
                            'updated_at' => date('Y-m-d H:i:s'),
                            'name' => $request->name,
                            'product_category_id' => $request->product_category_id,
                            'product_supplier_id' => $request->product_supplier_id,
                            'detail' => $request->detail,
                            'price_buy' => str_replace(',','',$request->price_buy),
                            'price_sell' => str_replace(',','',$request->price_sell),
                            'stok' => $request->stok,
                        ]);
                    });
                }

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
}
