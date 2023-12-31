<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\NewsResource;
use App\Models\Berita;
use App\Repositories\NewsRepositoryInterface;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateBeritaRequest;

class NewsController extends Controller
{

    protected $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->newsRepository->all();
        return (new NewsResource(true, 'Success Get List News', $data))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsRequest $request)
    {
        $news = $this->newsRepository->create($request->all());

        return (new NewsResource(true, 'Success Store News', $news))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return (new NewsResource(true, 'Success Show News', $this->newsRepository->find($slug)))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBeritaRequest $request, $uuid)
    {
        return (new NewsResource(true, 'Success Update News', $this->newsRepository->update($uuid, $request->all())))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        return (new NewsResource(true, 'Success Delete News', $this->newsRepository->delete($uuid)))
            ->response()
            ->setStatusCode(200);
    }
}
