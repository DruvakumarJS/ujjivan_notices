<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Notice;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Bank;
use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Facades\Hash;
use App\Models\DeviceData;
use App\Models\Audit;
use App\Models\NonIdleDevice;
use DB;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use PDF;
use Illuminate\Support\Facades\Validator;
use Auth;


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

            $device = Devices::where('region_id' , $value->id)->get();

            $devicecount[] =  $device->count();

        }

        $pie_data = ['labels' => ['Online' ,  'Offline' , 'Dead'],
            'data' => [ $online ,  $offiine , $dead],
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
    }

    public function branches(){
        $region = Region::get();
        $data = Branch::paginate(25);
        return view('settings/branches', compact('region','data'));
    }

    public function save_branch(Request $request){

       // print_r($request->input()); die();

        $validator = Validator::make($request->all(), [

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

      if ($validator->fails()) {
        
          return redirect()->back()->withErrors($validator)->withInput();
      }

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
           $audit = Audit::create([
            'action' => 'New branch created - '.$request->branch_code,
            'track_id' => $data->id,
            'user_id' => Auth::user()->id,
            'module' => 'Branch',
            'operation' => 'C'
          ]);
            return redirect()->route('branches');
        }
    }

    public function update_branch(Request $request){

       // print_r($request->input()); die();
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

      if ($validator->fails()) {
        
          return redirect()->back()->withErrors($validator)->withInput();
      }

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
          $data = Branch::where('branch_code', $request->branch_code)->first();
           $audit = Audit::create([
            'action' => 'Branch details modified - '.$request->branch_code,
            'track_id' => $data->id,
            'user_id' => Auth::user()->id,
            'module' => 'Branch',
            'operation' => 'C'
          ]);

            return redirect()->route('branches');
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

    public function branch_notices($id){
     // print_r($id); die();
        $branch = Branch::where('id',$id)->first();
        $region_id = $branch->region_id;
        $state = $branch->state;
        $branchid = $branch->id;

        $languages = Language::get();

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
                   ->paginate(50);

          return view('settings/notices',compact('data','languages'));
    }


}
