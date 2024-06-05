<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceData;
use App\Models\Devices;
use App\Models\Branch;
use App\Models\Notice;
use App\Models\NoticeContent;
use App\Models\BranchInformation;
use App\Models\Language;
use App\Models\NonIdleDevice;
use File;

class DeviceController extends Controller
{
   public function device_data(Request $request){
   	//print_r($request->input());

   	if(Devices::where('mac_id',$request->mac_id)->exists()){


    $device_details = Devices::where('mac_id',$request->mac_id)->first(); 
    
    $insert = DeviceData::create([
    	'mac_id' => $request->mac_id ,
    	'device_id' => $device_details->id,
    	'apk_version' => $request->apk_version ,
    	'last_updated_date' => $request->last_updated_date ,
    	'last_updated_time' => $request->last_updated_time ]);

    if($insert){
      $update = Devices::where('id',$device_details->id)->update(['last_updated_date' => $request->last_updated_date." ".$request->last_updated_time , 'apk_version' =>$request->apk_version ]);

    }

    $current_apk_version = '1.0';
    $min_apk_version = '1.0';
    $new_apk_available = 'false';
    $mandatory_apk_update = 'false';

    if($request->apk_version < $min_apk_version){
      $apk_update_required = 'true';
      $message = 'Please update the app to latest version';
     
    }
    else if($request->apk_version < $current_apk_version &&  $request->apk_version >= $min_apk_version && $mandatory_apk_update == 'true'){
      $apk_update_required = 'true';
      $message = 'Please update the app to latest version';
     
    }
    else if($request->apk_version < $current_apk_version &&  $request->apk_version >= $min_apk_version &&  $mandatory_apk_update == 'false'){
    	$apk_update_required = 'false';
        $message = 'New version available';
    }
    else{
    	$apk_update_required = 'false';
        $message = 'You are using updated app version.';
    }

   	return response([
   		'status'=>'true',
   		'update_required' => $apk_update_required ,
   		'message'=> $message 
   	]);
   }
   else{
    
   	return response([
   		'status'=>'false',
   		'update_required' => 'false' ,
   		'message'=> 'Device not registered' 
   		
   	]);

   }

   }

   public function get_notices(Request $request){
      
      $device_id = $request->mac_id ;
      $lang = $request->lang ;
      $data = array();

      if(Devices::where('mac_id',$request->mac_id)->exists()){


        $notices = Notice::where('lang_code',$lang)->where('notice_type','ujjivan')->get();

        foreach ($notices as $key => $value) {

          $voice = $value->voiceover ;

          if($voice == 'Y'){$voicover="YES";}
          else {$voicover="No";}
          
          $data[]=[
          'name' => $value->name ,
          'description' => $value->description ,
          'path' => url('/').'/noticefiles/' ,
          'filename' => $value->filename,
          'available_languages' => $value->available_languages,
          'voiceover' => $voicover ,
          'notice_group' => $value->notice_group,
          'lang' => $value->lang_code
          ];

        }

        
         return response([
          'status'=>'true',
          'data' => $data
          
        ]);

      }
      else{

        return response([
          'status'=>'false',
          'data' => $data
          
        ]);

      }


   }

   public function register(Request $request){
      $mac_id = $request->mac_id ;
      
      if(Devices::where('mac_id',$mac_id)->exists()){
          $data = Devices::where('mac_id',$mac_id)->first();

          $id = $data->mac_id;

          return response()->json([
            'status' => 'true',
            'message' => 'Success',
            'mac_id' => $data->mac_id]);
      }
      else{

          return response()->json([
            'status' => 'false',
            'message' => 'Device not registered',
            'mac_id' => '0']);

      }
   }

   public function languages(Request $request){
    $mac_id = $request->mac_id ;
    $langArray = array();

     if(Devices::where('mac_id',$mac_id)->exists()){
          $data = Language::get();

          foreach ($data as $key => $value) {
             $langArray[]= [
              'language' => $value->lang ,
              'name' => $value->name,
              'code' => $value->code,
              'font' => $value->font ];
          }

          return response()->json([
            'status' => 'true',
            'message' => 'Success',
            'data' => $langArray]);
      }
      else{

          return response()->json([
            'status' => 'false',
            'message' => 'Device not registered',
            'data' => $langArray]);

      }

   }

