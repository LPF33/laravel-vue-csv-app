<template>
    <tr>
        <TableData
            v-for="(column, index) in row"
            :key="index"
            :column-data="column"
        />
    </tr>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import { IArticle } from "../types";
import TableData from "./TableData.vue";

export default defineComponent({
    name: "TableRow",
    components: { TableData },
    props: {
        row: {
            type: Object as PropType<IArticle>,
            required: true,
        },
    },
});
</script>
