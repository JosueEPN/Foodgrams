<template>
    <AppLayout>
        <div class="w-7/12">
            <div class="flex justify-center pb-10">
                    <img :src="userProfile.profile_photo_url"
                        class="h-40 w-40 rounded-full object-cover"
                        :alt="userProfile.nick_name"/>
                    <div class="ml-10">
                        <div class="flex items-center">
                            <h2 class="block leading-relaxed font-light text-gray-700 text-3xl">{{ userProfile.nick_name }}</h2>
                            <Link v-if="userProfile.id !== $page.props.user.id" :href="'/direct-message/'+userProfile.id" class="cursor-pointer h-7 px-3 ml-3 outline-none border-transparent text-center rounded border bg-blue-500 hover:bg-blue-600 text-white bg-transparent font-semibold">Enviar mensaje</Link>
                            <Link v-if="userProfile.id === $page.props.user.id"  href="/user/profile" class="cursor-pointer h-7 px-3 ml-3 focus:outline-none hover:border-transparent text-center rounded border border-gray-400 hover:bg-blue-500 hover:text-white bg-transparent text-gray-500 font-semibold">Editar perfil</Link>
                            
                            <div v-else>
                                <button v-if="!existsState" @click="follow" class="flex items-center ml-3 border border-blue-600 hover:bg-blue-600 hover:text-white rounded outline-none focus:outline-none bg-transparent text-blue-600 text-sm py-1 px-2">
                                    <span class="block">Seguir</span>
                                    <svg class="block h-5 w-5 pl-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                                <button v-else @click="unfollow" class="flex items-center ml-3 border border-blue-600 hover:bg-blue-600 hover:text-white rounded outline-none focus:outline-none bg-transparent text-blue-600 text-sm py-1 px-2">
                                    <span class="block">Dejar de seguir</span>
                                    <svg class="block h-5 w-5 pl-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </div>
                            <Link v-if="$page.props.user.permission.includes('admin.recetas.create') && userProfile.id !== $page.props.user.id " :href="'/admin/'+userProfile.id+'/edit'" class="cursor-pointer h-7 px-3 ml-3 focus:outline-none hover:border-transparent text-center rounded border border-gray-400 hover:bg-blue-500 hover:text-white bg-transparent text-gray-500 font-semibold">Editar perfil</Link>
                        </div>
                        <ul class="flex justify-content-around items-center">
                            <li>
                                <span class="block text-base flex"><span class="font-bold mr-2">{{ postsCount }} </span> publicaciones</span>
                            </li>
                            <li>
                                <span class="cursor-pointer block text-base flex ml-5"><span class="font-bold mr-2">{{ followers }} </span> seguidores</span>
                            </li>
                            <li>
                                <span class="cursor-pointer block text-base flex ml-5"><span class="font-bold mr-2">{{ followed }} </span> seguidos</span>
                            </li>
                        </ul>
                        <br>
                        <div class="">
                            
                            <h1>Presentación</h1>
                            <span class="text-base">{{ userProfile.presentation }}</span>
                            <a class="block text-base text-blue-500 mt-2" target="_blank" :href="userProfile.web_site">{{ userProfile.web_site }}</a>
                        </div>
                    </div>
            </div>
            <div class="border-b border-gray-300"></div>
            <article v-if="posts.length > 0" class="mt-5 grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-10">
                <image-post v-for="(post,index) in posts" :key="index" :post="post" @show="changeStateModalPost"></image-post>
            </article>
            <div v-else class="w-full text-center text-3xl pt-10">No hay publicaciones</div>

            <modal-post :show="show" :post="post" @show="changeState"></modal-post>
        </div>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import ImagePost from '@/Pages/UserProfile/ImagePost'
    import ModalPost from '@/Components/ModalPost'
    import { Link } from '@inertiajs/inertia-vue3'
    import axios from 'axios'
import route from '../../../../vendor/tightenco/ziggy/src/js'

    export default {
        data(){
            return {
                show: false,
                post:[],
                existsState: false
            }
        },
        props:[
            'userProfile',
            'followers',
            'followed',
            'postsCount',
            'posts',
        ],
        components: {
            AppLayout,
            ImagePost,
            ModalPost,
            Link
        },
        methods: {
            changeStateModalPost(post){
                this.post = post
                this.show = !this.show
            },
            changeState(){
                this.show = !this.show
            },
            async follow(){
                await axios.post('/follow-user',{user_id: this.userProfile.id})
                .then(response => {
                    this.existsState = !this.existsState
                    if(this.userProfile.id === this.$page.props.user.id){
                        this.$page.props.unreadNotifications++
                    }
                })
            },
            async unfollow(){
                await axios.post('/unfollow-user',{user_id: this.userProfile.id})
                    .then(response => {
                        this.existsState = !this.existsState
                    })
            },
            async existsFollow(){
                await axios.get('/exists-follow/'+this.userProfile.id)
                .then(response => {
                    if(response.data.exists){
                        this.existsState = !this.existsState
                    }
                })
            }
        },
        mounted() {
            this.existsFollow()
        },
    }
</script>

