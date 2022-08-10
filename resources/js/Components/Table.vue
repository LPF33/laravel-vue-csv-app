<template>
    <table>
        <thead>
            <tr>
                <th v-for="(item, index) in header" :key="index">{{item}}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row, index2) in body" :key="index2">
                <TableData v-for="(column, index3) in row" :key="index3" :column-data="column"/>
            </tr>
        </tbody>
    </table>
</template>

<script lang="ts">
import {defineComponent, PropType} from 'vue';
import { IArticle } from '../types';
import TableData from './TableData.vue';

export default defineComponent({
    name: "Table",
    props: {
        header: {
            type: Array as PropType<string[]>,
            required: true
        },
        body: {
            type: Array as PropType<IArticle[]>,
            required: true
        }
    },
    setup(props) {
    },
    components: { TableData }
})
</script>

<style scoped>
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

    th, td {
        padding: 12px 10px;
    }

    tbody tr {
        border-bottom: 1px solid #dddddd;
    }

tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
}

tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}

tbody tr.active {
    font-weight: bold;
    color: #009879;
}
</style>