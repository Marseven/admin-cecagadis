<?php

namespace App\Exports;

use App\Models\Refill;
use App\Models\RefillUba;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RefillsExport implements FromView
{
    public function __construct($begin, $end, $bank)
    {
        $this->begin = new \DateTime($begin);
        $this->end = new \DateTime($end);
        $this->end->add(new \DateInterval('P1D'));
        $this->bank = $bank;
    }

    public function view(): View
    {

        if ($this->bank == "orabank") {
            $refills = Refill::all()->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'));
            return view('admin.exports.refill', [
                'refills' => $refills,
            ]);
        } elseif ($this->bank == "uba") {
            $refills = RefillUba::all()->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'));
            return view('admin.exports.refill_uba', [
                'refills' => $refills,
            ]);
        }
    }
}
