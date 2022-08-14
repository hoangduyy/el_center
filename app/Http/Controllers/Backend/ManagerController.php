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
use Illuminate\Support\Str;

class ManagerController extends Controller
{
    public function index()
    {
        $list = Admin::orderBy('id', 'desc')->where('role', Admin::ROLE_MANAGE);

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

        return view('backend.staff.index', compact('list'));
    }

    public function create()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }
        return view('backend.staff.create');
    }

    public function store(ManagerRequest $request)
    {
        try {
            $data = new Admin();
            $data->name = request('name');
            $data->email = request('email');
            $data->password = bcrypt(request('password'));
            $data->role = Admin::ROLE_MANAGE;
            $data->save();
            return redirect()->route('be.staff.index')->with('notification_success', 'Thành công');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('notification_error', 'Lỗi hệ thống');
        }
    }

    public function edit($id)
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        $data = Admin::findOrFail($id);
        return view('backend.staff.edit', compact(['data']));
    }

    public function update($id, ManagerRequest $request)
    {
        try {
            $data = Admin::findOrFail($id);
            $data->name = request('name');
            $data->email = request('email');
            $data->role = Admin::ROLE_MANAGE;
            if (request('password_new')) {
                $data->password = bcrypt(request('password_new'));
            }
            $data->save();
            return redirect()->route('be.staff.index')->with('notification_success', 'Thành công');
        } catch (\Exception $e) {
        }
        return redirect()->back()->with('notification_error', 'Lỗi hệ thống');
    }

    public function destroy($id)
    {
        $model = Admin::findOrFail($id);
        $model->delete();
        return redirect()->back()->with('notification_success', 'Thành công');
    }
}
