<template>
    <AppLayout>
        <div class="flex flex-col items-center">
            <Link :href="route('index.user.admin')" ><button  class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]" >  Usuarios </button></Link>
            <h1 class="text-xl decoration-solid p-1"> Recetas </h1>
            <div class="w-full">
                
                <table class="table-auto" >
                     <thead>
                         <tr>
                            <th class="border border-gray-400 px-5">Imagen</th>
                            <th class="border border-gray-400 px-5">Titúlo</th>
                            <th class="border border-gray-400 px-5">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="post in posts" :key="post.id">
                                    
                            <td class="border border-gray-400 p-5 " >
                                
                                    <img class="w-40" :src="post.image_path" :alt="post.title" />                                     
                             
                            </td>
                            <td class="border border-gray-400 px-5">
                                
                                    {{ post.title}}                                    
                             
                                        
                            </td>
                          
                            <td class="border border-gray-400 px-5">
                                <a :href="'/Admin/post/'+post.id+'/'+post.user_id+'/edit'"><button  class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]" > Editar  </button> </a>
                                
                                    <button  class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]" @click="DeletePost(post.title,post.id,post.user_id)" >
                                        Eliminar
                                    </button>
                                
                            </td>
                    

                             
                        </tr>
                    </tbody>
                                
                </table>

                            

                               
                       
            </div>
        </div>                        
         
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import { Link } from '@inertiajs/inertia-vue3';


    export default {
        data(){
            return {
                isOpenAdmin: false,
            }
        },
        props:{
            posts: Array,
            msg:String,
        },
        components: {
            AppLayout,
            Link,
           
        },
        methods: 
        {
            DeletePost(tittle,id,user_id)
            {
                var resultado = window.confirm('Seguro de Eliminar el post "' + tittle + '"?');
                if (resultado === true) {
                    Inertia.get('/Admin/post/'+id+'/'+user_id+'/delete');
                }
            }
        }
            
    }
</script>

