<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes, Factories\HasFactory};
use HelperSelects;

class Bot extends Model
{
    use HasFactory, SoftDeletes;

    public function question()
    {
        return $this->hasMany(Question::class);
    }
    public function botmessage()
    {
        return $this->hasMany(Botmessage::class);
    }

    protected $guarded = [];
    public function CssClass()
    {
        return;
    }

    public static $DisplayButtons = ['add' => true, 'show' => true, 'edit' => true, 'create' => true, 'delete' => true, 'import' => false, 'export' => false];

    public $displayColumns = [

        'title' => [
            'table' => [
                'column' => [
                    ['title'],
                ],
                'title' => 'title',
            ],

            'filter' => [
                'by' => ['title'],
                'type' => 'like',
                'placeholder' => 'title',
                'pos' => 1,
            ],
        ],

        'status' => [
            'table' => [
                'column' => [
                    ['statusString()']
                ],
                'columnColor' => 'status',
                'title' => 'status',
            ],
            'filter' => [
                'by' => ['status'],
                'type' => 'select',
                'placeholder' => 'Status',
                'list' => 'ListStatus',
                'pos' => 2,
            ],
        ],

        'reminder_time' => [
            'table' => [
                'column' => [
                    ['reminder_time'],
                ],
                'title' => 'Reminder time',
            ]
        ],

        'description' => [
            'table' => [
                'column' => [
                    ['description']
                ],
                'title' => 'Description',
            ],
        ],

    ];

    public function can($permission)
    {
        return static::$DisplayButtons[$permission];
    }

    public function statusString()
    {
        return HelperSelects::OnOff[$this->status] ?? '';
    }
}
