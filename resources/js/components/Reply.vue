<template>
    <div :id="'reply'+id" class="card mb-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name"></a>
                said {{ data.created_at }}
            </div>
            <div v-if="signedIn">
                <favorite :reply="data"></favorite>
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
            <article v-else v-text="body"></article>
        </div>

        <div class="card-footer d-flex" v-if="canUpdate">
            <button class="btn btn-sm btn-success mr-1" @click="editing = true">Edit</button>
            <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['data'],
        components: {Favorite},
        data() {
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id
            };
        },
        computed: {
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
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                });
                this.editing = false;
                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id)
            }
        }
    }
</script>
