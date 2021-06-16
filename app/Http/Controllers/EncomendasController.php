<?php

namespace App\Http\Controllers;

use App\Models\Encomendas;
use App\Models\Tshirts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EncomendasController extends Controller
{
    public function view_encomendas(Request $request)
    {

        $status = $request->status ?? '';
        $data = $request->data ?? '';

        if($status != null){
            if(Auth::user()->isAdmin())
            {
                $qry = Encomendas::where('estado', $status);

            }
            else
            {
                if($status == 'pendente'){
                    $qry = Encomendas::where('estado', 'pendente');
                
                }elseif($status == 'paga')
                {
                    $qry = Encomendas::where('estado', 'paga');
                }  
                else
                {
                    $qry = Encomendas::where('estado', 'pendente')->where('data', 'LIKE', '%' . $data . '%')
                                        ->orwhere('estado', 'paga')->where('data', 'LIKE', '%' . $data . '%');
                }         
            }
        }
        else if($data != null)
        {
            if(Auth::user()->isAdmin())
            {
                $qry = Encomendas::where('data', 'LIKE', '%' . $data . '%');
            }
            else
            {
                $qry = Encomendas::where('estado', 'pendente')->where('data', 'LIKE', '%' . $data . '%')
                                    ->orwhere('estado', 'paga')->where('data', 'LIKE', '%' . $data . '%');
            }
        }
        else
        {
            if(Auth::user()->isAdmin())
            {
                $qry = Encomendas::Query();
            }
            else
            {
                $qry = Encomendas::where('estado', 'pendente')
                                        ->orWhere('estado', 'paga');
            }
        }

        $encomendas = $qry->paginate(10);

        return view('encomendas.index')
            ->withEncomendas($encomendas)
            ->withData($data)
            ->withSelectedStatus($status);
    }

    public function mudarEstado(Request $request){


        $encomenda = Encomendas::findOrFail($request->id);

        $this->authorize('view_encomendas_mudarEstado', $encomenda);

        if($request->estado == 'fechada')
        {
            $status = FaturaController::gerarFatura($encomenda);

            if($status)
            {
                $encomenda->recibo_url = $status;
                EmailController::enviar_email_com_fatura($encomenda);
            }
        }

        $encomenda->estado = $request->estado;

        $encomenda->save();

        return back()
            ->with('alert-msg', 'O estado da encomenda ' . $request->id . ' foi atualizado para ' . $request->estado)
            ->with('alert-type', 'success');
    }

    public function detalhes_encomenda(Encomendas $encomenda)
    {
        $this->authorize('view_encomendas_mudarEstado', $encomenda);

        $tshirts = Tshirts::where('encomenda_id', $encomenda->id)->get();

        $encomenda = $tshirts[0]->encomenda;

        return view('encomendas.detalhes')
                ->withTshirts($tshirts)
                ->withEncomenda($encomenda);
    }

    public function mostrarFatura($fatura)
    {
        $encomenda = Encomendas::where('recibo_url', $fatura)->firstOrFail();


        $this->authorize('view_faturas', $encomenda);

        $path = storage_path('app/pdf_recibos/'.$fatura);
        return response()->file($path);
    }
}
