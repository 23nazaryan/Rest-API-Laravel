<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Facades\ArticleFacade;
use App\Facades\AttachmentFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\IndexRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\ArticleCollection;

class ArticleController extends Controller
{
    /**
     * @param IndexRequest $request
     * @return ArticleCollection
     */
    public function index(IndexRequest $request): ArticleCollection
    {
        $article = ArticleFacade::getAll($request->validated());
        return new ArticleCollection($article);
    }

    /**
     * @param StoreRequest $request
     * @return ArticleResource
     */
    public function store(StoreRequest $request): ArticleResource
    {
        $article = ArticleFacade::create($request->validated());
        $attachment = AttachmentFacade::uploadFile($request->file('attachment'));
        ArticleFacade::assignAttachment($article->id, $attachment);

        return ArticleResource::make($article);
    }

    /**
     * @param int $id
     * @return ArticleResource
     */
    public function show(int $id): ArticleResource
    {
        $article = ArticleFacade::getById($id);

        return ArticleResource::make($article);
    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateRequest $request, int $id): Response
    {
        ArticleFacade::update($id, $request->validated());

        if ($request->file('attachment')) {
            $attachment = AttachmentFacade::uploadFile($request->file('attachment'));
            ArticleFacade::assignAttachment($id, $attachment);
        }

        return response()->noContent();
    }

    /**
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        ArticleFacade::delete($id);

        return response()->noContent();
    }
}
