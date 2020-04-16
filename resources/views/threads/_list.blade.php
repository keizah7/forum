@forelse($threads as $thread)
    <div class="card {{ $loop->last ? '' : 'mb-3' }}">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                <h4>
                    <a href="{{ $thread->path() }}">
                        @guest
                            {{ $thread->title }}
                        @else
                            @if ($thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{ $thread->title }}
                                </strong>
                            @else
                                {{ $thread->title }}
                            @endif
                        @endguest
                    </a>
                </h4>
                <h5 class="mb-0">
                    Posted By: <a href="{{ route('user.profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                </h5></div>

                <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}</a>
            </div>
        </div>

        <div class="card-body">
            <div class="body">{!! $thread->body !!}</div>
        </div>

        <div class="card-footer">
            {{ $thread->visits }} {{ Str::plural('visit', $thread->visits) }}
        </div>
    </div>
@empty
    List is empty
@endforelse
