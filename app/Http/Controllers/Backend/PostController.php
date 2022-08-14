<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        $list = BlogPost::orderBy('id', 'desc');

        if (request('id')) {
            $list->where('id', request('id'));
        }

        $list = $list->paginate(getConst('BE_PER_PAGE'));

        return view('backend.post.index', compact('list'));
    }

    public function create()
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        return view('backend.post.create');
    }

    public function store(BlogPostRequest $request)
    {
        $slug = Str::slug(request('title'));
        $thumbnail = '';

        if (request()->hasFile('thumbnail')) {
            $fileName = time() . "_" . request()->file('thumbnail')->getClientOriginalName();
            $pathTmp = 'backend/upload/post';
            $uploadPath = public_path($pathTmp); // Folder upload path

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            request()->file('thumbnail')->move($uploadPath, $fileName);
            $thumbnail = $pathTmp . '/' . $fileName;
        }

        $data = new BlogPost();
        $data->title = request('title');
        $data->slug = $slug;
        $data->description = request('description');
        $data->content = request('content');
        $data->thumbnail = $thumbnail;
        $data->save();

        return redirect()->route('be.post.index')->with('notification_success', 'Thành công');
    }

    public function edit($id)
    {
        if (!isAdmin()) {
            return redirect()->route('be.dashboard');
        }

        $data = BlogPost::findOrFail($id);
        return view('backend.post.edit', compact('data'));
    }

    public function update($id, BlogPostRequest $request)
    {
        if (request()->hasFile('thumbnail')) {
            $fileName = time() . "_" . request()->file('thumbnail')->getClientOriginalName();
            $pathTmp = 'backend/upload/post';
            $uploadPath = public_path($pathTmp); // Folder upload path

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            request()->file('thumbnail')->move($uploadPath, $fileName);
            $thumbnail = $pathTmp . '/' . $fileName;
        }

        $data = BlogPost::where('id', $id)->first();
        $data->title = $request->title;
        $data->slug = Str::slug($request->title);
        $data->description = request('description');
        $data->content = request('content');
        $data->thumbnail = !empty($thumbnail) ? $thumbnail : $data->thumbnail;
        $data->save();

        return redirect()->route('be.post.index')->with('notification_success', 'Thành công');
    }

    public function destroy($id)
    {
        $model = BlogPost::findOrFail($id);
        $model->delete();
        return redirect()->back()->with('notification_success', 'Thành công');
    }
}
