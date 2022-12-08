<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentsExport implements FromView
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
        $payments = Payment::all()->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'))->where('bank', $this->bank);

        if ($this->bank == "orabank") {
            $payments->load(['refill', 'request']);
            return view('admin.exports.payment', [
                'payments' => $payments,
            ]);
        } elseif ($this->bank == "uba") {
            $payments->load(['refill_uba', 'request_uba']);
            return view('admin.exports.payment_uba', [
                'payments' => $payments,
            ]);
        } elseif ($this->bank == "ecobank") {
            $payments->load(['request_eco']);
            return view('admin.exports.payment_eco', [
                'payments' => $payments,
            ]);
        } else {
            $payments_ora = Payment::all()->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'))->where('bank', 'orabank');
            $payments_ora->load(['refill', 'request']);
            $payments_uba = Payment::all()->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'))->where('bank', 'uba');
            $payments_uba->load(['refill_uba', 'request_uba']);
            $payments_eco = Payment::all()->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'))->where('bank', 'ecobank');
            $payments_eco->load(['request_eco']);

            return view('admin.exports.payment_all', [
                'payments_ora' => $payments_ora,
                'payments_uba' => $payments_uba,
                'payments_eco' => $payments_eco,
            ]);
        }
    }
}