   public function get_notice_tittle(Request $request){
      

      if(isset($request->lang) && isset($request->notice_group))
      {
         $lang = $request->lang;
         $group_id = $request->notice_group;

         if(Notice::where('notice_group' , $group_id)->where('lang_code' , $lang)->exists()){
         
          $notice = Notice::where('notice_group' , $group_id)->where('lang_code' , $lang)->first();

          return response()->json([
            'status' => 'true',
            'message' => 'Success',
            'tittle' => $notice->name]);
         }
         else{
            return response()->json([
              'status' => 'false',
              'message' => 'Does not exists',
              'tittle' => '']);

         }
        

      }
      else{
        return response()->json([
            'status' => 'false',
            'message' => 'Insifficient Data',
            'tittle' => '']);

      }

     

   }  

    public function get_all_notices(Request $request){
      
      $device_id = $request->mac_id ;
      
      $data = array();

      if(Devices::where('mac_id',$request->mac_id)->exists()){


        $notices = Notice::where('notice_type','ujjivan')->get();

        foreach ($notices as $key => $value) {

          $voice = $value->voiceover ;

          if($voice == 'Y'){$voicover="YES";}
          else {$voicover="No";}
          
          $data[]=[
          'name' => $value->name ,
          'description' => $value->description ,
          'path' => url('/').'/noticefiles/' ,
          'filename' => $value->filename,
          'available_languages' => $value->available_languages,
          'voiceover' => $voicover ,
          'notice_group' => $value->notice_group,
          'lang' => $value->lang_code
          ];

        }

        
         return response([
          'status'=>'true',
          'data' => $data
          
        ]);

      }
      else{

        return response([
          'status'=>'false',
          'data' => $data
          
        ]);

      }


   }

    public function get_notices_for_db(Request $request){
      
      $device_id = $request->mac_id ;
      
      $data = array();
      $old_data = array();

      if(Devices::where('mac_id',$request->mac_id)->exists()){
       
        $lastdate = $request->lastupdatedate;

        $data = Notice::where(function($query){
           $query->where('published_date','<=',date('Y-m-d'));
        })
        
         ->where(function($query)use($lastdate){  
           $query->where('created_at' ,'>',$lastdate);
           $query->orWhere('updated_at','>=',$lastdate);
        })
        ->get();

        /*old notice*/
        $old = Notice::where(function($query){
           $query->where('published_date','<=',date('Y-m-d'));
        })
        
         ->where(function($query)use($lastdate){  
           $query->where('created_at' ,'<',$lastdate);
           $query->orWhere('updated_at','<',$lastdate);
        })
        ->get();

        foreach ($old as $key => $value) {
            $old_data[]=$value->id;
        }
       
        /*old notice*/

         return response([
          'status'=>'true',
          'data' => $data,
          'old_notice_ids' => $old_data
          
        ]);

      }
      else{

        return response([
          'status'=>'false',
          'data' => $data,
          'old_notice_ids' => $old_data
          
        ]);

      }


   }

   public function insert_roomdb_data(Request $request){
    $data = $request->data;

    if(Devices::where('mac_id',$request->mac_id)->exists()){

      $device_details = Devices::where('mac_id',$request->mac_id)->first(); 


      if(sizeof($data) > 0){
        foreach ($data as $key => $value) {
        $insert = DeviceData::create([
          'mac_id' => $request->mac_id ,
          'device_id' => $device_details->id,
          'apk_version' => $value['apk_version'] ,
          'last_updated_date' => $value['last_updated_date'] ,
          'last_updated_time' => $value['last_updated_time'] 
        ]);

        $l_data = $value['last_updated_date'];
        $l_time = $value['last_updated_time'] ;
        $version = $value['apk_version'] ;
      }

      $update = Devices::where('id',$device_details->id)->update(['last_updated_date' => $l_data." ".$l_time , 'apk_version' =>$version ]);

      }
     
      $current_apk_version = '1.1';
      $min_apk_version = '1.0';
      $new_apk_available = 'true';
      $mandatory_apk_update = 'false';

      if($request->apk_version < $min_apk_version){
        $apk_update_required = 'true';
        $message = 'Please update the app to latest version';
       
      }
      else if($request->apk_version < $current_apk_version &&  $request->apk_version >= $min_apk_version && $mandatory_apk_update == 'true'){
        $apk_update_required = 'true';
        $message = 'Please update the app to latest version';
       
      }
      else if($request->apk_version < $current_apk_version &&  $request->apk_version >= $min_apk_version &&  $mandatory_apk_update == 'false'){
        $apk_update_required = 'false';
          $message = 'New version available';
      }
      else{
        $apk_update_required = 'false';
          $message = 'You are using updated app version.';
      }

      return response([
        'status'=>'true',
        'update_required' => $apk_update_required ,
        'message'=> $message 
      ]);
     }
     else{
      
      return response([
        'status'=>'false',
        'update_required' => 'false' ,
        'message'=> 'Device not registered' 
        
      ]);

     }

   }

