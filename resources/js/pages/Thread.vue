<script>
    import Replies from "../components/Replies";
    import SubscribeButton from "../components/SubscribeButton";

    export default {
        props: ['thread'],

        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                title: this.thread.title,
                body: this.thread.body,
                form: {},
                editing: false
            }
        },
        created() {
            this.resetForm();
        },
        components: {Replies, SubscribeButton},
    }
</script>
