<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{


    public function store(Channel $channel)
    {
        return $channel->subscriptions()->create([
            'user_id' => Auth::id()
        ]);
    }

    public function destroy(Channel $channel, Subscription $subscription)
    {
        $subscription->delete();
        return response()->json([]);
    }
}
