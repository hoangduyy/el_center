<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận đăng ký khoá học</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>{{ $details['body'] }}</p>
    <ul>
        <li>Tài khoản: {{ $details['email']}} </li>
        @if($details['password'])
        <li>Mật khẩu:  {{ $details['password'] }}</li>
        @endif
    </ul>
    <br />  Truy cập 
        <a href="http://localhost:8000/admin/login">vào đây</a> để đăng nhập vào hệ thống
    <p>Thank you</p>
</body>
</html>
