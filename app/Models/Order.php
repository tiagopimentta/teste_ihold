<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS = [
        'PROGRESS',
        'COMPLETED',
        'CANCELED',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
