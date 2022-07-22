<script>
import AppLayout from '@/Layouts/AppLayout.vue';
 import Paginator from '@/Components/Paginator';
export default {
    props:{
        users: Array,
        posts: Array,
    },
    components:{
        AppLayout,
        Paginator,
    },
    data(){
        return{

        }
    },


}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Resultados de busqueda
            </h2>
        </template>


        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                    <div>
                        <h3>Recetas</h3>
                            <table class="table-fixed w-full">
                            <tbody>
                                <tr v-for="p in posts.data" :key="p.id">
                                    <td class="p-3 border content-center w-40">
                                        <img :src="p.image_path" :alt="p.title">
                                    </td>
                                    <td class="p-3 border">{{ p.title }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="w-full">
                        <h3> Usuarios </h3>
                        <table class="table-fixed w-full">
                            <tbody>
                                <tr v-for="u in users.data" :key="u.id">
                                    <td class="p-3 border content-center "><img :src="u.profile_photo_url" :alt="u.name"></td>
                                    <td class="p-3 border">{{ u.nick_name }}</td>
                                </tr>
                            </tbody>

                        </table>
                        <paginator :paginator="users"/>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
