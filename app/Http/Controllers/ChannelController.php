<?php

namespace App\Http\Controllers;

use App\Http\Requests\Channels\UpdateChannelRequest;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChannelController extends Controller
{

    public function __construct()
    {
        if(Auth::check()){
            $this->middleware(['auth'])->only('update');    
        }
        else{
            return false;
        }
    }

    public function index()
    {
        
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //
    }

    public function show(Channel $channel)
    {
        $videos = $channel->videos()->get();
        return view('channels.show', compact('channel', 'videos'));
    }

    public function edit(Channel $channel)
    {
        //
    }


    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        if ($request->hasFile('image')){
            $channel->clearMediaCollection('images');
            $channel->addMediaFromRequest('image')->toMediaCollection('images');
        }        
        $channel->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->back();
    }   

    public function destroy(Channel $channel)
    {
        //
    }
}
