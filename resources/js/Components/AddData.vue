<template>
    <form @submit.prevent="submit">
        <div
            v-for="(item, index) in columns"
            :key="index"
            :class="{ error: error[item] }"
        >
            <label :for="item">{{ item }}</label>
            <input type="text" :id="item" v-model="data[item]" />
        </div>
        <button type="submit">
            <font-awesome-icon icon="fa-solid fa-floppy-disk" class="icon" />
            <span>Save</span>
        </button>
    </form>
</template>

<script lang="ts">
import axios from "axios";
import { defineComponent, PropType, reactive } from "vue";
import { HeaderTuple, IArticle, TCheckValues } from "../types";

export default defineComponent({
    name: "AddData",
    props: {
        columns: {
            type: Object as PropType<HeaderTuple>,
            required: true,
        },
    },
    setup(props) {
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

        const error = reactive<IArticle>({
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

        function checkIfEmpty(arr: TCheckValues): boolean {
            let hasError = false;
            for (const elem of arr) {
                if (data[elem] === "") {
                    error[elem] = "Fill out this field!";
                    hasError = true;
                } else {
                    error[elem] = "";
                }
            }
            return hasError;
        }

        async function submit() {
            if (
                checkIfEmpty(
                    props.columns.filter(
                        (item) =>
                            !item.match(
                                /Ärmel|Bein|Kragen|Herstellung|Taschenart|Grammatur|Ursprungsland|Bildname/
                            )
                    ) as TCheckValues
                )
            ) {
                return;
            }

            const response = await axios.post("/api/add", data);
            console.log(response);
        }

        return { data, error, submit };
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
}
.error {
    color: #0077b6;
}

.error input[type="text"] {
    border: 2px solid #0077b6;
}

button {
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
</style>
