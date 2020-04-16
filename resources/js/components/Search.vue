<script>
    import algoliasearch from 'algoliasearch/lite';

    export default {
        name: "Search",
        data() {
            return {
                searchClient: algoliasearch(
                    'RIPX81I70I',
                    'a9c0912e0b5f4c8cfd9cc1fba5c17090'
                ),
            };
        },
    }
</script>
