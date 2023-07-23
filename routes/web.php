<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use App\Models\Comment;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-redis', function () {
    $redisData = Redis::lrange('news:comments', 0, -1);
    dd($redisData);
    foreach ($redisData as $data) {
        $data = json_decode($data);

        // Simpan data ke dalam tabel Comment
        Comment::create([
            'uuid' => $data->uuid,
            'berita_id' => $data->berita_id,
            'user_id' => $data->user_id,
            'comment' => $data->comment
        ]);
    }
});
