@extends('layouts.app')

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
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                            </div>

                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea name="body"
                                          id="body"
                                          cols="30"
                                          rows="5"
                                          class="form-control"
                                          placeholder="Say something"></textarea>
                            </div>

                            <button type="submit">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
