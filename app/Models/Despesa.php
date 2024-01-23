<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descricao',
        'data',
        'valor',
        'user_id'
    ];

    /**
     * Retorna o relacionamento belongsTo com a tabela User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
