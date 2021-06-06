<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BillingController extends Controller
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

    public function get_all_billing(){
        $billings = DB::table("tx_hdr_billing")->join("tx_dtl_billing","tx_dtl_billing.DTL_HDR_ID","=","tx_hdr_billing.BILLING_ID")->get();
        return $billings;
    }
    
    public function get_filter_billing($id){
        $billing = DB::table("tx_hdr_billing")->where("BILLING_ID", $id)->get();
        return $billing;
    }
    
    public function get_filter_user_name($username){
        $user = DB::table("tx_hdr_user")->where("USER_NAME","like", "%$username%")->get();
        return $user;
    }
    
    public function create_billing(){
        $input = $this->request->all();
        $request_header = [
					    "BILLING_NAME"     => $input["name"],
					    "BILLING_EMAIL" => $input["email"],
					    "BILLING_PHONE" => $input["phone"],
					    "BILLING_DESC" => $input["desc"],
					    "BILLING_ADDRESS" => $input["address"]
					];
					$insert = DB::table("tx_hdr_billing")->insert($request_header);
					$billing = (array) DB::table("tx_hdr_billing")->orderBy("BILLING_ID", "desc")->first();
					$hdr_id =  $billing["BILLING_ID"];
					foreach($input["product"] as $value){
						$request_detail = [
								"DTL_HDR_ID" => $hdr_id,
								"DTL_BILLING_PRODUCT_NAME" => $value["name"],
								"DTL_BILLING_PRODUCT_QUANTITY" => $value["quantity"],
								"DTL_BILLING_PRODUCT_PRICE" => $value["price"]
						];
						$insert = DB::table("tx_dtl_billing")->insert($request_detail);
					}
        if($insert){
            return "Insert Success";
        } else {
            return "Insert Failed";
        }
    }
}
