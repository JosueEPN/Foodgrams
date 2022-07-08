<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Creemos una receta
            </h2>
        </template>
                <div class=" bg-white rounded-md px-6 py-10 w-full">
                    <h1 class="text-center text-2xl font-bold text-gray-500 mb-10">Crea tu Receta</h1>
                    <div class="space-y-4">
                        <div>
                        <label for="title" class="text-lx font-serif">Titulo:</label>
                        <input v-model="text" type="text" placeholder="title" id="title" class="ml-2 outline-none py-1 px-2 text-md border-2 rounded-md" />
                        </div>
                        <div>
                            <div>
                                <img src="" alt="" />
                            </div>
                            <div>
                                <button @click="selectImage" class="outline-none focus:outline-none inline-flex items-center rounded-full cursor-pointer bg-blue-500 p-2">
                                    <svg class="text-white h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <input id="image" @change="filechange" type="file" name="image" accept="image/gif,image/jepg,image/png,image/jpg" style="display: none;" />
                            </div>



                        </div>
                        <div>
                        <label for="description" class="block mb-2 text-lg font-serif">Ingredientes</label>
                        <textarea v-model="text2" id="description" cols="30" rows="10" placeholder="whrite here.." class="w-full font-serif  p-4 text-gray-600 bg-indigo-50 outline-none rounded-md"></textarea>
                        </div>

                        <div>
                        <label for="description" class="block mb-2 text-lg font-serif">Preparacion:</label>
                        <textarea v-model="text3" id="description" cols="30" rows="10" placeholder="whrite here.." class="w-full font-serif  p-4 text-gray-600 bg-indigo-50 outline-none rounded-md"></textarea>
                        </div>

                        <button v-if="text.length > 0 && text2.length > 0 && text2.length > 0 && image != null" class=" px-6 py-2 mx-auto block rounded-md text-lg font-semibold text-indigo-100 bg-indigo-600  ">Crear</button>


                    </div>

                </div>





    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
export default {
    components:{
        AppLayout,
    },
    data(){
        return{
            url:null,
            imgea:null,
            text:'',
            text2:'',
            text3:''

        }
    },
    methods:{

        filechange(e){

            let file = e.target.files[0]
            this.image = file
            this.url = URL.createObjectURL(file)

        },
        selectImage(){
            document.getElementById('image').click
        }


    },


}
</script>
