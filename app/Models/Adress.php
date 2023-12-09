<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Adress extends Model{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'address';
    protected $fillable = [
        'cep',
        'numero_endereco',
        'complemento',
        'logradouro',
        'bairro',
        'localidade',
        'uf',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
