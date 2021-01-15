@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if($Video->isEditable($Video))
                <form action="">
                @endif
                    <div class="card-header">
                        {{ $Video->title }}
                    </div>
                
                    <div class="card-body">
                        <video
                        id="video"
                        class="video-js"
                        controls
                        preload="auto"
                        width="640"
                        height="264"
                        poster='{{ asset(Storage::url("thumbnail/{$Video->id}.png")) }}'
                        data-setup="{}">
                            <source src='{{asset(Storage::url("videos/{$Video->id}/{$Video->id}.m3u8"))}}' type="application/x-mpegURL" />
                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a
                                web browser that
                            </p>
                        </video>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mt-1">                                
                                @if(!$Video->isEditable($Video))
                                <h4 class="mt-3"> {{ $Video->title }}</h4>
                                @else
                                    <input type="text" value="{{ $Video->title }}" class="form-control" name="title">
                                @endif
                                {{ $Video->views }} {{$Video->views <> 1 ? 'views' : 'view'}}
                            </div>

                            <div class="d-flex flex-row justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                xmlns:xlink="http://www.w3.org/1999/xlink" 
                                aria-hidden="true" 
                                focusable="false" 
                                length="40px" height="40px" 
                                style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" 
                                preserveAspectRatio="xMidYMid meet" 
                                viewBox="0 0 20 20">
                                    <path d="M12.72 2c.15-.02.26.02.41.07c.56.19.83.79.66 1.35c-.17.55-1 3.04-1 3.58c0 .53.75 1 1.35 
                                    1h3c.6 0 1 .4 1 1s-2 7-2 7c-.17.39-.55 1-1 1H6V8h2.14c.41-.41 3.3-4.71 3.58-5.27c.21-.41.6-.68 
                                    1-.73zM2 8h2v9H2V8z" fill="#626262"/>
                                </svg>

                               100

                                <svg xmlns="http://www.w3.org/2000/svg" 
                                xmlns:xlink="http://www.w3.org/1999/xlink" 
                                aria-hidden="true" 
                                focusable="false" 
                                length=40px" height="40px" 
                                style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" 
                                preserveAspectRatio="xMidYMid meet" 
                                viewBox="0 0 20 20">
                                    <path d="M7.28 18c-.15.02-.26-.02-.41-.07c-.56-.19-.83-.79-.66-1.35c.17-.55 
                                    1-3.04 1-3.58c0-.53-.75-1-1.35-1h-3c-.6 0-1-.4-1-1s2-7 2-7c.17-.39.55-1 
                                    1-1H14v9h-2.14c-.41.41-3.3 4.71-3.58 5.27c-.21.41-.6.68-1 
                                    .73zM18 12h-2V3h2v9z" fill="#626262"/>
                                </svg>

                                12
                            </div>
                        </div>
                        <hr>
                        @if($Video->isEditable($Video))
                            <div>
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ $Video->description }}</textarea>
                                <button type="submit" class="btn btn-info btn-sm mt-2">Update video details</button>
                            </div>
                            <hr>
                        @endif
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <div class="media">
                                <img src="" alt="">
                                <div class="media-body m1-2">
                                    <h5 class="mt-0 mb-0">{{ $Video->channel->name}}</h5>
                                    <span class="small">Published on {{ $Video->created_at->toFormattedDateString()}}</span>
                                </div>
                            </div>
                            <subscribe-button :initialsubscriptions="{{ $Video->channel->subscriptions}}" :channel="{{ $Video->channel }}"></subscribe-button>

                        </div>
                    </div>
                @if($Video->isEditable($Video))
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
    <script>
        window.CURRENT_VIDEO = '{{ $Video->id }}'
    </script>
    <script src='{{ asset("js/player.js") }}'></script>
@endsection
