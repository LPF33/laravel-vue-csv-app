<template>
    <HeadLine />
    <NavMenu @toggle="toggle" :activeElem="show" />
    <TableUnit
        v-show="show === 'table'"
        :header="data.header"
        :body="data.body"
    />
    <ChartUnit v-show="show === 'chart'" :table="data.body" />
    <AddData v-show="show === 'add'" :columns="data.header" @add-row="addRow" />
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import axios from "axios";
import { HeaderTuple, IArticle, AxiosReponse, TToggleMenu } from "./types";
import TableUnit from "./Components/TableUnit.vue";
import NavMenu from "./Components/NavMenu.vue";
import ChartUnit from "./Components/ChartUnit.vue";
import HeadLine from "./Components/HeadLine.vue";
import AddData from "./Components/AddData.vue";

const data = reactive({
    header: [] as HeaderTuple | [],
    body: [] as IArticle[],
});

const show = ref<TToggleMenu>("table");

(async () => {
    const response = await axios.get<AxiosReponse>("/api/read");
    if (response.status === 200 && response.data) {
        data.header = response.data.header;
        data.body = response.data.body;
    }
})();

const toggle = (str: TToggleMenu): void => {
    show.value = str;
};

const addRow = (row: IArticle) => {
    console.log(row);
    data.body.push(row);
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
}

body {
    background-color: var(--header-color);
}
</style>
