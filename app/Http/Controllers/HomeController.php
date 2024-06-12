<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Notice;
use App\Models\Region;
use App\Models\Branch;
use App\Models\BranchInformation;
use App\Models\Bank;
use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Facades\Hash;
use App\Models\DeviceData;
use App\Models\Audit;
use App\Models\NonIdleDevice;
use App\Imports\ImportBranches;
use DB;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use PDF;
use Illuminate\Support\Facades\Validator;
use Auth;
use Excel;
use File;


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
        $active_time = date("Y-m-d H:i",strtotime("-120 minutes", strtotime($current_time)));
        $inactive_time = date("Y-m-d H:i",strtotime("-2880 minutes", strtotime($current_time)));

        $online = Devices::where('last_updated_date' , '>=', $active_time)->where('last_updated_date','LIKE',$today.'%')->get();
        $offiine = Devices::where('last_updated_date' , '<', $active_time)->where('last_updated_date','>=',$inactive_time)->get();
        $dead = Devices::where('last_updated_date','<',$inactive_time)->get();

       // print_r($inactive_time); die();
        $regionName= array();
        $devicecount=array();
        $online_device=array();
        $offline_device=array();
        $dead_deivce=array();

        $regions = Region::get();

        foreach ($regions as $key => $value) {
            $regionName[] = $value->name;

            $device = Devices::where('region_id' , $value->id)->get();

            $devicecount[] =  $device->count();

        }
        foreach ($online as $key => $value) {
          $online_device[] = $value->branch->branch_code.'-'.$value->branch->city.'-'.$value->branch->state;
        }
        foreach ($offiine as $key2 => $value2) {
          $offline_device[] = $value2->branch->branch_code.'-'.$value2->branch->city.'-'.$value2->branch->state;
        }
        foreach ($dead as $key3 => $value3) {
          $dead_deivce[] = $value3->branch->branch_code.'-'.$value3->branch->city.'-'.$value3->branch->state;
        }
       // print_r($online_device); die();

        $pie_data = [
            'labels' => ['Online' ,  'Offline' , 'Dead'],
            'data' => [ count($online) ,  count($offiine) , count($dead)],
            'devices' => [ 'online_device'=> $online_device ,  'offline_device'=>$offline_device , 'dead_device'=>$dead_deivce],
        ];

        $line_data =['labels' => $regionName,'data' => $devicecount ];

        //running and idle timings
        
        $from = date('Y-m-01');
        $to = date('Y-m-t');
        $data = array();
        $now = strtotime($from);
        $last = strtotime($to);

       
        while($now <= $last ) {
            $running_minutes = 0;
            $idle_minutes = 0;

            if(DeviceData::where('last_updated_date',date('Y-m-d' , $now))->exists()){

                $devices = Devices::select('id')->get();

                foreach ($devices as $key0 => $devices) {
                     $details = DeviceData::where('device_id' ,$devices->id)->where('last_updated_date',date('Y-m-d' , $now))->get();
             
                     foreach ($details as $key => $value) {
                        if($key == 0){
                            $d1 = date('Y-m-d' , $now).' '.$value->last_updated_time;
                            
                        }
                        else{
                            $d2 = date('Y-m-d' , $now).' '.$value->last_updated_time;
                            $diff = strtotime($d2) - strtotime($d1) ;
                            $minutes = $diff/60;

                            if($minutes <= 20 ){
                               $running_minutes = intval($running_minutes)+intval($minutes);
                            }
                            else{
                                $idle_minutes = intval($idle_minutes)+intval($minutes);
                            }
                            
                            $d1 = date('Y-m-d' , $now).' '.$value->last_updated_time;

                        }
                        
                    }
                }
                
            
             }

             $analytic_date[] = date('d' , $now);
             $analytic_running[] = floor($running_minutes/60).".".floor($running_minutes%60);
             $analytic_idle[] = floor($idle_minutes/60).".".floor($idle_minutes%60);
             
             $now = strtotime('+1 day', $now);
            }

            /*print_r(json_encode($analytic_date));print_r("---");
            print_r(json_encode($analytic_running));print_r("---");
            print_r(json_encode($analytic_idle));print_r("---");*/

            $monthdata = ['date' => $analytic_date , 'running' => $analytic_running , 'idle' => $analytic_idle];

           // print_r(($monthdata)) ; die();  

            $languages = Language::get();
             $publishedarray=array();
             $draftarray=array();

             $t_p=Notice::where('status','Published')->count();
             $t_up=Notice::where('status','UnPublished')->count();
             $t_d=Notice::where('status','Draft')->count();

            foreach ($languages as $key => $lng) {
               $langugaearray[]=$lng->lang;
               $published = Notice::where('lang_code',$lng->code)->where('status','Published')->count();
               $publishedarray[]=$published;
              
               $Draft = Notice::where('lang_code',$lng->code)->where('status','Draft')->count();
               $draftarray[]=$Draft;

               $unpublished = Notice::where('lang_code',$lng->code)->where('status','UnPublished')->count();
               $unpublishedarray[]=$unpublished;

            }

            //devices running for more than 18 hours


            $noticeArray=['languages'=> $langugaearray , 'published' => $publishedarray , 'draft' => $draftarray , 'unpublished' => $unpublishedarray , 'publish_count'=> $t_p , 'UnPublished_count'=>$t_up , 'draftdount' => $t_d];

        
           return view('home',compact('pie_data' , 'line_data' , 'monthdata' , 'noticeArray'));
    }

    public function settings(){
    
        $region =Region::get(); 
        $branch =Branch::count(); 
        $bank =Bank::count(); 
        $search = '';
        $btn_position = '0';

        return view('settings/list' , compact('region','branch','bank','search','btn_position'));
    }
    /*public function region(){

        $data = Region::paginate(25);
        return view('settings/regions',compact('data'));
    }
    public function save_region(Request $request){

         $validator = Validator::make($request->all(), [

        'name' => [
              'required',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = ($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],
           'branch_code' => [
              'required',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = ($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],

        
      ]);

      if ($validator->fails()) {
        
          return redirect()->back()->withErrors($validator)->withInput();
      }

       // $save = Region::create(['name' => $request->name , 'region_code'=> $request->branch_code]);

        $region = New Region();
        $region->name = $request->name;
        $region->region_code = $request->branch_code;
        $save = $region->save();

        if($save){
          $audit = Audit::create([
            'action' => 'New Region added - '.$request->name,
            'track_id' => $region->id,
            'user_id' => Auth::user()->id,
            'module' => 'Region',
            'operation' => 'C'
          ]);

            return redirect()->route('regions');
        }
    }

    public function update_region(Request $request){
         $validator = Validator::make($request->all(), [

        'name' => [
              'required',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = ($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],
           'branch_code' => [
              'required',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = ($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],

        
      ]);

      if ($validator->fails()) {
        
          return redirect()->back()->withErrors($validator)->withInput();
      }

        $update = Region::where('id',$request->id)->update(['name' => $request->name , 'region_code'=> $request->branch_code]);

        if($update){

          $audit = Audit::create([
            'action' => 'Region details modified - '.$request->name,
            'track_id' => $request->id,
            'user_id' => Auth::user()->id,
            'module' => 'Region',
            'operation' => 'U'
          ]);
            return redirect()->route('regions');
        }
    }

    public function delete_region($id){
        //print_r($id); die();
        $data = Region::where('id',$id)->first();
        $delete = Region::where('id',$id)->delete();

        if($delete){
           $audit = Audit::create([
            'action' => 'Region deleted - '.$data->name,
            'track_id' => $id,
            'user_id' => Auth::user()->id,
            'module' => 'Region',
            'operation' => 'D'
          ]);

            return redirect()->route('regions');
        }
    }*/

    public function branches(){
        $region = Region::get();
        $data = Branch::paginate(25);
        $search = '';
        return view('settings/branches', compact('region','data','search'));
    }

    public function save_branch(Request $request){

      //  print_r($request->ctname); die();

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
          $data = Branch::where('branch_code', $request->branch_code)->first();

          $info = BranchInformation::create([
            'branch_id' => $data->id,
            'bm_name' => $request->bm_name , 
            'bm_number' => $request->bm_number , 
            'bm_email' => $request->bm_email , 
            'bm_designation' => "BM" , 
            'bo_name' => $request->bo_name , 
            'bo_number' => $request->bo_number , 
            'bo_email' => $request->bo_email , 
            'bo_designation' => "BO" , 
            'medical' => $request->medical , 
            'ambulance' => $request->ambulance , 
            'fire' => $request->fire , 
            'police' => $request->police ]);

           $audit = Audit::create([
            'action' => 'New branch created ',
            'track_id' => $data->id,
            'user_id' => Auth::user()->id,
            'module' => 'Branch',
            'operation' => 'C',
            'pan_india' => '-',
            'regions' => $request->region,
            'states' => $request->state,
            'branch' => $request->branch_code
          ]);
            return redirect()->route('settings');
        }
    }

    public function edit_branch($id){

      $value = Branch::with('branchinfo')->where('id',$id)->first();
      $region = Region::get();

     // print_r(json_encode($value) ); die();

      return view('settings/edit_branch',compact('value','region')); 

    }

    public function update_branch(Request $request){

        //print_r($request->input()); die();

        $validator = Validator::make($request->all(), [

         'id' => [
              'required',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = ($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],   

        'region' => [
              'required',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = ($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],
           'name' => [
              'required',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = ($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],

          'branch_code' => [
              'required',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = ($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],

        'ifsc' => [
              'required',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = ($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],

          'area' => [
              'required',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = ($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],


          'state' => [
              '',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = html_entity_decode($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],
          'district' => [
              '',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = html_entity_decode($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],
          'city' => [
              '',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = html_entity_decode($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],
          'pincode' => [
              '',
              function ($attribute, $value, $fail) {
                  // Decode HTML entities
                  $decodedValue = html_entity_decode($value);

                  // Check if the decoded HTML content contains any <script> tags
                  if (strpos($decodedValue, '<script') !== false) {
                      $fail('Scripts are not allowed within Notices and inputs, remove them and submit again  ');
                  }
              },
          ],
      ]);

      $fileName = '';

      if ($validator->fails()) {
        
          return redirect()->back()->withErrors($validator)->withInput();
      }

        if (file_exists(public_path().'/announcement')) {
              
        } else {
           
            File::makeDirectory(public_path().'/announcement', $mode = 0777, true, true);
        }


        if($file = $request->hasFile('announcement_file')) {
             
            $file = $request->file('announcement_file') ;
           // $fileName = $file->getClientOriginalName() ;
            $current = date('Y-m-d_H_i_s');
            $temp = explode(".", $file->getClientOriginalName());
            $fileName=$request->branch_code.'_'.$current. '.' . end($temp);
           
            $destinationPath = public_path().'/announcement' ;
            $file->move($destinationPath,$fileName);
            
         }

        $data = Branch::where('branch_code', $request->branch_code)->first();

        $save = Branch::where('id',$data->id)->update([
            'region_id'=>$request->region,
            'name' => $request->name , 
            'branch_code'=> $request->branch_code ,
            'ifsc' => $request->ifsc,
            'area' => $request->area ,
            'state' => $request->state ,
            'district' => $request->district ,
            'city' => $request->city ,
            'pincode' => $request->pincode,
            ]);

        $updateBranchinfo = BranchInformation::where('branch_id',$data->id)->update([
            'bm_name' => $request->bm_name , 
            'bm_number' => $request->bm_number , 
            'bm_email' => $request->bm_email , 
            'bm_designation' => "BM" , 
            'bo_name' => $request->bo_name , 
            'bo_number' => $request->bo_number , 
            'bo_email' => $request->bo_email , 
            'bo_designation' => "BO" , 
            'medical' => $request->medical , 
            'ambulance' => $request->ambulance , 
            'fire' => $request->fire , 
            'police' => $request->police , 
            'disclaimer1' => $request->disclaimer1 , 
            'disclaimer2' => $request->disclaimer2 , 
            'announcement' => $request->announcement , 
            'start_time' => $request->start , 
            'end_time' => $request->end , 
            'filename' => $fileName , 
          ]);

        if($save || $updateBranchinfo){
          
           $audit = Audit::create([
            'action' => 'Branch details modified ',
            'track_id' => $data->id,
            'user_id' => Auth::user()->id,
            'module' => 'Branch',
            'operation' => 'C',
            'pan_india' => '-',
            'regions' => $request->region,
            'states' => $request->state,
            'branch' => $request->branch_code
          ]);

            return redirect()->back()->withMessage('Updated Successfully');
           
        }
         return redirect()->back();

    }

    public function import_branches(Request $request){
     $import = new ImportBranches ;
     Excel::import($import, $request->file('file'));

     if($import->getRowCount() == 0){
            return redirect()->back()->withMessage('No data imported');
        }
        else {
            $audit = Audit::create([
            'action' => 'Branch details imported via Excel sheet',
            'track_id' => '',
            'user_id' => Auth::user()->id,
            'module' => 'Branch',
            'operation' => 'C',
            'pan_india' => '-',
          ]);
            return redirect()->back()->withMessage('Import Successfull. '.$import->getRowCount() . ' Branches  added .');
        }
    }

    public function delete_branch($id){
       // print_r($id); die();
        $data = Branch::where('id',$id)->first();
        $delete = Branch::where('id',$id)->delete();

        if($delete){

           $audit = Audit::create([
            'action' => 'Branch details modified - '.$data->branch_code,
            'track_id' => $data->id,
            'user_id' => Auth::user()->id,
            'module' => 'Branch',
            'operation' => 'C'
          ]);
            
        }
        return redirect()->route('settings');
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

   
    public function pdf(){

     $html = '<h1 >Hello, world!</h1>';


        // Specify the font file path
        //$fontPath = storage_path('fonts/calibril.ttf');

        // Configure the options for PDF generation
      /*  $options = [
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isPhpDebug' => true,
            'isHtml5ParserEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'font-family' =>$fontPath,
            
            'font' => 'calibril', // Font alias
        ];
*/
        // Generate the PDF using Dompdf
        //$pdf = PDF::loadHTML($html)->setOptions($options);

        // Download the PDF file
       // return $pdf->download('example.pdf');

        /*$filename = 'indent.pdf';
        $indent_details = ['content' => "Hello"];
        $pdf = PDF::loadView('template');
    
        $savepdf = $pdf->save(public_path($filename));*/


         $pdf = PDF::loadView('template');

    /*$pdf->setOption('encoding', 'UTF-8');
    $pdf->setOption('no-collate', true);
    $pdf->setOption('header-font-name', 'Verdana');*/
    return $pdf->stream('document.pdf');

    }

    public function authenticate(Request $request){
        $pass = Hash::make('admin');
       
        if($request->input == 'Admin'){
           echo json_encode("Authorized");
        }
        else{
           echo json_encode("UnAuthorized");
        }
        
    }

    public function notification(Request $request){
       $data = NonIdleDevice::where('created_at','LIKE',date('Y-m-d').'%')->get();
       $notification=array();
       foreach ($data as $key => $value) {
         $id = $value->mac_id;
         $deviceDetail = Devices::where('mac_id',$id)->first();
         $branch = Branch::where('id', $deviceDetail->branch_id)->first();
         $notification[]=[
          'mac_id'=> $id,
          'name'=> $deviceDetail->name,
          'branch_code' => $branch->branch_code,
          'elapsed_time'=> $value->elapsed_time ,
          'logged_time' => $value->created_at
           ];
       }

       return response()->json($notification);
    }

    public function branch_notices($lang,$id){
    //  print_r($id); die();
        $branch = Branch::where('id',$id)->first();
        $region_id = $branch->region_id;
        $state = $branch->state;
        $branchid = $branch->id;

        $languages = Language::get();

        if($lang == 'all'){

        $data = Notice::where('is_pan_india','Yes')
                 ->orWhere(function($query)use($region_id){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]); 
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                 })
                   ->orderBy('id', 'DESC')
                   ->paginate(25);
          }
          else{
            $data = Notice::where(function($query)use($lang){
                   $query->where('is_pan_india','Yes');
                   $query->where('lang_code',$lang);
                 })
                 ->orWhere(function($query)use($region_id,$lang){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where('lang_code',$lang);
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lang){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where('lang_code',$lang);
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lang){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]); 
                    $query->where('lang_code',$lang);
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lang){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where('lang_code',$lang);
                 })
                   ->orderBy('id', 'DESC')
                   ->paginate(25);

          }         

          $search = '';         

          return view('settings/notices',compact('data','languages','search','lang','id'));
    }

    public function search(Request $request){
     // print_r($request->Input()); die();

       $search = $request->search;
       $lang = $request->lang;
       $id = $request->id;

       $branch = Branch::where('id',$id)->first();
        $region_id = $branch->region_id;
        $state = $branch->state;
        $branchid = $branch->id;

       if($request->lang == 'all'){
          $data = Notice::where(function($query)use($search){
                   $query->where('is_pan_india','Yes');
                   $query->where('document_id','LIKE','%'.$search.'%');
                 })
                 ->orWhere(function($query)use($region_id,$search){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where('document_id','LIKE','%'.$search.'%');
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$search){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where('document_id','LIKE','%'.$search.'%');
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$search){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]); 
                    $query->where('document_id','LIKE','%'.$search.'%');
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$search){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where('document_id','LIKE','%'.$search.'%');
                 })
       ->orderBy('id', 'DESC')
       ->paginate(25)->withQueryString();
       }
       else{
         $data = Notice::where(function($query)use($search,$lang){
                   $query->where('is_pan_india','Yes');
                   $query->where('document_id','LIKE','%'.$search.'%');
                   $query->where('lang_code',$lang);
                 })
                 ->orWhere(function($query)use($region_id,$search,$lang){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where('document_id','LIKE','%'.$search.'%');
                    $query->where('lang_code',$lang);
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$search,$lang){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where('document_id','LIKE','%'.$search.'%');
                    $query->where('lang_code',$lang);
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$search,$lang){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]); 
                    $query->where('document_id','LIKE','%'.$search.'%');
                    $query->where('lang_code',$lang);
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$search,$lang){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where('document_id','LIKE','%'.$search.'%');
                    $query->where('lang_code',$lang);
                 })
        
         ->orderBy('id', 'DESC')
         ->paginate(25)->withQueryString();
       }
       
        
        $languages = Language::get();

       return view('settings/notices', compact('data','search','languages','lang','id'));
    }

    public function get_branches(Request $request){
       $regionId = $request->regionId;
       $branchArray=array();

       $branch = Branch::where('region_id',$regionId)->get();
       $regionData = Region::where('id',$regionId)->first();

       foreach ($branch as $key => $value) {
          $branchArray[] = [
            'regionId' => $regionId ,
            'region_name' => $regionData->name,
            'branch_id' => $value->id,
            'name' => $value->name ,
            'branch_code' => $value->branch_code ,
            'address' => $value->area,
            'state' => $value->state ,
            
          ];
       }

       return response()->json($branchArray);
    }

     public function search_branch(Request $request){
    //  print_r($request->input()); die();

        $region = Region::get();
        $search = $request->search ; 
        $btn_position = $request->btn_pos;
        $branchArray=array();

        $regionData = Region::where('id',$request->regionId)->first();

        $data = Branch::where('region_id', $request->regionId)
              ->where(function($query)use($search){
                $query->where('branch_code' , 'LIKE','%'.$search.'%');
                $query->orWhere('name' , 'LIKE','%'.$search.'%');
                $query->orWhere('pincode' , 'LIKE','%'.$search.'%');
                $query->orWhere('state' , 'LIKE','%'.$search.'%');
                $query->orWhere('city' , 'LIKE','%'.$search.'%');
                $query->orWhere('district' , 'LIKE','%'.$search.'%');
                $query->orWhere('area' , 'LIKE','%'.$search.'%');
              })
              ->get();

        foreach ($data as $key => $value) {
          $branchArray[] = [
            'regionId' => $request->regionId ,
            'region_name' => $regionData->name,
            'branch_id' => $value->id,
            'name' => $value->name ,
            'branch_code' => $value->branch_code ,
            'address' => $value->area.' ,'.$value->city.' ,'.$value->district.' ,'.$value->pincode,
            'state' => $value->state ,
            
          ];
       }
              
              //->paginate(25);
      //  return view('settings/list', compact('region','data','search','btn_position'));

        return response()->json($branchArray);

    }

    public function poster(){
      return view('settings.poster');
    }

    public function update_poster(Request $request){
    // print_r($request->input()); die();
     $announcement = '0';
      $start = '';
      $end = '';
      $fileName = '';

      if($request->announcement == '1'){
        if($file = $request->hasFile('announcement_file')) {
             
            $file = $request->file('announcement_file') ;
           // $fileName = $file->getClientOriginalName() ;
            $current = date('Y-m-d_H_i_s');
            $temp = explode(".", $file->getClientOriginalName());
            $fileName='PAN_'.$current. '.' . end($temp);
           
            $destinationPath = public_path().'/announcement' ;
            $file->move($destinationPath,$fileName);
            
         }

        $announcement = '1';
        $start = $request->start;
        $end = $request->end;
        $fileName = $fileName;
      }

      $update = BranchInformation::where('id','!=','0')->update([
        'disclaimer2' => $request->disclaimer2 , 
        'announcement' => $announcement , 
        'start_time' => $start , 
        'end_time' => $end , 
        'filename' => $fileName , 
      ]);

      if($update){
        return redirect()->route('branches');
      }


    }



}
