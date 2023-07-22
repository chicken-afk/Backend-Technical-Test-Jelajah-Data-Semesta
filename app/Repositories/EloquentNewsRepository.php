<?php

namespace App\Repositories;

use App\Repositories\NewsRepositoryInterface;
use App\Models\Berita as News;
use Str;
use App\Services\ImageUpload;
use App\Services\SlugGenerator;

class EloquentNewsRepository implements NewsRepositoryInterface
{
    public function all()
    {
        return News::orderBy('id', 'desc')->paginate(10);
    }

    public function find(string $slug)
    {
        return News::where('slug', $slug)->with('comments')->first();
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

        return News::create($data);
    }

    public function update(string $uuid, array $data)
    {
        $news = News::where('uuid', $uuid)->first();
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
        return $news;
    }

    public function delete(string $uuid)
    {
        News::where('uuid', $uuid)->update([
            'deleted_by_id' => auth()->user()->id,
            'deleted_at' => now()
        ]);
        $news = News::where('uuid', $uuid)->withTrashed()->first();

        if (!$news) throw new \App\Exceptions\CustomException("News not found with UUID: $uuid", 404);

        return $news;
    }
}
