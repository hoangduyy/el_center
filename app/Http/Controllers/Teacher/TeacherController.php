<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherRequest;
use App\Models\Certificate;
use App\Models\ClassRoom;
use App\Models\ClassSchedule;
use App\Models\Degree;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\TeacherCertificate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function profile()
    {
        $data = tGuard()->user();
        $listChungChi = TeacherCertificate::whereTeacherId($data->id)->pluck('certificate_id')->toArray();
        $certificate = Certificate::whereIn('id', $listChungChi)->pluck('name')->toArray();
        return view('teacher.profile', compact('data', 'certificate'));
    }

    public function edit()
    {
        $data = tGuard()->user();
        $degree = Degree::all();
        $listCertificate = Certificate::all();
        $teacherCertificate = TeacherCertificate::whereTeacherId($data->id)->pluck('certificate_id')->toArray();
        return view('teacher.edit', compact('data', 'degree', 'listCertificate', 'teacherCertificate'));
    }

    public function update(TeacherRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = tGuard()->user();
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

            return redirect()->route('t.profile')->with('notification_success', 'Thành công');
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->back()->with('notification_error', 'Lỗi hệ thống');
    }

    public function getTKB()
    {
        $list = ClassSchedule::orderBy('id', 'desc')->where('teacher_id', tE()->id);

        $class = ClassRoom::all();
        $teacher = Teacher::all();
        $room = Room::all();

        $list = $list->paginate(getConst('BE_PER_PAGE'));

        return view('teacher.tkb.index', compact('list', 'class', 'teacher', 'room'));
    }
}
