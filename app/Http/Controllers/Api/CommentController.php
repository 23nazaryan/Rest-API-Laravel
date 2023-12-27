<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Facades\CommentFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\IndexRequest;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Comment\CommentCollection;

class CommentController extends Controller
{
    /**
     * @param IndexRequest $request
     * @return CommentCollection
     */
    public function index(IndexRequest $request): CommentCollection
    {
        $comment = CommentFacade::getAll($request->validated());

        return new CommentCollection($comment);
    }

    /**
     * @param StoreRequest $request
     * @return CommentResource
     */
    public function store(StoreRequest $request): CommentResource
    {
        $requestData = $request->validated();
        $requestData['user_id'] = $request->user()->id;
        $comment = CommentFacade::create($requestData);

        return CommentResource::make($comment);
    }

    /**
     * @param int $id
     * @return CommentResource
     */
    public function show(int $id): CommentResource
    {
        $comment = CommentFacade::getById($id);

        return CommentResource::make($comment);
    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateRequest $request, int $id): Response
    {
        CommentFacade::update($id, $request->validated());

        return response()->noContent();
    }

    /**
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        CommentFacade::delete($id);

        return response()->noContent();
    }
}
