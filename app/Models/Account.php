<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Model{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'account';
    protected $fillable = [
        'user_cpf',
        'balance',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'cpf', 'cpf');
    }
    public function historics()
    {
        return $this->hasMany(Historic::class, 'id_account', 'id');
    }
}
