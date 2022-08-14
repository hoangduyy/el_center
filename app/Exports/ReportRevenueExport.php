<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportRevenueExport implements FromCollection
{

    private $startDate;
    private $endDate;
    public function __construct($startDate,$endDate){
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $dataFill = [];
        $dayStart = $this->startDate ? (new Carbon($this->startDate)) : Carbon::now()->startOfMonth();
        $dayEnd = $this->endDate ? (new Carbon($this->endDate . ' 23:59')) : Carbon::now();

        $data = DB::select("select cast(o2.created_at as date) day, 
                                sum(o2.total) as totalAmount, 
                                count(o2.id) as totalOrder,  
                                sum(case when o2.status = 1 then 1 else 0 end) totalOrderSuccess
                                from orders o2 
                                where  o2.created_at > '$dayStart' and '$dayEnd'
                                group by cast(o2.created_at as date)
                                order by day
                                ");

        while ($dayStart->lte($dayEnd)) {
            $set = false;
            foreach ($data as $item) {
                $itemDate = new Carbon($item->day);
                if ($itemDate == $dayStart) {
                    $dataFill[] =
                        [
                            'totalAmount'  => $item->totalAmount,
                            'totalOrder'  => $item->totalOrder,
                            'totalOrderSuccess'  => $item->totalOrderSuccess
                        ];
                    $set = true;
                }
            }

            $dayStart->addDay();
            if ($set) continue;
            $dataFill[] =
                [
                    'totalAmount'  => 0,
                    'totalOrder'  => 0,
                    'totalOrderSuccess'  =>  0
                ];
        }

        return collect($dataFill);

    }
}