<template>
    <div class="alert alert-flash alert-success fade show" role="alert" v-show="show">
        <strong>Success!</strong> {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data () {
            return {
                show: false,
                body: '',
            }
        },

        created () {
            if  (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => this.flash(message));
        },

        methods: {
            flash (message) {
                this.body = message;
                this.show = true;

                this.hide();
            },
            hide () {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }

        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 3rem;
        bottom: 2rem;
    }
</style>
