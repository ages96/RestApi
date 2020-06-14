<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\ContainerSetting;

class ContainerController extends Controller
{
    public function __construct()
    {
        //
    }

    public function getSetting(Request $req){

        $container = ContainerSetting::select("id","email","is_verified","limit","created_at")->with(["getContainers"])->where("email",$req->email)->get();

        $setting = [
            "total_container"=>count($container),
            "container"=>$container
        ];

        $response = [
            "code" => 200,
            "message"=>"Successfull get data!",
            "data"=> $setting
        ];

        return response()->json($response,$response["code"]);
    }

    public function getContainer(Request $req){

        $container = Container::where("containers.email",$req->email)->where("container_setting_id",$req->parent_id)
            ->with(
                    ["getSetting"]
                )
            ->get();

        $data = [
            "total_ball"=>count($container),
            "container"=>$container
        ];

        $response = [
            "code" => 200,
            "message"=>"Successfull get data!",
            "data"=> $data
        ];

        return response()->json($response,$response["code"]);
    }

    public function add(Request $req){
        $s = ContainerSetting::where("id",$req->setting_id)->first();

        try {

            if (!$s){
                $response = [
                    "code" => 404,
                    "message"=>"Setting does not exist !",
                    "data"=> (object) null
                ];
                return response()->json($response,$response["code"]);
            }

            $counter = count(Container::where("email",$req->email)->where("container_setting_id",$req->setting_id)->get());
            if ($counter + 1 > $s->limit){
                $s->is_verified = 1;
                $s->save();
                $response = [
                    "code" => 404,
                    "message"=>"Container is full and verified !",
                    "data"=> (object) null
                ];
                return response()->json($response,$response["code"]);
            }

            $c = new Container;
            $c->email = $req->email;
            $c->container_setting_id = $req->setting_id;
            
            if ($c->save()){
                $response = [
                    "code" => 200,
                    "message"=>"Successfull add data!",
                    "data"=> (object) null
                ];
                return response()->json($response,$response["code"]);
            }

            $response = [
                "code" => 400,
                "message"=>"Failed save data!",
                "data"=> (object) null
            ];

            return response()->json($response,$response["code"]);

        } catch (\Exception $e){
            $response = [
                "code" => 200,
                "message"=>$e->getLine()." : ".$e->getMessage(),
                "data"=> (object) null
            ];
            return response()->json($response,$response["code"]);
        }

    }

    public function addSetting(Request $req){
        
        try {
            
            $c = new ContainerSetting;
            $c->email = $req->email;
            $c->is_verified = 0;
            $c->limit = $req->limit;
            
            if ($c->save()){
                $response = [
                    "code" => 200,
                    "message"=>"Successfull add data!",
                    "data"=> (object) null
                ];
                return response()->json($response,$response["code"]);
            }

            $response = [
                "code" => 400,
                "message"=>"Failed save data!",
                "data"=> (object) null
            ];

            return response()->json($response,$response["code"]);

        } catch (\Exception $e){
            $response["code"] = 500;
            return response()->json("Oppss something wrong !",$response["code"]);
        }

    }

}
