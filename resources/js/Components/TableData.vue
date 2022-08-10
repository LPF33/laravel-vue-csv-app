<template>
    <td><input type="text" v-model="data"/></td>
</template>

<script lang="ts">
import {defineComponent, ref} from 'vue';

export default defineComponent({
    name: "TableDate",
    props: {
        columnData: {
            type: String,
            required: true
        }
    },
    setup(props) {
        const data = ref<string>(props.columnData);

        return {data};
    }
})
</script>

<style scoped>
input {
    background-color: transparent;
}
</style>