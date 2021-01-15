@extends('layouts.app')

@section('content')
@if($channel->editable())
    <div class="container-fluid">
        <div class="row justify-content-center">
        <channel-uploads :channel="{{ $channel }}"></channel-uploads>
        </div>
    </div>
@else

@endif
@endsection
