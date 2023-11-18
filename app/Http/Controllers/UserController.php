<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller

{
    public function login(Request $request)
    {
        $token = Str::random(10);

        $user = User::where('username', $request->input('username'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Password mu salah oi'], 401);
        }


        $role = $user->role;

        return response()->json(compact('token', 'role'));
    }

    public function getuser()
    {
        $get_user = User::get();
        return response()->json($get_user);
    }

    public function getkasir()
    {
        $kasir = User::where('role','kasir')->get();
            return response()->json($kasir);
    }

    public function selectuser($id)
    {
        $getuser = User::where('id_user', $id)->get();
        return response()->json($getuser);
    }

    public function createuser(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nama_user' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->tojson(), 422);
        }

        $create = User::create([
            'nama_user' => $req->input('nama_user'),
            'username' => $req->input('username'),
            'gender' => $req->input('gender'),
            'password' => Hash::make($req->input('password')),
            'role' => $req->input('role'),
        ]);

        return response()->json([
            'Status' => 'Success'
        ]);
    }

    public function updateuser(Request $req, $id)
    {
        // $validator = Validator::make($req->all(), [

        // ]);
        $update = User::where('id_user', $id)->update([
            'nama_user' => $req->input('nama_user'),
            'username' => $req->input('username'),
            'password' => Hash::make($req->input('password')),
            'role' => $req->input('role'),
            'gender' => $req->input('gender'),
        ]);

        if ($update) {
            return response()->json('Berhasil');
        } else {
            return response()->json('gagal');
        }
    }

    public function deleteuser($id)
    {
        $delete = User::where('id_user', $id)->delete();
        return response()->json([
            'Pesan' => 'Berhasil'
        ]);
    }
}