<?php

namespace FaithGen\Gallery\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaithGen\Gallery\Http\Requests\ImageCommentRequest;
use FaithGen\SDK\Helpers\CommentHelper;
use FaithGen\SDK\Services\ImageService;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function comment(ImageCommentRequest $request)
    {
        return CommentHelper::createComment($this->imageService->getImage(), $request);
    }
}
