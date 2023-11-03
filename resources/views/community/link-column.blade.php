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

        <span>
            <form method="POST" action="/votes/{{ $link->id }}">
                {{ csrf_field() }}
                <button type="submit" class="btn {{ Auth::check() && Auth::user()->votedFor($link) ? 'btn-success' : 'btn-secondary' }}" {{ Auth::guest() ? 'disabled' : '' }}>
                    <span><i class="fa-solid fa-arrow-up"></i></span>

                    {{$link->users()->count()}}

                </button>
            </form>

        </span>
        <a href="{{ $link->link }}" target="_blank">
            {{ $link->title }}
        </a>
        <small>Contributed by: {{ $link->creator->name }} {{ $link->updated_at->diffForHumans() }}</small>

        <span class="label label-default" style="border: {{ $link->channel->color }} solid 3px">
            <a class="text-decoration-none" href="/community/{{ $link->channel->slug }}">
                {{ $link->channel->title }}

            </a>
        </span>

    </li>
    @endforeach
    @endif

    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link {{request()->exists('popular') ? '' : 'disabled' }}" href="{{request()->exists('search') ? 'community?search='.request()->input('search') : ''}}">Most recent</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{request()->exists('popular') ? 'disabled' : '' }}" href="{{request()->exists('search') ? request()->getRequestUri().'&popular' : '?popular'}}">Most popular</a>
        </li>
    </ul>

</div>