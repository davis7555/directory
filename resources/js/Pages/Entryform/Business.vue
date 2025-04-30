<template>
    <Menu />
    <Heading>BUSINESS</Heading>
    <form @submit.prevent="route()">
        <div class="container grid grid-cols-1 gap-4 py-8 px-12">
            <IftaLabel>
                <Autocomplete v-model="form.name" :information="elements" :errors="props.errors.name" id="name">
                </Autocomplete>
                <label for="name">Name</label>
            </IftaLabel>
            <IftaLabel>
                <Autocomplete v-model="form.building" :information="buildings" :errors="props.errors.building"
                    id="building_name"></Autocomplete>
                <label for="building_name">Building Name</label>
            </IftaLabel>
            <IftaLabel>
                <Autocomplete v-model="form.category" :information="categories" :errors="props.errors.category"
                    id="category_type"></Autocomplete>
                <label for="category_type">Category Type</label>
            </IftaLabel>
            <IftaLabel>
                <InputText type="text" v-model="form.location" id="location"></InputText>
                <label for="location">Location</label>
            </IftaLabel>
            <div v-if="errors.location">
                <InputError>{{ errors.location }}</InputError>
            </div>
            <IftaLabel>
                <InputText type="text" v-model="form.email" id="email"></InputText>
                <label for="email">Email</label>
            </IftaLabel>
            <div v-if="errors.email">
                <InputError>{{ errors.email }}</InputError>
            </div>
            <IftaLabel>
                <InputText type="text" v-model="form.icon" inputId="icon"></InputText>
                <label for="icon">Icon</label>
            </IftaLabel>
            <div v-if="errors.icon">
                <InputError>{{ errors.icon }}</InputError>
            </div>
            <IftaLabel>
                <InputText type="text" v-model="form.phone" inputId="phone"></InputText>
                <label for="phone">Phone Number</label>
            </IftaLabel>
            <div v-if="errors.phone">
                <InputError>{{ errors.phone }}</InputError>
            </div>
            <div class="flex justify-center pb-2 gap-4">
                <SubmitButton :disabled="form.processing" @click="method = 'post'">ADD BUSINESS</SubmitButton>
                <UpdateButton :disabled="form.processing" @click="method = 'put'">UPDATE BUSINESS</UpdateButton>
            </div>
        </div>
    </form>
</template>
<script setup>
import Heading from '@/Components/Heading.vue';

import { useForm } from '@inertiajs/vue3';

import IftaLabel from 'primevue/iftalabel';

import InputError from '@/Components/InputError.vue';

import SubmitButton from '@/Components/SubmitButton.vue';

import UpdateButton from '@/Components/UpdateButton.vue';

import InputText from 'primevue/inputtext';

import Autocomplete from '@/Components/Autocomplete.vue';

import Menu from '@/Layouts/Menu.vue';

const form = useForm({
    name: null,
    building: null,
    category: null,
    location: null,
    email: null,
    icon: null,
    phone: null,
});

const props = defineProps({
    business_data: Object,
    building_data: Object,
    category_data: Object,
    errors: Object,
})

let elements = [];

let buildings = [];

let categories = [];

let method = '';

for (let find = 0; find < props.business_data.length; find++) {
    elements.push(props.business_data[find].name);
}

for (let find = 0; find < props.building_data.length; find++) {
    buildings.push(props.building_data[find].name);
}

for (let find = 0; find < props.category_data.length; find++) {
    categories.push(props.category_data[find].type);
}

function route() {
    if (method == 'post') {
        return form.post('/input-business', {
            onSuccess: () => form.reset(),
        })
    }
    else if (method == 'put') {
        return form.put('/input-business', {
            onSuccess: () => form.reset(),
        })
    }
}
</script>