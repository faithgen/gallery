<?php

namespace FaithGen\Gallery\Http\Controllers;

use FaithGen\Gallery\Http\Requests\AddImagesRequest;
use FaithGen\Gallery\Http\Requests\CreateRequest;
use FaithGen\Gallery\Http\Requests\DeleteImageRequest;
use FaithGen\Gallery\Http\Requests\GetRequest;
use FaithGen\Gallery\Http\Requests\ImagesRequest;
use FaithGen\Gallery\Http\Requests\UpdateRequest;
use FaithGen\Gallery\Http\Resources\Album as AlbumResource;
use FaithGen\Gallery\Http\Resources\Image as ImageResource;
use FaithGen\Gallery\Jobs\ImageSaved\ProcessUploadedImage;
use FaithGen\Gallery\Jobs\ImageSaved\S3Upload;
use FaithGen\Gallery\Models\Album;
use FaithGen\Gallery\Services\AlbumService;
use FaithGen\SDK\Helpers\CommentHelper;
use FaithGen\SDK\Http\Requests\CommentRequest;
use FaithGen\SDK\Http\Requests\IndexRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use InnoFlash\LaraStart\Helper;
use InnoFlash\LaraStart\Traits\APIResponses;
use Intervention\Image\ImageManager;

class AlbumController extends Controller
{
    use AuthorizesRequests, APIResponses;

    /**
     * @var AlbumService
     */
    private $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    /**
     * Gets the albums.
     *
     * @param  IndexRequest  $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexRequest $request)
    {
        $albums = $this->albumService->getParentRelationship()->where('name', 'LIKE', '%'.$request->filter_text.'%')
            ->latest()
            ->paginate($request->has('limit') ? $request->limit : 15);

        AlbumResource::wrap('albums');

        return AlbumResource::collection($albums);
    }

    /**
     * Creates an album.
     *
     * @param  CreateRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request)
    {
        return $this->albumService->createFromParent($request->validated(), 'Album created!');
    }

    /**
     * Updates an album.
     *
     * @param  UpdateRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(UpdateRequest $request)
    {
        return $this->albumService->update($request->validated());
    }

    /**
     * Deletes an album.
     *
     * @param  GetRequest  $request
     *
     * @return mixed
     */
    public function destroy(GetRequest $request)
    {
        return $this->albumService->destroy();
    }

    /**
     * Views images in an album.
     *
     * @param  ImagesRequest  $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function view(ImagesRequest $request)
    {
        $images = $this->albumService
            ->getAlbum()
            ->images()
            ->latest()
            ->paginate(Helper::getLimit($request));

        ImageResource::wrap('images');

        return ImageResource::collection($images);
    }

    /**
     * Adds an image to an album.
     *
     * @param  AddImagesRequest  $request
     * @param  ImageManager  $imageManager
     *
     * @return mixed
     */
    public function addImage(AddImagesRequest $request, ImageManager $imageManager)
    {
        $fileName = str_shuffle($this->albumService->getAlbum()->id.time().time()).'.png';
        $ogSave = storage_path('app/public/gallery/original/').$fileName;

        $imageManager->make($request->file('images'))->save($ogSave);

        $image = $this->albumService->getAlbum()->images()->create([
            'name' => $fileName,
        ]);

        ProcessUploadedImage::withChain([
            new S3Upload($image),
        ])->dispatch($image);

        return $this->successResponse('Image uploaded');
    }

    /**
     * Removes an image from an album.
     *
     * @param  DeleteImageRequest  $request
     * @param  string  $image_id
     *
     * @return mixed
     */
    public function destroyImage(DeleteImageRequest $request, string $image_id)
    {
        $image = $this->albumService->getAlbum()->images()->findOrFail($image_id);

        try {
            unlink(storage_path('app/public/gallery/100-100/'.$image->name));
            unlink(storage_path('app/public/gallery/original/'.$image->name));
            $image->delete();

            return $this->successResponse('Image deleted!');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Sends a comment to an album.
     *
     * @param  CommentRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function comment(CommentRequest $request)
    {
        return CommentHelper::createComment($this->albumService->getAlbum(), $request);
    }

    /**
     * Fetches comments for an album.
     *
     * @param  Request  $request
     * @param  Album  $album
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function comments(Request $request, Album $album)
    {
        $this->authorize('view', $album);

        return CommentHelper::getComments($album, $request);
    }
}
