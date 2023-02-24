<?php

namespace App\Http\Controllers;
use App\Models\todo as ModelsTodo;
use Illuminate\Http\Request;

class Todo extends Controller
{
    //

    public function insert(Request $req)
    {
        // dd($req->all());
        // $this->validate($req, [
        //     'task_name' => 'required',
        //     'task_desc' => 'required'
        // ]);   
        ModelsTodo::create($req->all());
    }


    public function view()
    {
        $values = ModelsTodo::get();
        return response()->json(['values'=>$values]);
    }

    public function display_edt(Request $req)
    {
        $id = $req->id;
        $new_values = ModelsTodo::where([
            ['id',$id],
        ])->get();
        return response()->json(['new_values'=>$new_values]);
    }
}
