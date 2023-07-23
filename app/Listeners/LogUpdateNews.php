<?php

namespace App\Listeners;

use App\Events\UpdatedNews;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;

class LogUpdateNews implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UpdatedNews  $event
     * @return void
     */
    public function handle(UpdatedNews $event)
    {
        $request = Request::capture();
        \DB::table('news_log')->insert([
            'user_id' => auth()->user()->id,
            'row_id' => $event->news->id,
            'action' => 'edited',
            'ip_address' => $request->ip(),
            'message' => auth()->user()->name . " Merubah data berita " . $event->news->title,
            'created_at' => now(),
            'new_data' => $event->news,
            'old_data' => $event->oldNews
        ]);
    }
}
