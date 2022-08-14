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

class CourseController extends Controller
{
    public function index()
    {
        if (isManager()) {
            return redirect()->route('be.dashboard');
        }

        $list = Course::orderBy('id', 'desc');

        if (request('id')) {
            $list->where('id', request('id'));
        }

        if (request('title')) {
            $list->where('title', 'like', '%' . request('title') . '%');
        }

        $list = $list->paginate(getConst('BE_PER_PAGE'));

        return view('backend.course.index', compact('list'));
    }

    public function create()
    {
        if (isManager()) {
            return redirect()->route('be.dashboard');
        }

        $level = Level::all();
        return view('backend.course.create', compact(['level']));
    }

    public function store()
    {
        $params = request()->all();

        if (request()->hasFile('thumbnail')) {
            $fileName = time() . "_" . request()->file('thumbnail')->getClientOriginalName();
            $pathTmp = 'backend/upload/course';
            $uploadPath = public_path($pathTmp); // Folder upload path

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            request()->file('thumbnail')->move($uploadPath, $fileName);
            $params['thumbnail'] = $pathTmp . '/' . $fileName;
        }

        $params['slug'] = Str::slug(request('title'));
        $params['user_id'] = bE()->id;
        $data = new Course();
        $data->fill($params);
        $data->save();
        return redirect()->route('be.course.index')->with('notification_success', 'Thành công');
    }

    public function edit($id)
    {
        if (isManager()) {
            return redirect()->route('be.dashboard');
        }

        $data = Course::findOrFail($id);
        $level = Level::all();
        return view('backend.course.edit', compact(['data', 'level']));
    }

    public function update($id)
    {
        $params = request()->all();
        $params['user_id'] = bE()->id;

        if (request()->hasFile('thumbnail')) {
            $fileName = time() . "_" . request()->file('thumbnail')->getClientOriginalName();
            $pathTmp = 'backend/upload/course';
            $uploadPath = public_path($pathTmp); // Folder upload path

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            request()->file('thumbnail')->move($uploadPath, $fileName);
            $params['thumbnail'] = $pathTmp . '/' . $fileName;
        }

        $params['slug'] = Str::slug(request('title'));
        $data = Course::findOrFail($id);
        $data->fill($params);
        $data->save();

        return redirect()->route('be.course.index')->with('notification_success', 'Thành công');
    }

    public function destroy($id)
    {
        $model = Course::findOrFail($id);
        $model->delete();
        return redirect()->back()->with('notification_success', 'Thành công');
    }
}
