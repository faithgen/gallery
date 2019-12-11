<?php

namespace FaithGen\Gallery\Http\Controllers;

use Illuminate\Http\Request;
use FaithGen\Gallery\Models\Album;
use App\Http\Controllers\Controller;
use InnoFlash\LaraStart\Http\Helper;
use Intervention\Image\ImageManager;
use FaithGen\Gallery\Services\AlbumService;
use FaithGen\SDK\Http\Requests\IndexRequest;
use FaithGen\Gallery\Events\Album\ImageSaved;
use FaithGen\Gallery\Http\Requests\CommentRequest;
use FaithGen\Gallery\Http\Requests\Album\GetRequest;
use FaithGen\Gallery\Http\Requests\Album\CreateRequest;
use FaithGen\Gallery\Http\Requests\Album\ImagesRequest;
use FaithGen\Gallery\Http\Requests\Album\UpdateRequest;
use FaithGen\Gallery\Http\Requests\Album\AddImagesRequest;
use FaithGen\Gallery\Http\Resources\Album as AlbumResource;
use FaithGen\Gallery\Http\Resources\Image as ImageResource;
use FaithGen\Gallery\Http\Requests\Album\DeleteImageRequest;
use FaithGen\SDK\Http\Resources\Comment as CommentsResource;

class AlbumController extends Controller
{
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
        event(new ImageSaved($image));
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
        try {
            $this->albumService->getAlbum()->comments()->create([
                'comment' => $request->comment,
                'creatable_id' => auth()->user()->id,
                'creatable_type' => get_class(auth()->user()),
            ]);
            return $this->successResponse('Comment posted');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function comments(Request $request, Album $album)
    {
        $comments = $album->comments()->latest()->paginate(Helper::getLimit($request));
        CommentsResource::wrap('comments');
        return CommentsResource::collection($comments);
    }
}
