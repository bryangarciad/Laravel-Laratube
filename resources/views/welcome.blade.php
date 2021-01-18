@extends('layouts.app')

@section('content')
<div class="container" style="display: flex; flex-direction: row; flex-wrap: wrap">
@foreach($videos as $video)
    <div class="card mb-3 ml-2" style="width: 30%;">
            <a href="{{ route('videos.show', ['video'=> $video]) }}" >

            <img style="width:100%;height: 230px; object-fit: cover;" class="card-img-top" src='{{ asset(Storage::url("thumbnail/{$video->id}.png")) }}' alt="Card image cap">
        </a>
        <div class="card-body">
            <h5 class="card-title">{{$video->title}}</h5>
            <p class="card-text">{{$video->description}}</p>
           <small class="text-muted"> Uploaded By <a href="{{route('channels.show', ['channel'=>$video->channel])}}">{{$video->channel->name}}</a></small>
        </div>
    </div>
    @endforeach
</div>
@endsection
