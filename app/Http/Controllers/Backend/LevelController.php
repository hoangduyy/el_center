<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogPostRequest;
use App\Http\Requests\Backend\TeacherRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Certificate;
use App\Models\Degree;
use App\Models\Level;
use App\Models\Teacher;
use App\Models\TeacherCertificate;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LevelController extends Controller
{
    public function index()
    {
        $list = Level::orderBy('id', 'desc')->get();
        return view('backend.level.index', compact('list'));
    }
}
