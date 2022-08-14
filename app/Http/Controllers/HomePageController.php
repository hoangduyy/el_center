<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index(Request $request)
    {
        $newCourses = Course::with('user')->orderBy('id', 'desc')->limit(2)->get();
        $newCourseIds = [];

        foreach($newCourses as $item) {
            $newCourseIds[] = $item->id;
        }

        $otherCourses = Course::with('user')->whereNotIn('id',$newCourseIds)->orderBy('id', 'desc')->limit(10)->toSql();


        $posts = BlogPost::orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('home', [
            'newCourses' => $newCourses,
            'otherCourses' => $otherCourses,
            'posts' => $posts
        ]);
    }
}
