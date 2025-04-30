<template>
    <div class="card">
        <Menubar :model="items" />
    </div>
</template>
<script setup>
import Menubar from 'primevue/menubar';

import { ref } from 'vue';

const items = ref([
    {
        label: 'Category',
        url: '/',
    },
    {
        label: 'Business',
        url: '/business',
    },
    {
        label: 'Websites',
        url: '/website',
    },
    {
        label: 'Building',
        url: '/building',
    },
]);

</script>