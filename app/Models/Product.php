<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use HelperSelects;
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


    protected $appends = ['pathImage'];

    public static $DisplayButtons = ['show' => true, 'edit' => true, 'create' => true, 'delete' => true, 'import' => false, 'export' => true];

    // protected $fillable = [];
    protected $guarded = [];
    public function CssClass()
    {
        return;
    }

    public $displayColumns = [

        'image' => [
            'table' => [
                'column' => [
                    ['path_image'],
                ],
                'title' => 'Image',
                'is_image' => true,
            ],
        ],
        'name' => [
            'table' => [
                'column' => [
                    ['name'],
                ],
                'title' => 'name',
            ],

            'filter' => [
                'by' => ['name'],
                'type' => 'like',
                'placeholder' => 'name',
                'pos' => 1,
            ],
        ],

        'category' => [
            'table' => [
                'column' => [
                    ['category', 'name'],
                ],
                'title' => 'category',
            ],

            'filter' => [
                'by' => ['category.name'],
                'type' => 'like',
                'placeholder' => 'category',
                'pos' => 2,
            ],
        ],

        'active' => [
            'table' => [
                'column' => [['activeOrInactive()']],
                'columnColor' => 'active',
                'title' => 'Active',
            ],
            'filter' => [
                'by' => ['active'],
                'type' => 'select',
                'placeholder' => 'active',
                'list' => 'ListBoolean',
                'pos' => 3,
            ],
        ],
        'created_at' => [
            'table' => [
                'column' => [['created_at']],
                'title' => 'created at'
            ],
            'filter' => [
                'placeholder' => 'created at',
                'type' => 'dateRange',
                'by' => ['created_at_start', 'created_at_end'],
            ],
        ],

    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function can($permission)
    {
        return static::$DisplayButtons[$permission];
    }

    public function activeOrInactive()
    {
        return HelperSelects::Boolean[$this->active] ?? '';
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }


    public function getPathImageAttribute($value) {
        return optional($this->image)->path;
    }

}
