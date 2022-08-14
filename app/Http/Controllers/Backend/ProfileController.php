<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogPostRequest;
use App\Http\Requests\Backend\TeacherRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Level;
use App\Models\Teacher;
use App\Models\TeacherCertificate;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function profile()
    {
        if (isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        $data = bE();

        return view('backend.profile.index', compact('data'));
    }

    public function edit()
    {
        if (isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        $data = bE();
        return view('backend.profile.edit', compact('data'));
    }

    public function update()
    {
        $data = bE();
        $data->name = request('name');
        if (request('password')) {
            $data->password = bcrypt(request('password'));
        }
        $data->save();
        return redirect()->route('be.profile')->with('notification_success', 'Thành công');
    }
}
