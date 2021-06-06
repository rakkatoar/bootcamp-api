<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
         $this->request = $request;
    }

    public function main(){
        $input = $this->request->json()->all();
        $action = $input["action"];
        return $this->$action($input);
    }

    public function login($input){
        $data = $input["data"];
        $login = DB::table($input["table"])->where("user_name", "=", $data["user_name"])->where("user_password","=",$data["user_password"])->get();
        if(count($login) > 0 && count($login) < 2){
            return ["success"=> true, "message"=>"Login Successfull", "data"=> $login];
        } else {
            return ["success"=> false, "message"=>"Login Failed. Check Username & password"];
        }
    }

}
