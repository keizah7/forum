<script>
    import Replies from "../components/Replies";
    import SubscribeButton from "../components/SubscribeButton";

    export default {
        props: ['thread'],

        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked
            }
        },
        components: {Replies, SubscribeButton},
        methods: {
            toggleLock() {
                axios[
                    this.locked ? 'delete' : 'post'
                    ]('/locked-threads/' + this.thread.slug);
                this.locked = !this.locked;
            }
        }
    }
</script>
