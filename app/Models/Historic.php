<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Historic extends Model{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'historic';
    protected $fillable = [
        'value',
        'operation',
        'id_account'
    ];
    public function account()
    {
        return $this->belongsTo(Account::class, 'id_account', 'id');
    }
    public $timestamps = false;
}
