<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Like\LikeCollection;
use App\Http\Resources\Like\LikeResource;
use App\Http\Resources\News\NewsCollection;
use App\Http\Resources\News\NewsResource;
use App\Repositories\Interfaces\CrudRepositoryInterface;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    public function __construct(
        private readonly CrudRepositoryInterface $newsRepository,
        private readonly NewsService             $newsService
    ) {}

    /**
     * @param Request $request
     * @return NewsCollection
     */
    public function index(Request $request): NewsCollection
    {
        $news = $this->newsRepository->getAll($request);

        return new NewsCollection($news);
    }

    /**
     * @param StoreNewsRequest $request
     * @return NewsResource
     */
    public function store(StoreNewsRequest $request): NewsResource
    {
        $response = $this->newsRepository->create($request->validated());

        if ($request->file('attachment')) {
            $this->newsService->uploadAttachment($response->id, $request->file('attachment'));
        }

        return NewsResource::make($response);
    }

    /**
     * @param int $id
     * @return NewsResource
     */
    public function show(int $id): NewsResource
    {
        $news = $this->newsRepository->getById($id);

        return NewsResource::make($news);
    }

    /**
     * @param UpdateNewsRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateNewsRequest $request, int $id): Response
    {
        $this->newsRepository->update($id, $request->validated());

        if ($request->file('attachment')) {
            $this->newsService->uploadAttachment($id, $request->file('attachment'));
        }

        return response()->noContent();
    }

    /**
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        $this->newsRepository->delete($id);

        return response()->noContent();
    }

    /**
     * @param int $id
     * @return CommentResource|Response
     */
    public function getComments(int $id): CommentCollection|Response
    {
        $news = $this->newsRepository->getById($id);

        if ($news) {
            return new CommentCollection($news->comments);
        }

        return response(['error' => 'News item not found.'], 404);
    }

    /**
     * @param StoreCommentRequest $request
     * @param int $id
     * @return CommentResource|Response
     */
    public function addComment(StoreCommentRequest $request, int $id): CommentResource|Response
    {
        $news = $this->newsRepository->getById($id);

        if ($news) {
            $comment = $this->newsService->addComment($request->user(), $request->validated(), $news);
            return new CommentResource($comment);
        }

        return response(['error' => 'News item not found.'], 404);
    }

    /**
     * @param int $id
     * @return LikeCollection|Response
     */
    public function getLikes(int $id): LikeCollection|Response
    {
        $news = $this->newsRepository->getById($id);

        if ($news) {
            return new LikeCollection($news->likes);
        }

        return response(['error' => 'News item not found.'], 404);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return LikeResource|Response
     */
    public function addLike(Request $request, int $id): LikeResource|Response
    {
        $news = $this->newsRepository->getById($id);

        if ($news) {
            $like = $this->newsService->addLike($request->user(), $news);
            return new LikeResource($like);
        }

        return response(['error' => 'News item not found.'], 404);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function removeLike(Request $request, int $id): Response
    {
        $news = $this->newsRepository->getById($id);

        if ($news) {
            $this->newsService->removeLike($request->user(), $news);
            return response()->noContent();
        }

        return response(['error' => 'News item not found.'], 404);
    }
}
