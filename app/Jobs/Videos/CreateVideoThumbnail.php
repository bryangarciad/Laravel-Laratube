<?php

namespace App\Jobs\Videos;

use App\Models\Video;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CreateVideoThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }


    public function handle()
    {
        FFMpeg::fromDisk('local')->open($this->video->path)
        ->getFrameFromSeconds(1)
        ->export()
        ->toDisk('local')
        ->save("public/thumbnail/{$this->video->id}.png");

        $this->video->update([
            'thumbnail' => Storage::url("public/thumbnail/{$this->video->id}.png")
        ]);
    }
}
