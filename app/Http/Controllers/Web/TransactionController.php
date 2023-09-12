<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Observation;
use Illuminate\Http\Request;

class TransactionController extends Controller

{
    public function index(){
        $bservation = Observation::orderBy('time', 'DESC')->paginate(100);
        $data = [
            "title"             => "Observation List",
            "class"             => "Observation",
            "sub_class"         => "Get All",
            "content"           => "layout.admin",
            "observation"       => $bservation,
        ];
        return view('admin.observation.vital-sign.index', $data);
    }
    public function petugas($id){
        $bservation = Observation::where('id_petugas', $id)->orderBy('time', 'DESC')->get();
        $data = [
            "title"             => "Observation List",
            "class"             => "Observation",
            "sub_class"         => "User",
            "content"           => "layout.admin",
            "observation"       => $bservation,
        ];
        return view('admin.observation.vital-sign.index', $data);
    }
}