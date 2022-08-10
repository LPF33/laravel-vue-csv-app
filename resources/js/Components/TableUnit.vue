<template>
    <table>
        <thead>
            <tr>
                <th v-for="(item, index) in header" :key="index">{{ item }}</th>
            </tr>
        </thead>
        <tbody>
            <TableRow v-for="(row, index) in body" :key="index" :row="row" />
        </tbody>
    </table>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import { IArticle } from "../types";
import TableRow from "./TableRow.vue";

export default defineComponent({
    name: "TableUnit",
    components: { TableRow },
    props: {
        header: {
            type: Array as PropType<string[]>,
            required: true,
        },
        body: {
            type: Array as PropType<IArticle[]>,
            required: true,
        },
    },
});
</script>

<style>
table {
    border-collapse: collapse;
    margin: 0;
    font-size: 0.9em;
    font-family: sans-serif;
    width: 100%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

thead {
    position: sticky;
    top: 0;
}

thead tr {
    background-color: var(--table-header);
    color: var(--color-white);
    text-align: left;
}

th,
td {
    padding: 12px 10px;
}

tbody tr {
    border-bottom: 1px solid #dddddd;
    background-color: #ebebeb;
}

tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

tbody tr:hover {
    background-color: var(--table-hover);
}

tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}

tbody tr.active {
    font-weight: bold;
    color: #009879;
}
</style>
