<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffPost;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function admin(Request $request)
    {

        $status = $request->status ?? '';

        if($status != null){
            if($status == '0' || $status == '1')
            {
                $qry = User::where(['tipo' => 'A', 'tipo' => 'F'])->where('bloqueado', $status);

                $staffs = $qry->paginate(10);

            }else{

                $qry = User::where('tipo', $status);

                $staffs = $qry->paginate(10);
            }
        }
        else
        {
            $qry = User::where('tipo', 'A')
            ->orwhere('tipo', 'F');

            $staffs = $qry->paginate(10);
        }    

        return view('dashboard.staff')
            ->withStaffs($staffs)
            ->withSelectedStatus($status);
    }

    public function bloquearDesbloquearStaff(Request $request)
    {

        $block = $request->block;
        $id = $request->id;

        //dd($user);
        $user = User::where('id', $id)->first();

        $user->bloqueado = $block;
        $user->save();

        $mensagem = $block ? "Staff: [ ". $user->name." ] bloqueado com sucesso!" : "Staff: [ ".$user->name." ] desbloqueado com sucesso!";

        return redirect()->route('admin.staff')
            ->with('alert-msg', $mensagem)
            ->with('alert-type', 'success');
    }

    public function edit(User $staff)
    {
        return view('dashboard.staff_edit')
            ->withStaff($staff);
    }
    
    public function create()
    {
        $newStaff = new User();
        return view('dashboard.staff_create')
            ->withStaff($newStaff);
    }

    public function store(StaffPost $request)
    {

        $validated_data = $request->validated();

        $newUser = new User;
        $newUser->email = $validated_data['email'];
        $newUser->name = $validated_data['name'];
        $newUser->tipo = $validated_data['tipo'];
        $newUser->password = Hash::make($validated_data['password']);
 

        if ($request->hasFile('foto')) {
            $path = $request->foto->store('public/fotos');
            $newUser->foto_url = basename($path);
        }

        $newUser->save();
        
        $newUser = User::where('email', $validated_data['email'])->first();
        //dd($newUser);
        $newUser->sendEmailVerificationNotification();

        return redirect()->route('admin.staff')
            ->with('alert-msg', 'Staff [ '. $newUser->name .' ] foi criado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function update(StaffPost $request, User $staff)
    {
        $validated_data = $request->validated();

        $staff->email = $validated_data['email'];
        $staff->name = $validated_data['name'];
        $staff->tipo = $validated_data['tipo'];
        if($validated_data['password'])
        {
            $staff->password = Hash::make($validated_data['password']);
        }
 

        if ($request->hasFile('foto')) {
            Storage::delete('public/fotos/' . $staff->foto_url);
            $path = $request->foto->store('public/fotos');
            $staff->foto_url = basename($path);
        }

        $staff->save();
        return redirect()->route('admin.staff')
            ->with('alert-msg', 'Staff "' . $staff->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function staffChangePass(User $staff)
    {

        $this->authorize('can_view_change_pass', $staff);

        return view('dashboard.staff_change_pass')
            ->withStaff($staff);
    }

    public function updatestaffPass(Request $request, User $staff)
    {

        $this->authorize('can_change_pass', $staff);

        if($request->password)
        {
            $staff->password = Hash::make($request->password);

            $staff->save();

            return redirect()->route('admin.alterarpass', $staff)
            ->with('alert-msg', 'A sua password foi alterada com sucesso!')
            ->with('alert-type', 'success');
        }

        return redirect()->route('admin.alterarpass', $staff)
            ->with('alert-msg', 'A sua password permanece inalterada!')
            ->with('alert-type', 'success');
    }

    public function destroy(User $staff)
    {
        $oldName = $staff->name;
        $oldUrlFoto = $staff->foto_url;
        try {

            Storage::delete('public/fotos/' . $oldUrlFoto);
            $staff->delete();
            return redirect()->route('admin.staff')
                ->with('alert-msg', 'Staff "' . $staff->name . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('admin.staff')
                    ->with('alert-msg', 'Não foi possível apagar o staff "' . $oldName . '", porque este staff já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.staff')
                    ->with('alert-msg', 'Não foi possível apagar o staff "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    public function destroy_foto(User $staff)
    {
        Storage::delete('public/fotos/' . $staff->foto_url);
        $staff->foto_url = null;
        $staff->save();
        return redirect()->route('admin.staff.edit', ['staff' => $staff])
            ->with('alert-msg', 'Foto do staff "' . $staff->name . '" foi removida!')
            ->with('alert-type', 'success');
    }
}
