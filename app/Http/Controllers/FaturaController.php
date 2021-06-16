<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Encomendas;
use App\Models\Tshirts;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;

class FaturaController extends Controller
{
    public static function gerarFatura(Encomendas $encomenda)
    {
        //$user = User::findOrFail(Auth::user()->id);
        $tshirts = Tshirts::where('encomenda_id', 1)->get();
        if($tshirts[0]->encomenda->cliente)
        {
            $filename = $tshirts[0]->encomenda->id."_".$tshirts[0]->encomenda->cliente_id;
            $path = storage_path('app/pdf_recibos/');
            //Meter a vista onde diz view
            $encomenda = $tshirts[0]->encomenda;
            $pdf = PDF::loadView('teste', compact('tshirts', 'encomenda'))->setOptions(['defaultFont' => 'sans-serif'])->save($path.$filename.'.pdf');

            $filename = $filename.".pdf";
            return response()->file(storage_path().'/app/pdf_recibos/'. $filename);
            //return $filename.".pdf";
        }

        return null;
    }
}
