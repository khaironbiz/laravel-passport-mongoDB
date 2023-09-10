<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\admission;

class AdmissionController extends Controller
{
    public function index($id)
    {
        $admissions = admission::where('faskes_id', $id)->get();
        $data = [
            "title"         => "Admission List",
            "class"         => "Admission",
            "sub_class"     => "list",
            "content"       => "layout.admin",
            "admissions"    => $admissions,
        ];

        return view('user.admission.index', $data);
    }
}
