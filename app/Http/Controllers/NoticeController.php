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
     
        $data = Notice::where('lang_code','en')->paginate(50);
        $search = '';
        $lang = 'en';
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

    public function selct_template(){
        $data = Template::get();
        $languages = Language::get();
        return view('notice/choose_template',compact('data','languages'));
     }

     public function set_template(Request $request){
       print_r($request->input()); die();
     }


    public function create(Request $request)
    {
      //print_r($request->lang); die();
      $langarray=$request->lang ;
      $selected_lang_code = implode(',', $langarray);
      //print_r($langs); die();
      $template_id = $request->template_id;
      $regions = Region::all();
      $branch = Branch::select('state')->groupBy('state')->get();
      $template = Template::select('details')->where('id',$template_id)->first();
      $languages = Language::get();
      $selected_languages = Language::whereIn('code',$request->lang)->get();

     // print_r($lang); die();
      
      $data = $template->details ;

      $arr = json_decode($data);

     // return view('notice/create_ckeditor',compact('regions','branch','template','arr','template_id'));
       //return view('notice/ckeditor2',compact('regions','branch','template','arr','template_id'));
      // return view('notice/ckeditor/create_new_notice',compact('regions','branch','template','arr','template_id','languages'));
       return view('notice/ckeditor/create_multilingual_notice',compact('regions','branch','template','arr','template_id','languages','selected_languages','selected_lang_code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //print_r(($request->Input()) );die();
      
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
       
       foreach($request->notice as $key=>$value) {
       
        $current = date('Y-m-d_H_i_s');
        $filename = 'notice'.$request->template_id.'_'.$current.'.html';

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

         print_r($noticeContentID);
        $template = Template::select('details')->where('id',$request->template_id)->first();

       
        $content = NoticeContent::where('template_id',$request->template_id)->where('notice_id',$noticeID)->first();

        $data2 = $template->details ;
 
        $arr = json_decode($data2);

        if (file_exists(public_path().'/noticefiles')) {
              
        } else {
           
            File::makeDirectory(public_path().'/noticefiles', $mode = 0777, true, true);
        }

        $local_filename = $value['langauge'].'_notice'.$request->template_id.'_'.$current.'.html';

         $noticecontent = 
         File::put(public_path().'/noticefiles/'.$local_filename,
            view('htmltemplates.cktemp')
                ->with(["content" => $content , "arr" => $arr ,'template' => $template])
                ->render()
        );


       }

        
       }

      // die();


       return redirect()->route('notices');
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

      $current = date('Y-m-d_H_i_s');
      $filename = $request->lang.'_notice'.$request->template_id.'_'.$current.'.html';

      $notice = Notice::where('id',$request->id)->first();
      $filepath = public_path().'/noticefiles/'.$notice->filename;

       $update = Notice::where('id',$request->id)->update([
           'name' => $request->tittle ,
           'description' => $request->description ,
           'path' => 'noticefiles',
           'filename' => $filename,
           'is_pan_india'=> $request->is_pan_india ,
           'is_region_wise' => $region_prompt ,
           'regions' => $region_list ,
           'is_state_wise' => $state_prompt ,
           'states'=> $state_list ,
           'branch_code'=> $branchcodes ,
           'template_id'=>$request->template_id,
           'creator'=>Auth::user()->id ,
           'voiceover' => $request->voice_over
       ]);

       $noticeID = $request->id;

      // print_r($noticeID); die();

       if($noticeID != 0 AND $noticeID!=''){
       
        if (File::exists($filepath)) {
        //File::delete($image_path);
        unlink($filepath);
          //print_r("yes".$filepath);
        }
        else{
           print_r("no".$filepath);
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

        $local_filename = $request->lang.'_notice'.$request->template_id.'_'.$current.'.html';
        
       // print_r($local_filename);die();
         
         $noticecontent = 
         File::put(public_path().'/noticefiles/'.$local_filename,
            view('htmltemplates.cktemp')
                ->with(["content" => $content , "arr" => $arr ,'template' => $template])
                ->render()
        );

        }
        } 

        //die();

       return redirect()->route('notices');

       
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
        $filepath = public_path().'/noticefiles/'.$notice->filename;

        if (File::exists($filepath)) {
              unlink($filepath);
           }

        $delete = Notice::where('id', $id)->delete();

        if($delete){
          $delete_content = NoticeContent::where('notice_id',$id)->delete();
            return redirect()->route('notices');
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
       })
       ->paginate(50);
       
        $lang = $request->lang;
        $languages = Language::get();

       return view('notice/list', compact('data','search','languages','lang'));
    }

    public function filter(Request $request){
     // print_r($request->Input()); die();
       $data = Notice::where('lang_code',$request->lang)->paginate(50);
        $search = '';
        $lang = $request->lang;
        $languages = Language::get();

       return view('notice/list', compact('data','search','languages','lang'));
    }
}
