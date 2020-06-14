<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ContainerController extends Controller
{
    public function __construct()
    {
        //
    }

    public function login(){
        $u = User::where("email",$req->email);
        $true = Hash::check($req->password, $u->password);
        if ($true){
            return response()->json($response,$response["code"]);
        }
    }

    public function register(Request $req){

        $u = User::where("email",$req->email)->first();

        if ($u){
            $response = [
                "code" => 400,
                "message"=>"User already exists!",
                "data"=> (object) null
            ];
            return response()->json($response,$response["code"]);
        }


        $new = new User;
        $new->name = $req->name;
        $new->email = $req->email;
        $new->password = $req->password;

        if ($new->save()){
            $response = [
                "code" => 200,
                "message"=>"Successfull save data!",
                "data"=> (object) null
            ];

            return response()->json($response,$response["code"]);
        }
    }

}
