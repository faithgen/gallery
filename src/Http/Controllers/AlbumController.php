<?php

namespace FaithGen\Gallery\Http\Controllers;

use Illuminate\Http\Request;
use FaithGen\Gallery\Models\Album;
use Illuminate\Routing\Controller;
use Intervention\Image\ImageManager;
use FaithGen\SDK\Helpers\CommentHelper;
use FaithGen\Gallery\Services\AlbumService;
use FaithGen\SDK\Http\Requests\IndexRequest;
use FaithGen\Gallery\Events\Album\ImageSaved;
use FaithGen\Gallery\Http\Requests\GetRequest;
use FaithGen\Gallery\Http\Requests\CreateRequest;
use FaithGen\Gallery\Http\Requests\ImagesRequest;
use FaithGen\Gallery\Http\Requests\UpdateRequest;
use FaithGen\Gallery\Http\Requests\CommentRequest;
use FaithGen\Gallery\Http\Requests\AddImagesRequest;
use FaithGen\Gallery\Http\Requests\DeleteImageRequest;
use FaithGen\Gallery\Http\Resources\Album as AlbumResource;
use FaithGen\Gallery\Http\Resources\Image as ImageResource;
use FaithGen\Gallery\Jobs\ImageSaved\ProcessUploadedImage;
use FaithGen\Gallery\Jobs\ImageSaved\S3Upload;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use InnoFlash\LaraStart\Traits\APIResponses;

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

    function index(IndexRequest $request)
    {
        $albums = $this->albumService->getParentRelationship()->where('name', 'LIKE', '%' . $request->filter_text . '%')
            ->latest()
            ->paginate($request->has('limit') ? $request->limit : 15);
	AlbumResource::wrap('albums');
        return AlbumResource::collection($albums);
    }

    function create(CreateRequest $request)
    {
        return $this->albumService->createFromRelationship($request->validated(), 'Album created!');
    }

    function update(UpdateRequest $request)
    {
        return $this->albumService->update($request->validated());
    }

    function destroy(GetRequest $request)
    {
        return $this->albumService->destroy();
    }

    function view(ImagesRequest $request)
    {
        $images = $this->albumService->getAlbum()->images()->latest()
            ->paginate($request->has('limit') ? $request->limit : 15);
	ImageResource::wrap('images');
        return ImageResource::collection($images);
    }

    function addImage(AddImagesRequest $request, ImageManager $imageManager)
    {
        $fileName = str_shuffle($this->albumService->getAlbum()->id . time() . time()) . '.png';
        $ogSave = storage_path('app/public/gallery/original/') . $fileName;
        $imageManager->make($request->file('images'))->save($ogSave);
        $image = $this->albumService->getAlbum()->images()->create([
            'name' => $fileName
        ]);
        ProcessUploadedImage::withChain([
            new S3Upload($image)
        ])->dispatch($image);
        return $this->successResponse('Image uploaded');
    }

    function destroyImage(DeleteImageRequest $request)
    {
        $image = $this->albumService->getAlbum()->images()->findOrFail($request->image_id);
        try {
            unlink(storage_path('app/public/gallery/100-100/' . $image->name));
            unlink(storage_path('app/public/gallery/original/' . $image->name));
            $image->delete();
            return $this->successResponse('Image deleted!');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    function addImages(AddImagesRequest $request)
    {
        return $request->all();
    }

    public function comment(CommentRequest $request)
    {
        return CommentHelper::createComment($this->albumService->getAlbum(), $request);
    }

    public function comments(Request $request, Album $album)
    {
        $this->authorize('view', $album);
        return CommentHelper::getComments($album, $request);
    }
}
