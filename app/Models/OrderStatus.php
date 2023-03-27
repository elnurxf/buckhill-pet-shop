<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use Uuids;

    protected $fillable = [
        'title',
    ];
}
