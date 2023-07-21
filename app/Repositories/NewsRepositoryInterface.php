<?php

namespace App\Repositories;

use App\Models\Berita as News;

interface NewsRepositoryInterface
{
    public function all();

    public function find(string $slug);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
