<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Request as ModelRequest;
class RequestController extends Controller
{


    public function index(){
        $requests = ModelRequest::latest()->get();
        return view('dashboard.request.index',compact('requests'));
    }

    public function accept($id){
        $request = ModelRequest::where('id',$id)->first();

        User::find($request->user_id)->update([
            'role' => 'blogger',
            'updated_at' => now(),
        ]);

        ModelRequest::find($id)->delete();

        return back();

    }

    public function cancel($id){
        $request = ModelRequest::where('id',$id)->first();

        ModelRequest::find($id)->delete();

        return back();

    }
    public function request_send(Request $request,$id){

        ModelRequest::create([
            'user_id' => $id,
            'feedback' => $request->feedback,
            'created_at' => now(),
        ]);
        return back();
    }
}
