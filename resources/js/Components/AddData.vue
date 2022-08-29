<template>
    <form @submit.prevent="submit" :class="{ embed: embed }">
        <div v-for="(item, key) in inputData" :key="String(index) + key">
            <label :for="String(index) + key">{{ key }}</label>
            <input
                type="text"
                :id="String(index) + key"
                v-model="inputData[key]"
            />
        </div>
        <div class="button-wrapper">
            <button type="submit">
                <font-awesome-icon
                    v-if="icon === 'save'"
                    icon="fa-solid fa-floppy-disk"
                    class="icon"
                />
                <font-awesome-icon
                    v-if="icon === 'check'"
                    icon="fa-solid fa-circle-check"
                    class="icon icon-check"
                />
                <font-awesome-icon
                    v-if="icon === 'error'"
                    icon="fa-solid fa-triangle-exclamation"
                    class="icon icon-error"
                />
                <span>Save</span>
            </button>
        </div>
        <button v-if="embed" type="button" class="close icon" @click="close">
            <font-awesome-icon icon="fa-solid fa-square-xmark" />
        </button>
    </form>
</template>

<script lang="ts">
import { defineComponent, PropType, reactive, toRefs, watch } from "vue";
import { IRowData, IDataRowIndex, IAddDataState } from "../types";
import useAxios from "@/Composables/useAxios";

export default defineComponent({
    name: "AddData",
    props: {
        embed: Boolean,
        index: {
            type: Number,
            default: -1,
        },
        data: {
            type: Object as PropType<IRowData>,
            required: true,
        },
    },
    emit: ["save-row", "close-add-data"],
    setup(props, { emit }) {
        const state = reactive<IAddDataState>({
            inputData: { ...props.data },
            icon: "save",
        });

        const { responseData, responseError, fireAxios } =
            useAxios<IDataRowIndex>("post");

        function clearInputs() {
            for (const elem in state.inputData) {
                state.inputData[elem] = "";
            }
        }

        function timeoutIcon(str: "check" | "error") {
            state.icon = str;
            setTimeout(() => (state.icon = "save"), 3000);
        }

        async function submit() {
            fireAxios(props.embed ? "/csv/write" : "/csv/add", {
                index: props.index,
                data: state.inputData,
            });
        }

        function close() {
            emit("close-add-data");
        }

        watch(
            () => props.data,
            (newValue) => (state.inputData = { ...newValue })
        );

        watch(responseData, (newValue) => {
            if (newValue !== null) {
                emit("save-row", {
                    index: props.index,
                    data: { ...state.inputData },
                });
                clearInputs();
                timeoutIcon("check");
            }
        });

        watch(responseError, (hasError) => {
            if (hasError) {
                timeoutIcon("error");
            }
        });

        return { ...toRefs(state), submit, close };
    },
});
</script>

<style scoped>
form {
    display: flex;
    flex-wrap: wrap;
    padding: 10px;
    border-bottom-left-radius: 10px;
    justify-content: center;
    max-width: 800px;
    margin: 0 auto;
}

form.embed {
    position: absolute;
    top: 0;
    right: 0;
    background-color: var(--header-color);
}

form > div {
    color: var(--color-white);
    padding: 10px;
}

label {
    display: block;
    font-size: 0.8rem;
}

input[type="text"] {
    background-color: transparent;
    border: 2px solid var(--color-white);
    border-radius: 5px;
    height: 20px;
    padding: 2px;
}
.error {
    color: var(--color-error);
}

.error input[type="text"] {
    border: 2px solid var(--color-error);
}

.form-error {
    font-size: 0.8rem;
}

.button-wrapper {
    width: 100%;
}

button {
    margin: 0 auto;
    background-color: transparent;
    width: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
    color: var(--active-tab);
    cursor: pointer;
}

button:hover {
    background-color: var(--button-hover);
    border-radius: 5px;
}

button span {
    font-size: 1.2rem;
    margin-top: 5px;
}

.icon {
    font-size: 2rem;
}

.icon-check {
    color: var(--color-green);
}

.icon-error {
    color: var(--color-error);
}

button.close {
    position: absolute;
    top: 0;
    right: 0;
}
</style>
