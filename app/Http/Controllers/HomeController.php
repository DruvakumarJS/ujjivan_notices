<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Notice;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Bank;
use DB;

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

        $online = Devices::where('status' , 'Online')->count();
        $offiine = Devices::where('status' , 'Offline')->count();
        $dead = Devices::where('status' , 'Dead')->count();

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
            'state' => $request->state ,
            'district' => $request->district ,
            'city' => $request->city ,
            'pincode' => $request->pincode]);

        if($save){
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

    public function get_bank_details(Request $request){

        $data = DB::table('banks')
            ->select(
                    DB::raw("CONCAT(banks.bank_name,' - ',banks.bank_code,' - ',banks.ifsc , ' - ',banks.area ,' - ',banks.building,' - ',banks.pincode) AS value"),
                    'banks.id as bankid',
                    'banks.bank_name',
                    'banks.bank_code',
                    'banks.ifsc',
                    'banks.area',
                    'banks.building',
                    'banks.pincode',
                    'branches.id',
                    'branches.city',
                    'branches.state',
                    'branches.branch_code',
                    'branches.district'
                   )
                    ->join('branches','banks.branch_id','=','branches.id')
                    ->where('bank_name', 'LIKE', '%'. $request->get('search'). '%')
                    ->orWhere('ifsc', 'LIKE', '%'. $request->get('search'). '%')
                    ->orWhere('bank_code', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();            
    
        return response()->json($data);

    }

   


}
