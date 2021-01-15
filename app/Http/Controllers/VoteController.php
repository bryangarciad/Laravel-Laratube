<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Comment;
use App\Models\Subscription;
use App\Models\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote($entityId, $type) {
        $entity = $this->getEntity($entityId);
        $vote = $entity->votes->where('user_id', Auth::id())->first();

        if ($vote) {
            $vote->update([
                'type' => $type
            ]);

            return $vote->refresh();
        } else {
            return $entity->votes()->create([
                'type' => $type,
                'user_id' => Auth::id()
            ]);
        }
    }

    public function getEntity($entityId)
    {
        $video = Video::find($entityId);

        if ($video) return $video;

        $comment = Comment::find($entityId);

        if ($comment) return $comment;

        throw new ModelNotFoundException('Entity not found.');
    }
}
