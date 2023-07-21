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
        return News::paginate(20);
    }

    public function find(int $uuid)
    {
        return News::where('uuid', $uuid)->with('comments')->first();
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

    public function update(int $id, array $data)
    {
        $news = News::findOrFail($id);
        $news->update($data);
        return $news;
    }

    public function delete(int $id)
    {
        $news = News::findOrFail($id);
        $news->delete();
    }
}
