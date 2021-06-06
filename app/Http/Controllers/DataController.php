<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DataController extends Controller
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
        return $input;
    }
    
    public function list($input){
        $result = DB::table($input["table"])->get();
        if($result){
            return ["success"=>true, "message"=>"Data Found", "data"=>$result];
        } else {
            return ["success"=>false, "message"=>"No data found", "data"=>[]];
        }
    }

    public function save($input){
        $data = $input["data"];
        $insert = DB::table($input["table"])->insert($data);
        if($input["detail"]){
            $hdr = (array) DB::table($input["table"])->orderBy($input["create_date"], "desc")->first();
            $hdr_id =  $hdr[$input["hdr_id"]];
            $detail = $input["detail"];
            $input_detail = $detail["data"];
            $hdr_data = [
                "DTL_HDR_ID"=>$hdr_id
            ];
            $detail_data = array_merge($hdr_data, $input_detail);
            $insert_detail = DB::table($detail["table"])->insert($detail_data);
            if($insert_detail){
                $insert=true;
            } else {
                $insert=false;
            }
        }
        if($insert){
            return ["success"=>true, "message"=>"Success Add New Product"];
        } else {
            return ["success"=>false, "message"=>"Failed Add New Product"];
        }
    }
    
    public function update($input){
        $data = $input["data"];
        $update = DB::table($input["table"])->where($input["where"])->update($data);
        if($update){
            return "Success";
        } else {
            return "Failed";
        }
    }
    
    public function delete($input){
        $delete = DB::table($input["table"])->where($input["where"], "=", $input["id"])->delete();
        $delete_detail = DB::table($input["table_detail"])->where($input["where_detail"], "=", $input["id"])->delete();
        if($delete && $delete_detail){
            return ["success"=>true, "message"=>"Success Delete Product"];
        } else {
            return ["success"=>false, "message"=>"Failed Delete Product"];
        }
    }

}
