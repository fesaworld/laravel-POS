<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index() {
        $data = [
            'script' => 'components.scripts.transaksi'
        ];

        return view('pages.transaksi', $data);
    }

    public function show($id) {

        // if(is_numeric($id)) {
        //     $data = DB::table('products')->where('id', $id)->first();
        //     $data->price_sell = number_format($data->price_sell);

        //     return Response::json($data);
        // }

    }

    public function store(Request $request)
    {
        if($request->totalPrice == NULL) {
            $json = [
                'msg'       => 'Harga produk total belum terbaca',
                'status'    => false
            ];
        } else if(($request->totalPay == NULL)){
            $json = [
                'msg'       => 'Jumlah total bayar belum terbaca',
                'status'    => false
            ];
        } else if(str_replace(',','',$request->totalPrice) > $request->totalPay){
            $json = [
                'msg'       => 'Jumlah yang anda bayarkan kurang',
                'status'    => false
            ];
        }  else if($request->paymentStatus == NULL){
            $json = [
                'msg'       => 'Status pembayaran belum terpilih',
                'status'    => false
            ];
        } else if($request->memberId == NULL) {
            $json = [
                'msg'       => 'Mohon pilih memilih data member terlebih dahulu',
                'status'    => false
            ];
        } else {
            if($request->paymentStatus == 'Paid'){
                try{
                    DB::transaction(function() use($request) {
                        $id_transaction = DB::table('transactions')->insertGetId([
                            'created_at' => date('Y-m-d H:i:s'),
                            'user_id' => Auth::user()->id,
                            'member_id' => $request->memberId,
                            'totalPrice' => str_replace(',','',$request->totalPrice),
                            'totalPay' => $request->totalPay,
                            'paymentStatus' => $request->paymentStatus,
                        ]);

                        $carts = DB::table('carts')->select('product_id', 'quantity')->where('transaction_id', NULL)->get();
                        foreach($carts as $cart) {

                            $data = DB::table('products')->where('id', $cart->product_id)->first();

                            $totalStok = $data->stok - $cart->quantity;

                            DB::table('products')->where('id', $cart->product_id)->update([
                                'updated_at' => date('Y-m-d H:i:s'),
                                'stok' => $totalStok,
                            ]);

                            DB::table('stock_logs')->insert([
                                'created_at' => date('Y-m-d H:i:s'),
                                'product_id' => $cart->product_id,
                                'supplier_id' => null,
                                'user_id' => Auth::user()->id,
                                'member_id' => $request->memberId,
                                'in' => null,
                                'out' => $cart->quantity,
                                'total' => $data->price_sell * $cart->quantity,
                                'detail' => "Produk telah terbeli",
                            ]);
                        }

                        DB::table('carts')->where('transaction_id', null)->update([
                            'updated_at' => date('Y-m-d H:i:s'),
                            'transaction_id' => $id_transaction,
                        ]);
                    });

                    $totalPrice = 0;

                    $dataCart = DB::table('carts')
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->select([
                        'carts.*',
                        'products.price_sell as product_harga',
                    ])->where('transaction_id', NULL)->get();

                    foreach($dataCart as $row)
                    {
                        $totalPrice += $row->product_harga * $row->quantity;
                    }


                    $json = [
                        'msg' => 'Produk berhasil ditambahkan kedalam keranjang',
                        'total' => $totalPrice,
                        'status' => true
                    ];
                } catch(Exception $e) {
                    $json = [
                        'msg'       => 'error',
                        'status'    => false,
                        'e'         => $e,
                        'line'      => $e->getLine(),
                        'message'   => $e->getMessage(),
                    ];
                }

            }else{
                try{
                    DB::transaction(function() use($request) {
                        $id_transaction = DB::table('transactions')->insertGetId([
                            'created_at' => date('Y-m-d H:i:s'),
                            'user_id' => Auth::user()->id,
                            'member_id' => $request->memberId,
                            'totalPrice' => str_replace(',','',$request->totalPrice),
                            'totalPay' => $request->totalPay,
                            'paymentStatus' => $request->paymentStatus,
                        ]);

                        DB::table('carts')->where('transaction_id', null)->update([
                            'updated_at' => date('Y-m-d H:i:s'),
                            'transaction_id' => $id_transaction,
                        ]);

                    });

                    $total = 0;

                    $dataCart = DB::table('carts')
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->select([
                        'carts.*',
                        'products.price_sell as product_harga',
                    ])->where('transaction_id', NULL)->get();

                    foreach($dataCart as $row)
                    {
                        $total += $row->product_harga * $row->quantity;
                    }


                    $json = [
                        'msg' => 'Produk berhasil ditambahkan kedalam keranjang',
                        'total' => $total,
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
        }

        return Response::json($json);
    }

    public function showTotal() {
        $total = 0;

        $dataCart = DB::table('carts')
        ->join('products', 'products.id', '=', 'carts.product_id')
        ->select([
            'carts.*',
            'products.price_sell as product_harga',
        ])->get();

        foreach($dataCart as $row)
        {
            $total += $row->product_harga * $row->quantity;
        }

        return $total;
    }

//buat Product
    public function showProduct($id){
        if(is_numeric($id)) {
            $data = DB::table('products')->where('id', $id)->first();
            $data->price_sell = number_format($data->price_sell);

            return Response::json($data);
        }

        if($id == 'get-product') {

            $exclude = [];

            $carts = DB::table('carts')->where('transaction_id', NULL)->get();

            foreach($carts as $cart) {
                $exclude[] = $cart->product_id;
            }
            $data = DB::table('products')
                ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
                ->join('suppliers', 'suppliers.id', '=', 'products.product_supplier_id')
                ->select(['products.*', 'product_categories.name as product_category', 'suppliers.name as product_supplier'])
                ->where('deleted_at', NULL)
                ->where('status', 'Aktif')
                ->whereNotIn('products.id', $exclude)
                ->orderBy('products.id', 'desc')
                ->get();

                return DataTables::of($data)

                ->editColumn('image', function($row){
                    $data = array('image' => $row->image);

                    return view('components.images.images', $data);
                })

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

                        return view('components.buttons.selectProduct', $data);
                    }
                )

                ->addIndexColumn()
                ->make(true);
        }
    }

//buat Member
    public function showMember($id){
        if(is_numeric($id)) {
            $data = DB::table('members')->where('id', $id)->first();

            return Response::json($data);
        }

        $data = DB::table('members')
            ->orderBy('members.id', 'desc')
            ->get();

            return DataTables::of($data)

            ->addColumn(
                'action',
                function($row) {
                    $data = [
                        'id' => $row->id
                    ];

                    return view('components.buttons.selectMember', $data);
                }
            )

            ->addIndexColumn()
            ->make(true);
    }

//buat Cart
    public function showCart($id) {
        if(is_numeric($id)) {
            $dataCart = DB::table('carts')->where('id', $id)->first();

            return Response::json($dataCart);
        }

        $dataCart = DB::table('carts')
        ->join('products', 'products.id', '=', 'carts.product_id')
        ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
        ->select([
            'carts.*',
            'products.name as product_name',
            'product_categories.name as product_category_name',
            'products.image as product_image',
            'products.price_sell as product_harga',
            'products.stok as product_stok',
            ])
        ->where('transaction_id', NULL)
        ->orderBy('carts.id', 'desc');

        return DataTables::of($dataCart)

            ->editColumn('product_image', function($row){
                $data = array('image' => $row->product_image);

                return view('components.images.images', $data);
            })

            ->editColumn(
                'product_harga',
                function($row) {
                    return number_format($row->product_harga);
                }
            )

            ->addColumn(
                'subtotal',
                function($row) {
                    return number_format($row->product_harga * $row->quantity);
                }
            )

            ->addColumn(
                'action',
                function($row) {
                    $data = [
                        'id' => $row->id
                    ];

                    return view('components.buttons.viewCart', $data);
                }
            )

            ->addIndexColumn()
            ->make(true);
    }

    public function storeCart(Request $request)
    {
        if($request->productId != NULL)
        {
            $dataStok = DB::table('products')->where('id', $request->productId)->first();
            $dataStok = $dataStok->stok;
        }


        if($request->productId == NULL) {
            $json = [
                'msg'       => 'Mohon pilih produk terlebih dahulu',
                'status'    => false
            ];
        } else if($request->productQty > $dataStok) {
            $json = [
                'msg'       => 'Jumlah produk melebisi stok tersedia, Stok tersedia sebanyak : ' .$dataStok,
                'status'    => false
            ];
        } else if(($request->productQty <= 0)){
            $json = [
                'msg'       => 'Minimal pemesanan produk 1',
                'status'    => false
            ];
        } else {
            try{
                DB::transaction(function() use($request) {
                    DB::table('carts')->insert([
                        'created_at' => date('Y-m-d H:i:s'),
                        'product_id' => $request->productId,
                        'quantity' => $request->productQty,
                        'transaction_id' => null
                    ]);
                });

                $total = 0;

                $dataCart = DB::table('carts')
                ->join('products', 'products.id', '=', 'carts.product_id')
                ->select([
                    'carts.*',
                    'products.price_sell as product_harga',
                ])->where('transaction_id', NULL)->get();

                foreach($dataCart as $row)
                {
                    $total += $row->product_harga * $row->quantity;
                }


                $json = [
                    'msg' => 'Produk berhasil ditambahkan kedalam keranjang',
                    'total' => number_format($total),
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

    public  function updateCart(Request $request, $id)
    {
        $dataId = DB::table('carts')->where('id', $id)->first();
        $dataId = $dataId->product_id;

        $dataStok = DB::table('products')->where('id', $dataId)->first();
        $dataStok = $dataStok->stok;

        if($request->cartQuantity > $dataStok) {
            $json = [
                'msg'       => 'Jumlah produk melebisi stok tersedia, Stok tersedia sebanyak : ' .$dataStok,
                'status'    => false
            ];
        }else if(($request->cartQuantity <= 0)){
            $json = [
                'msg'       => 'Minimal pemesanan produk 1',
                'status'    => false
            ];
        }else {
            try{
                DB::transaction(function() use($request, $id) {
                    DB::table('carts')->where('id', $id)->update([
                        'created_at' => date('Y-m-d H:i:s'),
                        'quantity' => $request->cartQuantity,
                    ]);
                });

                $total = 0;

                $dataCart = DB::table('carts')
                ->join('products', 'products.id', '=', 'carts.product_id')
                ->select([
                    'carts.*',
                    'products.price_sell as product_harga',
                ])->where('transaction_id', NULL)->get();

                foreach($dataCart as $row)
                {
                    $total += $row->product_harga * $row->quantity;
                }

                $json = [
                    'msg' => 'Jumlah produk berhasil disunting',
                    'total' => number_format($total),
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

    public function destroyCart($id)
    {
        try{
            DB::transaction(function() use($id){
                DB::table('carts')->where('id', $id)->delete();
            });

            $total = 0;

            $dataCart = DB::table('carts')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->select([
                'carts.*',
                'products.price_sell as product_harga',
            ])->where('transaction_id', NULL)->get();

            foreach($dataCart as $row)
            {
                $total += $row->product_harga * $row->quantity;
            }


            $json = [
                'msg' => 'Produk berhasil dihapus',
                'total' => number_format($total),
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
