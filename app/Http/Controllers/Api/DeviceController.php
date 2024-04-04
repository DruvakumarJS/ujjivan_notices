<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceData;
use App\Models\Devices;
use App\Models\Notice;
use App\Models\Language;

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

}
