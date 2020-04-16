<div class="card mb-3" v-if="editing">
    <div class="card-header d-flex justify-content-between items-center">
        <input class="form-control mr-2" type="text" v-model="form.title">
    </div>

    <div class="card-body">
        <article class="form-group">
            <wysiwyg v-model="form.body"></wysiwyg>
        </article>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <div>
            <button class="btn btn-sm btn-primary mr-1" @click="update">Update</button>
            <button class="btn btn-sm" @click="resetForm">Cancel</button>
        </div>


        @can('update', $thread)
            <form action="{{$thread->path()}}" method="post">
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
            <a class="mr-2" href="{{ route('user.profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
            <span v-text="title"></span>
        </div>
    </div>

    <div class="card-body">
        <article>
            <p v-html="body"></p>
        </article>
    </div>

    <div class="card-footer" v-if="authorize('owns', thread)">
        <button class="btn btn-sm btn-success mr-1" @click="editing = true" v-show="! editing">Edit</button>
    </div>
</div>
