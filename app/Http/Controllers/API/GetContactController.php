<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetContactController extends Controller
{
    public function getcontact(Request $request)
    {
        $role = $request->q;
        $uidDosen = 0;
        $uidUser = 0;

        if($role == 'user' || $role == 'admin'){
            $contact = Dosen::all()->map(function($item) use($uidUser){

                $data =  [
                    'about' => $item->prodi,
                    'displayName' => $item->name,
                    // 'photoURL' => "/img/avatar-s-1.680013ab.jpg",
                    'status' => 'available',
                    'uid' => $item->id
                ];
                $uidUser += 1;
                return $data;
            });
        }else if($role == 'dosen' ){
            $contact = User::all()->map(function($item) use($uidDosen){

                $data =  [
                    'about' => $item->username,
                    'displayName' => $item->name,
                    // 'photoURL' => "/img/avatar-s-1.680013ab.jpg",
                    'status' => 'available',
                    'uid' => $item->id
                ];
                $uidDosen += 1;
                return $data;
            });
        }
        return $contact;
    }
}
