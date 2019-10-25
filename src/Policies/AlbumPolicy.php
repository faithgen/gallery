<?php

namespace FaithGen\Gallery\Policies;

use Carbon\Carbon;
use FaithGen\Gallery\Helpers\AlbumHelper;
use FaithGen\Gallery\Models\Album;
use FaithGen\SDK\Helpers\Helper;
use FaithGen\SDK\Models\Ministry;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlbumPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any albums.
     *
     * @param \App\Models\Ministry $user
     * @return mixed
     */
    public function viewAny(Ministry $user)
    {
        //
    }

    /**
     * Determine whether the user can view the album.
     *
     * @param Ministry $user
     * @param Album $album
     * @return mixed
     */
    public function view(Ministry $user, Album $album)
    {
        return $user->id === $album->ministry_id;
    }

    /**
     * Determine whether the user can create albums.
     *
     * @param \App\Models\Ministry $user
     * @return mixed
     */
    public function create(Ministry $user)
    {
        $albumsCount = Album::where('ministry_id', $user->id)->whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()->lastOfMonth()])->count();
        return $this->getAuthorization($user, $albumsCount, 'albums');
    }

    /**
     * Determine whether the user can update the album.
     *if
     * @param Ministry $user
     * @param Album $album
     * @return mixed
     */
    public function update(Ministry $user, Album $album)
    {
        return $user->id === $album->ministry_id;
    }

    /**
     * Determine whether the user can delete the album.
     *
     * @param Ministry $user
     * @param Album $album
     * @return mixed
     */
    public function delete(Ministry $user, Album $album)
    {
        return $user->id === $album->ministry_id;
    }

    public function addImages(Ministry $ministry, Album $album)
    {
        $albumSize = $album->images()->count();
        if (strcmp($ministry->id, $album->ministry_id) !== 0) return false;
        else {
            return $this->getAuthorization($ministry, $albumSize, 'images');
            $allow = $this->getAuthorization($ministry, $albumSize, 'images');
            if (!$allow) return false;
            else {
                if ($ministry->account->level === 'Free') $balance = AlbumHelper::$freeAlbumImagesCount - $albumSize;
                else if ($ministry->account->level === 'Premium') $balance = AlbumHelper::$premiumAlbumImagesCount - $albumSize;
                else $balance = 10000;

                return true;
                //return sizeof(request()->images) > $balance;
            }
        }
    }

    private function getAuthorization(Ministry $ministry, int $count, string $type): bool
    {
        if (strcmp($type, 'albums') === 0) {
            $freeCount = AlbumHelper::$freeAlbumsCount;
            $premiumCount = AlbumHelper::$premiumAlbumsCount;
        } else {
            $freeCount = AlbumHelper::$freeAlbumImagesCount;
            $premiumCount = AlbumHelper::$premiumAlbumImagesCount;
        }
        if ($ministry->account->level === 'Free') {
            if ($count >= $freeCount) return false;
            else return true;
        } else if ($ministry->account->level === 'Premium') {
            if ($count >= $premiumCount) return false;
            else return true;
        } else return true;
    }
}
