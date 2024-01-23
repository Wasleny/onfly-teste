<?php

namespace App\Policies;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DespesaPolicy
{
    /**
     * Determina se o usuário pode visualizar a listagem de despesas
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determina se o usuário pode visualizar uma despesa específica
     */
    public function view(User $user, Despesa $despesa): bool
    {
        return $user->id === $despesa->user_id;
    }

    /**
     * Determina se o usuário pode criar uma despesa
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determina se o usuário pode atualizar uma despesa específica
     */
    public function update(User $user, Despesa $despesa): bool
    {
        return $user->id === $despesa->user_id;
    }

    /**
     * Determina se o usuário pode excluir uma despesa específica
     */
    public function delete(User $user, Despesa $despesa): bool
    {
        return $user->id === $despesa->user_id;
    }
}
