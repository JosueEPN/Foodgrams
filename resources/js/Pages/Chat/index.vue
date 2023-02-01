<template>
    <div>
        <AppLayout>
            <div class="w-7/12">
                <div class="grid grid-cols-3 min-w-full border rounded" style="min-height: 80vh;">
                        <div class="col-span-1 bg-white border-r border-gray-300">
                            <div class="my-3 mx-3 ">
                                <div class="relative text-gray-600 focus-within:text-gray-400">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-gray-500"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </span>
                                    <input v-model="search" @keyup="searchFriends" aria-placeholder="Busca tus amigos o contacta nuevos" placeholder="Busca tus amigos"
                                    class="py-2 pl-10 block w-full rounded bg-gray-100 outline-none focus:text-gray-700" type="search" name="search" required autocomplete="search" />
                                </div>
                            </div>

                            <ul v-if="search != ''" class="overflow-auto" style="height: 400px;">
                                <h2 class="ml-2 mb-2 text-gray-600 text-lg my-2">Amigos</h2>
                                <li v-if="userschats.length > 0" v-for="(user,index) in userschats" :key="index">
                                    <user-chats :username="user.nick_name" :image="user.profile_photo_url"
                                    :message="[]"
                                    :userid="user.id" @getNewChat="getNewChat"></user-chats>
                                </li>
                                <div v-else class="ml-2 mb-2 text-gray-600 text-sm my-2">No se encontraron amigos</div>
                            </ul>
                            <ul class="overflow-auto" style="height: 500px;">
                                <h2 class="ml-2 mb-2 text-gray-600 text-lg my-2">Chats</h2>
                                <li v-if="chats.length > 0" v-for="(chat,index) in chats" :key="index">
                                    <user-chats :username="chat.userrecive.id === $page.props.user.id ? chat.usersent.nick_name : chat.userrecive.nick_name" 
                                    :image="chat.userrecive.id === $page.props.user.id ? chat.usersent.profile_photo_url : chat.userrecive.profile_photo_url"
                                    :message="chat.messages"
                                    :chatid="chat.id" @getChat="getChat"></user-chats>
                                </li>
                                <div v-else class="ml-2 mb-2 text-gray-600 text-sm my-2">No se hay chats</div>
                            </ul>
                        </div>
                        <div class="col-span-2 bg-white">
                            <div v-if="userchat.length <= 0"  class="w-full flex justify-center items-center" style="height:75vh;">
                                <div class="text-center">
                                    <h5 class="text-gray-600 text-lg mb-2">Tus mensajes</h5>
                                    <span class="block text-sm text-gray-600">Envía fotos y mensajes a tus amigos</span>
                                </div>
                            </div>

                            <chat v-else :userprop="userchat.userrecive.id === $page.props.user.id ? userchat.usersent : userchat.userrecive"
                            :messages="userchat.messages" :usercurrent="$page.props.user.id" :chatid="userchat.id"></chat>
                            
                        </div>
                    </div>
            </div>            
        </AppLayout>
    </div>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import UserChats from '@/Components/UserChats';
import Chat from '@/Components/Chat';
import axios from 'axios'
    export default{
        data(){
            return {
                search: '',
                userchats:[],
                userchat:[],
            }
        },
        props:['chats'],
        components:{
            AppLayout,
            UserChats,
            Chat,

        }, 
        methods: {
            async searchFriends(){
                if(this.search != ''){
                    await axios('/user/chat/'+this.search)
                    .then(response => {
                        this.userschats = response.data
                    })
                }else{
                    this.userschats = []
                }
            },
            async getChat(id){
                await axios('/user-chat/'+id)
                    .then(response => {
                        this.userchat = response.data
                    })
            },
            async getNewChat(id){
                await axios('/new-chat/'+id)
                    .then(response => {
                        this.userchat = response.data
                    })
            }
        },

    }
</script>