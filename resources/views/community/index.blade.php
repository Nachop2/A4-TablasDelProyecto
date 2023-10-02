@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('community.link-column')
        @include('community.add-link')
    </div>
    {{ $links->links() }}
</div>
@stop