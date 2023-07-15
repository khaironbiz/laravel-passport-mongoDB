<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        $id_user        = "64ab60837fb2f5709001bbe2";
        $user           = User::find($id_user);
        $observation    = Observation::where('id_pasien', $id_user)->orderBy('time', 'DESC');
        $data = [
            "title"         => "Profile",
            "class"         => "user",
            "sub_class"     => "profile",
            "content"       => "layout.admin",
            "user"          => $user,
            "observation"   => $observation->get()
        ];
        return view('admin.profile.profile', $data);
    }
}