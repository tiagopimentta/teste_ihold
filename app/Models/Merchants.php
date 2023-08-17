<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchants extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_name',
        'admin_id',
       'created_at',
       'updated_at'
    ];
}
