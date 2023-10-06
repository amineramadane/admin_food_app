<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes, Factories\HasFactory};
use Illuminate\Support\Str;

class Questionlanguage extends Model
{
    use HasFactory, SoftDeletes;
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    public function CssClass()
    {
        return;
    }

    public static $DisplayButtons = ['add' => true, 'show' => true, 'edit' => true, 'create' => true, 'delete' => true, 'import' => false, 'export' => false];

    public $displayColumns = [

        'message' => [
            'table' => [
                'column' => [
                    ['message()'], 
                ],
                'title' => 'message',
            ],
        ],
        'error_message' => [
            'table' => [
                'column' => [
                    ['error_message()'], 
                ],
                'title' => 'error_message',
            ],
        ],

        'question_id' => [
            'filter' => [],
        ],

        'language_id' => [
            'table' => [
                'column' => [
                    ['language','title'],
                ],
                'title' => 'language',
            ],

            // 'filter' => [
            //     'by' => ['language_id'],
            //     'type' => 'select',
            //     'placeholder' => 'Language',
            //     'list' => 'ListLang',
            //     'pos' => 4,
            // ],
        ],
    ];

    public function message(){
        return Str::limit($this->message, 50, '...');
    }
    public function error_message(){
        return Str::limit($this->error_message, 50, '...');
    }

    public function can($permission)
    {
        return static::$DisplayButtons[$permission];
    }
}
