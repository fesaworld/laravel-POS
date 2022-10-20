<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        $data = [
            'script' => 'components.scripts.supplier'
        ];

        return view('pages.supplier', $data);
    }

    public function show($id) {
        if(is_numeric($id))
        {
            $data = DB::table('suppliers')->where('id', $id)->first();

            return Response::json($data);
        }

        $data = DB::table('suppliers')
            ->select(['suppliers.*'])
        ->orderBy('suppliers.id', 'desc');

        return DataTables::of($data)
            ->addColumn(
                'action',
                function($row) {
                    $data = [
                        'id' => $row->id
                    ];

                    return view('components.buttons.supplier', $data);
                }
            )
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $result = DB::table('suppliers')->where('phone', $request->phone)->count();

        if($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon masukan nama supplier',
                'status'    => false
            ];
        } elseif($request->phone == NULL || $result > 0) {
            if($request->phone == NULL){
                $json = [
                    'msg'       => 'Mohon masukan nomor telepon supplier',
                    'status'    => false
                ];
            }else{
                $json = [
                    'msg'       => 'Nomor Telepon ini telah digunakan',
                    'status'    => false
                ];
            }
        }elseif(!$request->address) {
            $json = [
                'msg'       => 'Mohon masukan alamat supplier',
                'status'    => false
            ];
        }else {
            try{
                DB::transaction(function() use($request) {
                    DB::table('suppliers')->insert([
                        'created_at' => date('Y-m-d H:i:s'),
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'address' => $request->address,
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
        $new = DB::table('suppliers')
            ->where('phone', $request->phone)
            ->where('id', '<>', $id)
            ->count();

        if($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon masukan nama supplier',
                'status'    => false
            ];
        } elseif($request->phone == NULL || $new > 0 ) {
            if($request->phone == NULL){
                $json = [
                    'msg'       => 'Mohon masukan nomor telepon supplier',
                    'status'    => false
                ];
            } else{
                $json = [
                    'msg'       => 'Nomor Telepon ini telah digunakan',
                    'status'    => false
                ];
            }
        } elseif(!$request->address) {
            $json = [
                'msg'       => 'Mohon masukan alamat supplier',
                'status'    => false
            ];
        } else {
            try{
                DB::transaction(function() use($request, $id) {
                    DB::table('suppliers')->where('id', $id)->update([
                        'updated_at' => date('Y-m-d H:i:s'),
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'address' => $request->address,
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
                DB::table('suppliers')->where('id', $id)->delete();
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
