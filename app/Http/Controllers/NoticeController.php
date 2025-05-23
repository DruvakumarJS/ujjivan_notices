<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Template;
use App\Models\NoticeContent;
use App\Models\Language;
use App\Models\Audit;
use App\Exports\ExportNotice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoticeHistory;
use App\Models\NoticeContentHistory;

use Auth;
use File;
use Excel;
use Schema;
use App\Rules\NoScriptInjection;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    
     // print_r($request->lang); die();
       $lang = $request->lang;
       if($lang == 'all'){
       /* $region_id = '8';
        $state = 'Karnataka';
        $branchid = '6';
        ;
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
                   ->paginate(25);*/

        $data = Notice::orderBy('id','DESC')->paginate(25);            
       }
       else{
        $data = Notice::where('lang_code',$request->lang)->orderBy('id','DESC')->paginate(25);
        
       }
       
       $search = '';
       
       $languages = Language::get();
       $branches = Branch::get();
     
        
       return view('notice/list', compact('data','search','languages','lang', 'branches'));
    }

     public function templates(){
      $data = Template::get();

     // print_r(json_encode($data)); die();
        return view('notice/template',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function selct_template($lang){
        $data = Template::get();
        $languages = Language::get();
        return view('notice/choose_template',compact('data','languages','lang'));
     }

     public function set_template(Request $request){
       print_r($request->input()); die();
     }

      public function select_language($lang,$id){
      //print_r($id); die();
      $notice = Notice::where('id', $id)->first();
      $lang_array = explode(',', $notice->available_languages);
      $template_id = $notice->template_id;
      $notice_type = $notice->notice_type;
      $data = Template::get();

     
      $languages = Language::whereNotIn('code',$lang_array)->get();
      //print_r(json_encode($languages) ); die();

      return view('notice/choose_language',compact('data','languages','template_id','notice_type','id','lang'));

     }

    public function create(Request $request)
    {
      //print_r($request->Input()); die();
      $notice_type = $request->notice_type ;

      if($notice_type == 'ujjivan'){

      if(isset($request->noticeid)){
        $notice = Notice::where('id', $request->noticeid)->first();
        $langarray=$request->lang ;
        $selected_lang_code = implode(',', $langarray);
      //  print_r($langarray); die();
        $template_id = $request->template_id;
        $regions = Region::all();
        $branch = Branch::select('state')->groupBy('state')->get();
        $template = Template::select('details')->where('id',$template_id)->first();
        $languages = Language::get();
        $selected_languages = Language::whereIn('code',$request->lang)->get();
        $group_id = $notice->notice_group;
       // print_r($lang); die();
        
        $data = $template->details ;

        $arr = json_decode($data);
        $notice_id = $request->noticeid;
        $dropdown_lang =$request->dropdown_lang; 


        return view('notice/ckeditor/add_multilingual_notice',compact('regions','branch','template','arr','template_id','languages','selected_languages','selected_lang_code','notice_type' , 'group_id', 'notice_id','notice','dropdown_lang'));

      } 
      else{
        $langarray=$request->lang ;
        $selected_lang_code = implode(',', $langarray);
      //  print_r($langarray); die();
        $template_id = $request->template_id;
        $regions = Region::all();
        $branch = Branch::select('state')->groupBy('state')->get();
        $template = Template::select('details')->where('id',$template_id)->first();
        $languages = Language::get();
        $selected_languages = Language::whereIn('code',$request->lang)->get();
       
       // print_r($lang); die();
        
        $data = $template->details ;

        $arr = json_decode($data);
        $dropdown_lang =$request->dropdown_lang; 

        return view('notice/ckeditor/create_multilingual_notice',compact('regions','branch','template','arr','template_id','languages','selected_languages','selected_lang_code','notice_type','dropdown_lang'));

      } 
      
      }
      else if($notice_type == 'custom_ujjivan'){
       
        if(isset($request->noticeid)){
        $notice = Notice::where('id', $request->noticeid)->first();
        $langarray=$request->lang ;
        $selected_lang_code = implode(',', $langarray);
     
        $regions = Region::all();
        $branch = Branch::select('state')->groupBy('state')->get();
       // $template = Template::select('details')->where('id',$template_id)->first();
        $languages = Language::get();
        $selected_languages = Language::whereIn('code',$request->lang)->get();
       
        $dropdown_lang =$request->dropdown_lang; 

        $custNoticeDetails = NoticeContent::where('notice_group' , $notice->notice_group)->first();


         $info_cols = Schema::getColumnListing('emergency_contact_details');
         $excludedColumns = ['id','lang_code','created_at', 'updated_at'];
         $filteredColumns = array_diff($info_cols, $excludedColumns);
         $readableNames = [
            'branch_id' => 'Branch ID',
            'police' => 'Police Station addres',
            'police_contact' => 'Police Station Contact Number',
            'medical' => 'Emergency Medical Support',
            'medical_contact' => 'Medical Support Contact',
            'ambulance' => 'Ambulance',
            'ambulance_contact' => 'Ambulance Contact Number',
            'fire' => 'Fire Station',
            'fire_contact' => 'Fire Station Contact',
            'manager' => 'Branch managerer Name',
            'manager_contact' => 'Branch Manager Number',
            'rno' => 'RNO',
            'rno_contact' => 'RNO Contact',
            'pno' => 'PNO',
            'pno_contact' => 'PNO Contact',
            'contact_center' => 'Contact Center',
            'contact_center_number' => 'Contact Center Number',
            'cyber_dost' => 'Cyber Dost',
            'cyber_dost_number' => 'Cyber Dost Number',

            // Add all your columns here
        ];


        $info_columns = [];
        foreach ($filteredColumns as $column) {
          if (isset($readableNames[$column])) {
              $info_columns[$column] = $readableNames[$column];
          } else {
              $info_columns[$column] = $column; // Use the original name if no readable name is found
          }
         }
        
         return view('notice/ckeditor/add_custom_notice',compact('notice','regions','branch','languages','selected_languages','selected_lang_code','notice_type' ,'dropdown_lang','info_columns','custNoticeDetails'));
         }

        
        else{
        $langarray=$request->lang ;
        $selected_lang_code = implode(',', $langarray);
     
        $regions = Region::all();
        $branch = Branch::select('state')->groupBy('state')->get();
       // $template = Template::select('details')->where('id',$template_id)->first();
        $languages = Language::get();
        $selected_languages = Language::whereIn('code',$request->lang)->get();
       
        $dropdown_lang =$request->dropdown_lang; 


         $info_cols = Schema::getColumnListing('emergency_contact_details');
         $excludedColumns = ['id','lang_code','created_at', 'updated_at'];
         $filteredColumns = array_diff($info_cols, $excludedColumns);
         $readableNames = [
            'branch_id' => 'Branch ID',
            'police' => 'Police Station addres',
            'police_contact' => 'Police Station Contact Number',
            'medical' => 'Emergency Medical Support',
            'medical_contact' => 'Medical Support Contact',
            'ambulance' => 'Ambulance',
            'ambulance_contact' => 'Ambulance Contact Number',
            'fire' => 'Fire Station',
            'fire_contact' => 'Fire Station Contact',
            'manager' => 'Branch managerer Name',
            'manager_contact' => 'Branch Manager Number',
            'rno' => 'RNO',
            'rno_contact' => 'RNO Contact',
            'pno' => 'PNO',
            'pno_contact' => 'PNO Contact',
            'contact_center' => 'Contact Center',
            'contact_center_number' => 'Contact Center Number',
            'cyber_dost' => 'Cyber Dost',
            'cyber_dost_number' => 'Cyber Dost Number',

            // Add all your columns here
        ];


        $info_columns = [];
        foreach ($filteredColumns as $column) {
          if (isset($readableNames[$column])) {
              $info_columns[$column] = $readableNames[$column];
          } else {
              $info_columns[$column] = $column; // Use the original name if no readable name is found
          }
         }
        
         return view('notice/ckeditor/custom_notice',compact('regions','branch','languages','selected_languages','selected_lang_code','notice_type' ,'dropdown_lang','info_columns'));
        }
       }

       else if($notice_type == 'custom_ujjivan_n9'){
       //print_r("kkk"); die();
       if(isset($request->noticeid)){
        $notice = Notice::where('id', $request->noticeid)->first();
        $langarray=$request->lang ;
        $selected_lang_code = implode(',', $langarray);
     
        $regions = Region::all();
        $branch = Branch::select('state')->groupBy('state')->get();
       // $template = Template::select('details')->where('id',$template_id)->first();
        $languages = Language::get();
        $selected_languages = Language::whereIn('code',$request->lang)->get();
       
        $dropdown_lang =$request->dropdown_lang; 

        $custNoticeDetails = NoticeContent::where('notice_group' , $notice->notice_group)->first();


         $info_cols = Schema::getColumnListing('banking_ombudsments');
         $excludedColumns = ['id','lang_code','created_at', 'updated_at'];
         $filteredColumns = array_diff($info_cols, $excludedColumns);
         $readableNames = [
            'state' => 'STATE',
            'banking_ombudsment' => 'BANKING OMBUDSMAN LABLE',
            'banking_ombudsment_name' => 'NAME OF THE BANKING OMBUDSMAN',
            'center' => 'CENTER LABLE',
            'center_name' => 'NAME OF THE CENTER',
            'area' => 'AREA LABLE',
            'area_name' => 'NAME OF THE AREA',
            'address' => 'ADDRESS LABLE',
            'full_address' => 'COMPLETE ADDRESS',
            'tel' => 'TELEPHONE LABLE',
            'tel_number' => 'TELEPHONE NUMBER',
            'fax' => 'FAX LABLE',
            'fax_number' => 'FAX NUMBER',
            'email' => 'E-MAIL LABLE',
            'email_id' => 'E-MAIL ADDRESS',
            'toll_free' => 'TOLL-FREE LABLE',
            'toll_free_number' => 'TOLL-FREE NUMBER',
            
            // Add all your columns here
        ];


        $info_columns = [];
        foreach ($filteredColumns as $column) {
          if (isset($readableNames[$column])) {
              $info_columns[$column] = $readableNames[$column];
          } else {
              $info_columns[$column] = $column; // Use the original name if no readable name is found
          }
         }
        
         return view('notice/ckeditor/add_custom_notice',compact('notice','regions','branch','languages','selected_languages','selected_lang_code','notice_type' ,'dropdown_lang','info_columns','custNoticeDetails'));
         }

        
        else{
        $langarray=$request->lang ;
        $selected_lang_code = implode(',', $langarray);
     
        $regions = Region::all();
        $branch = Branch::select('state')->groupBy('state')->get();
       // $template = Template::select('details')->where('id',$template_id)->first();
        $languages = Language::get();
        $selected_languages = Language::whereIn('code',$request->lang)->get();
       
        $dropdown_lang =$request->dropdown_lang; 


         $info_cols = Schema::getColumnListing('banking_ombudsments');
         $excludedColumns = ['id','lang_code','created_at', 'updated_at'];
         $filteredColumns = array_diff($info_cols, $excludedColumns);
         $readableNames = [
            'state' => 'STATE',
            'banking_ombudsment' => 'BANKING OMBUDSMAN LABLE',
            'banking_ombudsment_name' => 'NAME OF THE BANKING OMBUDSMAN',
            'center' => 'CENTER LABLE',
            'center_name' => 'NAME OF THE CENTER',
            'area' => 'AREA LABLE',
            'area_name' => 'NAME OF THE AREA',
            'address' => 'ADDRESS LABLE',
            'full_address' => 'COMPLETE ADDRESS',
            'tel' => 'TELEPHONE LABLE',
            'tel_number' => 'TELEPHONE NUMBER',
            'fax' => 'FAX LABLE',
            'fax_number' => 'FAX NUMBER',
            'email' => 'E-MAIL LABLE',
            'email_id' => 'E-MAIL ADDRESS',
            'toll_free' => 'TOLL-FREE LABLE',
            'toll_free_number' => 'TOLL-FREE NUMBER',
            
            // Add all your columns here
        ];


        $info_columns = [];
        foreach ($filteredColumns as $column) {
          if (isset($readableNames[$column])) {
              $info_columns[$column] = $readableNames[$column];
          } else {
              $info_columns[$column] = $column; // Use the original name if no readable name is found
          }
         }
        
         return view('notice/ckeditor/custom_notice_n9',compact('regions','branch','languages','selected_languages','selected_lang_code','notice_type' ,'dropdown_lang','info_columns'));
        }
       }

    
      else{
       // print_r($request->Input()); die();
        if(isset($request->noticeid)){
          $notice = Notice::where('id', $request->noticeid)->first();
          $langarray=$request->lang ;
          $selected_lang_code = implode(',', $langarray);
         
          $regions = Region::all();
          $branch = Branch::select('state')->groupBy('state')->get();
          $languages = Language::get();
          $selected_languages = Language::whereIn('code',$request->lang)->get();

          $dropdown_lang =$request->dropdown_lang; 

          return view('notice/ckeditor/add_multilingual_rbi_notice',compact('regions','branch','languages','selected_languages','selected_lang_code','notice_type' ,'notice','dropdown_lang'));
        }
        else{
          $langarray=$request->lang ;
          $selected_lang_code = implode(',', $langarray);
         
          $regions = Region::all();
          $branch = Branch::select('state')->groupBy('state')->get();
          $languages = Language::get();
          $selected_languages = Language::whereIn('code',$request->lang)->get();

          $dropdown_lang =$request->dropdown_lang; 

          return view('notice/ckeditor/create_multilingual_rbi_notice',compact('regions','branch','languages','selected_languages','selected_lang_code','notice_type', 'dropdown_lang'));

        }

      

      }
      
     }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     // print_r(json_encode($request->Input()) );die();
      
      // print_r(json_encode($request->selected_languages) );

     
       $validator = Validator::make($request->all(), [

        'document_id' => [
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
           'version' => [
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

          'publish_date' => [
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

        'notice.*.tittle' => [
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

          'notice.*.description' => [
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


          'notice.*.row1_1' => [
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
          'notice.*.row2_1' => [
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
          'notice.*.row3_1' => [
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
         //  print_r("lll"); die();
          return redirect()->back()->withErrors($validator)->withInput();
      }

       
       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';

       $reion_names = '';
       $br_code = '';
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
           $branchcodes = '';
       }
        if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);

           foreach ($request->regions as $key => $value) {
             $re = Region::where('id',$value)->first();
             $rearray[]=$re->name;
           }
           $reion_names = implode(',', $rearray);


       }
       if(isset($request->states)){
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }
       if(isset($request->branches)){
         
           $branchcodes = implode(',' , $request->branches);
         
           if(!in_array('all', $request->branches)){

             foreach ($request->branches as $key => $value2) {
               $br = Branch::where('id',$value2)->first();
               $brarray[]=$br->branch_code;
              }
              $br_code = implode(',', $brarray);

           }
           else{
            $br_code = implode(',', $request->branches);
           }

          
       }

       $group_id = rand('000000','999999');

       $current = date('Y-m-d_H_i_s');
       $c_time = $request->template_id.'_'.$current.'.html';
       $filename = 'notice'.$c_time;

       foreach($request->notice as $key=>$value) {
       
        
        $langaugedata = Language::where('code',$value['langauge'])->first();

         $notice = new Notice;
         $notice->name = $value['tittle'] ;
         $notice->description = $value['description'] ;
         $notice->path = 'noticefiles';
         $notice->filename = $filename;
         $notice->is_pan_india = $request->is_pan_india ;
         $notice->is_region_wise = $region_prompt ;
         $notice->regions = $region_list ;
         $notice->is_state_wise = $state_prompt ;
         $notice->states =  $state_list;
         $notice->branch_code = $branchcodes ;
         $notice->status = 'Draft';
         $notice->available_languages =$request->selected_lang_code ;
         $notice->template_id = $request->template_id;
         $notice->creator = Auth::user()->id ;
         $notice->voiceover = $request->voice_over;
         $notice->lang_code = $langaugedata->code;
         $notice->lang_name = $langaugedata->name;
         $notice->notice_group = $group_id;
         $notice->notice_type = 'ujjivan';
         $notice->document_id = $request->document_id;
         $notice->published_date = $request->publish_date;
         $notice->version = $request->version;
         $notice->expiry_date = '2024-12-12';


         $notice->save();

         $noticeID = $notice->id;


         if($noticeID != 0 AND $noticeID!=''){
         $content = new NoticeContent;
         $content->notice_id = $noticeID ;
         $content->template_id = $request->template_id;
         $content->lang_code = $langaugedata->code;
         $content->lang_name = $langaugedata->name;
         $content->notice_group = $group_id;

         if(isset($value['row1_1']))$content->c11 = $value['row1_1'];
         if(isset($value['row1_2']))$content->c12 = $value['row1_2'];
         if(isset($value['row1_3']))$content->c13 = $value['row1_3'];
         if(isset($value['row1_4']))$content->c14 = $value['row1_4'];

         if(isset($value['row2_1']))$content->c21 = $value['row2_1'];
         if(isset($value['row2_2']))$content->c22 = $value['row2_2'];
         if(isset($value['row2_3']))$content->c23 = $value['row2_3'];
         if(isset($value['row2_4']))$content->c24 = $value['row2_4'];
        
         if(isset($value['row3_1']))$content->c31 = $value['row3_1'];
         if(isset($value['row3_2']))$content->c32 = $value['row3_2'];
         if(isset($value['row3_3']))$content->c33 = $value['row3_3'];
         if(isset($value['row3_4']))$content->c34 = $value['row3_4'];

         if(isset($value['row4_1']))$content->c41 = $value['row4_1'];
         if(isset($value['row4_2']))$content->c42 = $value['row4_2'];
         if(isset($value['row4_3']))$content->c43 = $value['row4_3'];
         if(isset($value['row4_4']))$content->c44 = $value['row4_4'];

         if(isset($value['row5_1']))$content->c51 = $value['row5_1'];
         if(isset($value['row5_2']))$content->c52 = $value['row5_2'];
         if(isset($value['row5_3']))$content->c53 = $value['row5_3'];
         if(isset($value['row5_4']))$content->c54 = $value['row5_4'];

         if(isset($value['row6_1']))$content->c61 = $value['row6_1'];
         if(isset($value['row6_2']))$content->c62 = $value['row6_2'];
         if(isset($value['row6_3']))$content->c63 = $value['row6_3'];
         if(isset($value['row6_4']))$content->c64 = $value['row6_4'];
         
         $content->save();
         $noticeContentID = $content->id;

       
        $template = Template::select('details')->where('id',$request->template_id)->first();

       
        $content = NoticeContent::where('template_id',$request->template_id)->where('notice_id',$noticeID)->first();

        $langArray[] = $langaugedata->lang;

        $data2 = $template->details ;
 
        $arr = json_decode($data2);

        if (file_exists(public_path().'/noticefiles')) {
              
        } else {
           
            File::makeDirectory(public_path().'/noticefiles', $mode = 0777, true, true);
        }

        $local_filename = $value['langauge'].'_notice'.$c_time;
        $version = $request->version;
        $published = $request->publish_date;
         $qrcode_data = url('/').'/noticefiles/'.$local_filename;
         $name = $value['tittle'];

         $noticecontent = 
         File::put(public_path().'/noticefiles/'.$local_filename,
            view('htmltemplates.ckofflinetemp')
                ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'lang_code' => $langaugedata->code , 'name' => $name])
                ->render()
        );

       /* File::put(public_path().'/noticefilesOffline/'.$local_filename,
            view('htmltemplates.ckofflinetemp')
                ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'lang_code' => $langaugedata->code , 'name' => $name])
                ->render()
        );*/

         File::put(public_path().'/noticefilesforweb/'.$local_filename,
            view('htmltemplates.cktempforweb')
                ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'lang_code' => $langaugedata->code , 'name' => $name])
                ->render()
        );

          /*$audit = Audit::create([
            'action' => 'New Ujjivan notice created in '.$langaugedata->lang,
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'C'
          ]);*/
             

       }

        
       }

      // die();
       $audit = Audit::create([
            'action' => 'New Ujjivan notice(s) created in '.implode(',',$langArray),
            'pan_india' => $request->is_pan_india,
            'regions' => $reion_names,
            'states' => $state_list,
            'branch' => $br_code,
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'C'
          ]);


       return redirect()->route('notices',$request->dropdown_lang);
    }

    public function add_notices(Request $request){
      // print_r($request->Input()); die();
       $validator = Validator::make($request->all(), [

        'document_id' => [
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
           'version' => [
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

           'publish_date' => [
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

        'notice.*.tittle' => [
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

          'notice.*.description' => [
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


          'notice.*.row1_1' => [
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
          'notice.*.row2_1' => [
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
          'notice.*.row3_1' => [
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


       $noticedetails = Notice::where('id', $request->notice_id)->first();
       $langs = $noticedetails->available_languages;
       $new_langs = $request->selected_lang_code;

     //  print_r($langs.','.$new_langs); die();

       foreach($request->notice as $key=>$value) {
       
        
        $langaugedata = Language::where('code',$value['langauge'])->first();

         $notice = new Notice;
         $notice->name = $value['tittle'] ;
         $notice->description = $value['description'] ;
         $notice->path = 'noticefiles';
         $notice->filename = $noticedetails->filename;
         $notice->is_pan_india = $noticedetails->is_pan_india ;
         $notice->is_region_wise = $noticedetails->is_region_wise ;
         $notice->regions = $noticedetails->regions;
         $notice->is_state_wise = $noticedetails->is_state_wise;
         $notice->states = $noticedetails->states;
         $notice->branch_code = $noticedetails->branch_code ;
         $notice->status = 'Draft';
         $notice->available_languages = $langs.','.$new_langs ;
         $notice->template_id = $noticedetails->template_id;
         $notice->creator = Auth::user()->id ;
         $notice->voiceover = $request->voice_over;
         $notice->lang_code = $langaugedata->code;
         $notice->lang_name = $langaugedata->name;
         $notice->notice_group = $noticedetails->notice_group;
         $notice->notice_type = 'ujjivan';
         $notice->document_id = $noticedetails->document_id;
         $notice->published_date = $request->publish_date;
         $notice->version = $request->version;
         $notice->expiry_date = '2024-12-12';



         $notice->save();

         $noticeID = $notice->id;

         
         if($noticeID != 0 AND $noticeID!=''){
         $content = new NoticeContent;
         $content->notice_id = $noticeID ;
         $content->template_id = $request->template_id;
         $content->lang_code = $langaugedata->code;
         $content->lang_name = $langaugedata->name;
         $content->notice_group = $noticedetails->notice_group;

         if(isset($value['row1_1']))$content->c11 = $value['row1_1'];
         if(isset($value['row1_2']))$content->c12 = $value['row1_2'];
         if(isset($value['row1_3']))$content->c13 = $value['row1_3'];
         if(isset($value['row1_4']))$content->c14 = $value['row1_4'];

         if(isset($value['row2_1']))$content->c21 = $value['row2_1'];
         if(isset($value['row2_2']))$content->c22 = $value['row2_2'];
         if(isset($value['row2_3']))$content->c23 = $value['row2_3'];
         if(isset($value['row2_4']))$content->c24 = $value['row2_4'];
        
         if(isset($value['row3_1']))$content->c31 = $value['row3_1'];
         if(isset($value['row3_2']))$content->c32 = $value['row3_2'];
         if(isset($value['row3_3']))$content->c33 = $value['row3_3'];
         if(isset($value['row3_4']))$content->c34 = $value['row3_4'];

         if(isset($value['row4_1']))$content->c41 = $value['row4_1'];
         if(isset($value['row4_2']))$content->c42 = $value['row4_2'];
         if(isset($value['row4_3']))$content->c43 = $value['row4_3'];
         if(isset($value['row4_4']))$content->c44 = $value['row4_4'];

         if(isset($value['row5_1']))$content->c51 = $value['row5_1'];
         if(isset($value['row5_2']))$content->c52 = $value['row5_2'];
         if(isset($value['row5_3']))$content->c53 = $value['row5_3'];
         if(isset($value['row5_4']))$content->c54 = $value['row5_4'];

         if(isset($value['row6_1']))$content->c61 = $value['row6_1'];
         if(isset($value['row6_2']))$content->c62 = $value['row6_2'];
         if(isset($value['row6_3']))$content->c63 = $value['row6_3'];
         if(isset($value['row6_4']))$content->c64 = $value['row6_4'];
         
         $content->save();
         $noticeContentID = $content->id;

       
        $template = Template::select('details')->where('id',$request->template_id)->first();

       
        $content = NoticeContent::where('template_id',$request->template_id)->where('notice_id',$noticeID)->first();

        $langArray[] = $langaugedata->lang;

        $data2 = $template->details ;
 
        $arr = json_decode($data2);

        if (file_exists(public_path().'/noticefiles')) {
              
        } else {
           
            File::makeDirectory(public_path().'/noticefiles', $mode = 0777, true, true);
        }

        $local_filename = $value['langauge']."_".$noticedetails->filename;
        $version = $request->version;
        $published = $request->publish_date;
         $qrcode_data = url('/').'/noticefiles/'.$local_filename;

         $noticecontent = 
         File::put(public_path().'/noticefiles/'.$local_filename,
            view('htmltemplates.ckofflinetemp')
                ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'lang_code' => $langaugedata->code ])
                ->render()
        );

        File::put(public_path().'/noticefilesforweb/'.$local_filename,
            view('htmltemplates.cktempforweb')
                ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'lang_code' => $langaugedata->code ])
                ->render()
        ); 

       }
     }


     $update = Notice::where('notice_group',$noticedetails->notice_group)->update(['available_languages'=> $langs.','.$new_langs]);

     $audit = Audit::create([
            'action' => 'New Ujjivan notices added in '.implode(',', $langArray),
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'A'
      ]);

      return redirect()->route('notices',$request->dropdown_lang);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Notice::where('id',$id)->first();

         $template = Template::select('details')->where('id',$data->template_id)->first();

       // print_r($data->template_id); die();
        $content = NoticeContent::where('template_id',$data->template_id)->where('notice_id',$data->id)->first();

        //print_r(json_encode($content)); die();
        $data2 = $template->details ;
 
        $arr = json_decode($data2);

       // return view('notice/view_more',compact('data','id','template' ,'content','arr'));
        return view('notice/ckeditor/view_more',compact('data','id','template' ,'content','arr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Notice::where('id',$id)->first();
         $regions = Region::all();

        $template = Template::select('details')->where('id',$data->template_id)->first();

       // print_r($data->template_id); die();
        $content = NoticeContent::where('template_id',$data->template_id)->where('notice_id',$data->id)->first();

        //print_r(json_encode($content)); die();
        $data2 = $template->details ;
 
        $arr = json_decode($data2);

        //return view('notice/edit',compact('data','id','template','arr' ,'content'));
        return view('notice/ckeditor/edit',compact('data','id','template','arr' ,'content','regions'));
    }

    public function edit_multilingual($id,$lang){
 
      $notice = Notice::where('notice_group' , $id)->first();
      $langarray=$notice->available_languages ;
      $selected_lang_code = explode(',', $langarray);
    //  print_r($langarray); die();
      $template_id = $notice->template_id;
      $regions = Region::all();
      $branch = Branch::select('state')->groupBy('state')->get();

      $data = Notice::where('notice_group',$id)->first();
      $template = Template::select('details')->where('id',$data->template_id)->first();

      $languages = Language::get();
      $selected_languages = Language::whereIn('code',$selected_lang_code)->get();

      $data2 = $template->details ;
      $arr = json_decode($data2);
      //$content = NoticeContent::where('template_id',$data->template_id)->where('notice_group',$id)->get();
     // $content = Notice::with('noticeContent')->where('notice_group',$id)->get();
      $noticeDetails = array();
      $multinotice = Notice::where('notice_group' , $id)->get();
      foreach ($multinotice as $key => $value) {
          $noticename = $value->name;
          $noticedesc = $value->description;
          $notice_content = NoticeContent::where('notice_group',$value->notice_group)->where('lang_code',$value->lang_code)->first();
          $eng_lang = Language::where('code',$value->lang_code)->first();

          $noticeDetails[]=['name' => $noticename , 'desc' =>$noticedesc ,'language' =>$eng_lang->lang.' - '.$value->lang_name , 'notice_content' => $notice_content ];

      }

     // print_r(json_encode($noticeDetails)); die();

   
      return view('notice/ckeditor/edit_multilingual',compact('regions','branch','data','id','template','arr' ,'noticeDetails','languages','selected_languages','langarray','lang'));

    }

    public function update_multilang_notice(Request $request){
     // print_r($request->Input() ) ;die();
      $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';

       $reion_names = '';
       $br_code = '';
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
           $branchcodes = '';
       }
        if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);

           foreach ($request->regions as $key => $value) {
             $re = Region::where('id',$value)->first();
             $rearray[]=$re->name;
           }
           $reion_names = implode(',', $rearray);


       }
       if(isset($request->states)){
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }
       if(isset($request->branches)){
         
           $branchcodes = implode(',' , $request->branches);

           if(!in_array('all', $request->branches)){

             foreach ($request->branches as $key => $value2) {
               $br = Branch::where('id',$value2)->first();
               $brarray[]=$br->branch_code;
              }
              $br_code = implode(',', $brarray);

           }
           else{
            $br_code = implode(',', $request->branches);
           }
       }

      /*$current = date('Y-m-d_H_i_s');
      $filename = 'notice'.$request->template_id.'_'.$current.'.html';*/

      /* $request->validate([
            'voice_over' => ['required', new NoScriptInjection],
            'document_id' => ['required', new NoScriptInjection],
            'version' => ['required', new NoScriptInjection],
            'notice.*.tittle' => ['required', new NoScriptInjection],
            'notice.*.description' => ['required', new NoScriptInjection],
            
            
        ]);*/

      $validator = Validator::make($request->all(), [

        'document_id' => [
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
           'version' => [
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

           'publish_date' => [
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

        'notice.*.tittle' => [
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

          'notice.*.description' => [
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


          'notice.*.row1_1' => [
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
          'notice.*.row2_1' => [
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
          'notice.*.row3_1' => [
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

     

    $notice = Notice::where('notice_group',$request->notice_group)->first();



    $existingNoticeRows = Notice::where('notice_group', $request->notice_group)->get();

    if ($existingNoticeRows->isNotEmpty()) {
        // Generate a new group ID or reference if needed
        $newNoticeGroup =  rand('000000','999999'); // or any logic you prefer

        foreach ($existingNoticeRows as $existingNoticeRow) {
            // Generate a new notice_id (can use UUID or auto-increment logic if needed)
            $newNoticeId = rand('000000','999999');
     // or just leave it and use DB's auto-increment if 'id' is auto

            // Prepare data for NoticeHistory
            $noticeData = $existingNoticeRow->toArray();
            unset($noticeData['id']); // remove old ID so it doesn't conflict
            $noticeData['notice_group'] = $newNoticeGroup; // assign new group
           // $noticeData['original_notice_id'] = $noticeData['id'] ?? null; // optional tracking
            //$noticeData['notice_id'] = $newNoticeId; // if custom, else omit this

            // Save new NoticeHistory
            //$noticeHistory = NoticeHistory::create($noticeData);
            $noticeHistory = new NoticeHistory($noticeData);

            $noticeHistory->created_at = $existingNoticeRow->created_at;
            $noticeHistory->save();

            // Get corresponding NoticeContent rows
            $existingNoticeContentRows = NoticeContent::where('notice_id', $existingNoticeRow->id)->get();

            foreach ($existingNoticeContentRows as $existingNoticeContentRow) {
                $contentData = $existingNoticeContentRow->toArray();
                unset($contentData['id']); // remove old ID
                $contentData['notice_group'] = $newNoticeGroup;
                $contentData['notice_id'] = $noticeHistory->id; // assign new notice_id

                NoticeContentHistory::create($contentData);
            }
        }
    }

     
     
     $update = Notice::where('notice_group',$request->notice_group)->update([
           'is_pan_india'=> $request->is_pan_india ,
           'is_region_wise' => $region_prompt ,
           'regions' => $region_list ,
           'is_state_wise' => $state_prompt ,
           'states' => $state_list ,
           'branch_code' => $branchcodes ,
           'template_id' => $request->template_id,
           'creator' =>Auth::user()->id ,
           'voiceover' => $request->voice_over,
           'document_id' => $request->document_id,
           'published_date' => $request->publish_date ,
           'version' => $request->version,
           'status' => 'UnPublished'
       ]);

       $noticeID = $request->id;

      // die();
       if($update){

           
        foreach ($request->notice as $key => $value) {

         // print_r($value->langauge); die();
  
           $updateNotice = Notice::where('notice_group',$request->notice_group)->where('lang_code',$value['langauge'])->update([ 'name' => $value['tittle'] , 'description' => $value['description'] ]);

            $filepath = public_path().'/noticefiles/'.$value['langauge'].'_'.$notice->filename;

            

              if (File::exists($filepath)) {
                unlink($filepath);
               // print_r("yes".$filepath);
              }
              else{
              
              }
             // print_r($value->id);die();

              $delete = NoticeContent::where('id',$value['id'])->delete();
             // die();
              if($delete){
                $langaugedata = Language::where('code',$value['langauge'])->first();
                
               $content = new NoticeContent;
               $content->notice_id = $value['notice_id'] ;
               $content->template_id = $request->template_id;
               $content->lang_code = $langaugedata->code;
               $content->lang_name = $langaugedata->name;
               $content->notice_group = $request->notice_group;


               if(isset($value['row1_1']))$content->c11 = $value['row1_1'];
               if(isset($value['row1_2']))$content->c12 = $value['row1_2'];
               if(isset($value['row1_3']))$content->c13 = $value['row1_3'];
               if(isset($value['row1_4']))$content->c14 = $value['row1_4'];

               if(isset($value['row2_1']))$content->c21 = $value['row2_1'];
               if(isset($value['row2_2']))$content->c22 = $value['row2_2'];
               if(isset($value['row2_3']))$content->c23 = $value['row2_3'];
               if(isset($value['row2_4']))$content->c24 = $value['row2_4'];
              
               if(isset($value['row3_1']))$content->c31 = $value['row3_1'];
               if(isset($value['row3_2']))$content->c32 = $value['row3_2'];
               if(isset($value['row3_3']))$content->c33 = $value['row3_3'];
               if(isset($value['row3_4']))$content->c34 = $value['row3_4'];

               if(isset($value['row4_1']))$content->c41 = $value['row4_1'];
               if(isset($value['row4_2']))$content->c42 = $value['row4_2'];
               if(isset($value['row4_3']))$content->c43 = $value['row4_3'];
               if(isset($value['row4_4']))$content->c44 = $value['row4_4'];

               if(isset($value['row5_1']))$content->c51 = $value['row5_1'];
               if(isset($value['row5_2']))$content->c52 = $value['row5_2'];
               if(isset($value['row5_3']))$content->c53 = $value['row5_3'];
               if(isset($value['row5_4']))$content->c54 = $value['row5_4'];

               if(isset($value['row6_1']))$content->c61 = $value['row6_1'];
               if(isset($value['row6_2']))$content->c62 = $value['row6_2'];
               if(isset($value['row6_3']))$content->c63 = $value['row6_3'];
               if(isset($value['row6_4']))$content->c64 = $value['row6_4'];
               
               $content->save();
               $noticeContentID = $content->id;

               $template = Template::select('details')->where('id',$request->template_id)->first();

                $content = NoticeContent::where('id',$noticeContentID)->first();

                //print_r(json_encode($content)); die();
                $data2 = $template->details ;
         
                $arr = json_decode($data2);

                if (file_exists(public_path().'/noticefiles')) {
                      
                } else {
                   
                    File::makeDirectory(public_path().'/noticefiles', $mode = 0777, true, true);
                }

               // $lang = 'en';

                $local_filename = $value['langauge'].'_'.$notice->filename; 
                $qrcode_data = url('/').'/noticefiles/'.$local_filename;
                
                $name = $value['tittle'] ;
                $version = $request->version;
                $published = $request->publish_date;

                 $noticecontent = 
                 File::put(public_path().'/noticefiles/'.$local_filename,
                    view('htmltemplates.ckofflinetemp')
                        ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data' => $qrcode_data , 'lang_code' => $langaugedata->code ,  'name' => $name])
                        ->render()
                );

                 File::put(public_path().'/noticefilesforweb/'.$local_filename,
                    view('htmltemplates.cktempforweb')
                        ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'lang_code' => $langaugedata->code ,'name' => $name ])
                        ->render()
                ); 

                 // print_r($local_filename);die();
                 

             }


        }

       }

       $audit = Audit::create([
            'action' => 'Ujjivan Notices modified in All languages',
            'pan_india' => $request->is_pan_india,
            'regions' => $reion_names,
            'states' => $state_list,
            'branch' => $br_code,
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'U'
        ]);

       return redirect()->route('notices',$request->default_lang);
// die();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // print_r($request->Input()); die();

       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';

       $reion_names = '';
       $br_code = '';
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
           $branchcodes = '';
       }
        if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);

           foreach ($request->regions as $key => $value) {
             $re = Region::where('id',$value)->first();
             $rearray[]=$re->name;
           }
           $reion_names = implode(',', $rearray);


       }
       if(isset($request->states)){
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }
       if(isset($request->branches)){
         
           $branchcodes = implode(',' , $request->branches);

           if(!in_array('all', $request->branches)){

             foreach ($request->branches as $key => $value2) {
               $br = Branch::where('id',$value2)->first();
               $brarray[]=$br->branch_code;
              }
              $br_code = implode(',', $brarray);

           }
           else{
            $br_code = implode(',', $request->branches);
           }
       }

      /*$current = date('Y-m-d_H_i_s');
      $filename = 'notice'.$request->template_id.'_'.$current.'.html';*/

      $notice = Notice::where('id',$request->id)->first();

      $filepath = public_path().'/noticefiles/'.$request->lang.'_'.$notice->filename;

      
      $existingNoticeRow = Notice::find($request->id);
      $existingNoticeContentRow = NoticeContent::where('notice_id',$request->id)->first();

      if ($existingNoticeRow) {
         $newNoticeGroup =  rand('000000','999999');
         $noticeData = $existingNoticeRow->toArray();
         $noticeData['notice_group'] = $newNoticeGroup;
         //$noticeHistory = NoticeHistory::create($noticeData);
         $noticeHistory = new NoticeHistory($noticeData);

         $noticeHistory->created_at = $existingNoticeRow->created_at;
         $noticeHistory->save();

         $noticeContentData = $existingNoticeContentRow->toArray();
         $noticeContentData['notice_id'] = $noticeHistory->id; // Assign the new ID
         $noticeContentData['notice_group'] = $newNoticeGroup;

         // Step 3: Create NoticeContentHistory with the updated notice_id
         NoticeContentHistory::create($noticeContentData);
      }

       $update = Notice::where('id',$request->id)->update([
           'name' => $request->tittle ,
           'description' => $request->description ,
           'is_pan_india'=> $request->is_pan_india ,
           'is_region_wise' => $region_prompt ,
           'regions' => $region_list ,
           'is_state_wise' => $state_prompt ,
           'states' => $state_list ,
           'branch_code' => $branchcodes ,
           'template_id' => $request->template_id,
           'creator' =>Auth::user()->id ,
           'voiceover' => $request->voice_over,
           'document_id' => $request->document_id,
           'published_date' => $request->publish_date ,
           'version' => $request->version,
           'status' => 'UnPublished'
       ]);

       $noticeID = $request->id;

       //print_r($noticeID); die();

       if($noticeID != 0 AND $noticeID!=''){
       
        if (File::exists($filepath)) {
        //File::delete($image_path);
        unlink($filepath);
         // print_r("yes".$filepath);
        }
        else{
         //  print_r("no".$filepath);
        }

      // die();

        $delete = NoticeContent::where('notice_id',$noticeID)->delete();
       // die();
        if($delete){
          $langaugedata = Language::where('code',$request->lang)->first();
          
         $content = new NoticeContent;
         $content->notice_id = $noticeID ;
         $content->template_id = $request->template_id;
         $content->lang_code = $langaugedata->code;
         $content->lang_name = $langaugedata->name;
         $content->notice_group = $notice->notice_group;


         $content->c11 = $request->row1_1;
         $content->c12 = $request->row1_2;
         $content->c13 = $request->row1_3;
         $content->c14 = $request->row1_4;

         $content->c21 = $request->row2_1;
         $content->c22 = $request->row2_2;
         $content->c23 = $request->row2_3;
         $content->c24 = $request->row2_4;
        
         $content->c31 = $request->row3_1;
         $content->c32 = $request->row3_2;
         $content->c33 = $request->row3_3;
         $content->c34 = $request->row3_4;

         $content->c41 = $request->row4_1;
         $content->c42 = $request->row4_2;
         $content->c43 = $request->row4_3;
         $content->c44 = $request->row4_4;

         $content->c51 = $request->row5_1;
         $content->c52 = $request->row5_2;
         $content->c53 = $request->row5_3;
         $content->c54 = $request->row5_4;

         $content->c61 = $request->row6_1;
         $content->c62 = $request->row6_2;
         $content->c63 = $request->row6_3;
         $content->c64 = $request->row6_4;
         
         $content->save();
         $noticeContentID = $content->id;

         
        $template = Template::select('details')->where('id',$request->template_id)->first();

       
        $content = NoticeContent::where('id',$noticeContentID)->first();

        //print_r(json_encode($content)); die();
        $data2 = $template->details ;
 
        $arr = json_decode($data2);

        if (file_exists(public_path().'/noticefiles')) {
              
        } else {
           
            File::makeDirectory(public_path().'/noticefiles', $mode = 0777, true, true);
        }

       // $lang = 'en';

        $local_filename = $request->lang.'_'.$notice->filename;
        $qrcode_data = url('/').'/noticefiles/'.$local_filename;
        
       // print_r($local_filename);die();
         
        $name = $request['tittle'] ; 
        $version = $request->version;
        $published = $request->publish_date;

          $noticecontent = 
                 File::put(public_path().'/noticefiles/'.$local_filename,
                    view('htmltemplates.ckofflinetemp')
                        ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data' => $qrcode_data , 'lang_code' => $langaugedata->code ,  'name' => $name])
                        ->render()
                );
         File::put(public_path().'/noticefilesforweb/'.$local_filename,
                    view('htmltemplates.cktempforweb')
                        ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'lang_code' => $langaugedata->code ,'name' => $name ])
                        ->render()
                ); 

        }

        } 

        //die();
        $audit = Audit::create([
            'action' => 'Ujjivan Notices modified in '.$langaugedata->lang,
            'pan_india' => $request->is_pan_india,
            'regions' => $reion_names,
            'states' => $state_list,
            'branch' => $br_code,
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'U'
        ]);

       return redirect()->route('notices',$request->lang);

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notice = Notice::where('id', $id)->first();
        $lang = $notice->lang_code;
        $groupID = $notice->notice_group;
        $langaugedata = Language::where('code',$notice->lang_code)->first();
        
      //  print_r($lang); die();
        $filepath = public_path().'/noticefiles/'.$notice->filename;

        if (File::exists($filepath)) {
              unlink($filepath);
           }

        $avail_langs = explode(',', $notice->available_languages) ;

       /* $record = Notice::find($id);

      if ($record) {
          $languages = explode(',', $record->available_languages);
          $deledetablelang = $record->lang_code;
          // Filter out 'en'
          $filtered = array_filter($languages, function($lang)use ($deledetablelang) {
              return trim($lang) !== $deledetablelang;
          });

          // Update the column
          $record->available_languages = implode(',', $filtered);
          $record->save();
      } */


        $records = Notice::where('notice_group', $groupID)->get();

        $deledetablelang = $notice->lang_code;

        foreach ($records as $record) {
            $languages = explode(',', $record->available_languages);

            // Remove 'en' and clean up spaces
            $filtered = array_filter($languages, function ($lang)use($deledetablelang) {
                return trim($lang) !== $deledetablelang;
            });

            // Rebuild the string
            $record->available_languages = implode(',', array_map('trim', $filtered));
            $record->save();
        }

        $delete = Notice::where('id', $id)->delete();

        if($delete){

           $audit = Audit::create([
            'action' => 'Notice deleted in '.$langaugedata->lang,
            'track_id' => $notice->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'D'
          ]);

         /* $delete_content = NoticeContent::where('notice_id',$id)->delete();
          $group_notices=Notice::where('notice_group',$groupID)->get();

          foreach ($group_notices as $key => $value) {
             $languages = $value->available_languages;

             $langArray = explode(',', $languages);
             $updatedArray = array_diff($langArray, [$lang]);

             $new_languages = implode(',', $updatedArray);

             $update = Notice::where('notice_group',$groupID)->update(['available_languages' => $new_languages ]);
          }*/
            return redirect()->route('notices',$lang);
        }
    }

    public function ck_upload(Request $request){

      if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
      
            $request->file('upload')->move(public_path('uploads'), $fileName);
      
            $url = asset('uploads/' . $fileName);
  
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }

    public function search(Request $request){
     // print_r($request->Input()); die();
       $search = $request->search;
       if($request->lang == 'all'){
          $data = Notice::
         where(function($query)use($search){
         /*$query->where('name','LIKE','%'.$search.'%');*/
         $query->orWhere('document_id','LIKE','%'.$search.'%');
         /*$query->orWhere('notice_type','LIKE','%'.$search.'%');*/
       })
       ->orderBy('id', 'DESC')
       ->paginate(25)->withQueryString();
       }
       else{
         $data = Notice::where('lang_code',$request->lang)
         ->where(function($query)use($search){
           /*$query->where('name','LIKE','%'.$search.'%');*/
           $query->orWhere('document_id','LIKE','%'.$search.'%');
           /*$query->orWhere('notice_type','LIKE','%'.$search.'%');*/
         })
         ->orderBy('id', 'DESC')
         ->paginate(25)->withQueryString();
       }
       
        $lang = $request->lang;
        $languages = Language::get();

       return view('notice/list', compact('data','search','languages','lang'));
    }

    public function filter(Request $request){
     // print_r($request->Input()); die();
       $data = Notice::where('lang_code',$request->lang)->paginate(2);
        $search = '';
        $lang = $request->lang;
        $languages = Language::get();

       return view('notice/list', compact('data','search','languages','lang'));
    }

    public function store_rbi_notice(Request $request){
     
     // print_r($request->Input());

       $validator = Validator::make($request->all(), [

        'document_id' => [
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
           'version' => [
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

           'publish_date' => [
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

        'notice.*.tittle' => [
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

          'notice.*.description' => [
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

      $imageFiles = $_FILES['notice'];

     

       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';

       $reion_names = '';
       $br_code = '';
      
        if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
           $branchcodes = '';
       }
        if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);

           foreach ($request->regions as $key => $value) {
             $re = Region::where('id',$value)->first();
             $rearray[]=$re->name;
           }
           $reion_names = implode(',', $rearray);


       }
       if(isset($request->states)){
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }
       if(isset($request->branches)){
         
           $branchcodes = implode(',' , $request->branches);

           if(!in_array('all', $request->branches)){

             foreach ($request->branches as $key => $value2) {
               $br = Branch::where('id',$value2)->first();
               $brarray[]=$br->branch_code;
              }
              $br_code = implode(',', $brarray);

           }
           else{
            $br_code = implode(',', $request->branches);
           }

       }

       $group_id = rand('000000','999999');

       $current = date('Y-m-d_H_i_s');
       $c_time = $current.'.pdf';
       $rbifilename = 'rbinotice_'.$c_time;

       foreach($request->notice as $key=>$value) {

            $fileName = $imageFiles['name'][$key]['rbi_file'];
            $temp = explode(".", $fileName);
            $local_filename = $value['langauge'].'_'.$rbifilename;

            $destinationPath = public_path().'/noticefiles/'.$local_filename ;
           
            move_uploaded_file($imageFiles['tmp_name'][$key]["rbi_file"], $destinationPath);
           
            //print_r($local_filename);
      

        $langaugedata = Language::where('code',$value['langauge'])->first();

         $notice = new Notice;
         $notice->name = $value['tittle'] ;
         $notice->description = $value['description'] ;
         $notice->path = 'noticefiles';
         $notice->filename = $rbifilename;
         $notice->is_pan_india = $request->is_pan_india ;
         $notice->is_region_wise = $region_prompt ;
         $notice->regions = $region_list ;
         $notice->is_state_wise = $state_prompt ;
         $notice->states = $state_list ;
         $notice->branch_code = $branchcodes ;
         $notice->status = 'Draft';
         $notice->available_languages =$request->selected_lang_code ;
         $notice->template_id = '0';
         $notice->creator = Auth::user()->id ;
         $notice->voiceover = 'N';
         $notice->lang_code = $langaugedata->code;
         $notice->lang_name = $langaugedata->name;
         $notice->notice_group = $group_id;
         $notice->notice_type = 'rbi';
         $notice->document_id = $request->document_id;
         $notice->published_date = $request->publish_date;
         $notice->version = $request->version;

         $notice->save();

         $noticeID = $notice->id;

         $langArray[] = $langaugedata->lang;


       }

        $audit = Audit::create([
            'action' => 'New RBI Notice Created in '.implode(',', $langArray),
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'C'
          ]);

        return redirect()->route('notices',$request->dropdown_lang);
    }

    public function add_rbi_notice(Request $request){
     // print_r($request->Input()); die();

       $validator = Validator::make($request->all(), [

        'document_id' => [
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
           'version' => [
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

           'publish_date' => [
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

        'notice.*.tittle' => [
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

          'notice.*.description' => [
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

      $imageFiles = $_FILES['notice'];

      $noticedetails = Notice::where('id', $request->notice_id)->first();
      $langs = $noticedetails->available_languages;
      $new_langs = $request->selected_lang_code;

      foreach($request->notice as $key=>$value) {

            $fileName = $imageFiles['name'][$key]['rbi_file'];
            $temp = explode(".", $fileName);
            $local_filename = $value['langauge'].'_'.$noticedetails->filename;

            $destinationPath = public_path().'/noticefiles/'.$local_filename ;
           
            move_uploaded_file($imageFiles['tmp_name'][$key]["rbi_file"], $destinationPath);
           
            //print_r($local_filename);
      

         $langaugedata = Language::where('code',$value['langauge'])->first();

         $notice = new Notice;
         $notice->name = $value['tittle'] ;
         $notice->description = $value['description'] ;
         $notice->path = 'noticefiles';
         $notice->filename = $noticedetails->filename;
         $notice->is_pan_india = $noticedetails->is_pan_india ;
         $notice->is_region_wise = $noticedetails->is_region_wise ;
         $notice->regions = $noticedetails->regions;
         $notice->is_state_wise = $noticedetails->is_state_wise;
         $notice->states = $noticedetails->states;
         $notice->branch_code = $noticedetails->branch_code ;
         $notice->status = 'Draft';
         $notice->available_languages = $langs.','.$new_langs ;
         $notice->template_id = $noticedetails->template_id;
         $notice->creator = Auth::user()->id ;
         $notice->voiceover = 'N';
         $notice->lang_code = $langaugedata->code;
         $notice->lang_name = $langaugedata->name;
         $notice->notice_group = $noticedetails->notice_group;
         $notice->notice_type = 'rbi';
         $notice->document_id = $noticedetails->document_id;
         $notice->published_date = $request->publish_date;
         $notice->version = $request->version;

         $notice->save();

         $noticeID = $notice->id;

         $langArray[] = $langaugedata->lang;

         

       }
       $update = Notice::where('notice_group',$noticedetails->notice_group)->update(['available_languages'=> $langs.','.$new_langs]);

       $audit = Audit::create([
            'action' => 'New RBI Notice added in '.implode(',', $langArray),
            'track_id' => $noticedetails->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'A'
          ]);

        return redirect()->route('notices',$request->dropdown_lang);
    }

     public function edit_rbi_notice($id){
        $data = Notice::where('id',$id)->first();
        $regions = Region::all();

        return view('notice/ckeditor/edit_rbi',compact('data','regions','id'));
    }

  
    public function update_rbi_notice(Request $request){
     // print_r($request->Input()); die();

       $validator = Validator::make($request->all(), [

        'document_id' => [
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
           'version' => [
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

           'publish_date' => [
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

        'notice.*.tittle' => [
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

          'notice.*.description' => [
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

       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';

       $reion_names = '';
       $br_code = '';
      
        if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
           $branchcodes = '';
       }
        if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);

           foreach ($request->regions as $key => $value) {
             $re = Region::where('id',$value)->first();
             $rearray[]=$re->name;
           }
           $reion_names = implode(',', $rearray);


       }
       if(isset($request->states)){
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }
       if(isset($request->branches)){
         
           $branchcodes = implode(',' , $request->branches);

           if(!in_array('all', $request->branches)){

             foreach ($request->branches as $key => $value2) {
               $br = Branch::where('id',$value2)->first();
               $brarray[]=$br->branch_code;
              }
              $br_code = implode(',', $brarray);

           }
           else{
            $br_code = implode(',', $request->branches);
           }
       }


      $notice = Notice::where('id',$request->id)->first();
      $filepath = public_path().'/noticefiles/'.$request->lang.'_'.$notice->filename;

      $langaugedata = Language::where('code',$notice->lang_code)->first();

       $update = Notice::where('id',$request->id)->update([
           'name' => $request->tittle ,
           'description' => $request->description ,
           'is_pan_india'=> $request->is_pan_india ,
           'is_region_wise' => $region_prompt ,
           'regions' => $region_list ,
           'is_state_wise' => $state_prompt ,
           'states'=> $state_list ,
           'branch_code'=> $branchcodes ,
           'creator'=>Auth::user()->id ,
           'document_id' => $request->document_id,
           'published_date' => $request->publish_date ,
           'version'=> $request->version,
           'status' => 'UnPublished'

         
       ]);

       $noticeID = $request->id;


       if($noticeID != 0 AND $noticeID!=''){
      
         if($file = $request->hasFile('rbi_file')) {

             if (File::exists($filepath)) {
               unlink($filepath);
             }

            $file = $request->file('rbi_file') ;
            $fileName = $request->lang.'_'.$notice->filename;;

            $destinationPath = public_path().'/noticefiles';
            $file->move($destinationPath,$fileName);
            
         }
         

      }

      $audit = Audit::create([
            'action' => 'RBI notices modified in '.$langaugedata->lang,
            'pan_india' => $request->is_pan_india,
            'regions' => $reion_names,
            'states' => $state_list,
            'branch' => $br_code,
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'U'
      ]);

      return redirect()->route('notices',$request->lang);

    }

     public function edit_multi_rbi_notice($id,$lang){
     // print_r($lang); die();
      $notice = Notice::where('notice_group' , $id)->first();
      $langarray=$notice->available_languages ;
      $selected_lang_code = explode(',', $langarray);
    //  print_r($langarray); die();
      $template_id = $notice->template_id;
      $regions = Region::all();
      $branch = Branch::select('state')->groupBy('state')->get();

      $data = Notice::where('notice_group',$id)->first();
     
      $languages = Language::get();
      $selected_languages = Language::whereIn('code',$selected_lang_code)->get();

      $rbi_data = Notice::where('notice_group',$id)->get();

     
      return view('notice/ckeditor/edit_multilingual_rbi',compact('regions','branch','data','id' ,'languages','selected_languages','langarray', 'rbi_data' ,'lang'));

    }

    public function update_multi_rbi_notice(Request $request){
     // print_r(json_encode($request->Input()) ); die();

      $validator = Validator::make($request->all(), [

        'document_id' => [
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
           'version' => [
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

           'publish_date' => [
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

        'notice.*.tittle' => [
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

          'notice.*.description' => [
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
      
      $imageFiles = $_FILES['notice'];

      foreach ($request->notice as $key => $value) {

       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';

       $reion_names = '';
       $br_code = '';
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
           $branchcodes = '';
       }
        if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);

           foreach ($request->regions as $key1 => $value1) {
             $re = Region::where('id',$value1)->first();
             $rearray[]=$re->name;
           }
           $reion_names = implode(',', $rearray);


       }
       if(isset($request->states)){
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }
       if(isset($request->branches)){
         
           $branchcodes = implode(',' , $request->branches);

           if(!in_array('all', $request->branches)){

             foreach ($request->branches as $key2 => $value2) {
               $br = Branch::where('id',$value2)->first();
               $brarray[]=$br->branch_code;
              }
              $br_code = implode(',', $brarray);

           }
           else{
            $br_code = implode(',', $request->branches);
           }
       }

      $notice = Notice::where('id',$value['id'])->first();
      $filepath = public_path().'/noticefiles/'.$value['langauge'].'_'.$notice->filename;

      $langaugedata = Language::where('code',$notice->lang_code)->first();

       $update = Notice::where('id',$value['id'])->update([
           'name' => $value['tittle'] ,
           'description' => $value['description'] ,
           'is_pan_india'=> $request->is_pan_india ,
           'is_region_wise' => $region_prompt ,
           'regions' => $region_list ,
           'is_state_wise' => $state_prompt ,
           'states'=> $state_list ,
           'branch_code'=> $branchcodes ,
           'creator'=>Auth::user()->id ,
           'document_id' => $request->document_id,
           'published_date' => $request->publish_date ,
           'version'=> $request->version,
           'status' => 'UnPublished'

         
       ]);

       $noticeID = $value['id'];
       $langArray[] = $langaugedata->lang;


       if($noticeID != 0 AND $noticeID!=''){

       
        if($file = ($imageFiles['name'][$key]['rbi_file']) ){
         
           if (File::exists($filepath)) {
               unlink($filepath);
             }

           $fileName = $imageFiles['name'][$key]['rbi_file'];
            $temp = explode(".", $fileName);
            $local_filename = $value['langauge'].'_'.$notice->filename;

            $destinationPath = public_path().'/noticefiles/'.$local_filename ;
           
            move_uploaded_file($imageFiles['tmp_name'][$key]["rbi_file"], $destinationPath);
        }
      }
        
      }

      $audit = Audit::create([
            'action' => 'RBI Notices modified in All languages',
            'pan_india' => $request->is_pan_india,
            'regions' => $reion_names,
            'states' => $state_list,
            'branch' => $br_code,
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'U'
          ]);
     
      return redirect()->route('notices',$request->default_lang);

    }

    public function modify_status($id){
      //print_r($id); die();

      $noticedata = Notice::where('id',$id)->first();
      $status = $noticedata->status ;
      $langaugedata = Language::where('code',$noticedata->lang_code)->first();

      if($status == 'Published'){
        $update = Notice::where('id',$id)->update(['status' => 'UnPublished']);
        $new_status = 'UnPublished';
      }
      elseif($status == 'Draft'){
        $update = Notice::where('id',$id)->update(['status' => 'Published']);
        $new_status = 'Published';
      }
      else {
        $update = Notice::where('id',$id)->update(['status' => 'Published']);
        $new_status = 'Published';
      }

      if($update){

        $audit = Audit::create([
            'action' => $langaugedata->lang.' Notice Status Updated to '.$new_status,
            'track_id' => $noticedata->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'U'
          ]);

        return redirect()->back();
      }

    }

    public function modify_all_status($noticegroup , $status){

      $noticedata = Notice::where('notice_group',$noticegroup)->first();

       if($status == 'Publish'){
        $update = Notice::where('notice_group',$noticegroup)->update(['status' => 'Published']);
        $new_status = 'Published';
      }
      else {
        $update = Notice::where('notice_group',$noticegroup)->update(['status' => 'UnPublished']);
        $new_status = 'UnPublished';
      }

      $audit = Audit::create([
            'action' => 'All Notices Status Updated to '.$new_status,
            'track_id' => $noticedata->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'U'
          ]);

      

      return redirect()->back();
    }

    public function delete_all($noticegroup){

      $data = Notice::where('notice_group', $noticegroup)->get();
      $noticedata = Notice::where('notice_group',$noticegroup)->first();

      foreach($data as $key=>$value){
        $filename = $value->lang_code.'_'.$value->filename ;

        $filepath = public_path().'/noticefiles/'.$filename;
       
        if (File::exists($filepath)) {
              unlink($filepath);
           }

      }
    
        $delete = Notice::where('notice_group', $noticegroup)->delete();

        if($delete){
          $audit = Audit::create([
            'action' => 'All language Notices deleted',
            'track_id' => $noticedata->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'D'
          ]);
          return redirect()->back();
        }

    }

    public function AllNotices(Request $request){

      $data = Notice::where('lang_code',$request->lang)
              ->where('status','Published')
              ->whereIn('template_id',['0','1','2'])
              ->where('is_pan_india','Yes')
              ->orderBy('id','DESC')->get();
      $lang = $request->lang;
      $languages = Language::get();
      $search = '';

    //  print_r(json_encode($data) );die();
       
      return view('notice/allnotices', compact('data','languages','lang' ,'search'));
    }

    public function search_public_notice($lang,$id){
       $data = Notice::where('id',$id)->first();
       if($data->notice_type == 'ujjivan'){
           $url =  url('/').'/noticefilesforweb/'.$lang.'_'.$data->filename ; 
       }
       else{
          $url =  url('/').'/noticefiles/'.$lang.'_'.$data->filename ; 
       }
       
       return redirect()->to($url);

    }

    public function view_notices($noticegroup){

       $data = Notice::where('notice_group',$noticegroup)->get();
       $pdfUrls=array();

       foreach ($data as $key => $value) {
          $path = $value->lang_code.'_'.$value->filename;
          $pdfUrls[] = asset('noticefiles/' . $path);
       }
       return view('notice/viewpdf', compact('pdfUrls'));

      // print_r($filearray); die();


    }

    public function get_states_list(Request $request){

      $regionId = $request->regions;

      $states = Branch::select('state')->whereIn('region_id',$regionId)->groupBy(['state'])->get();

      return response()->json($states);

    }

    public function get_branch_list(Request $request){

      $stateslist = $request->states;
      $reionlist = $request->regions;
      // if(in_array("all", $search)){

      if($stateslist == 'all' || in_array("all", $stateslist)){
        $data = Branch::whereIn('region_id',$reionlist)->get();
       // $data = "abc";
      }
      else{
        $data  = Branch::whereIn('region_id',$reionlist)->whereIn('state',$stateslist)->get();
        // $data = "def";
      }

      return response()->json($data);

    }

    public function export_notices($lang,$search){
     // print_r($lang); print_r($search); die();
      $language = Language::where('code',$lang)->first();
      if($lang == 'all'){
         $file_name = 'Notices.csv';
      }
      else{
         $file_name = $language->lang.'_Notices.csv';
      }
       
       
         return Excel::download(new ExportNotice($lang,$search), $file_name);
      
    }

    public function save_custom_notice(Request $request){
     // print_r(explode(',',$request->selected_lang_code));die();
     // print_r(json_encode($request->input()) );die();

       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';

       $reion_names = '';
       $br_code = '';
      
        if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
           $branchcodes = '';
       }
        if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);

           foreach ($request->regions as $key => $value) {
             $re = Region::where('id',$value)->first();
             $rearray[]=$re->name;
           }
           $reion_names = implode(',', $rearray);


       }
       if(isset($request->states)){
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }
       if(isset($request->branches)){
         
           $branchcodes = implode(',' , $request->branches);

           if(!in_array('all', $request->branches)){

             foreach ($request->branches as $key => $value2) {
               $br = Branch::where('id',$value2)->first();
               $brarray[]=$br->branch_code;
              }
              $br_code = implode(',', $brarray);

           }
           else{
            $br_code = implode(',', $request->branches);
           }

       }

       $group_id = rand('000000','999999');

       $current = date('Y-m-d_H_i_s');
       $c_time = $current.'.html';
       $custmfilename = 'customnotice_'.$c_time;

        $data = $request->contact ;             
         $result = array();

         foreach ($data as $keys => $custom_value) {

         if(!empty($custom_value['value'])){
          $result[$custom_value['name']]=$custom_value['value'];
         }
            
        }

        if(sizeof($result)>0){
             $features = json_encode($result,JSON_UNESCAPED_UNICODE);
         }
         else{
             $features = "{}";
         }

         $languags=explode(',',$request->selected_lang_code);
         foreach ($request->notice as $key => $value) {

         $langaugedata = Language::where('code',$value['langauge'])->first();
 
         $notice = new Notice;
         $notice->name = $value['tittle'] ;
         $notice->description = $value['description'] ;
         $notice->path = 'custom_noticefiles';
         $notice->filename = $custmfilename;
         $notice->is_pan_india = $request->is_pan_india ;
         $notice->is_region_wise = $region_prompt ;
         $notice->regions = $region_list ;
         $notice->is_state_wise = $state_prompt ;
         $notice->states =  $state_list;
         $notice->branch_code = $branchcodes ;
         $notice->status = 'Draft';
         $notice->available_languages =$request->selected_lang_code ;
         $notice->template_id = $request->template_id;
         $notice->creator = Auth::user()->id ;
         $notice->voiceover = 'Y';
         $notice->lang_code = $langaugedata->code;
         $notice->lang_name = $langaugedata->name;
         $notice->notice_group = $group_id;
         $notice->notice_type = 'custom_ujjivan';
         $notice->document_id = $request->document_id;
         $notice->published_date = $request->publish_date;
         $notice->version = $request->version;
         $notice->expiry_date = '2024-12-12';


         $notice->save();

         $noticeID = $notice->id;

           $langArray[] = $langaugedata->lang;

           if($noticeID != 0 AND $noticeID!=''){
           
           $content = new NoticeContent;
           $content->notice_id = $noticeID ;
           $content->template_id = '3';
           $content->lang_code = $langaugedata->code;
           $content->lang_name = $langaugedata->name;
           $content->notice_group = $group_id;

           $content->c11 = $features;

           $content->save();
           $noticeContentID = $content->id;

           $content = NoticeContent::select('c11')->where('notice_id',$noticeID)->first();

           if (file_exists(public_path().'/noticefiles')) {
                
          } else {
             
              File::makeDirectory(public_path().'/noticefiles', $mode = 0777, true, true);
          }

         // print_r(json_encode($content) ); die();

          $local_filename = $langaugedata->code.'_customnotice_'.$c_time;
          $version = $request->version;
          $published = $request->publish_date;
           $qrcode_data = url('/').'/noticefiles/'.$local_filename;
           $name = $request->tittle;

         //  $info = json_decode($content->c11);

          // print_r($info); die();

           $noticecontent = 
           File::put(public_path().'/noticefiles/'.$local_filename,
              view('htmltemplates.custom_cktemp')
                  ->with(["content" => $content ,  'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'name'=>$value['tittle'] , 'desc'=>$value['description'] , 'n_id' => $request->document_id ])
                  ->render()
          );

      }
    }

     $audit = Audit::create([
            'action' => 'New Custom Ujjivan Notice Created in '.implode(',', $langArray),
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'C'
          ]);

        return redirect()->route('notices',$request->dropdown_lang);
  }

    public function generate_custom_notice($id){
      print_r($id); die();

    }

    public function edit_multi_custom_notices($id , $lang){
        $notice = Notice::where('notice_group' , $id)->first();
        $notice_content = NoticeContent::where('notice_group' , $id)->first();
        $langarray=$notice->available_languages ;
        $selected_lang_code = explode(',', $langarray);
        $template_id = $notice->template_id;
        $notice_type = 'custom_ujjivan';
        $noticegroup = $id;
     
        $regions = Region::all();
        $branch = Branch::select('state')->groupBy('state')->get();
       // $template = Template::select('details')->where('id',$template_id)->first();
        $languages = Language::get();
        $selected_languages = Language::whereIn('code',$selected_lang_code)->get();
       
        //$dropdown_lang =$request->dropdown_lang; 
         $data = Notice::where('notice_group' , $id)->first();
         $custom_noticeData = Notice::where('notice_group' , $id)->get();
         $custNoticeDetails = NoticeContent::where('notice_group' , $id)->first();

         if($notice->template_id == 3){
           $info_cols = Schema::getColumnListing('emergency_contact_details');
           $excludedColumns = ['id','lang_code','created_at', 'updated_at'];
           $filteredColumns = array_diff($info_cols, $excludedColumns);
           $readableNames = [
              'branch_id' => 'Branch ID',
              'police' => 'Police Station addres',
              'police_contact' => 'Police Station Contact Number',
              'medical' => 'Emergency Medical Support',
              'medical_contact' => 'Medical Support Contact',
              'ambulance' => 'Ambulance',
              'ambulance_contact' => 'Ambulance Contact Number',
              'fire' => 'Fire Station',
              'fire_contact' => 'Fire Station Contact',
              'manager' => 'Branch managerer Name',
              'manager_contact' => 'Branch Manager Number',
              'rno' => 'RNO',
              'rno_contact' => 'RNO Contact',
              'pno' => 'PNO',
              'pno_contact' => 'PNO Contact',
              'contact_center' => 'Contact Center',
              'contact_center_number' => 'Contact Center Number',
              'cyber_dost' => 'Cyber Dost',
              'cyber_dost_number' => 'Cyber Dost Number',

              // Add all your columns here
          ];

         }
         else{

           $info_cols = Schema::getColumnListing('banking_ombudsments');
           $excludedColumns = ['id','lang_code','created_at', 'updated_at'];
           $filteredColumns = array_diff($info_cols, $excludedColumns);
           $readableNames = [
              'state' => 'STATE',
              'banking_ombudsment' => 'BANKING OMBUDSMAN LABLE',
              'banking_ombudsment_name' => 'NAME OF THE BANKING OMBUDSMAN',
              'center' => 'CENTER LABLE',
              'center_name' => 'NAME OF THE CENTER',
              'area' => 'AREA LABLE',
              'area_name' => 'NAME OF THE AREA',
              'address' => 'ADDRESS LABLE',
              'full_address' => 'COMPLETE ADDRESS',
              'tel' => 'TELEPHONE LABLE',
              'tel_number' => 'TELEPHONE NUMBER',
              'fax' => 'FAX LABLE',
              'fax_number' => 'FAX NUMBER',
              'email' => 'E-MAIL LABLE',
              'email_id' => 'E-MAIL ADDRESS',
              'toll_free' => 'TOLL-FREE LABLE',
              'toll_free_number' => 'TOLL-FREE NUMBER',

              // Add all your columns here
          ];


         }
         

        $info_columns = [];
        foreach ($filteredColumns as $column) {
          if (isset($readableNames[$column])) {
              $info_columns[$column] = $readableNames[$column];
          } else {
              $info_columns[$column] = $column; // Use the original name if no readable name is found
          }
      }
        
         return view('notice/ckeditor/edit_custom_notice',compact('noticegroup','lang','data','regions','branch','languages','selected_languages','selected_lang_code','notice_type' ,'info_columns','custom_noticeData','custNoticeDetails'));
    }

    public function update_custom_notice(Request $request){
      //print_r(json_encode($request->input())); die();

       $data = $request->contact ;             
       $result = array();

       foreach ($data as $keys => $custom_value) {

       if(!empty($custom_value['value'])){
        $result[$custom_value['name']]=$custom_value['value'];
       }
          
      }

      if(sizeof($result)>0){
           $features = json_encode($result,JSON_UNESCAPED_UNICODE);
       }
       else{
           $features = "{}";
       }

      foreach ($request->notice as $key => $value) {

       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';

       $reion_names = '';
       $br_code = '';
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
           $branchcodes = '';
       }
        if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);

           foreach ($request->regions as $key1 => $value1) {
             $re = Region::where('id',$value1)->first();
             $rearray[]=$re->name;
           }
           $reion_names = implode(',', $rearray);


       }
       if(isset($request->states)){
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }
       if(isset($request->branches)){
         
           $branchcodes = implode(',' , $request->branches);

           if(!in_array('all', $request->branches)){

             foreach ($request->branches as $key2 => $value2) {
               $br = Branch::where('id',$value2)->first();
               $brarray[]=$br->branch_code;
              }
              $br_code = implode(',', $brarray);

           }
           else{
            $br_code = implode(',', $request->branches);
           }
       }

      $notice = Notice::where('id',$value['id'])->first();
      $filepath = public_path().'/noticefiles/'.$value['langauge'].'_'.$notice->filename;

      $langaugedata = Language::where('code',$notice->lang_code)->first();

      $update = Notice::where('id',$value['id'])->update([
           'name' => $value['tittle'] ,
           'description' => $value['description'] ,
           'is_pan_india'=> $request->is_pan_india ,
           'is_region_wise' => $region_prompt ,
           'regions' => $region_list ,
           'is_state_wise' => $state_prompt ,
           'states'=> $state_list ,
           'branch_code'=> $branchcodes ,
           'creator'=>Auth::user()->id ,
           'document_id' => $request->document_id,
           'published_date' => $request->publish_date ,
           'version'=> $request->version,
           'status' => 'UnPublished'

         
       ]);

      $noticeID = $value['id'];
      $langArray[] = $langaugedata->lang;


      if($noticeID != 0 AND $noticeID!=''){
         $updateContent = NoticeContent::where('notice_id',$noticeID)->update(['c11'=>$features]);
         $content = NoticeContent::select('c11')->where('notice_id',$noticeID)->first();

         if (file_exists(public_path().'/noticefiles')) {
              
          } else {
             
              File::makeDirectory(public_path().'/noticefiles', $mode = 0777, true, true);
          }

         // print_r(json_encode($content) ); die();

          $local_filename = $value['langauge'].'_'.$notice->filename;
          $version = $request->version;
          $published = $request->publish_date;
           $qrcode_data = url('/').'/noticefiles/'.$local_filename;
           $name = $request->tittle;

         //  $info = json_decode($content->c11);

          // print_r($info); die();

           $noticecontent = 
           File::put(public_path().'/noticefiles/'.$local_filename,
              view('htmltemplates.custom_cktemp')
                  ->with(["content" => $content ,  'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'name'=>$value['tittle'] ])
                  ->render()
          );

      }
        
      }

      $audit = Audit::create([
            'action' => 'Custom Notices modified in All languages',
            'pan_india' => $request->is_pan_india,
            'regions' => $reion_names,
            'states' => $state_list,
            'branch' => $br_code,
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'U'
          ]);
     
      return redirect()->route('notices',$request->default_lang);

    }

    public function add_custom_notice(Request $request){
      // print_r(json_encode($request->input())); die();

       $noticedetails = Notice::where('id', $request->notice_id)->first();
       $langs = $noticedetails->available_languages;
       $new_langs = $request->selected_lang_code;

       foreach ($request->notice as $key => $value) {
         
         $langaugedata = Language::where('code',$value['langauge'])->first();

         $notice = new Notice;
         $notice->name = $value['tittle'] ;
         $notice->description = $value['description'] ;
         $notice->path = 'custom_noticefiles';
         $notice->filename = $noticedetails->filename;
         $notice->is_pan_india = $noticedetails->is_pan_india ;
         $notice->is_region_wise = $noticedetails->is_region_wise ;
         $notice->regions = $noticedetails->regions;
         $notice->is_state_wise = $noticedetails->is_state_wise;
         $notice->states = $noticedetails->states;
         $notice->branch_code = $noticedetails->branch_code ;
         $notice->status = 'Draft';
         $notice->available_languages = $langs.','.$new_langs ;
         $notice->template_id = $noticedetails->template_id;
         $notice->creator = Auth::user()->id ;
         $notice->voiceover = 'Y';
         $notice->lang_code = $langaugedata->code;
         $notice->lang_name = $langaugedata->name;
         $notice->notice_group = $noticedetails->notice_group;
         $notice->notice_type = 'custom_ujjivan';
         $notice->document_id = $noticedetails->document_id;
         $notice->published_date = $request->publish_date;
         $notice->version = $request->version;
         $notice->expiry_date = '2024-12-12';

         $notice->save();

         $noticeID = $notice->id;

         $langArray[] = $langaugedata->lang;

         if($noticeID != 0 AND $noticeID!=''){

          $noticeContent = NoticeContent::where('notice_group',$noticedetails->notice_group)->first(); 
         
         $content = new NoticeContent;
         $content->notice_id = $noticeID ;
         $content->template_id = '3';
         $content->lang_code = $langaugedata->code;
         $content->lang_name = $langaugedata->name;
         $content->notice_group = $noticedetails->notice_group;

         $content->c11 = $noticeContent->c11;

         $content->save();
         $noticeContentID = $content->id;

         $content = NoticeContent::select('c11')->where('notice_id',$noticeID)->first();

         if (file_exists(public_path().'/noticefiles')) {
              
          } else {
             
              File::makeDirectory(public_path().'/noticefiles', $mode = 0777, true, true);
          }

         // print_r(json_encode($content) ); die();

          $local_filename = $langaugedata->code.'_'.$noticedetails->filename;
          $version = $request->version;
          $published = $request->publish_date;
           $qrcode_data = url('/').'/noticefiles/'.$local_filename;
           $name = $request->tittle;

         //  $info = json_decode($content->c11);

          // print_r($info); die();

           $noticecontent = 
           File::put(public_path().'/noticefiles/'.$local_filename,
              view('htmltemplates.custom_cktemp')
                  ->with(["content" => $content ,  'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'name'=>$value['tittle'] ])
                  ->render()
          );

       
        
      }
    }

    $update = Notice::where('notice_group',$noticedetails->notice_group)->update(['available_languages'=> $langs.','.$new_langs]);

     $audit = Audit::create([
            'action' => 'Custom Notices added in -'.implode(',', $langArray),
            'track_id' => $request->document_id,
            'user_id' => Auth::user()->id,
            'module' => 'Notice',
            'operation' => 'U'
          ]);
     
      return redirect()->route('notices',$request->dropdown_lang);
}


//Archives

public function notices_history(Request $request){
  $lang = $request->lang;
   if($lang == 'all'){
    $data = NoticeHistory::orderBy('id','DESC')->paginate(25);            
   }
   else{
    $data = NoticeHistory::where('lang_code',$request->lang)->orderBy('id','DESC')->paginate(25);
    
   }
   
   $search = '';
   
   $languages = Language::get();
   $branches = Branch::get();
    
   return view('notice/archive/index', compact('data','search','languages','lang', 'branches'));

}


public function view_archive_notice_datails($id){
    $data = NoticeHistory::where('id',$id)->first();
    $regions = Region::all();

    $template = Template::select('details')->where('id',$data->template_id)->first();

    $content = NoticeContentHistory::where('template_id',$data->template_id)->where('notice_id',$data->id)->first();

    $data2 = $template->details ;

    $arr = json_decode($data2);

    return view('notice/archive/view',compact('data','id','template','arr' ,'content','regions'));
}

public function view_multilingual_archive_notice_datails($id,$lang){
      $notice = NoticeHistory::where('notice_group' , $id)->first();
      $langarray=$notice->available_languages ;
      $selected_lang_code = explode(',', $langarray);
    //  print_r($langarray); die();
      $template_id = $notice->template_id;
      $regions = Region::all();
      $branch = Branch::select('state')->groupBy('state')->get();

      $data = NoticeHistory::where('notice_group',$id)->first();
      $template = Template::select('details')->where('id',$data->template_id)->first();

      $languages = Language::get();
      $selected_languages = Language::whereIn('code',$selected_lang_code)->get();

      $data2 = $template->details ;
      $arr = json_decode($data2);
     
      $noticeDetails = array();
      $multinotice = NoticeHistory::where('notice_group' , $id)->get();
      foreach ($multinotice as $key => $value) {
          $noticename = $value->name;
          $noticedesc = $value->description;
          $notice_content = NoticeContentHistory::where('notice_group',$value->notice_group)->where('lang_code',$value->lang_code)->first();
          $eng_lang = Language::where('code',$value->lang_code)->first();

          $noticeDetails[]=['name' => $noticename , 'desc' =>$noticedesc ,'language' =>$eng_lang->lang.' - '.$value->lang_name , 'notice_content' => $notice_content ];

      }

    
      return view('notice/archive/view_multilingual',compact('regions','branch','data','id','template','arr' ,'noticeDetails','languages','selected_languages','langarray','lang'));

}

public function search_archive_notice(Request $request){

   $search = $request->search;
   if($request->lang == 'all'){
      $data = NoticeHistory::
     where(function($query)use($search){
     /*$query->where('name','LIKE','%'.$search.'%');*/
     $query->orWhere('document_id','LIKE','%'.$search.'%');
     /*$query->orWhere('notice_type','LIKE','%'.$search.'%');*/
   })
   ->orderBy('id', 'DESC')
   ->paginate(25)->withQueryString();
   }
   else{
     $data = NoticeHistory::where('lang_code',$request->lang)
     ->where(function($query)use($search){
       /*$query->where('name','LIKE','%'.$search.'%');*/
       $query->orWhere('document_id','LIKE','%'.$search.'%');
       /*$query->orWhere('notice_type','LIKE','%'.$search.'%');*/
     })
     ->orderBy('id', 'DESC')
     ->paginate(25)->withQueryString();
   }
   
    $lang = $request->lang;
    $languages = Language::get();

   return view('notice/archive/index', compact('data','search','languages','lang'));

}


//reycle Bin

public function notices_recycle(Request $request){
  $lang = $request->lang;
   if($lang == 'all'){
    $data = Notice::orderBy('deleted_at','DESC')->onlyTrashed()->paginate(25);            
   }
   else{
    $data = Notice::where('lang_code',$request->lang)->onlyTrashed()->orderBy('deleted_at','DESC')->paginate(25);
    
   }
   
   $search = '';
   
   $languages = Language::get();
   $branches = Branch::get();
    
   return view('notice/recycle/index', compact('data','search','languages','lang', 'branches'));

}

public function view_recycle_notice_datails($id){
    $data = Notice::where('id',$id)->withTrashed()->first();
   // print_r($data);die();
  
    $regions = Region::all();

    $template = Template::select('details')->where('id',$data->template_id)->first();

    $content = NoticeContent::where('template_id',$data->template_id)->where('notice_id',$data->id)->first();

    $data2 = $template->details ;

    $arr = json_decode($data2);

    return view('notice/recycle/view',compact('data','id','template','arr' ,'content','regions'));
}

public function view_multilingual_recycle_notice_datails($id,$lang){
      $notice = Notice::where('notice_group' , $id)->withTrashed()->first();
      $langarray=$notice->available_languages ;
      $selected_lang_code = explode(',', $langarray);
    //  print_r($langarray); die();
      $template_id = $notice->template_id;
      $regions = Region::all();
      $branch = Branch::select('state')->groupBy('state')->get();

      $data = Notice::where('notice_group',$id)->withTrashed()->first();
      $template = Template::select('details')->where('id',$data->template_id)->first();

      $languages = Language::get();
      $selected_languages = Language::whereIn('code',$selected_lang_code)->get();

      $data2 = $template->details ;
      $arr = json_decode($data2);
     
      $noticeDetails = array();
      $multinotice = Notice::where('notice_group' , $id)->withTrashed()->get();
      foreach ($multinotice as $key => $value) {
          $noticename = $value->name;
          $noticedesc = $value->description;
          $notice_content = NoticeContent::where('notice_group',$value->notice_group)->where('lang_code',$value->lang_code)->first();
          $eng_lang = Language::where('code',$value->lang_code)->first();

          $noticeDetails[]=['name' => $noticename , 'desc' =>$noticedesc ,'language' =>$eng_lang->lang.' - '.$value->lang_name , 'notice_content' => $notice_content ];

      }

    
      return view('notice/recycle/view_multilingual',compact('regions','branch','data','id','template','arr' ,'noticeDetails','languages','selected_languages','langarray','lang'));

}


}
