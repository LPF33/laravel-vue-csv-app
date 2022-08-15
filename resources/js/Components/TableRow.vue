<template>
    <tr>
        <TableData
            v-for="(value, key) in row"
            :key="index + value + Math.floor(Math.random() * 10000)"
            :column-data="value"
            :column-name="key"
            :row-index="index"
            :response-error="responseError"
            @update-value="initAxios"
            @open-add-data="openAddData"
        />
    </tr>
</template>

<script lang="ts">
import { defineComponent, PropType, watch } from "vue";
import { IArticle, IUpdateValueEmit, IDataRowIndex } from "../types";
import TableData from "./TableData.vue";
import useAxios from "@/Composables/useAxios";

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
        const { responseData, responseError, fireAxios } =
            useAxios<IDataRowIndex>("post");

        function initAxios(event: IUpdateValueEmit) {
            fireAxios("/api/write", {
                index: event.rowIndex,
                data: {
                    ...props.row,
                    [event.columnName]: event.columnData,
                },
            });
        }

        function openAddData() {
            emit("open-add-data", { index: props.index, data: props.row });
        }

        watch(responseData, (newValue) => {
            if (newValue !== null) {
                emit("update-value", newValue);
            }
        });

        return { responseError, initAxios, openAddData };
    },
});
</script>
