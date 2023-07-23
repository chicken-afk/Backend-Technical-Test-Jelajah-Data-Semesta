<?php

namespace App\Repositories;

use App\Models\Berita as News;

interface NewsRepositoryInterface
{
    public function all();

    public function find(string $slug);

    public function create(array $data);

    public function update(string $uuid, array $data);

    public function delete(string $id);
}
