<!DOCTYPE html>
<html>
<body>

<h2>Thanh toán thành công</h2>

<input type="hidden" id="url" value="{{ route('home') }}">

</body>
</html>

<script>
    setTimeout(function(){
        window.location.href = '/profile';
    }, 3000);
</script>
