<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes, Factories\HasFactory};
use HelperSelects;
class Customer extends Model
{
    use HasFactory, SoftDeletes;

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public static $DisplayButtons = ['add' => true, 'show' => true, 'edit' => true, 'create' => true, 'delete' => true, 'import' => true, 'export' => false];

    // protected $fillable = [];
    protected $guarded = [];
    public function CssClass()
    {
        return;
    }

    public $displayColumns = [

        'full_name' => [
            'table' => [
                'column' => [
                    ['full_name'],
                ],
                'title' => 'full name',
            ],

            'splitedWith' => ' ',

            'filter' => [
                'by' => ['full_name'],
                'type' => 'like',
                'placeholder' => 'full name',
                'pos' => 1,
            ],
        ],

        'phone' => [
            'table' => [
                'column' => [
                    ['phone']
                ],
                'title' => 'Phone',
            ],
            'filter' => [
                'by' => ['phone'],
                'type' => 'like',
                'placeholder' => 'Phone',
                'pos' => 2,
            ],
        ],

        'email' => [
            'table' => [
                'column' => [
                    ['email']
                ],
                'title' => 'Email',
            ],
            'filter' => [
                'by' => ['email'],
                'type' => 'like',
                "placeholder"=> "Email",
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

    public function status()
    {
        return HelperSelects::Customer_STATUS[$this->status] ?? '';
    }
}
