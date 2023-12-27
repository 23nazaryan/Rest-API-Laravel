<?php

namespace App\Http\Controllers\Api;

use App\Facades\Likefacade;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Like\StoreRequest;
use App\Http\Requests\Like\IndexRequest;
use App\Http\Resources\Like\LikeResource;
use App\Http\Resources\Like\LikeCollection;

class LikeController extends Controller
{
    /**
     * @param IndexRequest $request
     * @return LikeCollection
     */
    public function index(IndexRequest $request): LikeCollection
    {
        $comment = Likefacade::getAll($request->validated());

        return new LikeCollection($comment);
    }

    /**
     * @param StoreRequest $request
     * @return LikeResource
     */
    public function store(StoreRequest $request): LikeResource
    {
        $requestData = $request->validated();
        $requestData['user_id'] = $request->user()->id;
        $comment = Likefacade::create($requestData);

        return LikeResource::make($comment);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        Likefacade::delete($id);

        return response()->noContent();
    }
}
