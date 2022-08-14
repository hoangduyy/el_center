<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use App\Exports\OrdersExportBody;
use App\Models\OrderHistory;
use PDF;

class OrderController
{
    public function index(Request $request)
    {
         
        $user = Auth::user();
        $page = $request->query('page') ?? 1;
        $pageOrder = $request->query('pageSize') ?? 25;
        $userId = $request->query('userId');
        $classId = $request->query('classId');

        $query = Order::query();


        $query =  $query->orderBy('id', 'desc')
            ->with('creator','customer','class','class.course');

        if ($userId != null) {
            $query = $query->where('orders.user_id', $userId);
        }

        if ($classId != null) {
            $query = $query->where('orders.class_id', $classId);
        }

        if($user->role != 'admin' && $user->role  != 'manage'){
            $query = $query->where('user_id',$user->id);   
        }

        $data =  $query
            ->skip(($page - 1) * $pageOrder)
            ->take($pageOrder)
            ->get();

        $total =  $query
            ->count();

        return response()->json([
            "total" => $total,
            "data" => $data,
        ]);
    }

    public function show($id)
    {

        $model = Order::where('id', $id)
            ->with('creator')
            ->with('customer')
            ->first();

        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        return response()->json($model);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total' => 'required',
            'fullName' => 'required',
            'email' => 'email',
            'phone' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $model = $request->all();
        $model['creator_id'] = Auth::user()->id ?? null;
        $model = Order::create($model);


        return response()->json([
            "message" => "Thêm mới đơn đăng ký thành công",
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [

            'total' => 'required',
            'fullName' => 'required',
            'email' => 'email',
            'phone' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 400);
        }

        $model =  Order::find($id);
        $model->status = $request->status;
        $model->note = $request->note;
        $model->fullName = $request->fullName;
        $model->phone = $request->phone;
        $model->email = $request->email;
        $model->total = $request->total;
        $model->class_id = $request->class_id;
        $model->user_id = $request->user_id;
        $model['creator_id'] = Auth::user()->id ?? null;

        $model->save();
        return response()->json([
            "message" => "Cập nhật đơn đăng ký thành công",
        ]);


    }

    public function exportOrder($id){

        
        return Excel::download(new OrdersExport($id), 'orders-' .$id. '.xlsx');    
    }


    public function exportPDFOrder($id){

        $order = Order::with('creator','class')->where('id', $id)->first();
        $orderItems = OrderHistory::with('creator')->where('order_id', $id)->get();
        $c = collect();
        // $c->add(["Phiếu đăng ký"]);
        $c->add(new OrdersExportPDFBody ($order->id,$order->total ,$order->creator ? $order->creator->email : 'online', $order->fullName, date("d/m/Y", strtotime($order->created_at)),$order->phone,$order->class->title));
        // $c->add(["Chi tiết"]);
        foreach ($orderItems as $item){
            $c->add(new OrdersExportPDFBody (
                $item->id,
                $item->total ,
                $item->fullName, 
                $item->creator ? $item->creator->email : 'admin',
                 date("d/m/Y", strtotime($item->created_at)),
                null,null)
            );
        }

        $data = [
            'id' => $id,
            'title' => 'Phiếu thu học phí',
            'date' => date("d/m/Y", strtotime($order->created_at)),
            'c' => $c
        ];

        $pdf = Pdf::loadView('pdf-template', $data);
            return $pdf->download('orders-' .$id. '.pdf'); 
    }


    public function destroy($id)
    {
        $model = Order::find($id);
        if ($model == null) {
            return response()->json(['error' => "Không tìm thấy dữ liệu"], 400);
        }
        $model->delete();
        return response()->json([
            "message" => "Xoá đơn đăng ký thành công",
        ]);
    }
}

class OrdersExportPDFBody {
    public $id;
    public $total;
    public function __construct($id, $total,$submitter,$collector, $created_at, $phone , $class){
        $this->id = $id;
        $this->total = $total;
        $this->submitter = $submitter;
        $this->collector = $collector;
        $this->created_at = $created_at;
        $this->phone = $phone;
        $this->class = $class;
    }
}
