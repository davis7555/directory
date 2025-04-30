<template>
    <AutoComplete :suggestions="items" @complete="search" />
    <div v-if="errors">
        <InputError>{{ errors }}</InputError>
    </div>
</template>
<script setup>
import AutoComplete from 'primevue/autocomplete';

import { ref } from 'vue';

import InputError from './InputError.vue';

const props = defineProps({
    information: Array,
    errors: Object,
})

let items = ref([]);

const search = (event) => {
    items.value = [...props.information].filter((item) => item.match(new RegExp(event.query, 'gi')));
}
</script>