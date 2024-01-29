<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Notice;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Bank;
use DB;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = date('Y-m-d');
        $current_time = date('Y-m-d H:i');
        $active_time = date("Y-m-d H:i",strtotime("-15 minutes", strtotime($current_time)));
        $inactive_time = date("Y-m-d H:i",strtotime("-2880 minutes", strtotime($current_time)));

        $online = Devices::where('last_updated_date' , '>=', $active_time)->where('last_updated_date','LIKE',$today.'%')->count();
        $offiine = Devices::where('last_updated_date' , '<', $active_time)->where('last_updated_date','>=',$inactive_time)->count();
        $dead = Devices::where('last_updated_date','<',$inactive_time)->count();

       // print_r($inactive_time); die();
        $regionName= array();
        $devicecount=array();


        $regions = Region::get();

        foreach ($regions as $key => $value) {
            $regionName[] = $value->name;

            $branc = Branch::where('region_id' , $value->id)->get();

            foreach ($branc as $key2 => $value2) {

                $device = Devices::where('branch_id' , $value2->id)->get();

                $devicecount[] =  $device->count();
                
            }
        }

        //print_r($regionName);
        //print_r($devicecount); die();

        $pie_data = ['labels' => ['Online' ,  'offiine' , 'Dead'],
            'data' => [ $online ,  $offiine , $dead],
        ];

        $line_data =['labels' => $regionName,'data' => $devicecount ];
        
        return view('home',compact('pie_data' , 'line_data'));
    }

    public function settings(){
    
        $region =Region::count(); 
        $branch =Branch::count(); 
        $bank =Bank::count(); 

        return view('settings/list' , compact('region','branch','bank'));
    }
    public function region(){

        $data = Region::paginate(25);
        return view('settings/regions',compact('data'));
    }
    public function save_region(Request $request){

       // print_r($request->input()); die();

        $save = Region::create(['name' => $request->name , 'region_code'=> $request->branch_code]);

        if($save){
            return redirect()->route('regions');
        }
    }

    public function update_region(Request $request){
        $update = Region::where('id',$request->id)->update(['name' => $request->name , 'region_code'=> $request->branch_code]);

        if($update){
            return redirect()->route('regions');
        }
    }

    public function delete_region($id){
        //print_r($id); die();
        $delete = Region::where('id',$id)->delete();

        if($delete){
            return redirect()->route('regions');
        }
    }

    public function branches(){
        $region = Region::get();
        $data = Branch::paginate(25);
        return view('settings/branches', compact('region','data'));
    }

    public function save_branch(Request $request){

       // print_r($request->input()); die();

        $save = Branch::create([
            'region_id'=>$request->region,
            'name' => $request->name , 
            'branch_code'=> $request->branch_code ,
            'ifsc' => $request->ifsc,
            'area' => $request->area ,
            'state' => $request->state ,
            'district' => $request->district ,
            'city' => $request->city ,
            'pincode' => $request->pincode]);

        if($save){
            return redirect()->route('branches');
        }
    }

    public function update_branch(Request $request){

       // print_r($request->input()); die();

        $save = Branch::where('id',$request->id)->update([
            'region_id'=>$request->region,
            'name' => $request->name , 
            'branch_code'=> $request->branch_code ,
            'ifsc' => $request->ifsc,
            'area' => $request->area ,
            'state' => $request->state ,
            'district' => $request->district ,
            'city' => $request->city ,
            'pincode' => $request->pincode]);

        if($save){
            return redirect()->route('branches');
        }
    }

    public function delete_branch($id){
       // print_r($id); die();
        $delete = Branch::where('id',$id)->delete();

        if($delete){
            return redirect()->route('branches');
        }
    }



    public function banks(){
        $branch = Branch::get();
        $data = Bank::paginate(25);
        return view('settings/banks', compact('branch','data'));
    }


     public function save_bank(Request $request){

        //print_r($request->input()); die();

        $save = Bank::create([
            'branch_id'=>$request->branch,
            'bank_name' => $request->name , 
            'bank_code'=> $request->bank_code ,
            'ifsc' => $request->ifsc ,
            'area' => $request->area ,
            'building' => $request->building ,
            'pincode' => $request->pincode]);

        if($save){
            return redirect()->route('banks');
        }
    }

     public function update_bank(Request $request){

        //print_r($request->input()); die();

        $update = Bank::where('id',$request->id)->update([
            'branch_id'=>$request->branch,
            'bank_name' => $request->name , 
            'bank_code'=> $request->bank_code ,
            'ifsc' => $request->ifsc ,
            'area' => $request->area ,
            'building' => $request->building ,
            'pincode' => $request->pincode]);

        if($update){
            return redirect()->route('banks');
        }
    }

     public function delete_bank($id){
       // print_r($id); die();
        $delete = Bank::where('id',$id)->delete();

        if($delete){
            return redirect()->route('banks');
        }
    }

    public function get_bank_details(Request $request){

        $data = DB::table('branches')
            ->select(
                    DB::raw("CONCAT(branches.name,' - ',branches.branch_code,' - ',branches.ifsc , ' - ',branches.area ,' - ',branches.city,' - ',branches.pincode) AS value"),
                    'branches.id',
                    'branches.name',
                    'branches.branch_code',
                    'branches.ifsc',
                    'branches.area',
                    'branches.city',
                    'branches.pincode',
                    'branches.state',
                    'branches.district'
                   )
                    ->where('name', 'LIKE', '%'. $request->get('search'). '%')
                    ->orWhere('ifsc', 'LIKE', '%'. $request->get('search'). '%')
                    ->orWhere('branch_code', 'LIKE', '%'. $request->get('search'). '%')
                    ->orWhere('pincode', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();            
    
        return response()->json($data);

    }

    public function showqrcode(){
        return view('qrcode/index');
    }

   


}
