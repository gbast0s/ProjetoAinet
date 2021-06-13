<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientesPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clientes;
use Illuminate\Support\Facades\Storage;
use App\Models\Encomendas;

class ClienteController extends Controller
{
    public function perfil()
    {
        $cliente = Clientes::where('id', Auth::user()->id)->first();
        $qry = Encomendas::where('cliente_id',  Auth::user()->id);

        $encomendas = $qry->paginate(10);

        return view('perfil.index')
            ->withCliente($cliente)
            ->withEncomendas($encomendas);
    }

    public function admin_encomendas(Request $request, Clientes $cliente){
        $status = $request->status ?? '';
        $data = $request->data ?? '';

        if($status != null){
            $qry = Encomendas::where('cliente_id', $cliente->id)->where('estado', $status);

            $encomendas = $qry->paginate(10);
        }
        else if($data != null)
        {
            $qry = Encomendas::where('cliente_id', $cliente->id)->where('data', 'LIKE', '%' . $data . '%');

            $encomendas = $qry->paginate(10);
        }
        else
        {
            $qry =  Encomendas::where('cliente_id', $cliente->id);

            $encomendas = $qry->paginate(10);
        }

        return view('clientes.encomendas_admin')
            ->withEncomendas($encomendas)
            ->withCliente($cliente)
            ->withData($data)
            ->withSelectedStatus($status);

    }

    public function admin_view_clientes(Request $request)
    {

        $status = $request->status ?? '';

        if($status != null){
            $clientes = Clientes::whereHas('user', function($query) use ($status){
                $query->where('bloqueado', $status);
            })->paginate(10);
        }
        else
        {
            $qry =  Clientes::query();

            $clientes = $qry->paginate(10);
        }

        return view('clientes.index')
            ->withClientes($clientes)
            ->withSelectedStatus($status);
    }

    public function destroy(Clientes $cliente)
    {

        $oldName = $cliente->user->name;
        $oldUrlFoto = $cliente->user->foto_url;
        try {

            Storage::delete('public/fotos/' . $oldUrlFoto);
            $cliente->delete();
            $cliente->user->delete();
            return redirect()->route('admin.clientes')
                ->with('alert-msg', 'Cliente "' . $cliente->user->name . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('admin.clientes')
                    ->with('alert-msg', 'Não foi possível apagar o Cliente "' . $oldName . '", porque este cliente já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.clientes')
                    ->with('alert-msg', 'Não foi possível apagar o Cliente "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    public function bloquearDesbloquearClientes(Request $request)
    {

        $block = $request->block;
        $id = $request->id;

        $cliente = Clientes::where('id', $id)->first();
        $cliente->user->bloqueado = $block;
        $cliente->user->save();

        $mensagem = $block ? "Cliente: [ ".$cliente->user->name." ] bloqueado com sucesso!" : "Cliente: [ ".$cliente->user->name." ] desbloqueado com sucesso!";

        return redirect()->route('admin.clientes')
            ->with('alert-msg', $mensagem)
            ->with('alert-type', 'success');
    }

    public function destroy_foto(Clientes $cliente)
    {
        Storage::delete('public/fotos/' . $cliente->user->foto_url);
        $cliente->user->foto_url = null;
        $cliente->user->save();
        return redirect()->route('usuario.perfil')
            ->with('alert-msg', 'Foto do cliente "' . $cliente->user->name . '" foi removida!')
            ->with('alert-type', 'success');
    }

    public function updateClientesInfo(ClientesPost $request, Clientes $cliente) {

        $validatedData = $request->validated();
        // dd($validatedData);
        if($request->hasFile('foto')) {
            $path = Storage::putFile('public/fotos/', $request->file('foto'));
            $cliente->user->foto_url = basename($path);
        }
        $cliente->user->name = $validatedData['name'];
        $cliente->nif = $validatedData['nif'];
        $cliente->endereco = $validatedData['endereco'];
        $cliente->user->email = $validatedData['email'];
        $cliente->tipo_pagamento = $validatedData['tipo_pagamento'];
        $cliente->ref_pagamento = $validatedData['ref_pagamento'];
        $cliente->save();
        $cliente->user->save();
        return redirect()->route('usuario.perfil')
            ->with('alert-msg', 'Dados atualizados com sucesso!')
            ->with('alert-type', 'success');
    }
}
