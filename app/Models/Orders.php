<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    const STATUS_CREATED = 'CREATED';
    const STATUS_PAYED = 'PAYED';
    const STATUS_REJECTED = 'REJECTED';

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_mobile',
        'status',
    ];

    use HasFactory;
}
