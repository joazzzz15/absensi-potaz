<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UndianBatch extends Model
{
    protected $fillable = [
        'batch_ke',
        'data_pemenang',
    ];

    protected $casts = [
        'data_pemenang' => 'array',
    ];
}