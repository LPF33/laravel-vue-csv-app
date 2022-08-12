<template>
    <tr>
        <TableData
            v-for="(value, key) in row"
            :key="index + key"
            :column-data="value"
            :column-name="key"
            :row-index="index"
            @update-value="save"
        />
    </tr>
</template>

<script lang="ts">
import axios from "axios";
import { defineComponent, PropType } from "vue";
import { IArticle, IUpdateValueEmit } from "../types";
import TableData from "./TableData.vue";

export default defineComponent({
    name: "TableRow",
    components: { TableData },
    props: {
        row: {
            type: Object as PropType<IArticle>,
            required: true,
        },
        index: {
            type: Number,
            required: true,
        },
    },
    setup(props) {
        async function save(event: IUpdateValueEmit) {
            const response = await axios.post("/api/write", {
                index: event.rowIndex,
                data: { ...props.row, [event.columnName]: event.columnData },
            });
            console.log(response);
        }

        return { save };
    },
});
</script>
