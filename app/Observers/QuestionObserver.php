<?php

namespace App\Observers;

use App\Models\Question;

class QuestionObserver
{
    /**
     * Handle the Question "created" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function creating(Question $question)
    {
        $lastposition = optional(Question::where('bot_id', '=', $question->bot_id)->orderBy('position','desc')->first('position'))->position;
        if($lastposition) $question->position = $lastposition + 1;
        else $question->position = 1;
    }

    public function created(Question $question)
    {
        //
    }

    /**
     * Handle the Question "updated" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function updated(Question $question)
    {
        if($question->question_type == 1){
            Question::where('id', '=', $question->id)->update(['condition' => '0:10']);
        }
        
    }

    /**
     * Handle the Question "deleted" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function deleted(Question $question)
    {
        //
    }

    /**
     * Handle the Question "restored" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function restored(Question $question)
    {
        //
    }

    /**
     * Handle the Question "force deleted" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function forceDeleted(Question $question)
    {
        //
    }
}
