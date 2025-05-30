<template>
    <Menu />
    <Heading>Building List</Heading>
    <div class="card container pt-9">
        <DataTable v-model:filters="filters" :value="table" dataKey="id" tableStyle="min-width: 50rem"
            filterDisplay="menu" :globalFilterFields="['name', 'location']">
            <template #header>
                <div class="flex justify-content-between">
                    <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                </div>
            </template>
            <template #empty> No items found. </template>
            <Column field="name" header="Name"></Column>
            <Column field="location" header="Location"></Column>
        </DataTable>
    </div>
</template>
<script setup>
import DataTable from 'primevue/datatable';

import Heading from '@/Components/Heading.vue';

import { ref } from 'vue';

import Column from 'primevue/column';

import InputText from 'primevue/inputtext';

import Menu from '@/Layouts/Menu.vue';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';

const props = defineProps({
    building_data: Object,
});

const table = props.building_data;

const filters = ref();

const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
        location: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
    }
};
initFilters();
</script>