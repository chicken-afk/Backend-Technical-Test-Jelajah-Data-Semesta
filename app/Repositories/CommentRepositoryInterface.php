<?php

namespace App\Repositories;

interface CommentRepositoryInterface
{
    public function create(string $uuid, array $data);
}