   public function save_non_idle_device_state(Request $request){
      
      if(isset($request->mac_id) && isset($request->elapsed_time)){
         if(Devices::where('mac_id',$request->mac_id)->exists()){
            
            $save = NonIdleDevice::create([
              'mac_id' => $request->mac_id ,
              'elapsed_time' => $request->elapsed_time,
              'temperature'=> $request->temperature,
              'app_version'=> $request->apk_version]);
           
            return response()->json([
              'status'=> 'true',
              'message' => 'Saved Successfully',
            ]);
         }
         else{
            return response()->json([
              'status'=> 'false',
              'message' => 'Device not registered',
            ]);

         }   

      }else{
       
        return response()->json([
          'status'=> 'false',
          'message' => 'Insufficient data',
        ]);
      }

   }

   public function get_branch_based_notices(Request $request){
      
      $device_id = $request->mac_id ;
      
      $data = array();
      $old_data = array();

      if(Devices::where('mac_id',$request->mac_id)->exists()){
       
        $lastdate = $request->lastupdatedate;

        $deviceData = Devices::where('mac_id',$request->mac_id)->first();
        $branchData = Branch::where('id',$deviceData->branch_id)->first();

        $region_id = $branchData->region_id;
        $state = $branchData->state;
        $branchid = $branchData->id;
        

        $data = Notice::where(function($query)use($lastdate){
                  $query->where('is_pan_india','Yes');
                  $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                   })  
                 ->orWhere(function($query)use($region_id,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                    
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
   
                ->get();

        $old = Notice::where(function($query)use($lastdate){
                  $query->where('is_pan_india','Yes');
                  $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                   })  
                 ->orWhere(function($query)use($region_id,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                    
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
   
                ->get();          

        foreach ($old as $key => $value) {
            $old_data[]=$value->id;
        }
       
        /*old notice*/

         return response([
          'status'=>'true',
          'data' => $data,
          'old_notice_ids' => $old_data
          
        ]);

      }
      else{

        return response([
          'status'=>'false',
          'data' => $data,
          'old_notice_ids' => $old_data
          
        ]);

      }


   }

   /*public function get_branch_based_notices_offline(Request $request){
      
      $device_id = $request->mac_id ;
      
      $data = array();
      $old_data = array();
      $supporting_files = array();

      if(Devices::where('mac_id',$request->mac_id)->exists()){
       
        $lastdate = $request->lastupdatedate;

        $deviceData = Devices::where('mac_id',$request->mac_id)->first();
        $branchData = Branch::where('id',$deviceData->branch_id)->first();

        $region_id = $branchData->region_id;
        $state = $branchData->state;
        $branchid = $branchData->id;

        $supporting_files[]=[
           url('/').'/noticefiles/Ujjivan_files/app.css',
           url('/').'/noticefiles/Ujjivan_files/app.js.download',
           url('/').'/noticefiles/Ujjivan_files/content-styles.css',
           url('/').'/noticefiles/Ujjivan_files/ckeditor.js.download',
           url('/').'/noticefiles/Ujjivan_files/mainLogo.svg',
           url('/').'/noticefiles/Ujjivan_files/style.css'
         ];
        

        $data = Notice::where(function($query)use($lastdate){
                  $query->where('is_pan_india','Yes');
                  $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                   })  
                 ->orWhere(function($query)use($region_id,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                    
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
   
                ->get();

        $old = Notice::where(function($query)use($lastdate){
                  $query->where('is_pan_india','Yes');
                  $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                   })  
                 ->orWhere(function($query)use($region_id,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                    
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
   
                ->get();          

        foreach ($old as $key => $value) {
            $old_data[]=$value->id;
        }
       
       

         return response([
          'status'=>'true',
          'data' => $data,
          'support' => $supporting_files,
          'old_notice_ids' => $old_data
          
        ]);

      }
      else{

        return response([
          'status'=>'false',
          'data' => $data,
          'support' => $supporting_files,
          'old_notice_ids' => $old_data
          
        ]);

      }


   }*/


   public function get_branch_based_notices_offline(Request $request){
      
      $device_id = $request->mac_id ;
      
      $data = array();
      $custom_notice = array();
      $old_data = array();
      $supporting_files = array();

      if(Devices::where('mac_id',$request->mac_id)->exists()){
       
        $lastdate = $request->lastupdatedate;

        $deviceData = Devices::where('mac_id',$request->mac_id)->first();
        $branchData = Branch::where('id',$deviceData->branch_id)->first();

        $region_id = $branchData->region_id;
        $state = $branchData->state;
        $branchid = $branchData->id;

        $supporting_files[]=[
           url('/').'/noticefiles/Ujjivan_files/app.css',
           url('/').'/noticefiles/Ujjivan_files/app.js.download',
           url('/').'/noticefiles/Ujjivan_files/content-styles.css',
           url('/').'/noticefiles/Ujjivan_files/ckeditor.js.download',
           url('/').'/noticefiles/Ujjivan_files/mainLogo.svg',
           url('/').'/noticefiles/Ujjivan_files/style.css'
         ];
        

        $data = Notice::where(function($query)use($lastdate){
                  $query->where('is_pan_india','Yes');
                  $query->where('template_id','!=','3');
                  $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                   })  
                 ->orWhere(function($query)use($region_id,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                    
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
   
                ->get();

        //custom

        $custom_notice = Notice::where(function($query)use($lastdate){
                  $query->where('is_pan_india','Yes');
                  $query->where('template_id','3');
                  $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                   })  
                 ->orWhere(function($query)use($region_id,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                    
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
   
                ->get(); 

                foreach ($custom_notice as $keys => $c_notice) {
                   $c_id = $c_notice->id;

                   $cust_data = NoticeContent::where('notice_id',$c_id)->first();
                   $n_data = $cust_data->cll;

                   $local_filename = 'en_'.$c_notice->filename;
                   $branchDetail = BranchInformation::where('branch_id',$branchid)->first();

                   //print_r($cust_data ); die();

                   if(!file_exists(public_path().'/custom_noticefiles')) {
                         File::makeDirectory(public_path().'/custom_noticefiles', $mode = 0777, true, true);
                     }


                   if (!file_exists(public_path().'/custom_noticefiles/'.$local_filename)) {
                     
                    File::put(public_path().'/custom_noticefiles/'.$local_filename,
                      view('htmltemplates.custom_ckofflinetemp')
                          ->with(['data' => $cust_data , 'version' => $c_notice->version , 'published' => $c_notice->published_date ,'branch_detail'=>$branchDetail  ])
                          ->render()
                    );

                    }
    

                }

        //old               

        $old = Notice::where(function($query)use($lastdate){
                  $query->where('is_pan_india','Yes');
                 // $query->where('template_id','!=','3');
                  $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                   })  
                 ->orWhere(function($query)use($region_id,$lastdate){
                    $query->where('is_pan_india','No');
                   // $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                    
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                   // $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    //$query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    //$query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
   
                ->get();          

        foreach ($old as $key => $value) {
            $old_data[]=$value->id;
        }
       
        /*old notice*/

         return response([
          'status'=>'true',
          'data' => $data,
          'custom_notice' => $custom_notice ,
          'support' => $supporting_files,
          'old_notice_ids' => $old_data
          
        ]);

      }
      else{

        return response([
          'status'=>'false',
          'data' => $data,
          'custom_notice' => $custom_notice ,
          'support' => $supporting_files,
          'old_notice_ids' => $old_data
          
        ]);

      }


   }

   public function get_branch_based_notices_offline_with_disclaimer(Request $request){
      
      $device_id = $request->mac_id ;
      
      $data = array();
      $custom_notice = array();
      $old_data = array();
      $supporting_files = array();
      $bank_info = '';

      if(Devices::where('mac_id',$request->mac_id)->exists()){
       
        $lastdate = $request->lastupdatedate;

        $deviceData = Devices::where('mac_id',$request->mac_id)->first();
        $branchData = Branch::where('id',$deviceData->branch_id)->first();

        $region_id = $branchData->region_id;
        $state = $branchData->state;
        $branchid = $branchData->id;

        $supporting_files[]=[
           url('/').'/noticefiles/Ujjivan_files/app.css',
           url('/').'/noticefiles/Ujjivan_files/app.js.download',
           url('/').'/noticefiles/Ujjivan_files/content-styles.css',
           url('/').'/noticefiles/Ujjivan_files/ckeditor.js.download',
           url('/').'/noticefiles/Ujjivan_files/mainLogo.svg',
           url('/').'/noticefiles/Ujjivan_files/style.css'
         ];
        

        $data = Notice::where(function($query)use($lastdate){
                  $query->where('is_pan_india','Yes');
                  $query->where('template_id','!=','3');
                  $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                   })  
                 ->orWhere(function($query)use($region_id,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                    
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
   
                ->get();

        //custom

        $custom_notice = Notice::where(function($query)use($lastdate){
                  $query->where('is_pan_india','Yes');
                  $query->where('template_id','3');
                  $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                   })  
                 ->orWhere(function($query)use($region_id,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                    
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    $query->where('template_id','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'>',$lastdate);
                     $query2->orWhere('updated_at','>=',$lastdate);
                  });
                 })
   
                ->get(); 

                foreach ($custom_notice as $keys => $c_notice) {
                   $c_id = $c_notice->id;

                   $cust_data = NoticeContent::where('notice_id',$c_id)->first();
                   $n_data = $cust_data->cll;

                   $local_filename = 'en_'.$c_notice->filename;
                   $branchDetail = BranchInformation::where('branch_id',$branchid)->first();

                   //print_r($cust_data ); die();

                   if(!file_exists(public_path().'/custom_noticefiles')) {
                         File::makeDirectory(public_path().'/custom_noticefiles', $mode = 0777, true, true);
                     }


                   if (!file_exists(public_path().'/custom_noticefiles/'.$local_filename)) {
                     
                    File::put(public_path().'/custom_noticefiles/'.$local_filename,
                      view('htmltemplates.custom_ckofflinetemp')
                          ->with(['data' => $cust_data , 'version' => $c_notice->version , 'published' => $c_notice->published_date ,'branch_detail'=>$branchDetail  ])
                          ->render()
                    );

                    }
    

                }

        //old               

        $old = Notice::where(function($query)use($lastdate){
                  $query->where('is_pan_india','Yes');
                 // $query->where('template_id','!=','3');
                  $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                   })  
                 ->orWhere(function($query)use($region_id,$lastdate){
                    $query->where('is_pan_india','No');
                   // $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->where('branch_code','all');
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                    
                 })
                  ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                   // $query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->where('states','all');
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    //$query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->whereRaw("FIND_IN_SET(?, branch_code) > 0", [$branchid]);
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
                   ->orWhere(function($query)use($region_id,$state,$branchid,$lastdate){
                    $query->where('is_pan_india','No');
                    //$query->where('template_id','!=','3');
                    $query->whereRaw("FIND_IN_SET(?, regions) > 0", [$region_id]);
                    $query->whereRaw("FIND_IN_SET(?, states) > 0", [$state]);
                    $query->where('branch_code','all'); 
                    $query->where(function($query2)use($lastdate){  
                     $query2->where('created_at' ,'<',$lastdate);
                     $query2->orWhere('updated_at','<',$lastdate);
                  });
                 })
   
                ->get();          

        foreach ($old as $key => $value) {
            $old_data[]=$value->id;
        }

        if(Branch::where('id',$branchData->id)->where('updated_at','>=',$lastdate)->exists() || BranchInformation::where('branch_id',$branchData->id)->where('updated_at','>=',$lastdate)->exists()){
          $branchInfo = BranchInformation::where('branch_id',$branchData->id)->first();
          $disclaimer1 = 'Branch Name : '.$branchData->name.'  |  Branch Code : '.$branchData->branch_code.'  |  Manager Name : '.$branchInfo->bm_name.'  |  Manager Contact : '.$branchInfo->bm_number;

          $disclaimer2 = $branchInfo->disclaimer2 ;


          $bank_info = ['disclaimer_top' => $disclaimer1 , 'disclaimer_bottom' => $disclaimer2 ,'display_poster' => $branchInfo->announcement , 'start_time' => date('Y-m-d H:i:s',strtotime($branchInfo->start_time)) , 'end_time' => date('Y-m-d H:i:s',strtotime($branchInfo->end_time)) , 'filename' => ($branchInfo->filename != '')?url('/').'/announcement'.$branchInfo->filename:''];
        }

       
        /*old notice*/

         return response([
          'status'=>'true',
          'data' => $data,
          'custom_notice' => $custom_notice ,
          'support' => $supporting_files,
          'old_notice_ids' => $old_data,
          'bank_info' => $bank_info,
          
        ]);

      }
      else{

        return response([
          'status'=>'false',
          'data' => $data,
          'custom_notice' => $custom_notice ,
          'support' => $supporting_files,
          'old_notice_ids' => $old_data,
          'bank_info' => $bank_info,
          
        ]);

      }


   }

}
