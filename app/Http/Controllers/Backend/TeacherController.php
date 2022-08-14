<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogPostRequest;
use App\Http\Requests\Backend\TeacherRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Certificate;
use App\Models\Degree;
use App\Models\Teacher;
use App\Models\TeacherCertificate;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function index()
    {
        $list = Teacher::orderBy('id', 'desc');

        if (request('id')) {
            $list->where('id', request('id'));
        }
        if (request('email')) {
            $list->where('email', 'like', '%' . request('email') . '%');
        }
        if (request('phone')) {
            $list->where('phone', 'like', '%' . request('phone') . '%');
        }

        $list = $list->paginate(getConst('BE_PER_PAGE'));

        return view('backend.teacher.index', compact('list'));
    }

    public function create()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }
        $degree = Degree::all();
        $certificate = Certificate::all();
        return view('backend.teacher.create', compact(['degree', 'certificate']));
    }

    public function store(TeacherRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = new Teacher();
            $data->fill(request()->all());
            $data->save();

            foreach (request('certificate_id') as $i) {
                TeacherCertificate::create([
                    'teacher_id' => $data->id,
                    'certificate_id' => $i
                ]);
            }

            DB::commit();
            return redirect()->route('be.teacher.index')->with('notification_success', 'Thành công');
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->back()->with('notification_error', 'Lỗi hệ thống');
    }

    public function edit($id)
    {
        $data = Teacher::with('teacherCertificate')->findOrFail($id);
        $teacherCertificate = TeacherCertificate::where('teacher_id', $id)->pluck('certificate_id')->toArray();
        $degree = Degree::all();
        $certificate = Certificate::all();
        return view('backend.teacher.edit', compact(['data', 'degree', 'certificate', 'teacherCertificate']));
    }

    public function update($id, TeacherRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = Teacher::findOrFail($id);
            $data->fill(request()->all());
            $data->save();

            TeacherCertificate::where('teacher_id', $data->id)->delete();

            foreach (request('certificate_id') as $i) {
                TeacherCertificate::create([
                    'teacher_id' => $data->id,
                    'certificate_id' => $i
                ]);
            }

            DB::commit();

            return redirect()->route('be.teacher.index')->with('notification_success', 'Thành công');
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->back()->with('notification_error', 'Lỗi hệ thống');
    }

    public function destroy($id)
    {
        $model = Teacher::findOrFail($id);
        $model->delete();
        TeacherCertificate::where('teacher_id', $id)->delete();
        return redirect()->back()->with('notification_success', 'Thành công');
    }
}
