<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes, Factories\HasFactory};
use Illuminate\Support\Str;
class Botmessage extends Model
{
    use HasFactory, SoftDeletes;

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    protected $guarded = [];
    
    public function CssClass()
    {
        return;
    }

    public static $DisplayButtons = ['add' => true, 'show' => true, 'edit' => true, 'create' => true, 'delete' => true, 'import' => false, 'export' => false];

    public $displayColumns = [
        'welcome_message' => [
            'table' => [
                'column' => [
                    ['welcome_message()'], 
                ],
                'title' => 'welcome_message',
            ],
        ],
        'excuse_message' => [
            'table' => [
                'column' => [
                    ['excuse_message()'], 
                ],
                'title' => 'excuse_message',
            ],
        ],
        'cancel_message' => [
            'table' => [
                'column' => [
                    ['cancel_message()'], 
                ],
                'title' => 'cancel_message',
            ],
        ],

        'bot_id' => [
            'filter' => [],
        ],

    ];

    public function welcome_message(){
        return Str::limit($this->welcome_message, 50, '...');
    }
    public function excuse_message(){
        return Str::limit($this->excuse_message, 50, '...');
    }
    public function cancel_message(){
        return Str::limit($this->cancel_message, 50, '...');
    }

    public function can($permission)
    {
        return static::$DisplayButtons[$permission];
    }

}
