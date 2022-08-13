<template>
    <div>
        <font-awesome-icon
            icon="fa-solid fa-triangle-exclamation"
            class="icon-error"
        />
        <strong>{{errorMessage}}</strong>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "Error-Message",
    props: {
        errorMessage: String,
    },
});
</script>

<style scoped>
div {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 2rem;
    background-color: var(--color-white);
    padding: 10px;
    border-radius: 10px;
}

.icon-error {
    color: var(--color-error);
}

strong {
    margin-left: 10px;
}
</style>
