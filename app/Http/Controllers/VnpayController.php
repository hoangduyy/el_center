<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class VnpayController extends Controller
{
    public function payment(Request $request)
    {
        $vnp_TxnRef = $request->orderId ?? 'code el 2';
        $vnp_OrderInfo = $request->note ?? 'note';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = ($request->total ?? 20000 ) * 1000;
        $vnp_Locale = 'vn';
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => env('vnp_TmnCode') ?? '9PV2XG06',
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => env('vnp_Returnurl') ?? 'http://localhost:8000/vnpay/success',
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

        $vnp_Url =  'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
            // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnpSecureHash = hash('sha256', env('vnp_HashSecret') ?? 'QYNEJTXTTYYQWXIFMRXAZFQTNUXGFFGO' . $hashdata);
            $vnp_Url .= '?' . $query;
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;

        return redirect($vnp_Url);
    }

    public function success(Request $request)
    {
        $orderId = $request->vnp_TxnRef;
        $order = Order::find($orderId);
        $order->status = 1;
        $order->save();
        return view('order-success');
    }
}
