<div class="card mb-3" v-if="editing">
    <div class="card-header d-flex justify-content-between items-center">
        <input class="form-control mr-2" type="text" value="{{ $thread->title }}">
    </div>

    <div class="card-body">
        <article class="form-group">
            <textarea class="form-control" id="" cols="30" rows="5">{{ $thread->body }}</textarea>
        </article>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <div>
        <button class="btn btn-sm btn-primary mr-1" @click="update">Update</button>
        <button class="btn btn-sm" @click="resetForm">Cancel</button>
        </div>


    @can('update', $thread)
            <form action="/threads/{{ $thread->id }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger" type="submit">Delete</button>
            </form>
        @endcan
    </div>
</div>

<div class="card mb-3" v-else>
    <div class="card-header d-flex justify-content-between items-center">
        <div class="d-flex align-items-center">
            <img src="{{ $thread->creator->avatar_path }}"
                 alt="{{ $thread->creator->name }}"
                 width="25"
                 height="25"
                 class="mr-1">
            <a class="mr-2"
               href="{{ route('user.profile', $thread->creator) }}">{{ $thread->creator->name }}</a> {{ $thread->title }}
        </div>
    </div>

    <div class="card-body">
        <article>
            <p>{{ $thread->body }}</p>
        </article>
    </div>

    <div class="card-footer">
        <button class="btn btn-sm btn-success mr-1" @click="editing = true" v-show="! editing">Edit</button>
    </div>
</div>
