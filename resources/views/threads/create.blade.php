@extends('layouts.app')

@push('head')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a thread</div>

                    <div class="card-body">
                        <form action="{{ route('threads.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="channel_id">Channel</label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">Choose</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ $channel->id == old('channel_id') ? 'selected' : ''}}>{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text"
                                       name="title"
                                       id="title"
                                       class="form-control"
                                       placeholder="Title"
                                       value="{{ old('title') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body</label>
                                <wysiwyg name="body"></wysiwyg>
                            </div>

                            <div class="g-recaptcha mb-2" data-sitekey="6LfV8ukUAAAAAIo0GIozMWoK0XPwsZZShRIr-2SH"></div>

                            <button type="submit">Publish</button>
                        </form>

                        @if ($errors->{ $bag ?? 'default' }->any())
                            <div class="alert alert-danger mt-4 pb-0">
                                @foreach ($errors->{ $bag ?? 'default' }->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
