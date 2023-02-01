<template>
    <AppLayout>

        <div class="flex flex-col">
            <h1> Usuarios </h1>
            <JetFormSection @submitted="updateProfileInformation">
                <template #title>
                    Profile Information
                </template>

                <template #form>
                    <!-- Profile Photo -->
                    <div  class="col-span-6 sm:col-span-4">
                        <!-- Profile Photo File Input -->
                        <input
                            ref="photoInput"
                            type="file"
                            class="hidden"
                            @change="updatePhotoPreview"
                        >

                        <JetLabel for="photo" value="Photo" />

                        <!-- Current Profile Photo -->
                        <div v-show="! photoPreview" class="mt-2">
                            <img :src="userEdit.profile_photo_url" :alt="userEdit.name" class="rounded-full h-20 w-20 object-cover">
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div v-show="photoPreview" class="mt-2">
                            <span
                                class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                :style="'background-image: url(\'' + photoPreview + '\');'"
                            />
                        </div>

                        <JetSecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                            Select A New Photo
                        </JetSecondaryButton>

                        <JetSecondaryButton
                            v-if="userEdit.profile_photo_path"
                            type="button"
                            class="mt-2"
                            @click.prevent="deletePhoto"
                        >
                            Remove Photo
                        </JetSecondaryButton>

                        <JetInputError :message="form.errors.photo" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <JetLabel for="Nick_name" value="nick_name" />
                        <JetInput
                            id="nick_name"
                            v-model="form.nick_name"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="nick_name"
                        />
                        <JetInputError :message="form.errors.nick_name" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <JetLabel for="email" value="Email" />
                        <JetInput            
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                        />
                        <JetInputError :message="form.errors.email" class="mt-2" />

                        <div v-if="$page.props.jetstream.hasEmailVerification && userEdit.email_verified_at === null">
                            <p class="text-sm mt-2">
                                Your email address is unverified.

                                <Link
                                    :href="route('verification.send')"
                                    method="post"
                                    as="button"
                                    class="underline text-gray-600 hover:text-gray-900"
                                    @click.prevent="sendEmailVerification"
                                >
                                    Click here to re-send the verification email.
                                </Link>
                            </p>

                            <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                                A new verification link has been sent to your email address.
                            </div>
                        </div>
                    </div>
                    <!-- Web site -->
                    <div class="col-span-6 sm:col-span-4">
                        <JetLabel for="web_site" value="Web_site" />
                        <JetInput
                            id="web_site"
                            v-model="form.web_site"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <JetInputError :message="form.errors.web_site" class="mt-2" />
                    </div>
                    <!-- Presentation -->
                    <div class="col-span-6 sm:col-span-4">
                        <JetLabel for="presentation" value="Presentation" />
                        <JetInput
                            id="presentation"
                            v-model="form.presentation"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <JetInputError :message="form.errors.presentation" class="mt-2" />
                    </div>

                    <!--Roles-->

                    <div v-for="(rol,index) in roles" class="col-span-6 sm:col-span-4" >
                        <JetLabel :value="rol.name" :for="form.role"/>
                        <JetInput 
                            :id="rol.name"
                            type="checkbox" 
                            v-model="form.role" 
                            :value="rol.name" 
                            @change="uncheck"
                        />
                    </div>
                </template>

                <template #actions>
                    <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </JetActionMessage>

                    <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </JetButton>
                </template>
            </JetFormSection>
            
        </div>                        
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import AppLayout from '@/Layouts/AppLayout';

const props = defineProps({
    userEdit: Object,
    roles:Object
});





const form = useForm({
    _method: 'POST',
    id:props.userEdit.id,
    nick_name: props.userEdit.nick_name,
    email: props.userEdit.email,
    presentation: props.userEdit.presentation,
    web_site: props.userEdit.web_site,
    role:[],
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('update.admin'), {
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    Inertia.delete('/admin/'+props.userEdit.id+'/deletePhoto', {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};

const uncheck = () =>
{
    let checkbox1 = document.getElementById("Admin");
    let checkbox2 = document.getElementById("Creador"); 
   checkbox1.onclick = function(){ 
       if(checkbox1.checked != false)
        { 
           checkbox2.checked =null; 
        }
       } 
   checkbox2.onclick = function(){ 
       if(checkbox2.checked != false){ 
           checkbox1.checked=null;
       }
    }

};

</script>

