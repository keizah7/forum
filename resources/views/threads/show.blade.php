@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a>
                        posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        <article>
                            <p>{{ $thread->body }}</p>
                        </article>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-header">Replies</div>
                @forelse($thread->replies as $reply)
                    @include('threads.reply')
                @empty
                    Replies list is empty
                @endforelse
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @guest
                        <p class="text-center pt-3">
                            Please
                            <a href="{{ route('login') }}">sign in</a>
                            to participate
                        </p>
                    @else
                        <form action="{{ route('reply.store', $thread) }}" method="post">
                            @csrf

                            <textarea name="body"
                                      id="body"
                                      cols="30"
                                      rows="5"
                                      class="form-control"
                                      placeholder="Say something?"></textarea>
                            <button type="submit">Send</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>

    </div>
@endsection
