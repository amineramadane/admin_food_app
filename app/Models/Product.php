<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    private static function calculateTTC($ht_pr, $vate_r = 0)
    {
        return $ht_pr + (($ht_pr * $vate_r) / 100);
    }

    public static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {

            $vatRate = $model->vat_rate;
            $ht_price = $model->ht_price;

            $model->price = self::calculateTTC($ht_price, $vatRate);
        });

        static::created(function ($model) {

            $vatRate = $model->vat_rate;
            $ht_price = $model->ht_price;

            $model->price = self::calculateTTC($ht_price, $vatRate);
        });

        static::updated(function ($model) {

            $vatRate = $model->vat_rate;
            $ht_price = $model->ht_price;

            $model->price = self::calculateTTC($ht_price, $vatRate);
        });
    }
}
