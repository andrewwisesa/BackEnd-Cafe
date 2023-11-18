<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $token = Str::random(10);

        $user = User::where('username', $request->input('username'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Password Salah'], 401);
        }
        $role = $user->role;
        $id_user = $user->id_user;
        $nama_user = $user->nama_user;

        return response()->json(compact('token', 'role', 'id_user', 'nama_user'));
    }
}