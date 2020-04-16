<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <wysiwyg
                    placeholder="Have something to say?"
                    v-model="body"
                    :shouldClear="completed"
                ></wysiwyg>
            </div>

            <button type="submit"
                    class="btn btn-primary"
                    @click="addReply">Post</button>
        </div>

        <p class="text-center" v-else>
            Please <a href="/login">sign in</a> to participate in this
            discussion.
        </p>
    </div>
</template>

<script>
    import 'jquery.caret';
    import 'at.js';

    export default {
        data() {
            return {
                body: "",
                completed: false
            };
        },

        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON("/api/users", {name: query}, function(usernames) {
                            callback(usernames)
                        });
                    }
                }
            });
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';
                        this.$emit('created', data);

                        this.completed = true
                        flash('Your reply has been posted.');
                    })
                    .finally(() => {
                        this.completed = false
                    });
            }
        }
    }
</script>
