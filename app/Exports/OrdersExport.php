<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderHistory;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{

    private $orderId;
    public function __construct($id){
        $this->orderId = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $order = Order::with('creator','class')->where('id', $this->orderId)->first();
        $orderItems = OrderHistory::with('creator')->where('order_id', $this->orderId)->get();
        $c = collect();
        $c->add(["Phiếu đăng ký"]);
        $c->add(["Id", "Tổng tiền", "Người nộp","Người thu", "Ngày thu", "Điện thoại", "Lớp"]);
        $c->add(new OrdersExportBody ($order->id,$order->total ,$order->creator ? $order->creator->email : 'online', $order->fullName, date("d/m/Y", strtotime($order->created_at)),$order->phone,$order->class->title));
        $c->add(["Chi tiết"]);
        foreach ($orderItems as $item){
            $c->add(new OrdersExportBody (
                $item->id,
                $item->total ,
                $item->fullName, 
                $item->creator ? $item->creator->email : 'admin',
                 date("d/m/Y", strtotime($item->created_at)),
                null,null)
            );
        }
        return $c; 
    }

    public function headings() :array
    {
        return ["Id", "Tổng tiền", "Người nộp","Người thu", "Ngày thu", "Điện thoại", "Lớp"];
    }
}

class OrdersExportBody {
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