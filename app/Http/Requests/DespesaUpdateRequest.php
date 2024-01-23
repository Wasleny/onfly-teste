<?php

namespace App\Http\Requests;

use App\Models\Despesa;
use App\Rules\DataValida;
use Illuminate\Foundation\Http\FormRequest;

class DespesaUpdateRequest extends FormRequest
{
    /**
     * Determina se o usuário tem permissão para realizar a request.
     */
    public function authorize(): bool
    {
        $despesa = Despesa::where('id', $this->id)->first();
        return $this->user()->can('update', $despesa);
    }

    /**
     * Pega as regras de validação para aplicar na request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data' => ['date_format:d/m/Y', new DataValida],
            'valor' => ['gte:0'],
            'descricao' => ['max:191']
        ];
    }
}
