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
    public function create()
    {
      $regions = Region::all();
      $branch = Branch::select('state')->groupBy('state')->get();
      $template = Template::select('details')->where('id','4')->first();

      $data = $template->details ;

      $arr = json_decode($data);


      //print_r($arr); die();


        return view('notice/create',compact('regions','branch','template','arr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // print_r(json_encode($request->input()) ); die();

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

      $filename = 'template'.$request->template_id.'.html';

       $notice = new Notice;
       $notice->name = $request->tittle ;
       $notice->description = $request->description ;
       $notice->path = 'notices';
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

       
        $content = NoticeContent::where('template_id',$request->template_id)->where('notice_id',$noticeID)->first();

        //print_r(json_encode($content)); die();
        $data2 = $template->details ;
 
        $arr = json_decode($data2);



         
         $noticecontent = 
         File::put($filename,
            view('htmltemplates.temp')
                ->with(["content" => $content , "arr" => $arr ,'template' => $template])
                ->render()
        );

        // print_r($noticeContentID); die();

       }

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
}
