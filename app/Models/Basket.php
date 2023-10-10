<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $appends = ['total', 'quantityItems'];

    protected $fillable = [
        'user_id',
        'status',
    ];

    public function basketProducts() {
        return $this->hasMany(BasketProduct::class);
    }

    public function getTotalAttribute() {
        
        return $this->basketProducts->sum('total');
    }

    public function getQuantityItemsAttribute() {
        
        return $this->basketProducts->count();
    }
}
