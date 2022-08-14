<?php

namespace App\Http\Controllers;

use App\Http\Requests\Frontend\AuthRequest;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthFEController extends Controller
{
    public function register()
    {
        return view('frontend.register');
    }

    public function postRegister(AuthRequest $request)
    {
        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->phone = request('phone');
        $user->password = bcrypt(request('password'));
        $user->save();

        try {
            Mail::send('frontend.mail_register', [], function ($message) {
                $message->to(request('email'), request('name'))->subject('Đăng kí thành công');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
        } catch (\Exception $e) {
            Log::error($e);
        }

        return redirect()->route('get.login')->with('success', 'Đăng kí thành công');
    }

    public function login()
    {
        return view('frontend.login');
    }

    public function postLogin()
    {
        $email = request('email');
        $password = request('password');

        $auth = feGuard()->attempt(array(
            'email'     => $email,
            'password'  => $password,
        ));

        if ($auth) {
            return redirect()->route('get.profile');
        }

        return redirect()->back()->with('error', 'Tài khoản không tồn tại')->withInput(request()->all());
    }

    public function logout()
    {
        feGuard()->logout();
        return redirect()->route('get.login');
    }

    public function forgotPassword()
    {
        return view('frontend.forgot_password');
    }

    public function postForgotPassword()
    {
        $email = request('email');
        $user = User::whereEmail($email)->first();

        if (empty($user)) {
            return redirect()->back()->with('error', 'Email không tồn tại');
        }

        $otp = random_int(100000, 999999);
        $link = route('setting_new_password', ['otp' => $otp]);
        try {
            $user->otp = $otp;
            $user->save();

            Mail::send('frontend.mail_forgot_password', ['link' => $link], function ($message) use ($user) {
                $message->to(request('email'), $user->name)->subject('Quên mật khẩu');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
        } catch (\Exception $e) {
            Log::error($e);
        }

        return redirect()->back()->with('success', 'Thành công. Bạn vui lòng check mail để lấy link đặt lại mật khẩu.');
    }

    public function settingNewPassword($otp)
    {
        $user = User::where('otp', $otp)->first();
        if (empty($user)) {
            return redirect()->route('forgot_password');
        }
        return view('frontend.setting_new_password', compact('otp'));
    }

    public function postSettingNewPassword($otp)
    {
        $password = request('password');
        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Mật khẩu ít nhất 6 kí tự');
        }
        if ($password != request('password_confirmation')) {
            return redirect()->back()->with('error', 'Mật khẩu nhập lại không chính xác');
        }
        $user = User::where('otp', $otp)->first();
        if (empty($user)) {
            return redirect()->back()->with('error', 'Lỗi hệ thống, vui lòng thử lại');
        }
        $user->password = bcrypt($password);
        $user->otp = '';
        $user->save();

        return redirect()->route('get.login')->with('success', 'Đổi mật khẩu thành công');
    }
}
