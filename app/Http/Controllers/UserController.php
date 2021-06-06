<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
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
    }
    
    public function get_all_user(){
        $users = DB::table("tx_hdr_user")->join("tx_dtl_user","tx_dtl_user.DTL_HDR_ID","=","tx_hdr_user.USER_ID")->get();
        return $users;
    }
    
    public function get_filter_user($id){
        $user = DB::table("tx_hdr_user")->where("USER_ID", $id)->get();
        return $user;
    }
    
    public function get_filter_user_name($username){
        $user = DB::table("tx_hdr_user")->where("USER_NAME","like", "%$username%")->get();
        return $user;
    }
    
    public function create_user(){
        $input = $this->request->all();
        $request_header = [
            "USER_NAME"     => $input["username"],
            "USER_PASSWORD" => $input["password"]
        ];
        $insert = DB::table("tx_hdr_user")->insert($request_header);
        $user = (array) DB::table("tx_hdr_user")->orderBy("USER_ID", "desc")->first();
        $hdr_id =  $user["USER_ID"];
        $request_detail = [
            "DTL_HDR_ID" => $hdr_id,
            "DTL_USER_EMAIL" => $input["email"],
            "DTL_USER_ADDRESS" => $input["address"],
            "DTL_USER_PHONE" => $input["phone"]
        ];
        $insert = DB::table("tx_dtl_user")->insert($request_detail);
        if($insert){
            return "Insert Success";
        } else {
            return "Insert Failed";
        }
    }
}
