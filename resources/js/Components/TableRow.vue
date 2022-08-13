<template>
    <tr>
        <TableData
            v-for="(value, key) in row"
            :key="index + key"
            :column-data="value"
            :column-name="key"
            :row-index="index"
            :response-error="responseError"
            @update-value="save"
        />
    </tr>
</template>

<script lang="ts">
import axios from "axios";
import { defineComponent, PropType, ref } from "vue";
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
    emit: ["update-value"],
    setup(props, { emit }) {
        const responseError = ref<boolean>(false);

        async function save(event: IUpdateValueEmit) {
            try {
                const response = await axios.post("/api/write", {
                    index: event.rowIndex,
                    data: {
                        ...props.row,
                        [event.columnName]: event.columnData,
                    },
                });
                if (response.status === 200 && response.data.ok) {
                    emit("update-value", event);
                    responseError.value = false;
                } else {
                    responseError.value = true;
                }
            } catch (error) {
                responseError.value = true;
            }
        }

        return { responseError, save };
    },
});
</script>
