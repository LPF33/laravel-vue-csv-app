<template>
    <form @submit.prevent="submit">
        <div
            v-for="(item, index) in columns"
            :key="index"
            :class="{ error: error[item] }"
        >
            <label :for="item">{{ item }}</label>
            <input type="text" :id="item" v-model="data[item]" />
            <p v-if="error[item]" class="form-error">{{ error[item] }}</p>
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
    </form>
</template>

<script lang="ts">
import axios from "axios";
import { defineComponent, PropType, reactive, ref } from "vue";
import { HeaderTuple, IArticle, TFormError } from "../types";

export default defineComponent({
    name: "AddData",
    props: {
        columns: {
            type: Object as PropType<HeaderTuple>,
            required: true,
        },
    },
    setup() {
        const data = reactive<IArticle>({
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
        });

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

        function checkIfEmpty(): boolean {
            let hasError = false;
            for (const elem in error) {
                if (data[elem] === "") {
                    error[elem] = "Please fill in this field";
                    hasError = true;
                } else {
                    error[elem] = "";
                }
            }
            return hasError;
        }

        function clearInputs() {
            for (const elem in data) {
                data[elem] = "";
            }
            for (const elem in error) {
                error[elem] = "";
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

            const response = await axios.post("/api/add", data);
            if (response.status === 200 && response.data.error) {
                checkIfEmpty();
                timeoutIcon("error");
            } else if (response.status === 200 && response.data.ok) {
                clearInputs();
                timeoutIcon("check");
            } else {
                timeoutIcon("error");
            }
        }

        return { data, error, submit, showIcon };
    },
});
</script>

<style scoped>
form {
    display: flex;
    flex-wrap: wrap;
    padding: 10px;
    border-radius: 10px;
    justify-content: center;
    max-width: 800px;
    margin: 0 auto;
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
    color: #023e8a;
}

.error input[type="text"] {
    border: 2px solid #023e8a;
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

button span {
    font-size: 1.2rem;
    margin-top: 5px;
}

.icon {
    font-size: 2rem;
}

.icon-check {
    color: green;
}

.icon-error {
    color: #023e8a;
}
</style>