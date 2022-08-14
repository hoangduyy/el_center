<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders-{{$id}}</title>
</head>
<body>
<h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <table>
        <tr>
            <th>Id</th>
            <th>Tổng tiền</th>
            <th>Người nộp</th>
            <th>Người thu</th>
            <th>Điện thoại</th>
            <th>Lớp</th>
        </tr>
        @foreach($c as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->total }}</td>
            <td>{{ $item->submitter }}</td>
            <td>{{ $item->collector }}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->class }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>

