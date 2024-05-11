<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audit;
use Auth;

class AuditController extends Controller
{
    public function index(){
    	$search = '';
        if(Auth::user()->id == '3'){
           $data = Audit::orderBy('id','desc')->paginate(50);
        }
        else{
           $data = Audit::where('module','!=','Device')->orderBy('id','desc')->paginate(50);
        }
    	

    	return view('audit',compact('data','search'));
    }

    public function search_audit(Request $request){
         $search = $request->search;
         
         $data = Audit::orderBy('id', 'DESC')
                 ->where('created_at' , 'LIKE' ,'%'. $search.'%')
                 ->orWhere('action' , 'LIKE' , '%'.$search.'%')
                 ->orWhere('module' , 'LIKE' , '%'.$search.'%')
                 ->orWhere('track_id' , 'LIKE' , '%'.$search.'%')
                /* ->orWhereHas('user',function($query)use ($search){
                    $query->where('name','LIKE','%'.$search.'%')->orWhere('employee_id','LIKE','%'.$search.'%');
                 })*/
                 ->paginate(50)
                 ->withQueryString();

         return view('audit',compact('data', 'search'));        

    }
}
