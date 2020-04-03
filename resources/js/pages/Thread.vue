<script>
    import Replies from "../components/Replies";

    export default {
        props: ['initialRepliesCount'],

        data () {
            return {
                repliesCount: this.initialRepliesCount
            }
        },
        components: {Replies}
    }
</script>
