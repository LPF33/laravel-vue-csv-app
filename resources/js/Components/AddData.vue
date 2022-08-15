<template>
    <form @submit.prevent="submit" :class="{ embed: embed }">
        <div
            v-for="(item, key) in inputData"
            :key="key"
            :class="{ error: error[key] }"
        >
            <label :for="key">{{ key }}</label>
            <input type="text" :id="key" v-model="inputData[key]" />
            <p v-if="key in error" class="form-error">
                {{ error[key] }}
            </p>
        </div>
        <div class="button-wrapper">
            <button type="submit">
                <font-awesome-icon
                    v-if="showIcon === 'save'"
                    icon="fa-solid fa-floppy-disk"
                    class="icon"
                />
                <font-awesome-icon
                    v-if="showIcon === 'check'"
                    icon="fa-solid fa-circle-check"
                    class="icon icon-check"
                />
                <font-awesome-icon
                    v-if="showIcon === 'error'"
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
import { defineComponent, PropType, reactive, ref, watch } from "vue";
import { IArticle, IDataRowIndex, TFormError } from "../types";
import useAxios from "@/Composables/useAxios";

export default defineComponent({
    name: "AddData",
    props: {
        embed: Boolean,
        index: {
            type: Number,
            default: -1,
        },
        data: Object as PropType<IArticle | undefined>,
    },
    emit: ["save-row", "close-add-data"],
    setup(props, { emit }) {
        const inputData = reactive<IArticle>(
            props.data ?? {
                Hauptartikelnr: "",
                Artikelname: "",
                Hersteller: "",
                Beschreibung: "",
                Materialangaben: "",
                Geschlecht: "",
                Produktart: "",
                Ärmel: "",
                Bein: "",
                Kragen: "",
                Herstellung: "",
                Taschenart: "",
                Grammatur: "",
                Material: "",
                Ursprungsland: "",
                Bildname: "",
            }
        );

        const error = reactive<TFormError>({
            Hauptartikelnr: "",
            Artikelname: "",
            Hersteller: "",
            Beschreibung: "",
            Materialangaben: "",
            Geschlecht: "",
            Produktart: "",
            Material: "",
        });

        const showIcon = ref<"save" | "check" | "error">("save");

        const { responseData, responseError, fireAxios } =
            useAxios<IDataRowIndex>("post");

        function checkIfEmpty(): boolean {
            let hasError = false;
            let elem: keyof TFormError;
            for (elem in error) {
                if (inputData[elem] === "") {
                    error[elem] = "Please fill in this field";
                    hasError = true;
                } else {
                    error[elem] = "";
                }
            }
            return hasError;
        }

        function clearInputs() {
            let elem: keyof IArticle;
            for (elem in inputData) {
                inputData[elem] = "";
            }
            let err: keyof TFormError;
            for (err in error) {
                error[err] = "";
            }
        }

        function timeoutIcon(str: "check" | "error") {
            showIcon.value = str;
            setTimeout(() => (showIcon.value = "save"), 3000);
        }

        async function submit() {
            if (checkIfEmpty()) {
                timeoutIcon("error");
                return;
            }

            fireAxios(props.embed ? "/api/write" : "/api/add", {
                index: props.index,
                data: inputData,
            });
        }

        watch(responseData, (newValue) => {
            if (newValue !== null) {
                emit("save-row", {
                    index: props.index,
                    data: { ...inputData },
                });
                clearInputs();
                timeoutIcon("check");
            }
        });

        watch(responseError, (hasError) => {
            if (hasError) {
                checkIfEmpty();
                timeoutIcon("error");
            }
        });

        function close() {
            emit("close-add-data");
        }

        return { inputData, error, submit, showIcon, close };
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
