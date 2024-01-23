<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DataValida implements ValidationRule
{
    /**
     * Verifica se a data informada na request não está no futuro.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dataAtual = Carbon::now();

        $dataDespesa = Carbon::createFromFormat('Y-m-d', $value);

        if ($dataDespesa->greaterThan($dataAtual)) {
            $fail("A {$attribute} está no futuro.");
        }
    }
}
