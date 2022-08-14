<template>
    <nav>
        <button
            @click="toggleClicked('table')"
            :class="{ active: activeElem === 'table' }"
        >
            <font-awesome-icon icon="fa-solid fa-table-list" class="icon" />
            <span>Table</span>
        </button>
        <button
            @click="toggleClicked('add')"
            :class="{ active: activeElem === 'add' }"
        >
            <font-awesome-icon
                icon="fa-solid fa-file-circle-plus"
                class="icon"
            />
            <span>Add Data</span></button
        ><button
            @click="toggleClicked('upload')"
            :class="{ active: activeElem === 'upload' }"
        >
            <font-awesome-icon icon="fa-solid fa-upload" class="icon" />
            <span>Upload</span></button
        ><button
            @click="toggleClicked('chart')"
            :class="{ active: activeElem === 'chart' }"
        >
            <font-awesome-icon icon="fa-solid fa-chart-column" class="icon" />
            <span>Chart</span>
        </button>
        <a href="/api/export">
            <font-awesome-icon icon="fa-solid fa-download" class="icon" />
            <span>Download</span>
        </a>
    </nav>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import { TToggleMenu } from "../types";

export default defineComponent({
    name: "NavMenu",
    props: {
        activeElem: {
            type: String as PropType<TToggleMenu>,
            required: true,
        },
    },
    methods: {
        toggleClicked(str: TToggleMenu) {
            this.$emit("toggle", str);
        },
    },
});
</script>

<style scoped>
nav {
    padding: 10px 0;
    background-color: var(--header-color);
}

button,
a {
    background-color: transparent;
    width: 60px;
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    color: var(--inactive-tab);
    border-bottom: 2px solid transparent;
    text-decoration: none;
}

button:not(.active):hover,
a:hover {
    background-color: var(--button-hover);
    border-radius: 5px;
    cursor: pointer;
}

button.active {
    color: var(--active-tab);
    border-bottom: 2px solid var(--active-tab);
}

span {
    font-size: 0.8rem;
    margin-top: 5px;
}

.icon {
    font-size: 1.5rem;
}

@media screen and (min-width: 400px) {
    button,
    a {
        width: 80px;
    }
}

@media screen and (min-width: 540px) {
    nav {
        padding: 20px 20px 10px;
    }

    button,
    a {
        width: 100px;
    }

    span {
        font-size: 1.2rem;
    }
}
</style>
