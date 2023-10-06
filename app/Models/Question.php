<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes, Factories\HasFactory};
use HelperSelects;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    public function questionlanguage()
    {
        return $this->hasMany(Questionlanguage::class);
    }

    public function answer()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * return the next question if exist
     * @return Question object
     */
    public function getNextQuestion($language_id = null){ 
        $nextQuesId = optional(Question::where('bot_id', '=', $this->bot_id)->where('status', '=', 2)->where('position', '>', $this->position)->orderBy('position','asc'))->first('id');
        $nextQues = $nextQuesId ? optional(Question::find($nextQuesId))->first() : null;
        return $nextQues ? $nextQues->questionlanguage()->where('language_id', $language_id)->first() : null;
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

        'bot_id' => [
            'filter' => [],
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
