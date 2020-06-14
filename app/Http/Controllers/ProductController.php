<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;

class ProductController extends Controller
{
    public function __construct()
    {
        //
    }

    public function get(Request $req){

        $container = Product::select("id","name","description","stock")
                    ->where("stock",">",0)
                    ->orderBy("id","desc")->get();

        $setting = [
            "total_product"=>count($container),
            "product"=>$container
        ];

        $response = [
            "code" => 200,
            "message"=>"Successfull get data!",
            "data"=> $setting
        ];

        return response()->json($response,$response["code"]);
    }

    public function getDetail(Request $req){

        $container = Product::where("id",$req->product_id)->first();

        $response = [
            "code" => 200,
            "message"=>"Successfull get data!",
            "data"=> $container
        ];

        return response()->json($response,$response["code"]);
    }

    public function add(Request $req){
        
        try {
            
            $c = new Product;
            $c->name = $req->name;
            $c->description = $req->description;
            $c->stock = $req->stock;
            
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

    public function addStock(Request $req){
        
        try {
            
            $c = Product::find($req->product_id);

            if (!$c){
                $response = [
                    "code" => 404,
                    "message"=>"Product does not exist!",
                    "data"=> (object) null
                ];

                return response()->json($response,$response["code"]);
            }

            $c->stock = $c->stock + $req->stock;
            
            if ($c->save()){
                $response = [
                    "code" => 200,
                    "message"=>"Successfull add product stock!",
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

    public function order(Request $req){

        $p = Product::where("id",$req->product_id)->first();

        if (!$p){
            $response = [
                "code" => 404,
                "message"=>"Product does not exist!",
                "data"=> (object) null
            ];

            return response()->json($response,$response["code"]);
        }

        $stock = $p->stock;

        if ($stock<1){
            $response = [
                "code" => 404,
                "message"=>"Out of stock of product!",
                "data"=> (object) null
            ];

            return response()->json($response,$response["code"]);
        }

        $total_after_order = $stock-$req->ammount;

        if ($total_after_order<0){
            $response = [
                "code" => 404,
                "message"=>"The order amount exceeds the available product stock!",
                "data"=> (object) null
            ];

            return response()->json($response,$response["code"]);
        }
        
        try {

            $p->stock = $total_after_order;
            $p->save();

            $t = new Transaction;
            $t->email = $req->email;
            $t->product_id = $req->product_id;
            $t->ammount = $req->ammount;
            
            if ($t->save()){
                $response = [
                    "code" => 200,
                    "message"=>"Congratulations, the product was successfully ordered!",
                    "data"=> (object) null
                ];
                return response()->json($response,$response["code"]);
            }

            $response = [
                "code" => 400,
                "message"=>"Failed order product!",
                "data"=> (object) null
            ];

            return response()->json($response,$response["code"]);

        } catch (\Exception $e){
            $response["code"] = 500;
            return response()->json("Oppss something wrong !",$response["code"]);
        }

    }

    public function getTrans(Request $req){

        $container = Transaction::where("email",$req->email)
            ->orderBy("id","desc")->get();

        $setting = [
            "total_transaction"=>count($container),
            "transaction"=>$container
        ];

        $response = [
            "code" => 200,
            "message"=>"Successfull get data!",
            "data"=> $setting
        ];

        return response()->json($response,$response["code"]);
    }

}
