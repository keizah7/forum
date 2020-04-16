<template>
    <div>
        <input type="hidden" id="trix" :name="name" :value="value" />
        <trix-editor
            ref="trix"
            input="trix"
            :placeholder="placeholder"
            class="form-control"
            style="height: auto"
        ></trix-editor>
    </div>
</template>

<script>
    import Trix from "trix"

    export default {
        props: ["name", "value", "placeholder", "shouldClear"],

        mounted() {
            this.$refs.trix.addEventListener("trix-change", e =>
                this.$emit("input", e.target.innerHTML)
            )

            this.$watch("shouldClear", () => {
                this.$refs.trix.value = ""
            })
        }
    }
</script>
