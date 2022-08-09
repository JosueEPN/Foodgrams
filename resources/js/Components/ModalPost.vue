<template>
    <modal :show="show" @close="showModalPost" maxWidth="3xl">
        <div class="bg-white overflow-hidden shadow-none max-w-[75%]">
            <div class="grid grid-cols-3 min-w-full">

                <div class="col-span-2 w-full">
                    <img class="w-full max-w-full min-w-full"
                        :src="post.image_path"
                        :alt="post.title">
                </div>

               

                <div class="col-span-1 relative pl-4">
                    <header class="border-b border-grey-400">
                        <inertia-link :href="'/profile/'+post.user.nick_name" class="block cursor-pointer py-4 flex items-center text-sm outline-none focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                            <img :src="post.user.profile_photo_url"
                            :alt="post.user.nick_name" class="h-8 w-8 rounded-full object-cover"/>
                            <p class="block ml-2 font-bold">{{ post.user.nick_name }}</p>
                        </inertia-link>
                    </header>

                    <div>
                        <h1 class="font-bold m-5">{{post.title}}</h1>
                        <h2 class="font-bold">Ingredientes</h2>
                        <p>{{post.ingredients}}</p>
                        <h2 class="font-bold">Preparación</h2>
                        <p>{{post.description}}</p>
                         
                    </div>

                   

                    <div class="absolute bottom-0 left-0 right-0 pl-4">
                        <div class="pt-4">
                            <div class="mb-2">
                                <div class="flex items-center">
                                    <span @click="likeDislike" class="mr-3 inline-flex items-center cursor-pointer">
                                        <svg class="text-red-500 inline-block h-7 w-7" :class="[post.likes.find(like => like.user_id === $page.props.user.id) ? 'fill-current' : 'hover:fill-current']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </span>
                                    <span class="mr-3 inline-flex items-center cursor-pointer">
                                        <svg class="text-gray-700 inline-block h-7 w-7 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </span>                                    
                                </div>
                                <span class="text-gray-600 text-sm font-bold">{{ post.countLikes }} Likes</span>
                            </div>
                            <span class="block ml-2 text-xs text-gray-600">{{ getDifferenceTime(post.created_at) }}</span>
                        </div>

                        <div class="pt-4 pb-1 pr-3">
                            <div class="scroll" ref="scrollComments">
                     
                                <comments v-if="post.comments.length > 0" v-for="(comment,index) in post.comments" :key="index" :comment="comment.comment" :nickName="comment.user.nick_name" :urlImage="comment.user.profile_photo_url"></comments>
                                <div v-else class="w-100 text-grey-500">No hay comentarios</div>
                            </div>
                            <div class="flex items-start">
                                <input v-model="text" class="w-full resize-none outline-none appearance-none" aria-label="Agrega un comentario..." placeholder="Agrega un comentario..."  autocomplete="off" autocorrect="off" style="height: 36px;"/>
                                <button v-if="text.length > 0" @click="comment($page.props.user.id)" class="mb-2 focus:outline-none border-none bg-transparent text-blue-600">Publicar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    import Comments from '@/Components/Comments'
    import Modal from '@/Jetstream/Modal'
    import moment from 'moment'

    export default {
        data(){
            return {
                text:''
            }
        },
        props:['post','show'],
        components:{
            Comments,
            Modal
        },
        methods: {
            showModalPost(){
                this.$emit('show')
            },
            getDifferenceTime(date){
                return moment(date).toNow(true)
            },
        }
    }
</script>
