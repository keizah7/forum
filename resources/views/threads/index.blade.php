@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @forelse($threads as $thread)
                    <div class="card {{ $loop->last ? '' : 'mb-3' }}">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="mb-0">
                                    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                </h4>

                                <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}</a>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="body">{{ $thread->body }}</div>
                        </div>
                    </div>
                @empty
                    List is empty
                @endforelse
            </div>
        </div>
    </div>
@endsection
