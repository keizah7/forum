<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card mb-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('user.profile', $reply->owner) }}">{{ $reply->owner->name }}</a>
                said
                {{ $reply->created_at->diffForHumans() }}
            </div>
            <div>
                <favorite :reply="{{ $reply }}"></favorite>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea v-model="body" class="form-control mb-1" name="reply" id="" cols="30" rows="3"></textarea>
                    <button class="btn btn-primary btn-sm" @click="update">Update</button>
                    <button class="btn btn-outline-info btn-sm" @click="editing=false">Cancel</button>
                </div>
            </div>
            <article v-else v-text="body">
                <p>{{ $reply->body }}</p>
            </article>
        </div>

        <div class="card-footer">
            <div class="d-flex">
                @can('update', $reply)
                    <button class="btn btn-sm btn-success mr-1" @click="editing = true">Edit</button>
                    <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
                @endcan
            </div>

        </div>
    </div>
</reply>
