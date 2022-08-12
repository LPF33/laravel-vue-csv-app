<template>
    <td>
        <input type="text" v-model="data" @focus="edit(true)" />
        <span>
            <font-awesome-icon
                v-if="show"
                icon="fa-solid fa-circle-check"
                class="icon"
                @click="save"
            />
        </span>
    </td>
</template>

<script lang="ts">
import { IArticle, IUpdateValueEmit } from "@/types";
import { defineComponent, ref, PropType } from "vue";

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

        function edit(val: boolean) {
            console.log(val);
            show.value = val;
        }

        function save() {
            emit("update-value", {
                rowIndex: props.rowIndex,
                columnName: props.columnName,
                columnData: data.value,
            } as IUpdateValueEmit);
        }

        return { data, show, edit, save };
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
