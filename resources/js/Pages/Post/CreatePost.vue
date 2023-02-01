<template>
    <AppLayout >
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
                                    <div class="grid grid-cols-1 mt-5 mx-7">
                                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold mb-1">Subir Imagen</label>
                                        <div class='flex items-center justify-center w-full'>
                                            <label class='flex flex-col border-4 border-dashed w-full h-auto hover:bg-gray-100 hover:border-purple-300 group'>                                                
                                                <div class='flex flex-col items-center justify-center pt-7'>
                                                <div class="grid grid-cols-1 mt-5 mx-7">
                                                    <img v-if="url" :src="url" style="max-width: 100%; max-height: 400px; margin: 0 auto;">           
                                                </div>
                                                <input-error :message="errors.image"/>
                                                <svg v-if="!url" class="w-10 h-10 text-purple-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <p class='text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider'>Seleccione la imagen</p>
                                                </div>
                                            <input id="image" @change="filechange" type="file" name="image" accept="image/gif,image/jepg,image/png,image/jpg" class="hidden" />
                                            </label>
                                        </div>
                                    </div>
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
