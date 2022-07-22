<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Creemos una receta
            </h2>
        </template>
                <div class=" bg-white rounded-md px-6 py-10 w-full">
                    <h1 class="text-center text-2xl font-bold text-gray-500 mb-10">Crea tu Receta</h1>
                    <form @submit.prevent="submit" enctype="multiform/form-data">
                        <div class="space-y-4 flex flex-row">
                            <div class="basis-1/2">
                                <div>
                                    <div class="border-2 border-sky-500">
                                        <img v-if="url" :src="url" style="max-width: 100%; max-height: 400px; margin: 0 auto;">
                                    </div>
                                    <div class="flex justify-center">
                                        <input id="image" @change="filechange" type="file" name="image" accept="image/gif,image/jepg,image/png,image/jpg" />
                                    </div>
                                    <input-error :message="errors.image"/>


                                </div>
                            </div>
                            <div class="grid grid-cols-2 basis-1/2">

                                <div class="m-3">
                                    <label for="title" class="text-lx font-serif">Titulo:</label>
                                    <input v-model="text" type="text" placeholder="title" id="title" class="ml-2 outline-none py-1 px-2 text-md border-2 rounded-md" />
                                    <input-error :message="errors.text"/>
                                </div>

                                <div class="m-3">
                                    <label for="title" class="text-lx font-serif">Porciones</label>
                                    <input v-model="number" type="number" class="ml-2 outline-none py-1 px-2 text-md border-2 rounded-md" />
                                    <input-error :message="errors.number"/>
                                </div>

                                <div class="m-3">
                                    <label class="block mb-2 text-lg font-serif">Ingredientes</label>
                                    <textarea v-model="text2" id="Ingredientes" cols="30" rows="10" placeholder="whrite here.." class="w-full font-serif  p-4 text-gray-600 bg-indigo-50 outline-none rounded-md"></textarea>
                                    <input-error :message="errors.text2"/>
                                </div>

                                <div class="m-3">
                                    <label class="block mb-2 text-lg font-serif">Preparacion:</label>
                                    <textarea v-model="text3" id="description" cols="30" rows="10" placeholder="whrite here.." class="w-full font-serif  p-4 text-gray-600 bg-indigo-50 outline-none rounded-md"></textarea>
                                    <input-error :message="errors.text3"/>
                                </div>


                            </div>

                        </div>

                        <button type="submit"  class=" px-6 py-2 mx-auto block rounded-md text-lg font-semibold text-indigo-100 bg-indigo-600  ">Crear Posts</button>
                    </form>
                </div>





    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import InputError from "@/Jetstream/InputError";
export default {
    props:{
        errors:Object
    },

    components:{
        AppLayout,
        Inertia,
        InputError
    },
    data(){
        return{
            url:null,
            image:null,
            text:'',
            number: 0,
            text2:'',
            text3:'',



        }
    },
    methods:{

        submit(){
            Inertia.post(route('post.store'),{

                image:  this.image,
                text:   this.text,
                number: this.number,
                text2:  this.text2,
                text3:  this.text3,
            })
            this.resetData()
        },

        filechange(e){

            let file = e.target.files[0]
            this.image = file
            this.url = URL.createObjectURL(file)

        },
        selectImage(){
            document.getElementById('image').click()
        },
            resetData(){
                this.url = null
                this.image = null
                this.text = ''
                this.number= 0
                this.text2=''
                this.text3=''
            },

    },


}
</script>
