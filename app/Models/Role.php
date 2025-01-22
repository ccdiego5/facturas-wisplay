<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $incrementing = false; // Indica que la clave primaria no es incremental
    protected $keyType = 'string'; // La clave primaria es de tipo string (UUID)

    protected $fillable = [
        'id',
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
