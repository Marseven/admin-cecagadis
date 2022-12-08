<?php

namespace App\Exports;

use App\Models\RequestCard;
use App\Models\RequestCardEcobank;
use App\Models\RequestCardUba;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RequestCardsExport implements FromView
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
        if ($this->bank == "orbabank") {
            $requests = RequestCard::all()->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'));
            return view('admin.exports.request', [
                'request_cards' => $requests,
            ]);
        } elseif ($this->bank == "uba") {
            $requests = RequestCardUba::all()->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'));
            return view('admin.exports.request_uba', [
                'request_cards' => $requests,
            ]);
        } elseif ($this->bank == "ecobank") {
            $requests = RequestCardEcobank::all()->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'));
            return view('admin.exports.request', [
                'request_cards' => $requests,
            ]);
        }
    }
}
