<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketProduct extends Model
{
    use HasFactory;

    protected $appends = ['total', 'totalHt'];

    protected $fillable = [
        'basket_id',
        'product_id',
        'quantity',
    ];


    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute() {
        
        return $this->product->price * $this->quantity;
    }

    public function getTotalHtAttribute() {
        
        return $this->product->ht_price * $this->quantity;
    }

}
