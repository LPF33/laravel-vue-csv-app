<template>
    <td @mouseenter="edit(true)" @mouseleave="edit(false)">
        <input type="text" v-model="data" ref="input" />
        <span v-if="show && iconCheck" @click="save">
            <font-awesome-icon icon="fa-solid fa-circle-check" class="icon" />
        </span>
        <span v-if="show && !iconCheck" @click="openAddData">
            <font-awesome-icon icon="fa-solid fa-pen-to-square" class="icon" />
        </span>
    </td>
</template>

<script lang="ts">
import { IRowData, IUpdateValueEmit } from "@/types";
import { defineComponent, ref, PropType, watch } from "vue";

export default defineComponent({
    name: "TableDate",
    props: {
        columnData: {
            type: String,
            required: true,
        },
        columnName: {
            type: String as PropType<keyof IRowData>,
            required: true,
        },
        rowIndex: {
            type: Number,
            required: true,
        },
        responseError: {
            type: Boolean,
            required: true,
        },
    },
    emit: ["update-value", "open-add-data"],
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

        function openAddData() {
            emit("open-add-data");
        }

        watch(data, () => (iconCheck.value = true));

        watch(
            () => props.responseError,
            (newValue) => {
                if (newValue === true) {
                    data.value = props.columnData;
                }
            }
        );

        return {
            data,
            show,
            iconCheck,
            input,
            setFocus,
            edit,
            save,
            openAddData,
        };
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
    text-align: center;
}

.icon {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translate(0, -50%);
    color: var(--color-green);
    font-size: 1.5rem;
    cursor: pointer;
}
</style>
