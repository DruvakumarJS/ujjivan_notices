<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceData;
use App\Models\Devices;
use App\Models\Notice;

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

   public function get_notices(Request $request){
      
      $device_id = $request->mac_id ;
      $data = array();

      if(Devices::where('mac_id',$request->mac_id)->exists()){



        $notices = Notice::get();

        foreach ($notices as $key => $value) {

          $voice = $value->voiceover ;

          if($voice == 'Y'){$voicover="YES";}
          else {$voicover="No";}
          
          $data[]=[
          'name' => $value->name ,
          'description' => $value->description ,
          'path' => url('/').'/' ,
          'filename' => $value->filename,
          'available_languages' => $value->available_languages,
          'voiceover' => $voicover 
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
            'message' => 'Device data exists',
            'mac_id' => $data->mac_id]);
      }
      else{

          return response()->json([
            'status' => 'false',
            'message' => 'Device data exists',
            'mac_id' => '0']);

      }
   }
}
