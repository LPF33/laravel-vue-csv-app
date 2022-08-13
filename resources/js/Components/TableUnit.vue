<template>
    <main>
        <div>
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
                        :index="itemsPerPage * (currentPage - 1) + index"
                        @update-value="passValue"
                    />
                </tbody>
            </table>
        </div>
        <div>
            <button
                v-for="(item, index) in pages"
                :key="item + index"
                @click="setPage(item)"
                :class="{ active: item === currentPage }"
                class="pagination"
            >
                {{ item }}
            </button>
        </div>
    </main>
</template>

<script lang="ts">
import { computed, defineComponent, PropType, ref } from "vue";
import { IArticle, IUpdateValueEmit } from "../types";
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
    emit: ["update-value"],
    setup(props, { emit }) {
        const itemsPerPage = 15;
        const currentPage = ref(1);

        const currentBody = computed(() =>
            props.body.slice(
                itemsPerPage * (currentPage.value - 1),
                itemsPerPage * currentPage.value
            )
        );

        const pages = computed(() => {
            const maxPage = Math.ceil(props.body.length / itemsPerPage);
            const pagesArr: number[] = [1];
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

        function passValue(event: IUpdateValueEmit) {
            emit("update-value", event);
        }

        return {
            itemsPerPage,
            currentPage,
            currentBody,
            pages,
            setPage,
            passValue,
        };
    },
});
</script>

<style>
main > div:first-child {
    width: 100vw;
    overflow-x: scroll;
}

table {
    border-collapse: collapse;
    margin: 0;
    font-size: 0.9em;
    font-family: sans-serif;
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
    padding: 2px 24px 2px 2px;
    line-height: 2rem;
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

button.pagination {
    padding: 10px;
    margin: 10px;
    border-radius: 5px;
    background-color: var(--inactive-tab);
    color: black;
}

button.pagination:not(.active):hover {
    cursor: pointer;
    background-color: var(--active-tab);
}

button.pagination.active {
    background-color: var(--active-tab);
}
</style>
