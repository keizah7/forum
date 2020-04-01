@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Threads</div>

                    <div class="card-body">
                        @forelse($threads as $thread)
                            <article>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="mb-0">
                                        <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                    </h4>

                                    <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}</a>
                                </div>
                                <div class="body">{{ $thread->body }}</div>
                            </article>
                            {!! $loop->last ? '' : '<hr>' !!}
                        @empty
                            List is empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
