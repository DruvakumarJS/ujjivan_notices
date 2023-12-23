<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Template;
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
       print_r($request->input()); 

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


       $save = Notice::create([
           'name' => $request->tittle ,
           'description' => $request->description ,
           'path' => 'notices',
           'filename' => 'notice1',
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
       ]);

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
        return view('notice/view_more',compact('data','id'));
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
        return view('notice/edit',compact('data','id'));
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
