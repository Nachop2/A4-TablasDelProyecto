{{-- Left colum to show all the links in the DB --}}
<div class="col-md-8">
    @if ($channel != null)
    <h1><a href="/community">Community</a> - {{ $channel->title }}</h1>

    @else
    <h1>Community</h1>

    @endif

    @if (count($links) == 0)
    <h2>No approved contributions yet</h2>

    @else
    @foreach ($links as $link)

    <li>


        <a href="{{ $link->link }}" target="_blank">
            {{ $link->title }}
        </a>
        <small>Contributed by: {{ $link->creator->name }} {{ $link->updated_at->diffForHumans() }}</small>

        <span class="label label-default" style="background: {{ $link->channel->color }}">
            <a class="text-decoration-none" href="/community/{{ $link->channel->slug }}">
                {{ $link->channel->title }}

            </a>

        </span>

    </li>
    @endforeach
    @endif
</div>