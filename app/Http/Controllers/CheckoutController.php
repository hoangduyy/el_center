<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends BaseController
{
    public function addCart()
    {
        $cart = Cart::where('class_id', request('class_id'))->where('user_id', fE()->id)->first();
        if (empty($cart)) {
            Cart::create([
                'class_id' => request('class_id'),
                'user_id' => fe()->id,
            ]);
            return redirect()->route('cart')->with('notification_success', 'Bạn đã đăng kí lớp học trong giỏ hàng');
        }
        return redirect()->back()->with('notification_error', 'Bạn đã đăng kí lớp học trong giỏ hàng');
    }

    public function cart()
    {
        $classId = Cart::where('user_id', fE()->id)->pluck('class_id')->toArray();
        $class = ClassRoom::whereIn('id', $classId)->get();
        $count = count($class);
        $sale = getSale($count);
        return view('cart', compact('class', 'count', 'sale'));
    }

    public function removeItemCart($classId)
    {
        Cart::where('user_id', fE()->id)->where('class_id', $classId)->delete();
        return redirect()->route('cart')->with('notification_success', 'Thành công');
    }

    public function checkout()
    {
        $countCart = Cart::where('user_id', fE()->id)->count();
        if ($countCart < 1) {
            return redirect()->route('home');
        }

        $total = request('total');
        $fullName = fE()->name;
        $phone = fE()->phone;
        $email = fE()->email;
        $classId = request('class_id');
        $userId = fE()->id;

        $order = Order::create([
            'total' => $total,
            'note' => 'Thanh toán hóa đơn phí dich vụ',
            'fullName' => $fullName,
            'phone' => $phone,
            'email' => $email,
            'user_id' => $userId,
            'class_id' => $classId,
            'status' => Order::STATUS_FAIL,
            'sale' => request('sale') * 100,
            'total_final' => request('total_final'),
        ]);

        $cart = Cart::where('user_id', fE()->id)->get();
        foreach ($cart as $item) {
            OrderDetail::create([
                'status' => Order::STATUS_FAIL,
                'order_id' => $order->id,
                'class_id' => $item->class_id,
            ]);
        }

        Cart::where('user_id', fE()->id)->delete();

        session(['cost_id' => 1]);
        session(['url_prev' => url()->previous()]);
        $vnp_TmnCode = env("VNP_TMN_CODE"); //Mã website tại VNPAY
        $vnp_HashSecret = env("VNP_HASH_SECRET"); //Chuỗi bí mật
        $vnp_Url = env("VNP_URL");
        $vnp_Returnurl = route('returnVnpay');
        $vnp_TxnRef = $order->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = request('total_final') * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }

    public function returnVnpay(Request $request)
    {
        $orderId = $request->vnp_TxnRef;
        try {
            if ($request->vnp_ResponseCode == "00") {
                Order::where('id', $orderId)->update(array(
                    'status' => Order::STATUS_SUCCESS
                ));

                OrderDetail::where('order_id', $orderId)->update(array(
                    'status' => Order::STATUS_SUCCESS
                ));

                try {
                    $link = route('order.show', ['id' => $orderId]);
                    Mail::send('frontend.mail_order_success', ['link' => $link], function ($message) {
                        $message->to(fE()->email, fE()->name)->subject('Đặt hàng thành công');
                        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    });
                } catch (\Exception $e) {
                    Log::error($e);
                }

                return view('frontend.checkout.success');
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
        return view('frontend.checkout.fail');
    }
}
