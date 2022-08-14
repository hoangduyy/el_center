<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Question;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class NewController extends Controller
{
    public function index()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        $list = BlogCategory::orderBy('id', 'desc');

        if (request('id')) {
            $list->where('id', request('id'));
        }

        $list = $list->paginate(getConst('BE_PER_PAGE'));

        return view('backend.new.index', compact('list'));
    }

    public function create()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }
        return view('backend.new.create');
    }

    public function store()
    {
        $slug = Str::slug(request('name'));
        $new = new BlogCategory();
        $new->name = request('name');
        $new->slug = $slug;
        $new->description = request('description');
        $new->save();

        return redirect()->route('be.new.index')->with('notification_success', 'Thành công');
    }

    public function edit($id)
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }
        $data = BlogCategory::findOrFail($id);
        return view('backend.new.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $profile = BlogCategory::where('id', $id)->first();
        $profile->name = $request->name;
        $profile->slug = Str::slug($request->name);
        $profile->description = $request->description;
        $profile->save();

        return redirect()->route('be.new.index')->with('notification_success', 'Thành công');
    }

    public function destroy($id)
    {
        $model = BlogCategory::findOrFail($id);
        $model->delete();
        return redirect()->back()->with('notification_success', 'Thành công');
    }
}
