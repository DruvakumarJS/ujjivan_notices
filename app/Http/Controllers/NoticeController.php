<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Template;
use App\Models\NoticeContent;
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
    public function index()
    {
        $data = Notice::paginate(50);
        $search = '';

        /*File::put('test.html',
            view('htmltemplates.html_notices')
                ->with(["data" => $data , "search" => 'search'])
                ->render()
        );*/

       return view('notice/list', compact('data','search'));
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
        return view('notice/choose_template',compact('data'));
     }

     public function set_template(Request $request){
       print_r($request->input()); die();
     }


    public function create(Request $request)
    {
     // print_r($request->template_id); die();
      $template_id = $request->template_id;
      $regions = Region::all();
      $branch = Branch::select('state')->groupBy('state')->get();
      $template = Template::select('details')->where('id',$template_id)->first();
      
      $data = $template->details ;

      $arr = json_decode($data);

      return view('notice/create_ckeditor',compact('regions','branch','template','arr','template_id'));
       //return view('notice/ckeditor2',compact('regions','branch','template','arr','template_id'));
      // return view('notice/create_new_notice',compact('regions','branch','template','arr','template_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($file = $request->hasFile('row2_1')) {
       
            $fileName = basename($_FILES['row2_1']['name']); 
            $temp = explode(".", $fileName);
                 
            $fileName21 = 'Notice21_'.date('Y-m-d_H_i_s') . '.' . end($temp);

            $destinationPath = public_path().'/noticeimages/'.$fileName21 ;
           
            move_uploaded_file($_FILES["row2_1"]["tmp_name"], $destinationPath);

        }

        if($file = $request->hasFile('row2_2')) {
       
            $fileName = basename($_FILES['row2_2']['name']); 
            $temp = explode(".", $fileName);
                 
            $fileName22 = 'Notice22_'.date('Y-m-d_H_i_s') . '.' . end($temp);

            $destinationPath = public_path().'/noticeimages/'.$fileName22 ;
           
            move_uploaded_file($_FILES["row2_2"]["tmp_name"], $destinationPath);

        }

        if($file = $request->hasFile('row3_2')) {
       
            $fileName = basename($_FILES['row3_2']['name']); 
            $temp = explode(".", $fileName);
                 
            $fileName32 = 'Notice32_'.date('Y-m-d_H_i_s') . '.' . end($temp);

            $destinationPath = public_path().'/noticeimages/'.$fileName32 ;
           
            move_uploaded_file($_FILES["row3_2"]["tmp_name"], $destinationPath);

        }

        if($file = $request->hasFile('row4_1')) {
       
            $fileName = basename($_FILES['row4_1']['name']); 
            $temp = explode(".", $fileName);
                 
            $fileName41 = 'Notice41_'.date('Y-m-d_H_i_s') . '.' . end($temp);

            $destinationPath = public_path().'/noticeimages/'.$fileName41 ;
           
            move_uploaded_file($_FILES["row4_1"]["tmp_name"], $destinationPath);

        }

     //  print_r(json_encode($request->input()) ); die();

       $region_prompt = '0';
       $state_prompt = 'na';

       $region_list = '';
       $state_list = '';
       $branchcodes = '';
       $languages = implode(',' , $request->lang);

      

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

       // print_r($state_list); die();


       /*$save = Notice::create([
           'name' => $request->tittle ,
           'description' => $request->description ,
           'path' => 'notices',
           'filename' => '',
           'is_pan_india'=> $request->is_pan_india ,
           'is_region_wise' => $region_prompt ,
           'regions' => $region_list ,
           'is_state_wise' => $state_prompt ,
           'states'=> $state_list ,
           'branch_code'=> $branchcodes ,
           'status'=> 'Draft',
           'available_languages'=> $languages ,
           'template_id'=>'0',
           'creator'=>Auth::user()->id ,
           'voiceover' => $request->voice_over
       ]);*/
      
      $current = date('Y-m-d_H_i_s');
      $filename = 'notice'.$request->template_id.'_'.$current.'.html';

       $notice = new Notice;
       $notice->name = $request->tittle ;
       $notice->description = $request->description ;
       $notice->path = 'noticefiles';
       $notice->filename = $filename;
       $notice->is_pan_india = $request->is_pan_india ;
       $notice->is_region_wise = $region_prompt ;
       $notice->regions = $region_list ;
       $notice->is_state_wise = $state_prompt ;
       $notice->states = $state_list ;
       $notice->branch_code = $branchcodes ;
       $notice->status = 'Draft';
       $notice->available_languages = $languages ;
       $notice->template_id = $request->template_id;
       $notice->creator = Auth::user()->id ;
       $notice->voiceover = $request->voice_over;

       $notice->save();

       $noticeID = $notice->id;

       if($noticeID != 0 AND $noticeID!=''){
         $content = new NoticeContent;
         $content->notice_id = $noticeID ;
         $content->template_id = $request->template_id;

         if($file = $request->hasFile('row1_1'))$content->c11 = $fileName11;else $content->c11 = $request->row1_1;
         if($file = $request->hasFile('row1_2'))$content->c12 = $fileName12;else $content->c12 = $request->row1_2;
         if($file = $request->hasFile('row1_3'))$content->c13 = $fileName13;else $content->c13 = $request->row1_3;
         if($file = $request->hasFile('row1_4'))$content->c14 = $fileName14;else $content->c14 = $request->row1_4;
         
         if($file = $request->hasFile('row2_1'))$content->c21 = $fileName21;else $content->c21 = $request->row2_1;
         if($file = $request->hasFile('row2_2'))$content->c22 = $fileName22;else $content->c22 = $request->row2_2;
         if($file = $request->hasFile('row2_3'))$content->c23 = $fileName23;else $content->c23 = $request->row2_3;
         if($file = $request->hasFile('row2_4'))$content->c24 = $fileName24;else $content->c24 = $request->row2_4;

         if($file = $request->hasFile('row3_1'))$content->c31 = $fileName31;else $content->c31 = $request->row3_1;
         if($file = $request->hasFile('row3_2'))$content->c32 = $fileName32;else $content->c32 = $request->row3_2;
         if($file = $request->hasFile('row3_3'))$content->c33 = $fileName33;else $content->c33 = $request->row3_3;
         if($file = $request->hasFile('row3_4'))$content->c34 = $fileName34;else $content->c34 = $request->row3_4;

         if($file = $request->hasFile('row4_1'))$content->c41 = $fileName41;else $content->c41 = $request->row4_1;
         if($file = $request->hasFile('row4_2'))$content->c42 = $fileName42;else $content->c42 = $request->row4_2;
         if($file = $request->hasFile('row4_3'))$content->c43 = $fileName43;else $content->c43 = $request->row4_3;
         if($file = $request->hasFile('row4_4'))$content->c44 = $fileName44;else $content->c44 = $request->row4_4;

         if($file = $request->hasFile('row5_1'))$content->c51 = $fileName51;else $content->c51 = $request->row5_1;
         if($file = $request->hasFile('row5_2'))$content->c52 = $fileName52;else $content->c52 = $request->row5_2;
         if($file = $request->hasFile('row5_3'))$content->c53 = $fileName53;else $content->c53 = $request->row5_3;
         if($file = $request->hasFile('row5_4'))$content->c54 = $fileName54;else $content->c54 = $request->row5_4;

         if($file = $request->hasFile('row6_1'))$content->c61 = $fileName61;else $content->c61 = $request->row6_1;
         if($file = $request->hasFile('row6_2'))$content->c62 = $fileName62;else $content->c62 = $request->row6_2;
         if($file = $request->hasFile('row6_3'))$content->c63 = $fileName63;else $content->c63 = $request->row6_3;
         if($file = $request->hasFile('row6_4'))$content->c64 = $fileName64;else $content->c64 = $request->row6_4;
         
        
         /*$content->c31 = $request->row3_1;
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
         */
         $content->save();
         $noticeContentID = $content->id;

         
        $template = Template::select('details')->where('id',$request->template_id)->first();

       
        $content = NoticeContent::where('template_id',$request->template_id)->where('notice_id',$noticeID)->first();

        //print_r(json_encode($content)); die();
        $data2 = $template->details ;
 
        $arr = json_decode($data2);

        if (file_exists(public_path().'/noticefiles/')) {
              
        } else {
           
            File::makeDirectory(public_path().'/noticefiles/', $mode = 0777, true, true);
        }

        $lang = 'en';

        $local_filename = $lang.'_notice'.$request->template_id.'_'.$current.'.html';

         
         $noticecontent = 
         File::put(public_path().'/noticefiles/'.$local_filename,
            view('htmltemplates.temp')
                ->with(["content" => $content , "arr" => $arr ,'template' => $template])
                ->render()
        );

        // print_r($noticeContentID); die();

       }
       // print_r(json_encode($request->input()) ); die();

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

        return view('notice/view_more',compact('data','id','template' ,'content','arr'));
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

        return view('notice/edit',compact('data','id','template','arr' ,'content'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Notice::where('id', $id)->delete();

        if($delete){
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
}
