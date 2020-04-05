<script>
    import Replies from "../components/Replies";
    import SubscribeButton from "../components/SubscribeButton";

    export default {
        props: ['initialRepliesCount'],

        data () {
            return {
                repliesCount: this.initialRepliesCount
            }
        },
        components: {Replies, SubscribeButton}
    }
</script>
