<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Resources\Blog\BlogCollection;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Like\LikeCollection;
use App\Http\Resources\Like\LikeResource;
use App\Repositories\Interfaces\CrudRepositoryInterface;
use App\Services\BlogService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogController extends Controller
{
    public function __construct(
        private readonly CrudRepositoryInterface $blogRepository,
        private readonly BlogService             $blogService
    ) {}

    /**
     * @param Request $request
     * @return BlogCollection
     */
    public function index(Request $request): BlogCollection
    {
        $blog = $this->blogRepository->getAll($request);

        return new BlogCollection($blog);
    }

    /**
     * @param StoreBlogRequest $request
     * @return BlogResource
     */
    public function store(StoreBlogRequest $request): BlogResource
    {
        $response = $this->blogRepository->create($request->validated());

        if ($request->file('attachment')) {
            $this->blogService->uploadAttachment($response->id, $request->file('attachment'));
        }

        return BlogResource::make($response);
    }

    /**
     * @param int $id
     * @return BlogResource
     */
    public function show(int $id): BlogResource
    {
        $blog = $this->blogRepository->getById($id);

        return BlogResource::make($blog);
    }

    /**
     * @param UpdateBlogRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateBlogRequest $request, int $id): Response
    {
        $this->blogRepository->update($id, $request->validated());

        if ($request->file('attachment')) {
            $this->blogService->uploadAttachment($id, $request->file('attachment'));
        }

        return response()->noContent();
    }

    /**
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        $this->blogRepository->delete($id);

        return response()->noContent();
    }

    /**
     * @param int $id
     * @return CommentResource|Response
     */
    public function getComments(int $id): CommentCollection|Response
    {
        $blog = $this->blogRepository->getById($id);

        if ($blog) {
            return new CommentCollection($blog->comments);
        }

        return response(['error' => 'Blog item not found.'], 404);
    }

    /**
     * @param StoreCommentRequest $request
     * @param int $id
     * @return CommentResource|Response
     */
    public function addComment(StoreCommentRequest $request, int $id): CommentResource|Response
    {
        $blog = $this->blogRepository->getById($id);

        if ($blog) {
            $comment = $this->blogService->addComment($request->user(), $request->validated(), $blog);
            return new CommentResource($comment);
        }

        return response(['error' => 'Blog item not found.'], 404);
    }

    /**
     * @param int $id
     * @return LikeCollection|Response
     */
    public function getLikes(int $id): LikeCollection|Response
    {
        $blog = $this->blogRepository->getById($id);

        if ($blog) {
            return new LikeCollection($blog->likes);
        }

        return response(['error' => 'Blog item not found.'], 404);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return LikeResource|Response
     */
    public function addLike(Request $request, int $id): LikeResource|Response
    {
        $blog = $this->blogRepository->getById($id);

        if ($blog) {
            $like = $this->blogService->addLike($request->user(), $blog);
            return new LikeResource($like);
        }

        return response(['error' => 'Blog item not found.'], 404);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function removeLike(Request $request, int $id): Response
    {
        $blog = $this->blogRepository->getById($id);

        if ($blog) {
            $this->blogService->removeLike($request->user(), $blog);
            return response()->noContent();
        }

        return response(['error' => 'Blog item not found.'], 404);
    }
}
