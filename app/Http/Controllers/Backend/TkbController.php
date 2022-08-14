<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogPostRequest;
use App\Http\Requests\Backend\ClassRequest;
use App\Http\Requests\Backend\ManagerRequest;
use App\Http\Requests\Backend\TeacherRequest;
use App\Models\Admin;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Certificate;
use App\Models\ClassRoom;
use App\Models\ClassSchedule;
use App\Models\ClassScheduleDetail;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Level;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\TeacherCertificate;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TkbController extends Controller
{
    public function index()
    {
        $list = ClassSchedule::orderBy('id', 'desc');

        $class = ClassRoom::all();
        $teacher = Teacher::all();
        $room = Room::all();

        if (request('class_id')) {
            $list->where('class_id', request('class_id'));
        }

        if (request('room_id')) {
            $list->where('room_id', request('room_id'));
        }

        if (request('teacher_id')) {
            $list->where('teacher_id', request('teacher_id'));
        }

        $list = $list->paginate(getConst('BE_PER_PAGE'));

        return view('backend.tkb.index', compact('list', 'class', 'teacher', 'room'));
    }

    public function create()
    {
        $class = ClassRoom::all();
        $teacher = Teacher::all();
        $room = Room::all();
        return view('backend.tkb.create', compact('class', 'teacher', 'room'));
    }

    public function edit()
    {
        return view('backend.tkb.edit');
    }

    public function store()
    {
        DB::beginTransaction();

//        $tkb = ClassSchedule::whereClassId(request('class_id'))->whereRoomId(request('room_id'))
//            ->whereTimeId(request('time_id'))->get();//->first();
//
//        foreach ($tkb as $item) {
//            $day = $item->details()->pluck('day_id')->toArray('day_id');
//            foreach (request('day_id') as $item2) {
//                if (in_array($item2, $day)) {
//                    return redirect()->back()->withInput(request()->all())->with('notification_error', 'Thời khóa biểu đã tồn tại');
//                }
//            }
//        }

        $tkb = ClassSchedule::whereClassId(request('class_id'))->first();
        if (!empty($tkb)) {
            return redirect()->back()->withInput(request()->all())->with('notification_error', 'Thời khóa biểu cho lớp học đã tồn tại');
        }

        try {
            $tkb = new ClassSchedule();
            $tkb->class_id = request('class_id');
            $tkb->teacher_id = request('teacher_id');
            $tkb->room_id = request('room_id');
            $tkb->time_id = request('time_id');
            $tkb->save();

            foreach (request('day_id') as $day) {
                ClassScheduleDetail::create(
                    [
                        'schedule_id' => $tkb->id,
                        'day_id' => $day
                    ]
                );
            }

            DB::commit();
            return redirect()->route('be.tkb.index')->with('notification_success', 'Thành công');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
        }

        return redirect()->back()->with('notification_error', 'Lỗi hệ thống');
    }

    public function destroy($id)
    {
        $model = ClassSchedule::findOrFail($id);
        $model->delete();
        ClassScheduleDetail::where('schedule_id', $id)->delete();
        return redirect()->back()->with('notification_success', 'Thành công');
    }
}
