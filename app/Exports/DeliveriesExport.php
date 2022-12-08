<?php

namespace App\Exports;

use App\Models\Delivery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DeliveriesExport implements FromView
{

    public function __construct($begin, $end)
    {
        $this->begin = new \DateTime($begin);
        $this->end = new \DateTime($end);
        $this->end->add(new \DateInterval('P1D'));
    }

    public function view(): View
    {
        $deliveries = Delivery::all()->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'));

        return view('admin.exports.delivery', [
            'deliveries' => $deliveries,
        ]);
    }
}
