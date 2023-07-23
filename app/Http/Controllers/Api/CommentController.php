<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{

    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store($uuid, CommentRequest $request)
    {

        $data = $this->commentRepository->create($uuid, $request->all());

        return (new CommentResource(true, 'Comment has been posted', $data))
            ->response()
            ->setStatusCode(200);
    }
}
