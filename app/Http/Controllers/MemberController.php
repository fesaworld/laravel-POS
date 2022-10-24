<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index()
    {
        $data = [
            'script' => 'components.scripts.member'
        ];

        return view('pages.member', $data);
    }

    public function show($id) {
        if(is_numeric($id))
        {
            $data = DB::table('members')->where('id', $id)->first();

            return Response::json($data);
        }

        $data = DB::table('members')
            ->select(['members.*'])
        ->orderBy('members.id', 'desc');

        return DataTables::of($data)
            ->addColumn(
                'action',
                function($row) {
                    $data = [
                        'id' => $row->id
                    ];

                    return view('components.buttons.member', $data);
                }
            )
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $result = DB::table('members')->where('phone', $request->phone)->count();

        if($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon masukan nama member',
                'status'    => false
            ];
        } elseif($request->phone == NULL || $result > 0) {
            if($request->phone == NULL){
                $json = [
                    'msg'       => 'Mohon masukan nomor telepon member',
                    'status'    => false
                ];
            }else{
                $json = [
                    'msg'       => 'Nomor Telepon ini telah digunakan',
                    'status'    => false
                ];
            }
        }elseif(!$request->detail) {
            $json = [
                'msg'       => 'Mohon masukan detail member',
                'status'    => false
            ];
        }else {
            try{
                DB::transaction(function() use($request) {
                    DB::table('members')->insert([
                        'created_at' => date('Y-m-d H:i:s'),
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'detail' => $request->detail,
                    ]);
                });

                $json = [
                    'msg' => 'Member berhasil ditambahkan',
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
        $new = DB::table('members')
            ->where('phone', $request->phone)
            ->where('id', '<>', $id)
            ->count();

        if($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon masukan nama member',
                'status'    => false
            ];
        } elseif($request->phone == NULL || $new > 0 ) {
            if($request->phone == NULL){
                $json = [
                    'msg'       => 'Mohon masukan nomor telepon member',
                    'status'    => false
                ];
            } else{
                $json = [
                    'msg'       => 'Nomor Telepon ini telah digunakan',
                    'status'    => false
                ];
            }
        } elseif(!$request->detail) {
            $json = [
                'msg'       => 'Mohon masukan alamat member',
                'status'    => false
            ];
        } else {
            try{
                DB::transaction(function() use($request, $id) {
                    DB::table('members')->where('id', $id)->update([
                        'updated_at' => date('Y-m-d H:i:s'),
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'detail' => $request->detail,
                    ]);
                });

                $json = [
                    'msg' => 'Member berhasil disunting',
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
                DB::table('members')->where('id', $id)->delete();
            });

            $json = [
                'msg' => 'Member berhasil dihapus',
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
