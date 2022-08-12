<template>
    <main>
        <table>
            <thead>
                <tr>
                    <th v-for="(item, index) in header" :key="index">
                        {{ item }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <TableRow
                    v-for="(row, index) in currentBody"
                    :key="row.Hauptartikelnr + index"
                    :row="row"
                />
            </tbody>
        </table>
        <div>
            <button
                v-for="(item, index) in pages"
                :key="index"
                @click="setPage(item)"
                :class="{ active: item === currentPage }"
            >
                {{ item }}
            </button>
        </div>
    </main>
</template>

<script lang="ts">
import { computed, defineComponent, PropType, ref } from "vue";
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
    setup(props) {
        const itemsPerPage = 15;
        const maxPage = Math.ceil(props.body.length / itemsPerPage);
        const currentPage = ref(1);

        const currentBody = computed(() =>
            props.body.slice(
                itemsPerPage * (currentPage.value - 1),
                itemsPerPage * currentPage.value
            )
        );

        const pages = computed(() => {
            const pagesArr = [1];
            for (
                let i = currentPage.value - 3 < 1 ? 1 : currentPage.value - 3;
                i <=
                (currentPage.value + 3 > maxPage
                    ? maxPage
                    : currentPage.value + 3);
                i++
            ) {
                pagesArr.push(i);
            }
            pagesArr.push(maxPage);
            return [...new Set(pagesArr)];
        });

        function setPage(num: number) {
            currentPage.value = num;
        }

        return { currentBody, setPage, currentPage, pages };
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

table + div > button {
    padding: 10px;
    margin: 10px;
    border-radius: 5px;
    background-color: var(--inactive-tab);
    color: black;
}

table + div > button:not(.active):hover {
    cursor: pointer;
    background-color: var(--active-tab);
}

table + div > button.active {
    background-color: var(--active-tab);
}
</style>
