<template>
    <Menu />
    <Heading>BUILDING</Heading>
    <form @submit.prevent="route()">
        <div class="container grid grid-cols-1 gap-4 py-8 px-12">
            <IftaLabel>
                <Autocomplete :information="elements" :errors="props.errors.name" v-model="form.name" id="name" />
                <label for="name">Name</label>
                <div v-if="errors.name">
                    <InputError>{{ errors.name }}</InputError>
                </div>
            </IftaLabel>
            <IftaLabel>
                <InputText type="text" v-model="form.location" id="location" />
                <label for="location">Location</label>
                <div v-if="errors.location">
                    <InputError>{{ errors.location }}</InputError>
                </div>
            </IftaLabel>
            <div class="flex justify-center pb-2 gap-4">
                <SubmitButton :disabled="form.processing" @click="method = 'post'">ADD BUILDING</SubmitButton>
                <UpdateButton :disabled="form.processing" @click="method = 'put'">UPDATE BUILDING</UpdateButton>
            </div>
        </div>
    </form>
</template>
<script setup>
import Heading from '@/Components/Heading.vue';

import IftaLabel from 'primevue/iftalabel';

import { useForm } from '@inertiajs/vue3';

import SubmitButton from '@/Components/SubmitButton.vue';

import UpdateButton from '@/Components/UpdateButton.vue';

import InputText from 'primevue/inputtext';

import InputError from '@/Components/ErrorMessage.vue';

import Autocomplete from '@/Components/Autocomplete.vue';

import Menu from '@/Layouts/Menu.vue';

const form = useForm({
    name: null,
    location: null,
});

const props = defineProps({
    business_data: Object,
    errors: Object,
})

let elements = [];

let method = '';

for (let find = 0; find < props.business_data.length; find++) {
    elements.push(props.business_data[find].name);
}

function route() {
    if (method == 'post') {
        return form.post('/input-building', {
            onSuccess: () => form.reset(),
        })
    }
    else if (method == 'put') {
        return form.put('/input-building', {
            onSuccess: () => form.reset(),
        })
    }
}

</script>