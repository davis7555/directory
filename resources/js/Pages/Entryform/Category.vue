<template>
    <Menu />
    <Header>CATEGORY</Header>
    <form @submit.prevent="route()">
        <div class="container grid grid-cols-1 gap-4 py-8 px-12">
            <IftaLabel>
                <Autocomplete :information="elements" :errors="props.errors.type" v-model="form.type" id="type" />
                <label for="type">Type</label>
                <div v-if="errors.type">
                    <InputError>{{ errors.type }}</InputError>
                </div>
            </IftaLabel>
            <IftaLabel>
                <Textarea v-model="form.description" :rows="10" id="description">
                </Textarea>
                <label for="description">description</label>
                <div v-if="errors.description">
                    <InputError>{{ errors.description }}</InputError>
                </div>
            </IftaLabel>
            <div class="flex justify-center pb-2 gap-6">
                <SubmitButton :disabled="form.processing" @click="method = 'post'">ADD CATEGORY
                </SubmitButton>
                <UpdateButton :disabled="form.processing" @click="method = 'put'">UPDATE CATEGORY</UpdateButton>
            </div>
        </div>
    </form>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';

import IftaLabel from 'primevue/iftalabel';

import Header from '@/Components/Heading.vue';

import SubmitButton from '@/Components/SubmitButton.vue';

import UpdateButton from '@/Components/UpdateButton.vue';

import Autocomplete from '@/Components/Autocomplete.vue';

import Textarea from 'primevue/textarea';

import InputError from '@/Components/ErrorMessage.vue';

import Menu from '@/Layouts/Menu.vue';

const props = defineProps({
    errors: Object,
    type_data: Object,
});

let elements = [];

let method = '';

for (let find = 0; find < props.type_data.length; find++) {
    elements.push(props.type_data[find].type);
}

const form = useForm({
    type: null,
    description: null,
});

function route() {
    if (method == 'post') {
        return form.post('/input-category', {
            onSuccess: () => form.reset(),
        })
    }
    else if (method == 'put') {
        return form.put('/input-category', {
            onSuccess: () => form.reset(),
        })
    }
}
</script>