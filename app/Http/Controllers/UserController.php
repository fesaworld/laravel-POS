<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $status = DB::table('roles')->get();

        $data = [
            'status' => $status,
            'script' => 'components.scripts.user'
        ];

        return view('pages.user', $data);
    }

    public function show($id) {
        if(is_numeric($id))
        {
            $data = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->join('users', 'users.id', '=', 'model_has_roles.model_id')
            ->select([
                'users.*', 'roles.id as role_id', 'roles.name as user_role'
            ])->where('users.id', $id)->first();

            return Response::json($data);
        }

        $data = DB::table('model_has_roles')
        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->join('users', 'users.id', '=', 'model_has_roles.model_id')
        ->select([
            'users.*', 'roles.name as user_role'
        ])->where('deleted_at', NULL)
        ->orderBy('users.id', 'desc');

        return DataTables::of($data)
            ->addColumn(
                'action',
                function($row) {
                    $data = [
                        'id' => $row->id
                    ];

                    return view('components.buttons.user', $data);
                }
            )
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = DB::table('users')->where('email', $request->email)->count();

        if($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon masukan nama user',
                'status'    => false
            ];
        }else if($request->email == NULL || $data != 0 ) {
            if($request->email == NULL){
                $json = [
                    'msg'       => 'Mohon masukan email user',
                    'status'    => false
                ];
            }else{
                $json = [
                    'msg'       => 'Email ini telah digunakan',
                    'status'    => false
                ];
            }
        }else if(!$request->has('user_role')) {
            $json = [
                'msg'       => 'Mohon pilih status user',
                'status'    => false
            ];
        }else if($request->pass == NULL || (strlen($request->pass) < 8) ) {
            if($request->pass == NULL){
                $json = [
                    'msg'       => 'Mohon masukan password user',
                    'status'    => false
                ];
            }else{
                $json = [
                    'msg'       => 'Password minimal 8 karakter',
                    'status'    => false
                ];
            }
        }else {
            try{
                DB::transaction(function() use($request) {
                    $id_user = DB::table('users')->insertGetId([
                        'created_at' => date('Y-m-d H:i:s'),
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->pass),
                    ]);
                    DB::table('model_has_roles')->insert([
                        'role_id' => $request->user_role,
                        'model_type' => 'App\User',
                        'model_id' => $id_user,
                    ]);
                });

                $json = [
                    'msg' => 'user berhasil ditambahkan',
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
        $old = DB::table('users')->where('id', $id)->first();
        $new = DB::table('users')->where('email', $request->email)->first();

        if($new != NULL)
        {
            if($old->email == $new->email)
            {
                $result = 0;
            }else{
                $result = 1;
            }
        }else{
            $result = 1;
        }

        if($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon masukan nama user',
                'status'    => false
            ];
        }else if($request->email == NULL || $result != 0 ) {
            if($request->email == NULL){
                $json = [
                    'msg'       => 'Mohon masukan email user',
                    'status'    => false
                ];
            }else{
                $json = [
                    'msg'       => 'Email ini telah digunakan',
                    'status'    => false
                ];
            }
        }else if(!$request->has('user_role')) {
            $json = [
                'msg'       => 'Mohon pilih status user',
                'status'    => false
            ];
        }else {
            try{
                if($request->pass != NULL)
                {
                    DB::transaction(function() use($request, $id) {
                        DB::table('users')->where('id', $id)->update([
                            'updated_at' => date('Y-m-d H:i:s'),
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => Hash::make($request->pass),
                        ]);
                        DB::table('model_has_roles')->where('model_id', $id)->update([
                            'role_id' => $request->user_role,
                        ]);
                    });
                }else{
                    DB::transaction(function() use($request, $id) {
                        DB::table('users')->where('id', $id)->update([
                            'updated_at' => date('Y-m-d H:i:s'),
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => Hash::make($request->pass),
                        ]);
                        DB::table('model_has_roles')->where('model_id', $id)->update([
                            'role_id' => $request->user_role,
                        ]);
                    });
                }

                $json = [
                    'msg' => 'User berhasil disunting',
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

    public function delete(Request $request, $id)
    {
        try{
            DB::transaction(function() use($request, $id) {
                DB::table('users')->where('id', $id)->update([
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            });

            $json = [
                'msg' => 'User berhasil dihapus',
                'status' => true
            ];
        } catch(Exception $e) {
            $json = [
                'msg'       => 'error',
                'status'    => false,
                'e'         => $e
            ];
        }

        return Response::json($json);
    }
}
