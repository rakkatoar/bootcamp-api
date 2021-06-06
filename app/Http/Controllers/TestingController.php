<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TestingController extends Controller
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

    public function main() {
        $user = \DB::table("tx_hdr_user")->get();
        return $user;
    }
    
    public function filter_user($id) {
        $user = (array)\DB::table("tx_hdr_user")->where("user_id", $id)->first();
        return $user;
    }

    public function create_user() {
        $input = $this->request->all();
        $insert = \DB::table("tx_hdr_user")->insert([$input]);
        if($insert)
            return ["success"=>TRUE, "message"=>"Insert Success"];
        else
            return ["success"=>FALSE, "message"=>"Insert Failes"];
    }

    public function update_user($id) {
        $input = $this->request->all();
        $update = \DB::table("tx_hdr_user")->where("user_id", $id)->update(["user_name"=>$input["user_name"], "user_password"=>$input["user_password"]]);
        if($update)
            return ["success"=>TRUE, "message"=>"Update Success"];
        else
            return ["success"=>FALSE, "message"=>"Update Failes"];
    }

    public function delete_user($id) {
        $delete = \DB::table("tx_hdr_user")->where("user_id", $id)->delete();
        if($delete)
            return ["success"=>TRUE, "message"=>"Delete Success"];
        else
            return ["success"=>FALSE, "message"=>"Delete Failes"];
        return $id;
    }
    //
}
