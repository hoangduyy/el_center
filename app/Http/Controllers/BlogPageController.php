<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;

class BlogPageController extends Controller
{
    public function getTinTuc()
    {
        $data = BlogCategory::orderBy('id', 'desc')->paginate(getConst('FE_PER_PAGE'));
        return view('frontend.tin_tuc.index', compact('data'));
    }

    public function getTinTucDetail($slug)
    {
        $item = BlogCategory::whereSlug($slug)->first();
        if (empty($item)) {
            abort(404);
        }
        return view('frontend.tin_tuc.show', compact('item'));
    }

    public function getBaiViet()
    {
        $data = BlogPost::orderBy('id', 'desc')->paginate(getConst('FE_PER_PAGE'));
        return view('frontend.bai_viet.index', compact('data'));
    }

    public function getBaiVietDetail($slug)
    {
        $item = BlogPost::whereSlug($slug)->first();
        if (empty($item)) {
            abort(404);
        }
        return view('frontend.bai_viet.show', compact('item'));
    }
}
