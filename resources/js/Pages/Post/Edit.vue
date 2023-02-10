<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edita tu receta
            </h2>
        </template>
        <div class="bg-white rounded-md px-6 py-10 w-full">
            <h1 class="text-center text-2xl font-bold text-gray-500 mb-10">
                Edita
            </h1>
            <form @submit.prevent="summit" enctype="multiform/form-data">
                <div class="space-y-4 flex flex-row">
                    <div class="basis-1/2">
                        <div>
                            <div class="grid grid-cols-1 mt-5 mx-7">
                                <label
                                    class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold mb-1"
                                    >Subir Imagen</label
                                >
                                <div
                                    class="flex items-center justify-center w-full"
                                >
                                    <label
                                        class="flex flex-col border-4 border-dashed w-full h-auto hover:bg-gray-100 hover:border-purple-300 group"
                                    >
                                        <div
                                            class="flex flex-col items-center justify-center pt-7"
                                        >
                                            <div
                                                class="grid grid-cols-1 mt-5 mx-7"
                                            >
                                                <img
                                                    :src="form.image_path"
                                                    style="
                                                        max-width: 100%;
                                                        max-height: 400px;
                                                        margin: 0 auto;
                                                    "
                                                />
                                            </div>
                                            <input-error
                                                :message="errors.image"
                                            />

                                            <p
                                                class="text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider"
                                            >
                                                Seleccione la imagen
                                            </p>
                                        </div>
                                        <input
                                            id="image"
                                            @change="filechange"
                                            type="file"
                                            name="image"
                                            accept="image/gif,image/jepg,image/png,image/jpg"
                                            class="hidden"
                                        />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 basis-1/2">
                        <div class="m-3">
                            <label for="title" class="text-lx font-serif"
                                >Titulo:</label
                            >
                            <input
                                v-model="form.title"
                                type="text"
                                id="title"
                                class="ml-2 outline-none py-1 px-2 text-md border-2 rounded-md"
                            />
                            <input-error :message="errors.title" />
                        </div>

                        <div class="m-3">
                            <label for="title" class="text-lx font-serif"
                                >Porciones</label
                            >
                            <input
                                v-model="form.portions"
                                type="number"
                                class="ml-2 outline-none py-1 px-2 text-md border-2 rounded-md"
                            />
                            <input-error :message="errors.portions" />
                        </div>

                        <div class="m-3">
                            <label class="block mb-2 text-lg font-serif"
                                >Ingredientes</label
                            >
                            <textarea
                                v-model="form.ingredients"
                                id="Ingredientes"
                                cols="30"
                                rows="10"
                                placeholder="whrite here.."
                                class="w-full font-serif p-4 text-gray-600 bg-indigo-50 outline-none rounded-md"
                            ></textarea>
                            <input-error :message="errors.ingredients" />
                        </div>

                        <div class="m-3">
                            <label class="block mb-2 text-lg font-serif"
                                >Preparacion:</label
                            >
                            <textarea
                                v-model="form.description"
                                id="description"
                                cols="30"
                                rows="10"
                                placeholder="whrite here.."
                                class="w-full font-serif p-4 text-gray-600 bg-indigo-50 outline-none rounded-md"
                                >{{ text3 }}</textarea
                            >
                            <input-error :message="errors.description" />
                        </div>
                    </div>
                </div>
                <div>
                    <button
                        class="m-1 px-6 py-2 mx-auto block rounded-md text-lg font-semibold text-indigo-100 bg-indigo-600"
                        type="summit"
                    >
                        Editar
                    </button>
                    <button
                        class="m-1 px-6 py-2 mx-auto block rounded-md text-lg font-semibold text-indigo-100 bg-indigo-600"
                    >
                        <Link :href="route('dashboard')">Cancelar</Link>
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import InputError from "@/Jetstream/InputError";
import { defineProps } from "vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import route from "../../../../vendor/tightenco/ziggy/src/js";

const props = defineProps({
    PostEdit: Object,
    errors: Object,
});

const form = useForm({
    id: props.PostEdit.id,
    image_path: props.PostEdit.image_path,
    image: null,
    title: props.PostEdit.title,
    portions: props.PostEdit.portions,
    ingredients: props.PostEdit.ingredients,
    description: props.PostEdit.description,
});

function summit() {
    var resultado = window.confirm("Seguro de editar?");
    if (resultado === true) {
        form.post("/post/update");
    }
}

function filechange(e) {
    let file = e.target.files[0];
    form.image = file;
    form.image_path = URL.createObjectURL(file);
}
function selectImage() {
    document.getElementById("image").click();
}
</script>
