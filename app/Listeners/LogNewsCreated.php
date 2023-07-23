<?php

namespace App\Listeners;

use App\Events\CreatedNews;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;

class LogNewsCreated implements ShouldQueue
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
     * @param  \App\Events\CreatedNews  $event
     * @return void
     */
    public function handle(CreatedNews $event)
    {
        $request = Request::capture();
        \DB::table('news_log')->insert([
            'user_id' => auth()->user()->id,
            'row_id' => $event->news->id,
            'action' => 'created',
            'ip_address' => $request->ip(),
            'message' => auth()->user()->name . " Membuat data berita " . $event->news->title,
            'created_at' => now(),
            'new_data' => $event->news
        ]);
    }
}
