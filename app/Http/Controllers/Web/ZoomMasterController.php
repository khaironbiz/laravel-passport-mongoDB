<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\ZoomMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZoomMasterController extends Controller
{
    public function index()
    {
        $zoomMaster = ZoomMaster::all();
        $data = [
            "title"         => "Master Zoom",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "zoom_masters"  => $zoomMaster
        ];

        return view('user.zoom_master.index', $data);
    }
    public function create()
    {
        $zoomMaster = ZoomMaster::all();
        $data = [
            "title"         => "Master Zoom",
            "class"         => "Marital Status",
            "sub_class"     => "Get All",
            "content"       => "layout.admin",
            "zoom_master"   => $zoomMaster
        ];

        return view('user.zoom_master.create', $data);
    }
    public function store(Request $request)
    {
        $zoom_master = new ZoomMaster();
        $data_post = $request->all();
        $data_post['creator']=Auth::id();
        $create = $zoom_master->create($data_post);
        if($create){
            session()->flash('success', 'Master Zoom Telah Dibuat');
            return redirect()->route('zoom.master.index');
        }
    }

}
