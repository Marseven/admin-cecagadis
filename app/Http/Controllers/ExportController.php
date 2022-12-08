<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DeliveriesExport;
use App\Exports\PaymentsExport;
use App\Exports\RefillsExport;
use App\Exports\RequestCardsExport;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\RequestCard;
use App\Models\RequestCardEcobank;
use App\Models\RequestCardUba;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Excel;
use PDF;
use setasign\Fpdi\Fpdi;

class ExportController extends Controller
{

    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    //
    public function index(Request $request)
    {
        $day = Carbon::now();

        if ($request->type == 'Refill') {
            $type = "Recharge";
            Log::info('Téléchargement de la liste des recharges par ' . Auth::user()->name);
            if ($request->extension == 'EXCEL') {
                return $this->excel->download(new RefillsExport($request->begin, $request->end, $request->bank), $type . '-' . $day . '.xlsx');
            } elseif ($request->extension == 'CSV') {
                return $this->excel->download(new RefillsExport($request->begin, $request->end, $request->bank), $type . '-' . $day . '.csv');
            }
        } elseif ($request->type == 'Payment') {
            $type = "Paiement";
            Log::info('Téléchargement de la liste des paiements par ' . Auth::user()->name);
            if ($request->extension == 'EXCEL') {
                return $this->excel->download(new PaymentsExport($request->begin, $request->end,  $request->bank), $type . '-' . $day . '.xlsx');
            } elseif ($request->extension == 'CSV') {
                return $this->excel->download(new PaymentsExport($request->begin, $request->end,  $request->bank), $type . '-' . $day . '.csv');
            }
        } elseif ($request->type == 'Delivery') {
            $type = "Livraison";
            Log::info('Téléchargement de la liste des livraisons par ' . Auth::user()->name);
            if ($request->extension == 'EXCEL') {
                return $this->excel->download(new DeliveriesExport($request->begin, $request->end, $request->bank), $type . '-' . $day . '.xlsx');
            } elseif ($request->extension == 'CSV') {
                return $this->excel->download(new DeliveriesExport($request->begin, $request->end, $request->bank), $type . '-' . $day . '.csv');
            }
        } elseif ($request->type == 'Requests') {
            $type = "Commande";
            Log::info('Téléchargement de la liste des commandes de cartes par ' . Auth::user()->name);
            if ($request->extension == 'EXCEL') {
                return $this->excel->download(new RequestCardsExport($request->begin, $request->end, $request->bank), $type . '-' . $day . '.xlsx');
            } elseif ($request->extension == 'CSV') {
                return $this->excel->download(new RequestCardsExport($request->begin, $request->end, $request->bank), $type . '-' . $day . '.csv');
            }
        } elseif ($request->type == 'User') {
            $type = "Utilisateur";
            Log::info('Téléchargement de la liste des utilisateurs par ' . Auth::user()->name);
            if ($request->extension == 'EXCEL') {
                return $this->excel->download(new UsersExport($request->begin, $request->end), $type . '-' . $day . '.xlsx');
            } elseif ($request->extension == 'CSV') {
                return $this->excel->download(new UsersExport($request->begin, $request->end), $type . '-' . $day . '.csv');
            }
        }
    }

    public function generateBL($bank, Delivery $delivery)
    {
        $delivery->load(['fees', 'requests']);
        if ($bank == "orabank") {
            $delivery->load(['fees', 'requests']);
            $request = $delivery->requests;
        } elseif ($bank == "uba") {
            $delivery->load(['fees', 'request_uba']);
            $request = $delivery->request_uba;
        } elseif ($bank == "ecobank") {
            $delivery->load(['fees', 'request_eco']);
            $request = $delivery->request_eco;
        }
        $date = new \DateTime();

        $data = [
            'delivery' => $delivery,
            'request' => $request,
            'date' => $date->format('d-m-Y'),
            'bank' => $bank,
        ];

        $pdf = PDF::loadView('admin.deliveries.delivery-pdf', $data);

        Log::info('Impression du bon de livraion id : ' . $delivery->id . ' par ' . Auth::user()->name);

        return $pdf->download('Bon_de_livraison-' . $delivery->id . '.pdf');
    }

    public function generateFS($bank, $request_card)
    {
        $date = new \DateTime();

        if ($bank == "orabank") {
            $request_card = RequestCard::find($request_card);
            $termes = public_path('upload/file/ORA_TCU.pdf');
        } elseif ($bank == "uba") {
            $request_card = RequestCardUba::find($request_card);
            $termes = public_path('upload/file/UBA_TCU.pdf');
        } elseif ($bank == "ecobank") {
            $request_card = RequestCardEcobank::find($request_card);
            $termes = public_path('upload/file/ECO_TCU.pdf');
        }

        $data = [
            'request_card' => $request_card,
            'date' => $date->format('d-m-Y'),
        ];

        $pdf = PDF::loadView('admin.request_card.request-' . $bank . '-pdf', $data);

        $file = public_path('upload/file/' . $bank . '-' . $request_card->id . '.pdf');
        $outputPath = 'Formulaire-' . $bank . '-' . $request_card->id . '.pdf';

        $pdf->save($file);

        $fpdi = new FPDI;

        $filename  = $file;
        $count = $fpdi->setSourceFile($filename);
        for ($i = 1; $i <= $count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
        }

        $filename  = $termes;
        $count = $fpdi->setSourceFile($filename);
        for ($i = 1; $i <= $count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
        }

        Log::info('Impression du formulaire de ' . $bank . ' id : ' . $request_card->id . ' par ' . Auth::user()->name);

        unlink($file);

        return $fpdi->Output($outputPath, 'D');
    }
}
