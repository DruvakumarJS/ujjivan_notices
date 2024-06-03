<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use App\Models\DeviceData;
use App\Models\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Audit;
use Auth;

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
       // print_r($request->Input()); die();

        $validator = Validator::make($request->all(), [

        'branch_name' => [
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

         'device_id' => [
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

          'model' => [
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


          'date_of_installation' => [
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
          'branch_id' => [
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
          '_token' => [
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

        if(Devices::where('deviceID',$request->serial_no)->exists()){
            return redirect()->back()->withMessage('Duplicate device Serial Number . Please re-check the device Serial Number genarated by Super Admin')->withInput();
        }

        if(Devices::where('mac_id',$request->device_id)->exists()){
            return redirect()->back()->withMessage('Duplicate authorization ID . Please re-check the authorization ID in the application')->withInput();
        }


        $branch = Branch::where('id',$request->branch_id)->first();

        $store = Devices::create([
            'region_id' => $branch->region_id,
            'branch_id' => $request->branch_id,
            'bank_id' => '0',
            'mac_id' => $request->device_id,
            'device_details' => $request->model,
            'deviceID' => $request->serial_no,
            'tv_serial_no' => $request->tv,
            'router_serial_number' => $request->router,
            'sim_card_number' => $request->sim,
            'status' => 'Offline',
            'date_of_install' => $request->date_of_installation,
            'remote_id' => $request->serial_no

        ]);

        if($store){
          $data = Devices::where('mac_id',$request->device_id)->first();

          $audit = Audit::create([
            'action' => 'New device registered under branch ID - '.$branch->branch_code,
            'track_id' => $data->id,
            'user_id' => Auth::user()->id,
            'module' => 'Device',
            'operation' => 'C'
          ]);

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

        $validator = Validator::make($request->all(), [

        'branch_name' => [
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
        'device_id' => [
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

          'model' => [
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


          'date_of_installation' => [
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
          'branch_id' => [
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
          '_token' => [
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

        $branch = Branch::where('id',$request->branch_id)->first();

        $update  = Devices::where('id',$id)->update([
            'region_id' => $branch->region_id,
            'branch_id' => $request->branch_id,
            'bank_id' => '0',
            'device_details' => $request->model,
            'tv_serial_no' => $request->tv,
            'router_serial_number' => $request->router,
            'sim_card_number' => $request->sim,
            'date_of_install' => $request->date_of_installation
        ]);

        if($update){

          $audit = Audit::create([
            'action' => 'Device details modified for branch ID - '.$branch->branch_code,
            'track_id' => $id,
            'user_id' => Auth::user()->id,
            'module' => 'Device',
            'operation' => 'U'
          ]);


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
      $device=Devices::where('id',$id)->first();
      $branch = Branch::where('id',$device->branch_id)->first();

          $audit = Audit::create([
            'action' => 'Device removed from branch ID - '.$branch->branch_code,
            'track_id' => $id,
            'user_id' => Auth::user()->id,
            'module' => 'Device',
            'operation' => 'D'
          ]);

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

    public function analytics($id){

        $data = Devices::where('id', $id)->first();
        $date = date('Y-m-d');

        $api_data = DeviceData::where('last_updated_date',$date)->where('device_id', $id)->get();

        return view('device/analytics', compact('data' , 'date' , 'api_data'));
       
        /* $from = "2024-02-01";
        $to = "2024-02-02";
        $deviceID = "1";

      
        if($from != '' && $to != '')
          {

              $data = array();
              $now = strtotime($from);
              $last = strtotime($to);
             // $data= array();
              //$data = "123";
             
              while($now <= $last ) {

                if(DeviceData::where('device_id', $deviceID)->where('last_updated_date',date('Y-m-d' , $now))->exists()){
                    $firstdata = DeviceData::where('device_id', $deviceID)->where('last_updated_date',date('Y-m-d' , $now))->first();
                    $lastdata = DeviceData::where('device_id', $deviceID)->where('last_updated_date',date('Y-m-d' , $now))->orderBy('id','DESC')->first();

                    $details = DeviceData::where('device_id', $deviceID)->where('last_updated_date',date('Y-m-d' , $now))->get();


                    foreach ($details as $key => $value) {
                        if($key == 0){
                            $d1 = date('Y-m-d' , $now).' '.$value->last_updated_time;
                            $running_minutes = 0;
                            $idle_minutes = 0;
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
                             print_r(" from time: ".$d1." to time: ".$d2); 
                             print_r(" time diff: ".$minutes); 
                             print_r(" running: ".$running_minutes); 
                             print_r(" --idle: ".$idle_minutes);
                             print_r("<br>");
                            
                            $d1 = date('Y-m-d' , $now).' '.$value->last_updated_time;

                        }
                        
                    }
                             

                   // die();

                    
                    $date = date('Y-m-d' , $now);
                    $boot_on = $firstdata->last_updated_time;
                    $boot_off  = $lastdata->last_updated_time;
                    $total_running = $running_minutes;
                    $total_idle = $idle_minutes;


                }
                else{
                    $date = date('Y-m-d' , $now);
                    $boot_on = '--';
                    $boot_off  = '--';
                    $total_running = '--';
                    $total_idle = '--';

                }

                 $res = [
                    'date' => $date,
                    'boot_on_time' => $boot_on,
                    'boot_off_time' => $boot_off,
                    'total_running_hours' => $total_running,
                    'total_idle_hours' => $total_idle,

                    ];

                array_push($data, $res);

               
 
                 
               $now = strtotime('+1 day', $now);
              }
           
           }
         
          echo json_encode($data);*/



       
    }

    public function get_device_health_data(Request $request){
        print_r($request->search_date); die();

    }

    public function fetch_analytics_data(Request $request){
        $from = $request->from_date;
        $to = $request->to_date;
        $deviceID = $request->device_id;

        if($request->ajax())
        {
         if($request->from_date != '' && $request->to_date != '')
          {

              $data = array();
              $now = strtotime($request->from_date);
              $last = strtotime($request->to_date);
             // $data= array();
              //$data = "123";
             
              while($now <= $last ) {

                if(DeviceData::where('device_id', $deviceID)->where('last_updated_date',date('Y-m-d' , $now))->exists()){
                    $firstdata = DeviceData::where('device_id', $deviceID)->where('last_updated_date',date('Y-m-d' , $now))->first();
                    $lastdata = DeviceData::where('device_id', $deviceID)->where('last_updated_date',date('Y-m-d' , $now))->orderBy('id','DESC')->first();

                    $details = DeviceData::where('device_id', $deviceID)->where('last_updated_date',date('Y-m-d' , $now))->get();


                     foreach ($details as $key => $value) {
                        if($key == 0){
                            $d1 = date('Y-m-d' , $now).' '.$value->last_updated_time;
                            $running_minutes = 0;
                            $idle_minutes = 0;
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
                             /*print_r(" from time: ".$d1." to time: ".$d2); 
                             print_r(" time diff: ".$minutes); 
                             print_r(" running: ".$running_minutes); 
                             print_r(" --idle: ".$idle_minutes);
                             print_r("<br>");*/
                            
                            $d1 = date('Y-m-d' , $now).' '.$value->last_updated_time;

                        }
                        
                    }

                    $minutes_running = $running_minutes;
                    $minutes_idle = $idle_minutes;
                             
                    if($running_minutes != '0'){
                    
                        if($running_minutes%60 > '0'){
                             $running_minutes = floor($running_minutes/60) ."Hr : " . $running_minutes%60 ."Min";
                        }
                        else {
                            $running_minutes = $running_minutes/60 ."Hr";
                        }
                    }
                    else {
                        $running_minutes = '0 Min'; 
                    }

                     if($idle_minutes != '0'){
                    
                        if($idle_minutes%60 > '0'){
                             $idle_minutes = floor($idle_minutes/60) ."Hr : " . $idle_minutes%60 ."Min";
                        }
                        else {
                            $idle_minutes = $idle_minutes/60 ."Hr";
                        }
                    }
                    else {
                        $idle_minutes = '0 Min'; 
                    }

                    
                    $date = date('Y-m-d' , $now);
                    $boot_on = $firstdata->last_updated_time;
                    $boot_off  = $lastdata->last_updated_time;
                    $total_running = $running_minutes;
                    $total_idle = $idle_minutes;
                    $sync_data =  json_encode($details);



                }
                else{
                    $minutes_running = '0';
                    $minutes_idle = '0';

                    $date = date('Y-m-d' , $now);
                    $boot_on = '--';
                    $boot_off  = '--';
                    $total_running = '--';
                    $total_idle = '--';
                    $sync_data =  [];

                }

                 $res = [
                    'date' => $date,
                    'boot_on_time' => $boot_on,
                    'boot_off_time' => $boot_off,
                    'total_running_hours' => $total_running,
                    'total_idle_hours' => $total_idle,
                    'sync_data' => $sync_data,
                    'minutes_running' => $minutes_running,
                    'minutes_idle' => $minutes_idle

                    ];

                array_push($data, $res);

               
 
                 
               $now = strtotime('+1 day', $now);
              }
           
           }
          }
          else
          {
           $data = 'mnm';
          }
         // echo json_encode($data);
          echo json_encode($data);
         }

    
}
