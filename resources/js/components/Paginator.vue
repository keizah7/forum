<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li class="page-item" v-if="prevUrl" @click.prevent="page--">
            <a class="page-link" href="#" rel="prev">Previous</a>
        </li>
        <li class="page-item" v-if="nextUrl" @click.prevent="page++">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: null,
                nextUrl: null,
            };
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page() {
                this.broadcast().updateUrl();
            }
        },

        computed: {
            shouldPaginate() {
                return !! (this.prevUrl || this.nextUrl);
            }
        },
        methods: {
            broadcast() {
                return this.$emit('changed', this.page);
            },
            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>
