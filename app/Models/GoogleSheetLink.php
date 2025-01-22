<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleSheetLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'url_sheet',
    ];

    public $incrementing = false; // Indicamos que el ID no es incremental
    protected $keyType = 'string'; // El ID será de tipo UUID

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
