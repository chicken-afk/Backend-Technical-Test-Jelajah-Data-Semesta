<?php

namespace App\Listeners;

use App\Events\DeletedNews;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;

class LogDeletedNews implements ShouldQueue
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
     * @param  \App\Events\DeletedNews  $event
     * @return void
     */
    public function handle(DeletedNews $event)
    {
        $request = Request::capture();
        \DB::table('news_log')->insert([
            'user_id' => auth()->user()->id,
            'row_id' => $event->news->id,
            'action' => 'deleted',
            'ip_address' => $request->ip(),
            'message' => auth()->user()->name . " Menghapus data berita " . $event->news->title,
            'created_at' => now(),
            'old_data' => $event->news
        ]);
    }
}
