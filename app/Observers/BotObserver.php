<?php

namespace App\Observers;

use App\Models\Bot;

class BotObserver
{
    /**
     * Handle the Bot "created" event.
     *
     * @param  \App\Models\Bot  $bot
     * @return void
     */
    public function created(Bot $bot)
    {
        if($bot->status == 2) Bot::where('id', '<>', $bot->id)->update(['status' => 1]);
    }

    /**
     * Handle the Bot "updated" event.
     *
     * @param  \App\Models\Bot  $bot
     * @return void
     */
    public function updated(Bot $bot)
    {
        if($bot->status == 2) Bot::where('id', '<>', $bot->id)->update(['status' => 1]);
    }

    /**
     * Handle the Bot "deleted" event.
     *
     * @param  \App\Models\Bot  $bot
     * @return void
     */
    public function deleted(Bot $bot)
    {
        //
    }

    /**
     * Handle the Bot "restored" event.
     *
     * @param  \App\Models\Bot  $bot
     * @return void
     */
    public function restored(Bot $bot)
    {
        //
    }

    /**
     * Handle the Bot "force deleted" event.
     *
     * @param  \App\Models\Bot  $bot
     * @return void
     */
    public function forceDeleted(Bot $bot)
    {
        //
    }
}
