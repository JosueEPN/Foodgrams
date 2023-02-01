<template>
    <AppLayout>
        <div class="flex flex-col">
            <JetValidationErrors class="mb-4" />

            <form @submit.prevent="submit">
            <div>
                <JetLabel for="name" value="Name" />
                <JetInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
            </div>

            <div class="mt-4">
                <JetLabel for="nick_name" value="Nick_name" />
                <JetInput
                    id="name"
                    v-model="form.nick_name"
                    type="text"
                    class="mt-1 block w-full"
                    required

                />
            </div>

            <div class="mt-4">
                <JetLabel for="email" value="Email" />
                <JetInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                />
            </div>

            <div class="mt-4">
                <JetLabel for="password" value="Password" />
                <JetInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div class="mt-4">
                <JetLabel for="password_confirmation" value="Confirm Password" />
                <JetInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
            </div>

         

            <div class="flex items-center justify-end mt-4">
                <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrate
                </JetButton>
            </div>
        </form>
        </div>
         
    </AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetLabel from '@/Jetstream/Label.vue';
import AppLayout from '@/Layouts/AppLayout';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

const form = useForm({
    name: '',
    nick_name:'',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('user.register.admin'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
