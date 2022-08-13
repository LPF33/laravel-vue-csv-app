<template>
    <td @mouseenter="edit(true)" @mouseleave="edit(false)">
        <input type="text" v-model="data" ref="input" />
        <span v-if="show && iconCheck" @click="save">
            <font-awesome-icon icon="fa-solid fa-circle-check" class="icon" />
        </span>
        <span v-if="show && !iconCheck" @click="setFocus">
            <font-awesome-icon icon="fa-solid fa-pen-to-square" class="icon" />
        </span>
    </td>
</template>

<script lang="ts">
import { IArticle, IUpdateValueEmit } from "@/types";
import { defineComponent, ref, PropType, watch } from "vue";

export default defineComponent({
    name: "TableDate",
    props: {
        columnData: {
            type: String,
            required: true,
        },
        columnName: {
            type: String as PropType<keyof IArticle>,
            required: true,
        },
        rowIndex: {
            type: Number,
            required: true,
        },
    },
    emit: ["update-value"],
    setup(props, { emit }) {
        const data = ref<string>(props.columnData);
        const show = ref<boolean>(false);
        const iconCheck = ref<boolean>(false);
        const input = ref<HTMLInputElement>();

        function setFocus() {
            input.value?.focus();
        }

        function edit(val: boolean) {
            show.value = val;
        }

        function save() {
            emit("update-value", {
                rowIndex: props.rowIndex,
                columnName: props.columnName,
                columnData: data.value,
            } as IUpdateValueEmit);
            edit(false);
            iconCheck.value = false;
        }

        watch(data, () => (iconCheck.value = true));

        return { data, show, iconCheck, input, setFocus, edit, save };
    },
});
</script>

<style scoped>
td {
    position: relative;
}

input {
    display: inline-block;
    background-color: transparent;
    height: 1.8rem;
}

.icon {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translate(0, -50%);
    color: green;
    font-size: 1.5rem;
    cursor: pointer;
}
</style>
