<template>
    <form @submit.prevent="uploadFile">
        <label for="csv"
            >Select
            <font-awesome-icon icon="fa-solid fa-file-csv" class="icon" />
            file</label
        >
        <input
            type="file"
            name="csv"
            accept="text/csv"
            id="csv"
            ref="inputRef"
            @change="selectFile"
        />
        <p v-if="file">{{ file.name }} ausgewählt</p>
        <button type="submit">
            <font-awesome-icon icon="fa-solid fa-upload" class="icon" />
            <span>Upload file</span>
        </button>
        <ErrorMessage v-if="error" :errorMessage="error" :embed="!!error" />
    </form>
</template>

<script lang="ts">
import axios from "axios";
import { defineComponent, ref } from "vue";
import ErrorMessage from "./ErrorMessage.vue";

export default defineComponent({
    name: "UploadCsv",
    components: { ErrorMessage },
    emit: ["goto-table"],
    setup(props, { emit }) {
        const inputRef = ref<HTMLInputElement>();
        const file = ref<null | File>();
        const error = ref("");

        function selectFile() {
            error.value = "";
            file.value =
                inputRef.value &&
                inputRef.value.files &&
                inputRef.value.files[0];
        }
        async function uploadFile() {
            if (file.value === null || file.value === undefined) {
                return;
            }
            const formData = new FormData();
            formData.append("file", file.value);
            try {
                const response = await axios.post("/csv/upload", formData, {
                    headers: { "Content-Type": "text/csv" },
                });
                file.value = null;
                if (response.data.ok) {
                    emit("goto-table");
                } else {
                    error.value = response.data.error;
                }
            } catch (err) {
                error.value = "Server Error";
            }
        }

        return { inputRef, file, error, selectFile, uploadFile };
    },
});
</script>

<style scoped>
form {
    position: relative;
    color: var(--color-white);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

input[type="file"] {
    opacity: 0;
    z-index: -1;
    position: absolute;
    top: -1px;
    left: 0;
    width: 0.1px;
    height: 0.1px;
}

label {
    margin: 10px;
    font-size: 1.5rem;
    padding: 10px;
    background: var(--color-white);
    color: black;
    border-radius: 10px;
    cursor: pointer;
}

label:hover {
    background: var(--button-hover);
}
p {
    text-align: center;
    padding: 10px;
}

button {
    margin-top: 20px;
    background-color: transparent;
    width: 120px;
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
</style>
