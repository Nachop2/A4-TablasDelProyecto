{{-- Right colum to show the form to upload a link --}}
<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h3>Contribute a link</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="/community">
                @csrf
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input value="{{old('title')}}" type="text" class="form-control" class="@error('title') is-invalid @enderror" id="title" name="title" placeholder="What is the title of your article?">
                    @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="link">Link:</label>
                    <input value="{{old('link')}}" type="text" class="form-control" class="@error('link') is-invalid @enderror" id="link" name="link" placeholder="What is the URL?">
                    @error('link')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="Channel">Channel:</label>
                    <select class="form-control @error('channel_id') is-invalid @enderror" name="channel_id">
                        <option selected disabled>Pick a Channel...</option>
                        @foreach ($channels as $channel)
                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                            {{ $channel->title }}
                        </option>
                        @endforeach
                    </select>
                    @error('channel_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group pt-3">
                    <button class="btn btn-primary">Contribute!</button>
                </div>
            </form>
        </div>
    </div>

</div>