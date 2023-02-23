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
        $this->validate($req, [
            'task_name' => 'required',
            'task_date' => 'required',
            'task_desc' => 'required'
        ]);   
        ModelsTodo::create($req->all());
    }
}
