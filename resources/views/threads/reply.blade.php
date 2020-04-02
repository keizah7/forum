<div class="card mb-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('user.profile', $reply->owner->name) }}">{{ $reply->owner->name }}</a>
            said
            {{ $reply->created_at->diffForHumans() }}
        </div>
        <div>
            <form action="{{ route('favorite.store', $reply) }}" method="post">
                @csrf
                <button class="form-control"
                        type="submit" {{ $reply->isFavorited() ? 'disabled' : '' }}>{{ $reply->favorites_count. ' '. Str::plural('like', $reply->favorites_count) }}</button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <article>
            <p>{{ $reply->body }}</p>
        </article>
    </div>
</div>
