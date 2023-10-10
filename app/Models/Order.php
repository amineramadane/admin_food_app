<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'reference',
        'user_id',
        'basket_id' 
    ];

    public function basket() {
        return $this->belongsTo(Basket::class);
    }

}
