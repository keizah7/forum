<template>
    <div :id="'reply-'+id" class="card mb-2" :class="isBest ? 'border-success': 'card-default'">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <a :href="'/profiles/' + reply.owner.name" v-text="reply.owner.name">
                    said <span v-text="ago"></span>
                </a>
            </div>
            <div v-if="signedIn">
                <favorite :reply="reply"></favorite>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <form @submit.prevent="update">
                        <div class="form-group">
                            <wysiwyg v-model="body"></wysiwyg>
                        </div>

                        <button class="btn btn-sm btn-primary">Update</button>
                        <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                    </form>
                </div>
            </div>
            <article v-html="body" v-else></article>
        </div>

        <div class="card-footer d-flex justify-content-between" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-sm btn-success mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
            </div>
            <button class="btn btn-sm btn-outline-primary ml-a" @click="markBestReply" v-if="authorize('owns', reply.thread)">Best Reply?</button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],
        components: {Favorite},
        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            };
        },

        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        computed: {
            ago() {
                return moment(moment.utc(this.reply.created_at)).fromNow();
            },
            signedIn() {
                return window.app.signedIn;
            },

            canUpdate() {
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
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id)
            },
            markBestReply() {
                axios.post('/replies/' + this.id + '/best');
                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>
