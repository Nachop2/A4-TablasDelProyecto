@extends('layouts.app')
@section('content')

<p>Test</p>
<img src="{{url('storage/'.Auth::user()->profile->imageUpload)}}">
<form action="/profile/store" method="POST" id="updateImage" enctype="multipart/form-data">
    @csrf

    <input type="file" name="imageUpload" class="form-control" />
    @error('imageUpload')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="form-group pt-3">
        <button class="btn btn-primary">Edit!</button>
    </div>
</form>

@stop