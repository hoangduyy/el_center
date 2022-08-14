<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Auth;

class QuestionController extends Controller
{
    public function index()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        $list = Question::orderBy('id', 'desc');

        if (request('id')) {
            $list->where('id', request('id'));
        }

        $list = $list->paginate(getConst('BE_PER_PAGE'));

        return view('backend.question.index', compact('list'));
    }

    public function create()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        return view('backend.question.create');
    }

    public function store()
    {
        $params = request()->all();
        $params['da'] = arrayGet(request()->all(), 'da', 'a');

        Question::create([
            "question" => arrayGet($params, 'question'),
            "da_a" => arrayGet($params, 'da_a'),
            "da_b" => arrayGet($params, 'da_b'),
            "da_c" => arrayGet($params, 'da_c'),
            "da_d" => arrayGet($params, 'da_d'),
            "da" => arrayGet($params, 'da'),
        ]);

        return redirect()->route('be.question.index')->with('notification_success', 'Thành công');
    }

    public function edit($id)
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        $data = Question::findOrFail($id);
        return view('backend.question.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $profile = Question::where('id', $id)->first();

        $profile->question = $request->question;
        $profile->da_a = $request->da_a;
        $profile->da_b = $request->da_b;
        $profile->da_c = $request->da_c;
        $profile->da_d = $request->da_d;
        $profile->da = $request->da;

        $profile->save();

        return redirect()->route('be.question.index')->with('notification_success', 'Thành công');
    }

    public function destroy($id)
    {
        $model = Question::findOrFail($id);
        $model->delete();
        return redirect()->back()->with('notification_success', 'Thành công');
    }
}
