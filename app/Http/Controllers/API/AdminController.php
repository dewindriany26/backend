<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createUser(Request $req, $tipe)
    {
        try {
            switch ($tipe) {
                case 'user':
                    $user = new User();
                    $user->username = $req->username;
                    $user->name = $req->name;
                    $user->password = bcrypt($req->password);
                    $user->jk = $req->jk;
                    $user->save();
                    break;

                case 'dosen':
                    $user = new Dosen();
                    $user->username = $req->username;
                    $user->name = $req->name;
                    $user->password = bcrypt($req->password);
                    $user->jk = $req->jk;
                    $user->fakultas = $req->fakultas;
                    $user->prodi = $req->prodi;
                    $user->save();
                    break;
            }
            return response()->json([
                'message' => 'berhasil',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'gagal',
            ], 400);
        }
    }
}
