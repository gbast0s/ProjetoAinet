<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriasPost;
use App\Models\Preco;
use App\Http\Requests\PrecosPost;
use App\Models\Categorias;
use App\Models\Clientes;
use App\Models\Cores;
use App\Models\Encomendas;
use App\Http\Requests\CoresPost;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // INDEX //

    public function index()
    {
        $ganhosMensais_mes = Encomendas::ganhosMensais();
        $ganhosMensais = $ganhosMensais_mes[0];
        $Mes = $ganhosMensais_mes[1];
        $ganhosAnuais = Encomendas::ganhosAnuais();
        $total_clientes = Clientes::totalClientes();
        $total_encomendas_pendentes = Encomendas::encomendasPendentes();
        $total_grafico = Encomendas::ganhosMensaisGrafico();

        return view('dashboard.index')
            ->withGanhosMensais($ganhosMensais)
            ->withMes($Mes)
            ->withGanhosAnuais($ganhosAnuais)
            ->withTotalClientes($total_clientes)
            ->withEncomendasPendentes($total_encomendas_pendentes)
            ->withTotalGrafico($total_grafico);
    }

    // PREÇOS //

    public function view_precos()
    {
        $precos = Preco::all()->first();

        return view('catalogo.precos')
            ->withPrecos($precos);
    }

    public function edit_precos(Preco $precos)
    {
        return view('catalogo.precos_edit')
        ->withPrecos($precos);
    }

    public function update_precos(PrecosPost $request, Preco $precos)
    {
        $validated_data = $request->validated();

        $precos->preco_un_catalogo = $validated_data['preco_un_catalogo'];
        $precos->preco_un_proprio = $validated_data['preco_un_proprio'];
        $precos->preco_un_catalogo_desconto = $validated_data['preco_un_catalogo_desconto'];
        $precos->preco_un_proprio_desconto = $validated_data['preco_un_proprio_desconto'];
        $precos->quantidade_desconto = $validated_data['quantidade'];

        $precos->save();
        return redirect()->route('admin.precos')
            ->with('alert-msg', 'Preços configurados com sucesso!')
            ->with('alert-type', 'success');
    }

    // CATEGORIAS //

    public function view_categorias()
    {
        $qry = Categorias::Query();
        $categorias = $qry->paginate(10);

        return view('catalogo.categorias')
            ->withCategorias($categorias);
    }

    public function create_categoria()
    {
        $categoria = new Categorias();
        return view('catalogo.categoria_create')
            ->withCategoria($categoria);
    }

    public function store_categoria(CategoriasPost $request)
    {

        $validated_data = $request->validated();

        $newCategoria = new Categorias();
        $newCategoria->nome = $validated_data['name'];

        $newCategoria->save();

        return redirect()->route('admin.categorias')
            ->with('alert-msg', 'Categoria [ '. $newCategoria->nome .' ] foi criada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function edit_categoria(Categorias $categoria)
    {
        return view('catalogo.categoria_edit')
            ->withCategoria($categoria);
    }

    public function update_categoria(CategoriasPost $request, Categorias $categoria)
    {
        $validated_data = $request->validated();

        $categoria->nome = $validated_data['name'];

        $categoria->save();
        return redirect()->route('admin.categorias')
            ->with('alert-msg', 'Categoria "' . $categoria->nome . '" foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy_categoria(Categorias $categoria)
    {
        $oldName = $categoria->nome;
        try {

            $categoria->delete();
            return redirect()->route('admin.categorias')
                ->with('alert-msg', 'Categoria "' . $oldName . '" foi apagada com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('admin.categorias')
                    ->with('alert-msg', 'Não foi possível apagar a categoria "' . $oldName . '", porque esta já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.categorias')
                    ->with('alert-msg', 'Não foi possível apagar a categoria "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    //Encomendas

    public function view_encomendas()
    {
        $ganhosMensais_mes = Encomendas::ganhosMensais();
        $ganhosMensais = $ganhosMensais_mes[0];
        $Mes = $ganhosMensais_mes[1];
        $ganhosAnuais = Encomendas::ganhosAnuais();
        $total_clientes = Clientes::totalClientes();
        $total_encomendas_pendentes = Encomendas::encomendasPendentes();
        $total_grafico = Encomendas::ganhosMensaisGrafico();

        return view('dashboard.index')
            ->withGanhosMensais($ganhosMensais)
            ->withMes($Mes)
            ->withGanhosAnuais($ganhosAnuais)
            ->withTotalClientes($total_clientes)
            ->withEncomendasPendentes($total_encomendas_pendentes)
            ->withTotalGrafico($total_grafico);
    }

    //Cores

    public function view_cores()
    {
        $qry = Cores::Query();
        $cores = $qry->paginate(10);

        return view('catalogo.cores')
            ->withCores($cores);
    }

    public function create_cor()
    {

        $cor = new Cores();

        return view('catalogo.cores_create')
            ->withCor($cor);
    }

    public function store_cor(CoresPost $request)
    {

        $validated_data = $request->validated();

        $newCor = new Cores();
        $newCor->nome = $validated_data['nome'];
        $newCor->codigo = $validated_data['codigo'];

        if ($request->hasFile('foto')) {
            $request->foto->storeAs('public/tshirt_base', $validated_data['codigo'].'.jpg');
        }


        $newCor->save();

        return redirect()->route('admin.cores')
            ->with('alert-msg', 'Cor [ '. $newCor->nome .' ] foi criada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function edit_cor(Cores $cor)
    {
        return view('catalogo.cores_edit')
            ->withCor($cor);
    }

    public function update_cor(CoresPost $request, Cores $cor)
    {
        $validated_data = $request->validated();

        $cor->nome = $validated_data['nome'];
        $oldImage = $cor->codigo;
        $cor->codigo = $validated_data['codigo'];

        Storage::delete('public/tshirt_base/' . $oldImage. '.jpg');

        if ($request->hasFile('foto')) {
            $request->foto->storeAs('public/tshirt_base', $validated_data['codigo'].'.jpg');
        }

        $cor->save();
        return redirect()->route('admin.cores')
            ->with('alert-msg', 'Cor "' . $cor->nome . '" foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy_cor(Cores $cor)
    {
        $oldName = $cor->nome;
        $oldImage = $cor->codigo;

        try {
            Storage::delete('public/tshirt_base/' . $oldImage. '.jpg');

            $cor->delete();
            return redirect()->route('admin.cores')
                ->with('alert-msg', 'Cor "' . $oldName . '" foi apagada com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('admin.cores')
                    ->with('alert-msg', 'Não foi possível apagar a cor "' . $oldName . '", porque esta já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.cores')
                    ->with('alert-msg', 'Não foi possível apagar a cor "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }
}
