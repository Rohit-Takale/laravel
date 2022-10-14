<?php

namespace App\Http\Controllers;

use App\Models\company as companyModel;

use Illuminate\Http\Request;

class Company extends Controller
{
    //
    public function insert(Request $req){
        // dd($req->all());
        // $data =[
        //     "name" => $req->cname,
        //     "mail" =>

        // ];
    companyModel::create($req->all());
    }

    public function view()
    {
        $values = companyModel::get();
        return view("dash")->with(["values"=>$values]);
    }
}
