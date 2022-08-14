<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

function tGuard()
{
    return Auth::guard('teacher');
}

function tE()
{
    return Auth::guard('teacher')->user();
}

function beGuard()
{
    return Auth::guard('be');
}

function bE()
{
    return Auth::guard('be')->user();
}

function isManager()
{
    return Auth::guard('be')->user()->role == \App\Models\User::ROLE_MANAGE;
}

function isAdmin()
{
    return Auth::guard('be')->user()->role == \App\Models\User::ROLE_ADMIN;
}

function feGuard()
{
    return Auth::guard('fe');
}

function fE()
{
    return Auth::guard('fe')->user();
}

function arrayGet($array, $key, $default = null)
{
    return Arr::get($array, $key, $default);
}

function getConfig($key, $default = '')
{
    return config('config.' . $key, $default);
}

function getConst($key, $default = '')
{
    return config('const.' . $key, $default);
}

function getSTTBackend($entities, $index)
{
    return getConst('BE_PER_PAGE') * ($entities->currentPage() -1) + 1 + $index;
}

function getSale($count)
{
    $sale = 0;
    if ($count == 2) {
        $sale = 0.1;
    }
    if ($count >= 3) {
        $sale = 0.15;
    }
    return $sale;
}

function getLevel($diem)
{
    $level = 1;

    if ($diem < 4) {
        $level = 1;
    }
    if (4 <= $diem && $diem < 6) {
        $level = 2;
    }
    if (6 <= $diem && $diem < 8) {
        $level = 3;
    }
    if (8 <= $diem && $diem <= 10) {
        $level = 4;
    }

    return $level;
}

function getDayWeek()
{
    return [
        '1' => 'Chủ nhật',
        '2' => 'Thứ 2',
        '3' => 'Thứ 3',
        '4' => 'Thứ 4',
        '5' => 'Thứ 5',
        '6' => 'Thứ 6',
        '7' => 'Thứ 7'
    ];
}

function getKhungGio()
{
    return [
        '1' => '8h-10h',
        '2' => '10h-12h',
        '3' => '14h-16h',
        '4' => '16h-18h',
        '5' => '18h-20h',
        '6' => '20h-22h',
    ];
}
