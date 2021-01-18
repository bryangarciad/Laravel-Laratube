@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ $channel->name }}
                    @if($channel->editable())
                    <a href="{{ route('channel.upload', ['channel'=>$channel]) }}">upload videos</a>
                    @endif
                </div>
                <div class="card-body">
                    @if($channel->editable())
                        <form action="{{ route('channels.update', ['channel'=> $channel]) }}" id="form" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('PATCH')
                    @endif

                    <div class="form-group row justify-content-center">
                        <div class="channel-avatar" onclick="document.getElementById('image').click()">
                            @if($channel->editable())
                                <div class="channel-avatar-overlay" >
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                    xmlns:xlink="http://www.w3.org/1999/xlink" 
                                    ria-hidden="true" 
                                    focusable="false" width="80px" height="80px" 
                                    style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" 
                                    preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20">
                                        <path d="M10 8a3 3 0 1 0 0 6a3 3 0 0 0 0-6zm8-3h-2.4a.888.888 0 0 
                                        1-.789-.57l-.621-1.861A.89.89 0 0 0 13.4 2H6.6c-.33 0-.686.256-.789.568L5.189 
                                        4.43A.889.889 0 0 1 4.4 5H2C.9 5 0 5.9 0 7v9c0 1.1.9 2 2 2h16c1.1 0 
                                        2-.9 2-2V7c0-1.1-.9-2-2-2zm-8 11a5 5 0 0 1-5-5a5 5 0 1 1 10 0a5 5 0 0 
                                        1-5 5zm7.5-7.8a.7.7 0 1 1 0-1.4a.7.7 0 0 1 0 1.4z" fill="#626262"/>
                                    </svg>
                                </div>
                            @endif
                            <img style="width: 80px; height:80px" src="{{ asset($channel->image()) }}" alt="{{ $channel->image() }}">
                        </div>
                    </div>
                    @if(!$channel->editable())
                        <div class="form-group column justify-content-center">
                            <h4 class="text-center">{{ $channel->name }}</h4>
                            <p class="text-center">{{ $channel->description }}</p>
                            <div class="text-center">
                                <subscribe-button :initialsubscriptions="{{ $channel->subscriptions}}" :channel="{{ $channel }}"></subscribe-button>
                            </div>
                        </div>
                    @endif
                    @if($channel->editable())
                        <input type="file" name="image" id="image" style="display: none;" onchange="document.getElementById('form').submit()">
                        <div class="form-group">
                            <label for="name" class="form-control-label">Name</label>
                            <input type="text" id="name" name="name" value="{{ $channel->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3">{{ $channel->description }}</textarea>
                        </div>

                        @if($errors->any())
                            <ul class="list-group">
                                @foreach($errors->all() as $error)
                                <li class="text-danger list-group-item">
                                    {{$error}}
                                </li>
                                @endforeach
                            </ul>
                        @endif
                        <button type="submit" style="margin-top:10px;" class="btn btn-info">Update Channel</button>
                    @endif
                    </form>
                </div>
            </div>
            

            <hr>
            <div class="card">
                <div class="card-header d-flex justify-content-between text-center">
                    <h4 class="text-center"> Uploaded Videos</h4>
                </div>

                <ul class="list-group">
                    @foreach($videos as $video )
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="col-md-8">
                                <h4>{{ $video->title }}</h4> 
                                <small>{{$video->description}}</small>
                                <small>{{$video->id}}</small>
                            </div>
                            <div class="image-parent">
                                <a href="{{ route('videos.show', ['video'=> $video]) }}">
                                    <img src='{{ asset(Storage::url("thumbnail/{$video->id}.png"))  }}' class="img-fluid"  style="width:200px" alt="">
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection
