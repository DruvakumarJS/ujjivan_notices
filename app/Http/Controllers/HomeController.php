<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Notice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $branches_data = Devices::select('branch_code')->groupBy('branch_code')->get();
        $branch = $branches_data->count();

        $bank_data = Devices::get();
        $bank = $bank_data->count();

        $active_data = Devices::where('status' , 'Active')->get();
        $active = $active_data->count();

        $inactive_data = Devices::where('status' , 'In-Active')->get();
        $inactive = $inactive_data->count();

        $maintainance_data = Devices::where('status','Under-Maintanance')->get();
        $maintainace = $maintainance_data->count();

        $notice_data = Notice::get();
        $notice = $notice_data->count();

       

        return view('home',compact('branch' ,'bank','active','inactive','maintainace','notice'));
    }
}
