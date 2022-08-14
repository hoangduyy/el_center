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
use App\Models\Teacher;
use App\Models\TeacherCertificate;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BranchController extends Controller
{
    public function index()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        $list = Branch::orderBy('id', 'desc');

        if (request('id')) {
            $list->where('id', request('id'));
        }

        $list = $list->paginate(getConst('BE_PER_PAGE'));

        return view('backend.branch.index', compact('list'));
    }

    public function create()
    {
        return view('backend.branch.create');
    }

    public function store()
    {
        $data = new Branch();
        $data->fill(request()->all());
        $data->save();
        DB::commit();
        return redirect()->route('be.branch.index')->with('notification_success', 'Thành công');
    }

    public function edit($id)
    {
        $data = Branch::findOrFail($id);
        return view('backend.branch.edit', compact(['data']));
    }

    public function update($id)
    {
        $data = Branch::findOrFail($id);
        $data->fill(request()->all());
        $data->save();
        return redirect()->route('be.branch.index')->with('notification_success', 'Thành công');
    }

    public function destroy($id)
    {
        $model = Branch::findOrFail($id);
        $model->delete();
        return redirect()->back()->with('notification_success', 'Thành công');
    }
}
