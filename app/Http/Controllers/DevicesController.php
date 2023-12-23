<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use App\Models\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data = Devices::paginate(50);
         $search = '';
         $value = Devices::where('id','2')->first();

        return view('device/list',compact('data' ,'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('device/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  print_r($request->Input()); die();

        $branch = Branch::where('id',$request->branch_id)->first();

        $store = Devices::create([
            'region_id' => $branch->region_id,
            'branch_id' => $request->branch_id,
            'bank_id' => $request->bank_id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'device_details' => $request->device_id .':'.$request->model,
            'status' => 'Offline',
            'date_of_install' => $request->date_of_installation

        ]);

        if($store){
            return redirect()->route('devices');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Devices::where('id', $id)->first();
        return view('device/view_more',compact('data', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Devices::where('id', $id)->first();
        return view('device/edit',compact('data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       /* print_r($id);
        print_r($request->input()); die();*/
         $branch = Branch::where('id',$request->branch_id)->first();

        $update  = Devices::where('id',$id)->update([
            'region_id' => $branch->region_id,
            'branch_id' => $request->branch_id,
            'bank_id' => $request->bank_id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'device_details' => $request->device_id .':'.$request->model,
            'status' => $request->status,
            'date_of_install' => $request->date_of_installation,
            'status' => $request->status,
            'remote_id' => $request->remote_id
        ]);

        if($update){
            return redirect()->route('view_device_datails',$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // print_r($id); die();

        return redirect()->back();
    }

    public function search(Request $request){

        $search = $request->search;
        $search_array = explode(' ', $search);
        $dvices = array();
        $dvices =  Devices::select('*');
  
        foreach ($search_array as $key => $value) {

          if($key == '0'){
           $search = $value;
            
           $dvices = $dvices->where(function($query)use($search){
            $query->orWhere('branch' , 'LIKE', '%'.$search.'%');
            $query->orWhere('city' , 'LIKE', '%'.$search.'%');
            $query->orWhere('area' , 'LIKE', '%'.$search.'%');
            $query->orWhere('state' , 'LIKE', '%'.$search.'%');
            $query->orWhere('ifsc' , 'LIKE', '%'.$search.'%');
            $query->orWhere('status' , 'LIKE', '%'.$search.'%');
            $query->orWhere('region' , 'LIKE', '%'.$search.'%');

        });
        

          }
          else if($key > '0'){
          $search = $value;

           $dvices = $dvices->where(function($query)use($search){
            $query->orWhere('branch' , 'LIKE', '%'.$search.'%');
            $query->orWhere('city' , 'LIKE', '%'.$search.'%');
            $query->orWhere('area' , 'LIKE', '%'.$search.'%');
            $query->orWhere('state' , 'LIKE', '%'.$search.'%');
            $query->orWhere('ifsc' , 'LIKE', '%'.$search.'%');
            $query->orWhere('status' , 'LIKE', '%'.$search.'%');
            $query->orWhere('region' , 'LIKE', '%'.$search.'%');
            });
           
          }
         
         
        }

        $search = $request->search;
       

        $data = $dvices->paginate(50);
        return view('device/list',compact('data','search'));
    }
}
