<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\CommentTrait;
use Illuminate\Http\Response;

class DeleteCommentController extends Controller
{
    use CommentTrait;

    /**
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        $this->deleteComment($id);
        return response()->noContent();
    }
}
