<template>
    <div :id="'reply-'+id" class="card mb-2" :class="isBest ? 'border-success': 'card-default'">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name"></a>
                said <span v-text="ago"></span>
            </div>
            <div v-if="signedIn">
                <favorite :reply="data"></favorite>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <form @submit.prevent="update">
                        <div class="form-group">
                            <textarea class="form-control" v-model="body" required></textarea>
                        </div>

                        <button class="btn btn-xs btn-primary">Update</button>
                        <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
                    </form>
                </div>
            </div>
            <article v-html="body" v-else></article>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <div v-if="authorize('updateReply', reply)">
                <button class="btn btn-sm btn-success mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
            </div>
            <button class="btn btn-sm btn-outline-primary ml-a" @click="markBestReply" v-show="! isBest">Best Reply</button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['data'],
        components: {Favorite},
        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,
                isBest: this.data.isBest,
                reply: this.data
            };
        },

        created () {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        computed: {
            ago() {
                return moment(moment.utc(this.data.created_at)).fromNow();
            },
            signedIn() {
                return window.app.signedIn;
            },

            canUpdate() {
                // return this.data.user_id == window.app.user.id;
                return this.authorize(user => this.data.user_id == user.id)
            }
        },

        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.data.id, {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });
                this.editing = false;
                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id)
            },
            markBestReply() {
                axios.post('/replies/' + this.data.id + '/best');
                window.events.$emit('best-reply-selected', this.data.id);
            }
        }
    }
</script>
