<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes, Factories\HasFactory};
use HelperSelects;

class Chatlog extends Model
{
    use HasFactory, SoftDeletes;
    
    public $guarded = [];

    public static $DisplayButtons = ['add' => false, 'show' => false, 'edit' => false, 'create' => false, 'delete' => true, 'import' => false, 'export' => false];
    
    public function CssClass() { return ; }

    public $displayColumns = [
        'phone' => [
            'table' => [
                'column' => []
            ],
            'filter' => [
                'type' => 'like',
                'pos' => 1,
            ],
        ],
        'type' => [
            'table' => [
                'column' => [
                    'type' => [
                        'selectType()'
                    ]
                ]
            ],
            'filter' => [
                'type' => 'select',
                'placeholder' => 'Type',
                'list' => 'ListType'
            ],
        ],
        'status' => [
            'table' => [
                'column' => [['selectStatus()']],
                'columnColor' => 'status',
                'title' => 'Status',
            ],
            'filter' => [
                'type' => 'select',
                'placeholder' => 'Status',
                'list' => 'ListStatus'
            ],
        ],
        'message' => [
            'table' => [
                'column' => [
                    'message' =>[
                        'shortMessage()'
                    ]
                    ],
                'title' => 'Value'
            ]
        ],
        'created_at' => [
            'table' => [
                'column' => [['created_at']],
                'title' => 'date'
            ],
            'filter' => [
                'placeholder' => 'Date',
                'type' => 'dateRange',
                'by' => ['created_at_start', 'created_at_end'],
            ],
        ],
    ];


    public function can($permission)
    {
        return static::$DisplayButtons[$permission]; 
    }

    public function selectType(){
        return HelperSelects::CHATLOG_TYPE[$this->type] ?? '';
    }

    public function selectStatus(){
        return HelperSelects::CHATLOG_STATUS[$this->status] ?? '';
    }

    public function shortMessage(){
        return (strlen($this->message) <= 50 ? $this->message : substr($this->message, 0,50).'...');
    }
}
