<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Paginator from '@/Components/Paginator';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
export default {
    props:{
        users: Array,
        posts: Array,
    },
    components:{
        AppLayout,
        Paginator,
        Link,
        Inertia,
    },
    data(){
        return{

        }
    },
    methods: {
        viewpost(post)
        {
            Inertia.get('/post/view', {post:post})
        },          
            
    }


}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Resultados de busqueda
            </h2>
        </template>
        <div class="min-w-[90%]">
            <div class="min-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">                      
                    <div class="w-full p-4">
                        <h3>Recetas</h3>
                        <div v-if="posts.length > 0">

                             <tbody>
                            <tr v-for="post in posts" :key="post.id"  >
                                
                                    <td class="pr-5">
                                        <Link @click=" viewpost(post.id)" >
                                            <img class="w-40" :src="post.image_path" :alt="post.title" />                                     
                                        </Link>
                                    </td>
                                    <td>
                                        <Link @click=" viewpost(post.id)" >
                                            {{ post.title}}                                    
                                        </Link>
                                        
                                    </td>
                                
                            </tr> 
                        </tbody>


                        </div>
                       
                        <div v-else class="mt-3">No Existe la Receta</div>                                                      
                    </div>
                    
                    <div class="w-full p-4">
                        <h3> Usuarios </h3>
                        <div class="w-full">
                            <div v-if="users.length > 0">

                                <tbody>
                                <tr v-for="u in users" :key="u.id">
                                    
                                        <td class="pr-5 ">                                            
                                            <Link :href="'/profile/'+u.nick_name">
                                                <img class="w-40" :src="u.profile_photo_url" :alt="u.name">
                                            </Link> 
                                        </td>
                                        <td > 
                                            <Link :href="'/profile/'+u.nick_name">
                                                {{ u.nick_name }}
                                             </Link>                
                                        </td>
                                     
                                    </tr>
                                </tbody>
                                
                            </div>

                            <div v-else class="mt-3">No Existe el Usuario</div>   
                            

                        </div>
                        <paginator v-if="users.length > 10" :paginator="users"/>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
