<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\Comment;

class ProcessRedisData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:redis-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process and save comment Redis data to MySQL database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $redisData = Redis::lrange('news:comments', 0, -1);

        // Simpan data ke database MySQL
        foreach ($redisData as $data) {
            $value = json_decode($data);

            // Simpan data ke dalam tabel Comment
            Comment::create([
                'uuid' => $value->uuid,
                'berita_id' => $value->berita_id,
                'user_id' => $value->user_id,
                'comment' => $value->comment
            ]);
            Redis::lrem('news:comments', 0, $data);
        }

        $this->info('Data from Redis has been processed and saved to MySQL.');
    }
}
