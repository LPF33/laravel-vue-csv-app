<template>
    <HeadLine />
    <NavMenu @toggle="toggle" :activeElem="show" />
    <TableUnit
        v-show="show === 'table'"
        :header="data.header"
        :body="data.body"
        @update-value="updateValue"
    />
    <ChartUnit v-show="show === 'chart'" :table="data.body" />
    <AddData v-show="show === 'add'" :columns="data.header" @add-row="addRow" />
    <ErrorMessage v-if="error" :error-message="error" />
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import axios from "axios";
import {
    HeaderTuple,
    IArticle,
    AxiosReponse,
    TToggleMenu,
    IUpdateValueEmit,
} from "./types";
import TableUnit from "./Components/TableUnit.vue";
import NavMenu from "./Components/NavMenu.vue";
import ChartUnit from "./Components/ChartUnit.vue";
import HeadLine from "./Components/HeadLine.vue";
import AddData from "./Components/AddData.vue";
import ErrorMessage from "./Components/ErrorMessage.vue";

const data = reactive({
    header: [] as HeaderTuple | [],
    body: [] as IArticle[],
});

const show = ref<TToggleMenu>("table");

const error = ref("");

(async () => {
    try {
        const response = await axios.get<AxiosReponse>("/api/read");
        if (response.status === 200 && response.data) {
            data.header = response.data.header;
            data.body = response.data.body;
            error.value = "";
        }
    } catch (err) {
        error.value = "Server Error! Please try again!";
    }
})();

const toggle = (str: TToggleMenu): void => {
    show.value = str;
};

const addRow = (row: IArticle) => {
    data.body.push(row);
};

const updateValue = (event: IUpdateValueEmit) => {
    data.body[event.rowIndex][event.columnName] = event.columnData;
};
</script>

<style>
* {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    border: 0;
    box-sizing: border-box;
}

:root {
    --header-color: #f15412;
    --table-header: #000000;
    --color-white: #fff;
    --active-tab: #fff;
    --inactive-tab: #eeeeeeab;
    --table-hover: #cff7dd62;
    --color-error: #023e8a;
    --color-green: #008000;
}

body {
    background-color: var(--header-color);
}
</style>
