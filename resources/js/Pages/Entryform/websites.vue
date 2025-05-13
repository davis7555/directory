<template>
    <Menu />
    <Heading>WEBSITES</Heading>
    <form @submit.prevent="route()">
        <div class="container grid grid-cols-1 gap-4 py-8 px-12">
            <IftaLabel>
                <InputText type="text" v-model="form.name" class="w-64" id="name"></InputText>
                <label for="name">Name</label>
            </IftaLabel>
            <div v-if="errors.name">
                <InputError>{{ errors.name }}</InputError>
            </div>
            <IftaLabel>
                <Autocomplete v-model="form.url" :information="url" :errors="props.errors.url" id="url">
                </Autocomplete>
                <label for="url">URL</label>
            </IftaLabel>
            <div v-if="errors.url">
                <InputError>{{ errors.url }}</InputError>
            </div>
            <IftaLabel>
                <Autocomplete v-model="form.business" :information="business" :errors="props.errors.business"
                    id="business_name">
                </Autocomplete>
                <label for="business_name">Business Name</label>
            </IftaLabel>
            <div v-if="errors.business">
                <InputError>{{ errors.business }}</InputError>
            </div>
            <IftaLabel>
                <Autocomplete v-model="form.category" :information="categories" :errors="props.errors.category"
                    id="type">
                </Autocomplete>
                <label for="type">Category Type</label>
            </IftaLabel>
            <div v-if="errors.category">
                <InputError>{{ errors.category }}</InputError>
            </div>
            <div class="flex justify-center pb-2 gap-4">
                <SubmitButton :disabled="form.processing" @click="method = 'post'">ADD WEBSITE</SubmitButton>
                <UpdateButton :disabled="form.processing" @click="method = 'put'">UPDATE WEBSITE</UpdateButton>
            </div>
        </div>
    </form>
</template>
<script setup>
import Heading from '@/Components/Heading.vue';

import IftaLabel from 'primevue/iftalabel';

import { useForm } from '@inertiajs/vue3';

import InputError from '@/Components/InputError.vue';

import SubmitButton from '@/Components/SubmitButton.vue';

import UpdateButton from '@/Components/UpdateButton.vue';

import InputText from 'primevue/inputtext';

import Autocomplete from '@/Components/Autocomplete.vue';

import Menu from '@/Layouts/Menu.vue';

const form = useForm({
    name: null,
    url: null,
    business: null,
    category: null,
});

const props = defineProps({
    website_data: Object,
    business_data: Object,
    category_data: Object,
    errors: Object,
});

let url = [];

let business = [];

let categories = [];

let method = '';

for (let find = 0; find < props.website_data.length; find++) {
    url.push(props.website_data[find].url);
}

for (let find = 0; find < props.business_data.length; find++) {
    business.push(props.business_data[find].name);
}

for (let find = 0; find < props.category_data.length; find++) {
    categories.push(props.category_data[find].type);
}

function route() {
    if (method == 'post') {
        return form.post('/input-website', {
            onSuccess: () => form.reset(),
        })
    }
    else if (method == 'put') {
        return form.put('/input-website', {
            onSuccess: () => form.reset(),
        })
    }
}
</script>