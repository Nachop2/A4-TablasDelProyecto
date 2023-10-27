@extends('layouts.app')
@section('content')
<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
<div class="container">
    <div class="row">
        @include('community.link-column')
        @include('community.add-link')
    </div>
    {{ $links->appends($_GET)->links() }}
</div>
@stop