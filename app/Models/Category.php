<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes, Factories\HasFactory};
use HelperSelects;

use function PHPSTORM_META\type;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['pathImage'];

    public static $DisplayButtons = ['show' => true, 'edit' => true, 'create' => true, 'delete' => true, 'import' => false, 'export' => false];

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

        'active' => [
            'table' => [
                'column' => [['activeOrInactive()']],
                'columnColor' => 'status',
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
