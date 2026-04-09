<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    function login(Request $request){
        $request->validate([
            'login' => 'required',
            'password' => 'min:6|required',
        ]);

        $loginInput = trim($request->login);
       $user = User::where('username', $loginInput)
                ->orWhere('email', $loginInput)->first();

        if(!$user || !Hash::check($request-> password, $user->password)){
            return response()->json([
                'massage' => "Email atau Username atau password salah"
            ],401);
        };

        $user->tokens()->delete();
        $token = $user -> createToken("authToken")->plainTextToken;

        return response()->json([
            "massage" => "login berhasil",
            "token" => $token,
            "user" => [
                "name" => $user->username,
                "role" => $user->role,
            ]
        ]);
    }
    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
    function index(){
        $user = User::all();

        return response()->json($user);
    }

    function storeSiswa(Request $request) {
    $request->validate([
    'username'=>'required|unique:users,email',
    'password'=>'required',
    'role'=>'in:student,admin',
    'nis'=>'required',
    'kelas'=>'required'
    ]);

    $nis=$request->nis;
    $user=User::create([
    'username'=>$request->username,
    'password'=>Hash::make($nis . '826'),
    'role'=>'student',
    'nis'=>$nis,
    'kelas'=>$request->kelas,
    ]);

            $token = $user -> createToken("authToken")->plainTextToken;
    return response()->json([

    'messege'=>'siswa berhasil di tambah',
    'user'=>$user,
    'token'=>$token,
    ]);

    }
    function storeAdmin(Request $request) {
    $request->validate([
    'email'=>'required|unique:users.email',
    'username'=>'required|unique:users,email',
    'password'=>'required',
    'role'=>'in:student,admin',
    ]);

    $user=User::create([
    'email'=>$request->email,
    'username'=>$request->username,
    'password'=>Hash::make($request->password),
    'role'=>'admin',
    ]);

            $token = $user -> createToken("authToken")->plainTextToken;
    return response()->json([

    'messege'=>'admin berhasil di tambah',
    'user'=>$user,
    'token'=>$token,
    ]);

    }

    function updateSiswa(Request $request,$id){
    $request->validate([
    'username'=>'nullable',
    'kelas'=>'nullable',
    ]);

    $user=User::findOrFail($id);
    $user->update([
    'username'=>$request->username,
    'kelas'=>$request->kelas,
    ]);


    return response()->json($user);
    }
    function updateAdmin(Request $request,$id){
    $request->validate([
    'username'=>'nullable',
    'email'=>'nullable',
    'password'=>'nullable',
    ]);

    $user=User::findOrFail($id);
    $user->update([
    'username'=>$request->username,
    'email'=>$request->email,
    'password'=>$request->passwrod
    ]);


    return response()->json($user);
    }

    function deleteSiswa($id){
        $user=User::findOrFail($id);
        $user->delete();
        $user->forceDelete();
        return response()->json([
        'messege'=>'user telah di hapus'
        ]);
    }
    function deleteAdmin($id){
        $user=User::findOrFail($id);
        $user->delete();
        return response()->json([
        'messege'=>'user telah di hapus'
        ]);
    }

}
