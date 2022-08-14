<template>
    <div :class="{ embed: embed }">
        <font-awesome-icon
            icon="fa-solid fa-triangle-exclamation"
            class="icon-error"
        />
        <strong>{{ errorMessage }}</strong>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "Error-Message",
    props: {
        errorMessage: String,
        embed: Boolean,
    },
});
</script>

<style scoped>
div {
    position: absolute;
    font-size: 2rem;
    background-color: var(--color-white);
    padding: 10px;
    border-radius: 10px;
}

div:not(.embed) {
    top: 10px;
    left: 10px;
}

div.embed {
    bottom: 0;
    color: black;
}

.icon-error {
    color: var(--color-error);
}

strong {
    margin-left: 10px;
}
</style>
