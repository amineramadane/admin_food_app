<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes, Factories\HasFactory};
use HelperSelects;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    public static $DisplayButtons = ['add' => false, 'show' => false, 'edit' => false, 'create' => false, 'delete' => true, 'import' => false, 'export' => true];

    public $fillable  = ['customer_id', 'question_id', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function getCancelMsg($language_id = null)
    {
        $question = $bot = $cancel_msg = null;
        $question = $this->question()->first();
        if ($question) $bot = $question->bot()->first();
        if ($bot) $cancel_msg = $bot->botmessage()->where(['language_id' => $language_id])->first();
        return optional($cancel_msg)->cancel_message ?? null;
    }

    public function CssClass()
    {
        return;
    }

    public $displayColumns = [
        'customer_id' => [
            'table' => [
                'column' => [
                    ['customer', 'full_name'],
                ],
                'title' => 'full name',
            ],

            'splitedWith' => ' ',
        ],
        'question_id' => [
            'table' => [
                'column' => [
                    ['question', 'title']
                ],
                'title' => 'Question',
            ],
            'filter' => [
                'type' => 'select',
                'placeholder' => 'Question',
                'list' => 'ListQuestion',
                'pos' => 2
            ],
        ],
        'status' => [
            'table' => [
                'column' => [['status()']],
                'columnColor' => 'status',
                'title' => 'Status',
            ],
            'filter' => [
                'type' => 'select',
                'placeholder' => 'status',
                'list' => 'ListStatus',
                'pos' => 3,
            ],
        ],
        'answer' => [
            'table' => [
                'column' => [],
                'title' => 'Answer'
            ],
            'filter' => [
                'by' => ['answer'],
                'type' => 'like',
                'placeholder' => 'Answer',
                'pos' => 4,
            ],
        ],
        'created_at' => [
            'table' => [
                'column' => [['created_at']],
                'title' => 'Sending Date'
            ],
            'filter' => [
                'placeholder' => 'Sending Date',
                'type' => 'dateRange',
                'by' => ['created_at_start', 'created_at_end'],
            ],
        ],
        'answered_at' => [
            'table' => [
                'column' => [['answered_at']],
                'title' => 'Answer date'
            ],
            'filter' => [
                'placeholder' => 'Answer date',
                'type' => 'dateRange',
                'by' => ['answered_at_start', 'answered_at_end'],
            ],
        ],
    ];


    public function can($permission)
    {
        return static::$DisplayButtons[$permission];
    }
    public function status()
    {
        return HelperSelects::Answer_STATUS[$this->status] ?? '';
    }

    protected static function booted()
    {
        static::addGlobalScope('showAnswersActiveBot', function (Builder $builder) {
            $builder->whereRelation('question.bot', 'status', '<>', 1);
        });
    }
}
