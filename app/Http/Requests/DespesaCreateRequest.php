<?php

namespace App\Http\Requests;

use App\Models\Despesa;
use App\Rules\DataValida;
use Illuminate\Foundation\Http\FormRequest;

class DespesaCreateRequest extends FormRequest
{
    /**
     * Determina se o usuário tem permissão para realizar a request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Despesa::class);
    }

    /**
     * Pega as regras de validação para aplicar na request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data' => ['required', 'date_format:Y-m-d', new DataValida],
            'valor' => ['required', 'gte:0'],
            'descricao' => ['required', 'max:191']
        ];
    }
}
