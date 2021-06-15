<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Encomendas;
use Illuminate\Auth\Access\HandlesAuthorization;

class EncomendasPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view_encomendas_mudarEstado(User $user, Encomendas $encomenda)
    {
        if($user->isAdmin())
        {
            return true;
        }
        else
        {
            if($encomenda->estado == 'pendente' || $encomenda->estado == 'paga')
            {
                return true;
            }
            return false;
        }
    }
}
