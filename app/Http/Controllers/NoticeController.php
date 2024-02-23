<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Template;
use App\Models\NoticeContent;
use App\Models\Language;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use File;

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
      $data = Notice::where('lang_code',$request->lang)->orderBy('id','DESC')->paginate(25);
        $search = '';
        $lang = $request->lang;
        $languages = Language::get();
     
        
       return view('notice/list', compact('data','search','languages','lang'));
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
     // print_r(($request->Input()) );die();
      
     //  print_r(json_encode($request->input()) ); die();
       
       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
       }
       else if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);


       }
       else{
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
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
         $notice->states = $state_list ;
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


         $notice->save();

         $noticeID = $notice->id;

         //print_r($noticeID);

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

         $noticecontent = 
         File::put(public_path().'/noticefiles/'.$local_filename,
            view('htmltemplates.cktemp')
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

      // die();


       return redirect()->route('notices',$request->dropdown_lang);
    }

    public function add_notices(Request $request){
       //print_r($request->Input()); die();
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
            view('htmltemplates.cktemp')
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

        $template = Template::select('details')->where('id',$data->template_id)->first();

       // print_r($data->template_id); die();
        $content = NoticeContent::where('template_id',$data->template_id)->where('notice_id',$data->id)->first();

        //print_r(json_encode($content)); die();
        $data2 = $template->details ;
 
        $arr = json_decode($data2);

        //return view('notice/edit',compact('data','id','template','arr' ,'content'));
        return view('notice/ckeditor/edit',compact('data','id','template','arr' ,'content'));
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

          $noticeDetails[]=['name' => $noticename , 'desc' =>$noticedesc ,'language' => $value->lang_name , 'notice_content' => $notice_content ];

      }

     // print_r(json_encode($noticeDetails)); die();

   
      return view('notice/ckeditor/edit_multilingual',compact('regions','branch','data','id','template','arr' ,'noticeDetails','languages','selected_languages','langarray','lang'));

    }

    public function update_multilang_notice(Request $request){
     // print_r($request->Input() ) ; die();

      $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
       }
       else if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);


       }
       else{
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }

      /*$current = date('Y-m-d_H_i_s');
      $filename = 'notice'.$request->template_id.'_'.$current.'.html';*/

      $notice = Notice::where('notice_group',$request->notice_group)->first();
     
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
           'version' => $request->version
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
                
               
                $version = $request->version;
                $published = $request->publish_date;

                 $noticecontent = 
                 File::put(public_path().'/noticefiles/'.$local_filename,
                    view('htmltemplates.cktemp')
                        ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data' => $qrcode_data , 'lang_code' => $langaugedata->code])
                        ->render()
                );

                 File::put(public_path().'/noticefilesforweb/'.$local_filename,
                    view('htmltemplates.cktempforweb')
                        ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published ,'qrcode_data'=> $qrcode_data , 'lang_code' => $langaugedata->code ])
                        ->render()
                ); 

                 // print_r($local_filename);die();
                 

             }




        }

       }

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
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
       }
       else if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);


       }
       else{
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }

      /*$current = date('Y-m-d_H_i_s');
      $filename = 'notice'.$request->template_id.'_'.$current.'.html';*/

      $notice = Notice::where('id',$request->id)->first();
      $filepath = public_path().'/noticefiles/'.$request->lang.'_'.$notice->filename;

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
           'version' => $request->version
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

       
        $content = NoticeContent::where('template_id',$request->template_id)->where('notice_id',$request->id)->first();

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
         
        $version = $request->version;
        $published = $request->publish_date;

         $noticecontent = 
         File::put(public_path().'/noticefiles/'.$local_filename,
            view('htmltemplates.cktemp')
                ->with(["content" => $content , "arr" => $arr ,'template' => $template , 'version' => $version , 'published' => $published , 'qrcode_data' => $qrcode_data])
                ->render()
        );

        }

        } 

        //die();

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

      //  print_r($lang); die();
        $filepath = public_path().'/noticefiles/'.$notice->filename;

        if (File::exists($filepath)) {
              unlink($filepath);
           }

        $delete = Notice::where('id', $id)->delete();

        if($delete){
          $delete_content = NoticeContent::where('notice_id',$id)->delete();
          $group_notices=Notice::where('notice_group',$groupID)->get();

          foreach ($group_notices as $key => $value) {
             $languages = $value->available_languages;

             $langArray = explode(',', $languages);
             $updatedArray = array_diff($langArray, [$lang]);

             $new_languages = implode(',', $updatedArray);

             $update = Notice::where('notice_group',$groupID)->update(['available_languages' => $new_languages ]);
          }
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
       $data = Notice::where('lang_code',$request->lang)
       ->where(function($query)use($search){
         $query->where('name','LIKE','%'.$search.'%');
         $query->orWhere('description','LIKE','%'.$search.'%');
         $query->orWhere('document_id','LIKE','%'.$search.'%');
         $query->orWhere('notice_type','LIKE','%'.$search.'%');
       })
       ->orderBy('id', 'DESC')
       ->paginate(25)->withQueryString();
       
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
      $imageFiles = $_FILES['notice'];

     

       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
       }
       else if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);


       }
       else{
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
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

       }

        return redirect()->route('notices',$request->dropdown_lang);
    }

    public function add_rbi_notice(Request $request){
     // print_r($request->Input()); die();
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

       }
       $update = Notice::where('notice_group',$noticedetails->notice_group)->update(['available_languages'=> $langs.','.$new_langs]);
        return redirect()->route('notices',$request->dropdown_lang);
    }

     public function edit_rbi_notice($id){
        $data = Notice::where('id',$id)->first();

        return view('notice/ckeditor/edit_rbi',compact('data','id'));
    }

  
    public function update_rbi_notice(Request $request){
     // print_r($request->Input()); die();

       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
       }
       else if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);


       }
       else{
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }

      $notice = Notice::where('id',$request->id)->first();
      $filepath = public_path().'/noticefiles/'.$request->lang.'_'.$notice->filename;

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
           'version'=> $request->version

         
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
      $imageFiles = $_FILES['notice'];

      foreach ($request->notice as $key => $value) {

       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';
      
       if($request->is_pan_india == 'Yes'){
           $region_list = '';
           $state_list = '';
       }
       else if(isset($request->regions)){
           $region_prompt = '1';
           $region_list = implode(',' , $request->regions);


       }
       else{
           $state_prompt = 'ya';

           $state_list = implode(',' , $request->states);
       }

      $notice = Notice::where('id',$value['id'])->first();
      $filepath = public_path().'/noticefiles/'.$value['langauge'].'_'.$notice->filename;

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
           'version'=> $request->version

         
       ]);

       $noticeID = $value['id'];


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
     
      return redirect()->route('notices',$request->default_lang);

    }

    public function modify_status($id){
      //print_r($id); die();

      $noticedata = Notice::where('id',$id)->first();
      $status = $noticedata->status ;

      if($status == 'Published'){
        $update = Notice::where('id',$id)->update(['status' => 'Draft']);
      }
      else {
        $update = Notice::where('id',$id)->update(['status' => 'Published']);
      }

      if($update){
        return redirect()->back();
      }

    }

    public function AllNotices(Request $request){

      $data = Notice::where('lang_code',$request->lang)
              ->where('status','Published')
              ->orderBy('id','DESC')->paginate(25);
      $lang = $request->lang;
      $languages = Language::get();
      $search = '';
       
      return view('notice/allnotices', compact('data','languages','lang' ,'search'));
    }

    public function search_public_notice($lang,$id){
       $data = Notice::where('id',$id)->first();
       $url =  url('/').'/noticefiles/'.$lang.'_'.$data->filename ; 

       return redirect()->to($url);

    }
}
