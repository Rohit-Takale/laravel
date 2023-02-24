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
        $crt_lst = ModelsTodo::create($req->all());
        return response()->json($crt_lst);
    }


    public function view(Request $req)
    {
        $status = $req->status;
        $values = ModelsTodo::where('status',$status)->get();
        foreach ($values as $dtvals){
            $dtvals['created'] = $dtvals['created_at']->diffForHumans();
            // dd($dtvals['created'] );
        }
        return response()->json(['values' => $values]);
    }

    public function display_edt(Request $req)
    {
        $id = $req->id;
        $new_values = ModelsTodo::where([
            ['id', $id],
        ])->get();
        return response()->json(['new_values' => $new_values]);
    }

    public function edit_todo(Request $req)
    {

        // dd($req->all());
        $id = $req->id;
        $qry = ModelsTodo::where('id', $id)->update($req->all());
        if ($qry) {
            return response()->json(["msg" => 'Values are updated sucessfully']);
        } else {
            return response()->json(["msg" => 'Failed']);
        }
    }

    public function display_completed(Request $req)
    {
        $status = $req->status;
        $completed_values = ModelsTodo::where('status',$status)->get();
        foreach ($completed_values as $dtvals){
            $dtvals['created'] = $dtvals['updated_at']->diffForHumans();
            // dd($dtvals['created'] );
        }
        return response()->json(['completed_values' => $completed_values]);
    }

    public function move_cmpltd(Request $req){
        // dd($req->all());
        $status_new = $req->status;
        $cmplt_id = $req->id;
        $moved_vals = ModelsTodo::where('id', $cmplt_id)->update($req->all());
        return response()->json(['msg'=>"status has been changed",'msg'=>$moved_vals]);
    }

    public function delete_todo(Request $req)
    {
        $id = $req->id;
        $deleted_vals = ModelsTodo::where('id',$id)->delete();
        return response()->json(['dltvals'=>$deleted_vals]);
    }
    
}
