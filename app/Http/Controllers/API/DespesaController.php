<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DespesaCreateRequest;
use App\Http\Requests\DespesaUpdateRequest;
use App\Http\Resources\DespesaResource;
use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DespesaController extends Controller
{
    /**
     * Lista todas as despesa do usuário autenticado
     */
    public function index()
    {
        if ($this->authorize('viewAny', Despesa::class)) {
            $despesas = Despesa::where('user_id', Auth::id())->get();

            return new DespesaResource($despesas);
        }

        abort(403);
    }

    /**
     * Cria despesa
     */
    public function create(DespesaCreateRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();

        $despesa = Despesa::create($input);

        return new DespesaResource($despesa);
    }

    /**
     * Lista uma despesa específica
     */
    public function show($id)
    {
        $despesa = Despesa::where('id', $id)->first();

        if ($this->authorize('view', $despesa)) {
            return new DespesaResource($despesa);
        }

        abort(403);
    }

    /**
     * Atualiza despesa
     */
    public function update(int $id, DespesaUpdateRequest $request)
    {
        Despesa::where('user_id', Auth::id())->where('id', $id)->update($request->all());

        return response(['message' => 'Despesa atualizada com sucesso.']);
    }

    /**
     * Exclui despesa
     */
    public function destroy(int $id)
    {
        $despesa = Despesa::where('id', $id)->first();

        if ($this->authorize('delete', $despesa)) {
            $despesa->delete();
            $despesa->save();

            return response(['message' => 'Despesa excluída com sucesso.']);
        }

        abort(403);
    }
}
