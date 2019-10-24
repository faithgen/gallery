<?php

namespace FaithGen\Gallery\Events\Album;

use FaithGen\Gallery\Models\Album;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Album
     */
    private $album;

    /**
     * Create a new event instance.
     *
     * @param Album $album
     */
    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    /**
     * @return Album
     */
    public function getAlbum(): Album
    {
        return $this->album;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
