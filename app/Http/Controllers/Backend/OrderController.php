<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    public function index()
    {
        $list = Order::orderBy('id', 'desc');

        if (request('id')) {
            $list->where('id', '=', request('id'));
        }

        if (request('phone')) {
            $list->where('phone', 'like', '%' . request('phone') . '%');
        }

        if (request('email')) {
            $list->where('email', 'like', '%' . request('email') . '%');
        }

        $list = $list->paginate(getConst('BE_PER_PAGE'));
        return view('backend.order.index', compact('list'));
    }

    public function detail($id)
    {
        $classIds = OrderDetail::where('order_id', $id)->pluck('class_id')->toArray();
        $class = ClassRoom::whereIn('id', $classIds)->get();
        return view('backend.order.detail', compact('class', 'id'));
    }
}
