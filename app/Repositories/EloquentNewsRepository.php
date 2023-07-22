<?php

namespace App\Repositories;

use App\Repositories\NewsRepositoryInterface;
use App\Models\Berita as News;
use Str;
use App\Services\ImageUpload;
use App\Services\SlugGenerator;
use App\Events\CreatedNews;
use App\Events\UpdatedNews;
use App\Events\DeletedNews;

class EloquentNewsRepository implements NewsRepositoryInterface
{
    public function all()
    {
        return News::orderBy('id', 'desc')->paginate(10);
    }

    public function find(string $slug)
    {
        return News::where('slug', $slug)->with('comments.user')->first();
    }

    public function create(array $data)
    {

        /**Change Image Base64 to image */
        $image = new ImageUpload($data['image']);
        /**End */
        $slug = new SlugGenerator("beritas", "slug", $data['title']);

        $data['created_by_id'] = auth()->user()->id;
        $data["image"] = $image->save("photo/news");
        $data['uuid'] = Str::uuid();
        $data['slug'] = $slug->getSlug();

        $news = News::create($data);
        /**
         * Call Event Store NEws
         */
        event(new CreatedNews($news));

        return $news;
    }

    public function update(string $uuid, array $data)
    {
        $news = News::where('uuid', $uuid)->first();
        $oldNews = $news;
        // Throw your custom exception here ...
        // if (!$news) {
        //     // throw new CustomException("My Custom Message");
        // }
        if (!$news) throw new \App\Exceptions\CustomException("News not found with UUID: $uuid", 404);

        /**Check Jika Gambar Berubah */
        if (array_key_exists('image', $data)) {
            $image = new ImageUpload($data['image']);
            $news["image"] = $image->save("photo/news");
        }

        $slug = new SlugGenerator("beritas", "slug", $data['title']);
        $news->title = $data['title'];
        $news->content = $data['content'];
        $news->slug = $slug->getSlug();
        $news->save();

        event(new UpdatedNews($news, $oldNews));

        return $news;
    }

    public function delete(string $uuid)
    {
        $news = News::where('uuid', $uuid)->withTrashed()->first();

        if (!$news) throw new \App\Exceptions\CustomException("News not found with UUID: $uuid", 404);

        News::where('uuid', $uuid)->update([
            'deleted_by_id' => auth()->user()->id,
            'deleted_at' => now()
        ]);

        event(new DeletedNews($news));

        return $news;
    }
}
