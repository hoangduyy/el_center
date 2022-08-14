<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $doanhThuTuan = Order::whereBetween("created_at", [
            $now->startOfWeek()->format('Y-m-d'), //This will return date in format like this: 2022-01-10 // start week is monday
            $now->endOfWeek()->format('Y-m-d') // end week is sunday
        ])->sum('total_final');

        return view('backend.dashboard.index', compact('doanhThuTuan'));
    }
}
