<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card mb-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('user.profile', $reply->owner) }}">{{ $reply->owner->name }}</a>
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

                    <form action="/replies/{{ $reply->id }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    </form>
                @endcan
            </div>

        </div>
    </div>
</reply>
