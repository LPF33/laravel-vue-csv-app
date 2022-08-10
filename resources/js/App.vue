<template>
    <Header />
    <Menu @toggle="toggle" :activeElem="show"/>
    <Table v-show="show === 'table'" :header="data.header" :body="data.body"/>
    <Chart v-show="show === 'chart'" />
</template>

<script setup lang="ts">
import { onMounted, reactive, ref } from "@vue/runtime-core";
import axios from "axios";
import {HeaderTuple, IArticle, AxiosReponse, TToggleMenu} from "./types";
import Table from "./Components/Table.vue";
import Menu from "./Components/Menu.vue";
import Chart from "./Components/Chart.vue";
import Header from "./Components/Header.vue";

const data = reactive({
    header: [] as HeaderTuple | [],
    body: [] as IArticle[]
});

const show = ref<TToggleMenu>("table");

(async () => {
    const response = await axios.post<AxiosReponse>("/api/read");
    if(response.status === 200 && response.data) {
        data.header = response.data.header;
        data.body = response.data.body;
    }
})();

const toggle = (str: TToggleMenu):void => {
    show.value = str;
}
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
    --header-color: #F15412;
    --table-header: #000000;
    --color-white: #fff;
    --active-tab: #fff;
    --inactive-tab: #eeeeeeab;
}

body {
    width: 100%;
}
</style>