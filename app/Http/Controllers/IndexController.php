<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IndexController extends Controller
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
    
    public function main()
    {
        $input = $this->request->json()->all();
        $action = $input["action"];
        return $this->$action($input);
    }

    public function list($input){
        $table = $input["table"];
        $data = DB::table($table);
        if(!empty($input["where"]))
            $data->where($input["where"]);

        if(!empty($input["first"]) && $input["first"] == true)
            $data = (array) $data->first();
        else
            $data = $data->get();

        $result["count"] = count($data);
        $result["data"] = $data;

        return $result;
    }
    //
}
