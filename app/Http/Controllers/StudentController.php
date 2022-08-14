<?php

namespace App\Http\Controllers;

use App\Http\Requests\Frontend\AuthRequest;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Profile;
use App\Models\Question;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $pageSize = $request->query('pageSize') ?? 3;

        $data = User::with("profile")
            ->where('role','student')->when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(name) like (?) ', ["%{$term}%"])
                     ->orWhereRaw('lower(email) like (?) ', ["%{$term}%"])
                    ;
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


        $total = User::where('role','student')->when($request->has("search"), function ($q) use ($request) {
            $term = strtolower($request->search);
            return $q->whereRaw('lower(name) like (?) ', ["%{$term}%"])
                     ->orWhereRaw('lower(email) like (?) ', ["%{$term}%"])
                    ;
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
            'email' => 'required|unique:users',
            'fullName' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $customer = User::create([
            "name" => $request->name,
            "email" =>  $request->email,
            "role" =>  "student",
            'password' =>  $request->password ? Hash::make($request->password) : Hash::make($request->phone),
        ]);

        Profile::create([
            "user_id" => $customer->id,
            "name" => $request->fullName,
            "avatar" => $request->avatar,
            "address" => $request->address,
            "birthday" => $request->birthday,
            "gender" => $request->gender,
            "phone" => $request->phone,
            "facebook" => $request->facebook,
        ]);

        return response()->json([
            "message" => "Thêm mới thành công",
        ]);
    }

    public function show($id)
    {
        $model = User::with('profile')
        ->where('role','student')
        ->where('id',$id)
        ->first();
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($model);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'fullName' => 'required',
        ]);
        $model = User::find($id);
        $model->name = $request->name;
        if($model->email != $request->email){
            $validator = Validator::make($request->all(), [
                'email' => 'unique:users'
            ]);

        }
        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }
        $model->email = $request->email;

        if($request->password){
            $model->password = Hash::make($request->password);
        }
        $model->save();
        $profile = Profile::where('user_id', $model->id)->first();
        $profile->name = $request->fullName;
        $profile->avatar = $request->avatar;
        $profile->address = $request->address;
        $profile->birthday = $request->birthday;
        $profile->gender = $request->gender;
        $profile->phone = $request->phone;
        $profile->facebook = $request->facebook;
        $profile->save();
        return response()->json(["message" => "Cập nhật thành công"]);
    }

    public function destroy($id)
    {
        $model = User::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá khách hàng thành công",
        ]);
    }

    public function getSchedule(Request $request)
    {
        $userId = Auth::user()->id ?? 9;

        $schedules = ClassRoom::with('schedule','schedule.details')->where('teacher_id', $userId)->get();

        return response()->json([
            "message" => "get schedule",
            "userId" => $userId,
            "schedules" => $schedules
        ]);
    }

    public function profile()
    {
        if (!feGuard()->check()) {
            return redirect()->route('get.login');
        }

        $user = feGuard()->user();

        $testResult = TestResult::where('user_id', $user->id)->get();
        $kq = 0;
        foreach ($testResult as $test) {
            if (strtolower($test->user_da) == strtolower($test->question_da)) {
                $kq++;
            }
        }
        $diem = round($kq * 10 / 60, 2);

        $order = Order::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        $viewData = [
            'user' => $user,
            'kq' => $kq,
            'diem' => $diem,
            'order' => $order
        ];

        return view('frontend.profile', $viewData);
    }

    public function suggest()
    {
        try {
            $testResult = TestResult::where('user_id', feGuard()->user()->id)->get();
            $kq = 0;
            foreach ($testResult as $test) {
                if (strtolower($test->user_da) == strtolower($test->question_da)) {
                    $kq++;
                }
            }
            $diem = round($kq * 10 / 60, 2);
            $level = getLevel($diem);
            $data = Course::where('level_id', $level)->orderBy('id', 'desc')->paginate(getConst('FE_PER_PAGE'));
            return view('course', compact('data'));
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->route('home');
        }
    }

    public function test()
    {
        $showQuestion = [];
        $statusTest = feGuard()->user()->status_test;
        $userId = feGuard()->user()->id;

        if ($statusTest == User::STATUS_TESTED) {
            return redirect()->route('get.profile'); // @todo or man hinh ket qua test
        }

        $page = request('page', 1);
        $from = ($page - 1) * getConfig('number_question_on_page');
        $to = $from + getConfig('number_question_on_page') - 1;

        if (!empty(feGuard()->user()->time_test_end)) {
            if (feGuard()->user()->time_test_end > now()) {
                // dang test
                $showQuestionId = [];
                $deThiDangTest = TestResult::whereUserId($userId)->get();
                foreach ($deThiDangTest as $key1 => $item1) {
                    if ($from <= $key1 && $key1 <= $to) {
                        array_push($showQuestionId, $item1->question_id);
                    }
                }
                $showQuestion = Question::whereIn('id', $showQuestionId)->get();

                $viewData = [
                    'dethi' => $showQuestion,
                    'page' => $page,
                ];

                return view('frontend.test', $viewData);
            } else {
                // Thi lại
                TestResult::whereUserId($userId)->forceDelete();
            }
        }

        // Thi lần đầu
        $deadline = getConfig('time_test');
        $timeEnd = date("Y-m-d H:i:s", strtotime("+$deadline minutes"));
        feGuard()->user()->time_test_start = date("Y-m-d H:i:s");
        feGuard()->user()->time_test_end = $timeEnd;
        feGuard()->user()->save();

        $dethi = Question::all()->random(getConfig('number_question'));

        foreach ($dethi as $key => $item) {
            TestResult::create([
                'user_id' => $userId,
                'question_id' => $item->id,
                'question_da' => $item->da,
            ]);
            if ($from <= $key && $key <= $to) {
                array_push($showQuestion, $item);
            }
        }

        // test lai or test lan dau
        // update time test end

        $viewData = [
            'dethi' => $showQuestion,
            'page' => $page,
        ];

        return view('frontend.test', $viewData);
    }

    public function submitTest()
    {
        feGuard()->user()->status_test = User::STATUS_TESTED;
        feGuard()->user()->save();

        return redirect()->route('get.profile');
    }

    public function getKqTest()
    {
        $testResult = TestResult::whereUserId(feGuard()->user()->id)->get();
        $viewData = [
            'dethi' => $testResult
        ];
        return view('frontend.result', $viewData);
    }

    public function answerQuestion()
    {
        TestResult::where('user_id', feGuard()->user()->id)
            ->where('question_id', request('question_id'))
            ->update(['user_da' => request('user_da')]);

        $response = [
            'status' => 200,
            'data' => [],
            'message' => 'Success',
        ];

        return response()->json($response);
    }

    public function editProfile()
    {
        $data = fE();
        return view('frontend.edit_profile', compact('data'));
    }

    public function updateProfile(AuthRequest $request)
    {
        $params = request()->all();
        if (request('password_new')) {
            $params['password'] = bcrypt(request('password_new'));
        }
        fe()->fill($params);
        fe()->save();
        return redirect()->route('get.profile')->with('notification_success', 'Thành công');
    }

    public function orderDetail($id)
    {
        $classIds = OrderDetail::where('order_id', $id)->pluck('class_id')->toArray();
        if (count($classIds) < 1) {
            abort(404);
        }
        $class = ClassRoom::whereIn('id', $classIds)->get();
        return view('frontend.order_detail', compact('class', 'id'));
    }
}
