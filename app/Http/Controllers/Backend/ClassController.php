<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogPostRequest;
use App\Http\Requests\Backend\ClassRequest;
use App\Http\Requests\Backend\TeacherRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Certificate;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Level;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\TeacherCertificate;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    public function index()
    {
        $course = Course::all();
        $list = ClassRoom::orderBy('id', 'desc');

        if (request('id')) {
            $list->where('id', request('id'));
        }

        if (request('title')) {
            $list->where('title', 'like', '%' . request('title') . '%');
        }

        if (request('course_id')) {
            $list->where('course_id', '=', request('course_id'));
        }

        $list = $list->paginate(getConst('BE_PER_PAGE'));

        return view('backend.class.index', compact('list', 'course'));
    }

    public function create()
    {
        $course = Course::all();
        $rooms = Room::all();
        return view('backend.class.create', compact('course', 'rooms'));
    }

    public function store(ClassRequest $request)
    {
        $params = request()->all();

        if (request()->hasFile('thumbnail')) {
            $fileName = time() . "_" . request()->file('thumbnail')->getClientOriginalName();
            $pathTmp = 'backend/upload/class';
            $uploadPath = public_path($pathTmp); // Folder upload path

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            request()->file('thumbnail')->move($uploadPath, $fileName);
            $params['thumbnail'] = $pathTmp . '/' . $fileName;
        }

        $params['slug'] = Str::slug(request('title'));
        $data = new ClassRoom();
        $data->fill($params);
        $data->save();
        return redirect()->route('be.class.index')->with('notification_success', 'Thành công');
    }

    public function edit($id)
    {
        $data = ClassRoom::findOrFail($id);
        $course = Course::all();
        $rooms = Room::all();
        return view('backend.class.edit', compact(['data', 'course', 'rooms']));
    }

    public function update(ClassRequest $request, $id)
    {
        $params = request()->all();

        if (request()->hasFile('thumbnail')) {
            $fileName = time() . "_" . request()->file('thumbnail')->getClientOriginalName();
            $pathTmp = 'backend/upload/class';
            $uploadPath = public_path($pathTmp); // Folder upload path

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            request()->file('thumbnail')->move($uploadPath, $fileName);
            $params['thumbnail'] = $pathTmp . '/' . $fileName;
        }

        $params['slug'] = Str::slug(request('title'));
        $data = ClassRoom::findOrFail($id);
        $data->fill($params);
        $data->save();

        return redirect()->route('be.class.index')->with('notification_success', 'Thành công');
    }

    public function destroy($id)
    {
        $model = ClassRoom::findOrFail($id);
        $model->delete();
        return redirect()->back()->with('notification_success', 'Thành công');
    }
}
