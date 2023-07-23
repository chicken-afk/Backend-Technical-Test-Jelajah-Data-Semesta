<?php

namespace App\Repositories;

use App\Repositories\CommentRepositoryInterface;
use App\Models\Berita as News;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\CustomException;
use Str;

class CommentRepository implements CommentRepositoryInterface
{
    public function create(string $uuid, array $data)
    {
        $news = News::where('uuid', $uuid)->first();
        if (!$news) throw new CustomException("News with uuid:$uuid not found", 404);

        Redis::rpush("news:comments", json_encode([
            'uuid' => Str::uuid(),
            'berita_id' => $news->id,
            'user_id' => auth()->user()->id,
            'comment' => $data['comment'],
            'created_at' => now(),
        ]));

        return true;
    }
}
