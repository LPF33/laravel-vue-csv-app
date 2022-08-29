<template>
    <HeadLine />
    <NavMenu @toggle="toggle" :activeElem="show" />
    <TableUnit
        v-show="show === 'table' && !error"
        :header="data.header"
        :body="data.body"
        @update-value="updateValue"
    />
    <AddData
        v-if="show === 'add' && !error"
        @save-row="addRow"
        :data="data.emptyObj"
    />
    <ChartUnit
        v-if="show === 'chart' && !error"
        :filter-arr="data.header"
        :table="data.body"
    />
    <UploadFile v-if="show === 'upload'" @goto-table="goToTableAfterUpload" />
    <ErrorMessage v-if="error" :error-message="error" />
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import axios from "axios";
import {
    THeader,
    IRowData,
    AxiosReponse,
    TToggleMenu,
    IDataRowIndex,
} from "./types";
import HeadLine from "./Components/HeadLine.vue";
import NavMenu from "./Components/NavMenu.vue";
import UploadFile from "./Components/UploadFile.vue";
import TableUnit from "./Components/TableUnit.vue";
import ChartUnit from "./Components/ChartUnit.vue";
import AddData from "./Components/AddData.vue";
import ErrorMessage from "./Components/ErrorMessage.vue";

const data = reactive({
    header: [] as THeader | [],
    body: [] as IRowData[],
    emptyObj: {} as IRowData,
});

const show = ref<TToggleMenu>("table");

const error = ref("");

const getCSVData = async () => {
    try {
        const response = await axios.get<AxiosReponse>("/csv/read");
        if (response.status === 200 && !response.data.error) {
            data.header = response.data.header;
            data.body = response.data.body;
            data.emptyObj = Object.fromEntries(
                Object.keys(response.data.body[0]).map((key) => [key, ""])
            );
            error.value = "";
        } else if (response.status === 200 && response.data.error) {
            error.value = response.data.error;
            show.value = "upload";
        }
    } catch (err) {
        error.value = "Server Error! Please try again!";
    }
};

getCSVData();

const toggle = (str: TToggleMenu): void => {
    show.value = str;
};

const addRow = (row: IDataRowIndex) => {
    data.body.push(row.data);
};

const updateValue = (event: IDataRowIndex) => {
    data.body[event.index] = event.data;
};

const goToTableAfterUpload = () => {
    getCSVData();
    toggle("table");
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
    --button-hover: #ffffff66;
    --color-error: #023e8a;
    --color-green: #008000;
}

body {
    background-color: var(--header-color);
}
</style>
