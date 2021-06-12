<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Cores;
use App\Models\Estampa;
use App\Models\Preco;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EstampaPost;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;

class EstampasController extends Controller
{
    public function catalogo(Request $request)
    {
        //$qry =  Estampa::query();
        if($request->estampas){

            $term = $request->estampas;
            $qry = Estampa::where('cliente_id', null)->where('nome', 'LIKE', '%' . $term . '%')
                            ->orWhere('cliente_id', null)->where('descricao', 'LIKE', '%' . $term . '%');        
        }
        else
        {
            $qry = Estampa::where('cliente_id', null);
        }

        $categorias = Categorias::all();
        $estampas = $qry->paginate(9);

        if($estampas->first() == null)
        {
            $estampas = null;
        }

        return view('catalogo.index')
            ->withEstampas($estampas)
            ->withCategorias($categorias);
    }

    public function categoria(Categorias $categoria)
    {
        //$qry =  Estampa::query();
        $qry = Estampa::where('categoria_id', $categoria->id);
        $categorias = Categorias::all();

        $estampas = $qry->paginate(9);

        return view('catalogo.index')
            ->withEstampas($estampas)
            ->withCategorias($categorias);
    }

    public function index()
    {
        $estampas_all = Estampa::where('cliente_id', null); 
        $estampas = $estampas_all->paginate(6);
        
        return view('pagina_inicial.index')
            ->withEstampasIndex($estampas);  
    }

    public function estampa_detail(Estampa $estampa)
    {
        $preco = Preco::first();
        $cores = Cores::all();        
        

        return view('detalhes_produto.index')   
            ->withEstampa($estampa)
            ->withPreco($preco)
            ->withCores($cores);
    }

    public function getEstampa(Estampa $estampa){

        if ($estampa->imagem_url) {
            ob_end_clean();
            return response()->file(storage_path().'/app/estampas_privadas/'.$estampa->imagem_url);
        }
    }

    public function estampa_personalizada()
    {

        $estampas_privadas = null;
        $qry = Estampa::where('cliente_id', Auth::user()->id);
        $estampas_privadas = $qry->paginate(3);  
        
        $estampa_aux= $estampas_privadas->first();
        if(!$estampa_aux)
        {
            $estampas_privadas = null;
        }
        


        $newEstampa = new Estampa();
        return view('estampa_personalizada.index')
            ->withEstampa($newEstampa)
            ->withEstampasPrivada($estampas_privadas);
    }

    public function store_estampa_privada(EstampaPost $request)
    {
            
        $validated_data = $request->validated();
        $newEstampa = new Estampa();
        $newEstampa->cliente_id = Auth::user()->id;
        $newEstampa->nome = $validated_data['nome'];
        $newEstampa->descricao = $validated_data['descricao'];

        if ($request->file('foto')->isValid()) {
            $path= Storage::putFile('estampas_privadas', $request->file('foto'));
            $newEstampa->imagem_url = basename($path);
        }
        $newEstampa->save();
        
        
        return redirect()->route('usuario.estampa_personalizada')
            ->with('alert-msg', 'Estampa criada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy_estampa_privada(Estampa $estampa) 
    {
        $oldName = $estampa->nome;

        try {
            Storage::delete('estampas_privadas/' . $estampa->imagem_url);
            $estampa->delete();
            return redirect()->route('usuario.estampa_personalizada')
                ->with('alert-msg', 'Estampa "' .  $oldName . '" foi apagada com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('usuario.estampa_personalizada')
                    ->with('alert-msg', 'Não foi possível apagar a estampa "' . $oldName)
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('usuario.estampa_personalizada')
                    ->with('alert-msg', 'Não foi possível apagar a estampa "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    public function admin_view_estampas(Request $request){

        $categoria = $request->categoria ?? '';

        $categorias = Categorias::all();

        if($categoria)
        {
            $qry = Estampa::where('cliente_id', null)->where('categoria_id', $categoria);
        }
        else
        {
            $qry = Estampa::where('cliente_id', null);
        }

        $estampas = $qry->paginate(10);

        return view('catalogo.estampas')
            ->withEstampas($estampas)
            ->withCategorias($categorias)
            ->withSelectedCategoria($categoria);
    }

    public function create(Request $request)
    {
        $categoria = $request->categoria ?? '';

        $estampa = new Estampa();
        $categorias = Categorias::all();

        return view('catalogo.estampa_create')
            ->withEstampa($estampa)
            ->withCategorias($categorias)
            ->withSelectedCategoria($categoria);
    }

    public function store(EstampaPost $request)
    {

        $validated_data = $request->validated();

        $newEstampa = new Estampa();
        $newEstampa->nome = $validated_data['nome'];
        $newEstampa->descricao = $validated_data['descricao'];
        $newEstampa->categoria_id = $validated_data['categoria'];

        if ($request->hasFile('foto')) {
            $path = $request->foto->store('public/estampas');
            $newEstampa->imagem_url = basename($path);
        }

        $newEstampa->save();

        return redirect()->route('admin.estampas')
            ->with('alert-msg', 'Estampa [ '. $newEstampa->nome .' ] foi criada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function edit(Estampa $estampa)
    {
        $categorias = Categorias::all();

        if($estampa->categoria){
            $categoria = $estampa->categoria->id;
        }
        else
        {
            $categoria = '';
        }

        return view('catalogo.estampa_edit')
            ->withEstampa($estampa)
            ->withCategorias($categorias)
            ->withSelectedCategoria($categoria);
    }

    public function update(EstampaPost $request, Estampa $estampa)
    {
        $validated_data = $request->validated();

        // $request->validate([
        //     'email' => 'required|email|unique:users,email,'.$staff->id,
        // ]);
        $estampa->nome = $validated_data['nome'];
        $estampa->descricao = $validated_data['descricao'];
        $estampa->categoria_id = $validated_data['categoria'];
 
        if ($request->hasFile('foto')) {
            Storage::delete('public/estampas/' . $estampa->imagem_url);
            $path = $request->foto->store('public/estampas');
            $estampa->imagem_url = basename($path);
        }

        $estampa->save();
        return redirect()->route('admin.estampas')
            ->with('alert-msg', 'Estampa "' . $estampa->nome . '" foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(Estampa $estampa)
    {
        $oldName = $estampa->nome;
        $oldUrlFoto = $estampa->imagem_url;
        try {

            Storage::delete('public/estampas/' . $oldUrlFoto);
            $estampa->delete();
            return redirect()->route('admin.estampas')
                ->with('alert-msg', 'Estampa "' . $oldName . '" foi apagada com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('admin.estampas')
                    ->with('alert-msg', 'Não foi possível apagar a estampa "' . $oldName . '", porque esta estampa já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.estampas')
                    ->with('alert-msg', 'Não foi possível apagar a estampa "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }
}


