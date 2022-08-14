<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\ClassSchedule;
use App\Models\ClassScheduleDetail;
use App\Models\RoomHistory;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClassScheduleController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $pageSize = $request->query('pageSize') ?? 3;

        $data = ClassSchedule::with('class','class.room', 'user')
            ->when($request->has("search"), function ($q) use ($request) {
                $term = strtolower($request->search);
                return $q->whereRaw('lower(name) like (?) ', ["%{$term}%"])
                    ->orWhereRaw('lower(slug) like (?) ', ["%{$term}%"])
                    ->orWhereRaw('lower(description) like (?) ', ["%{$term}%"]);
            })
            ->when($request->has("class_id"), function ($q) use ($request) {
                return $q->where('class_id', '=', $request->class_id);
            })
            ->when($request->has("start_date"), function ($q) use ($request) {
                return $q->where('created_at', '>=', $request->start_date);
            })
            ->when($request->has("end_date"), function ($q) use ($request) {
                return $q->where('created_at', '<=', $request->end_date);
            })
            ->orderBy('id', 'desc')
            ->skip(($page - 1) * $pageSize)
            ->take($pageSize)
            ->get();


        $total = ClassSchedule::when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(name) like (?) ', ["%{$term}%"])
                ->orWhereRaw('lower(slug) like (?) ', ["%{$term}%"])
                ->orWhereRaw('lower(description) like (?) ', ["%{$term}%"]);
        })
            ->when($request->has("class_id"), function ($q) use ($request) {
                return $q->where('class_id', '=', $request->class_id);
            })
            ->when($request->has("start_date"), function ($q) use ($request) {
                return $q->where('created_at', '>=', $request->start_date);
            })
            ->when($request->has("end_date"), function ($q) use ($request) {
                return $q->where('created_at', '<=', $request->end_date);
            })
            ->count();

        return response()->json([
            "total" => $total,
            "data" => $data,
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'days' => 'required',
            'class_id' => 'required',
            'endHour' => 'required',
            'startHour' => 'required',
        ]);

        // ClassSchedule

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $class = ClassRoom::find($request->class_id);

        RoomHistory::create([
            'start_date' => $class->start_date,
            'end_date' => $class->end_date,
            'days' => implode(",", $request->days),
            'start_hour' => $request->startHour,
            'end_hour' => $request->endHour,
            'room_id' => $request->room_id,
        ]);

        $shedule = ClassSchedule::create([
            'start_date' => $class->start_date,
            'end_date' => $class->end_date,
            'days' => implode(",", $request->days),
            'start_hour' => $request->startHour,
            'end_hour' => $request->endHour,
            'class_id' => $request->class_id,
            'user_id' => Auth::user()->id ?? 1,
            'note' => ''
        ]);



        $dates = $this->getDatesFromRange($class->start_date, $class->end_date);

        foreach ($dates as $date) {
            ClassScheduleDetail::create([
                "start_date" => $date . " " . $request->startHour,
                "end_date" => $date . " " . $request->endHour,
                "schedule_id" => $shedule->id
            ]);
        }

        $class->teacher_id = $request->teacher_id;
        $class->room_id = $request->room_id;
        $class->save();

        return response()->json([
            "start_date" => $class->start_date,
            "end_date" => $class->end_date,
            "data" =>  $dates
        ]);
    }

    public function show($id)
    {
        $model = ClassSchedule::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($model);
    }

    public function update($id, Request $request)
    {
        $model = ClassSchedule::find($id);
        $model->date = $request->date;
        $model->note = $request->note;
        $model['user_id'] = Auth::user()->id ?? 1;
        $model->save();
        return response()->json(["message" => "Cập nhật thành công"]);
    }

    public function destroy($id)
    {
        $model = ClassSchedule::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá chiến dịch thành công",
        ]);
    }

    private function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {

        $array = array();
        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
        foreach ($period as $date) {
            $array[] = $date->format($format);
        }
        array_pop($array);
        return $array;
    }
}
