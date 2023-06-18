<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'brand_name',
        'generic_id',
        'company_id',
        'type',
        'strength',
        'price',
        'packsize',
        'status'
    ];
}
