<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogPostRequest;
use App\Http\Requests\Backend\TeacherRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Branch;
use App\Models\Certificate;
use App\Models\Degree;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\TeacherCertificate;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function index()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }
        $list = Room::orderBy('id', 'desc');

        if (request('id')) {
            $list->where('id', request('id'));
        }

        $list = $list->paginate(getConst('BE_PER_PAGE'));

        return view('backend.room.index', compact('list'));
    }

    public function create()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }
        $branch = Branch::all();
        return view('backend.room.create', compact(['branch']));
    }

    public function store()
    {
        $data = new Room();
        $data->fill(request()->all());
        $data->save();
        return redirect()->route('be.room.index')->with('notification_success', 'Thành công');
    }

    public function edit($id)
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }
        $data = Room::findOrFail($id);
        $branch = Branch::all();
        return view('backend.room.edit', compact(['data', 'branch']));
    }

    public function update($id)
    {
        $data = Room::findOrFail($id);
        $data->fill(request()->all());
        $data->save();
        return redirect()->route('be.room.index')->with('notification_success', 'Thành công');
    }

    public function destroy($id)
    {
        $model = Room::findOrFail($id);
        $model->delete();
        return redirect()->back()->with('notification_success', 'Thành công');
    }
}
