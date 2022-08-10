<template>
    <nav>
        <button @click="toggleClicked('table')" :class="{active: activeElem === 'table'}">
            <font-awesome-icon icon="fa-solid fa-table-list" class="icon"/>
            <span>Table</span>
        </button>
        <button @click="toggleClicked('chart')" :class="{active: activeElem === 'chart'}">
            <font-awesome-icon icon="fa-solid fa-chart-column" class="icon"/>
            <span>Chart</span>
        </button>
    </nav>
</template>

<script lang="ts">
import {defineComponent, PropType} from 'vue';
import {TToggleMenu} from "../types";

export default defineComponent({
    name: "Menu",
    props: {
        activeElem: {
            type: String as PropType<TToggleMenu>,
            required: true
        }
    },
    methods: {
        toggleClicked(str: TToggleMenu) {
            this.$emit("toggle", str);
        }
    }
})
</script>

<style scoped>
nav {
    padding: 20px 20px 10px;
    background-color: var(--header-color);
}

button {
    background-color: transparent;
    width: 100px;
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    color: var(--inactive-tab);
    border-bottom: 2px solid transparent;
}

button.active {
    color: var(--active-tab);
    border-bottom: 2px solid var(--active-tab);
}

span {
    font-size: 1.2rem;
    margin-top: 5px;
}

.icon {
    font-size: 1.5rem;

}
</style>