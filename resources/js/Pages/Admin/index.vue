<template>
    <AppLayout>
        <div class="flex flex-col items-center">
       
                            
            <Link :href="route('index.post.admin')"> <button class="w-20 mx-3 mb-5 text-center bg-[#01889d] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"> Recetas  </button> </Link>
                           

            <h1 class="text-xl decoration-solid p-1"> Usuarios </h1>
            <Link :href="route('create.user.admin')">  <button class="w-full mx-3 mb-5 text-center bg-[#01889d] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"> Crear Nuevo Usuario  </button> </Link>
            <div class="w-full">
                <table class="table-auto" >
                     <thead>
                         <tr>
                            <th class="border border-gray-400 px-5">Image_profile</th>
                            <th class="border border-gray-400 px-5">Nick_name</th>
                            <th class="border border-gray-400 px-5">Email</th>
                            <th class="border border-gray-400 px-5">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="u in users" :key="u.id">
                                    
                            <td class="border border-gray-400 px-5">                                            
                                <img class="w-40" :src="u.profile_photo_url" :alt="u.name">                                           
                            </td>
                            <td class="border border-gray-400 px-5"> 
                                {{ u.nick_name }}             
                            </td>
                            <td class="border border-gray-400 px-5"> 
                                {{ u.email }}             
                            </td>
                            <td class="border border-gray-400 px-5">
                                <button class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"> <a :href="'/admin/'+ u.id + '/edit'">Editar</a> </button>
                                <button class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"> <a :href="'/admin/'+ u.id + '/delete'">Eliminar</a>  </button>
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
           
        },
        props:{
            users: Array,
        },
        components: {
            AppLayout,
            Link
           
        },
        methods: {}
            
    }
</script>

