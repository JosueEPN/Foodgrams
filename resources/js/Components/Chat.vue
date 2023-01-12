<template>

    <div class="w-full">
        <div class="flex items-center border-b border-gray-300 pl-3 py-3">
            <img class="h-10 w-10 rounded-full object-cover"
            :src="userprop.profile_photo_url"
            :alt="userprop.nick_name" />
            <span class="block ml-2 font-bold text-base text-gray-600">{{ userprop.nick_name }}</span>
            <span v-if="user.status === 1" class="connected text-green-500 ml-2" >
                <svg width="6" height="6">
                    <circle cx="3" cy="3" r="3" fill="currentColor"></circle>
                </svg>
            </span>
        </div>
        <div id="chat" class="w-full overflow-y-auto p-10 relative" style="height: 700px;" ref="toolbarChat">
            <ul>
                <li v-if="messages.length > 0" v-for="(message,index) in messages" :key="index" class="clearfix2">
                    <div class="w-full flex" :class="[message.user_id === usercurrent ? 'justify-end' : 'justify-start']">
                        <div class="bg-gray-100 rounded px-5 py-2 my-2 text-gray-700 relative" style="max-width: 300px;">
                            <span v-if="message.type === 'text'" class="block">{{ message.message }}</span>
                            <div v-if="message.type === 'image'" class="w-52 h-48">
                                <a :href="message.file_path" download class="file-message block relative">
                                    <img :src="message.file_path" 
                                    :alt="message.file_name" class="w-full min-w-full max-w-full min-h-full max-h-full">
                                    <button class="hover-image bg-gray-500 absolute top-0 bottom-0 right-0 left-0 flex items-center justify-center cursor-pointer w-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </button>
                                </a>
                            </div>
                            <div v-if="message.type === 'document'" class="w-full rounded-lg bg-gray-700 flex items-center justify-center p-2">
                                <a :href="message.file_path" download class="flex justify-between">
                                    <div class="text-white">{{ message.file_name }}</div>
                                    <button class="cursor-pointer ml-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </button>
                                </a>
                            </div>

                            <span class="block text-xs text-right">{{ getHoursByDate(message.created_at) }}</span>
                        </div>
                    </div>
                </li>
                <div v-else class="w-full px-5 py-2 my-2 text-center text-3xl">No existe conversación</div>
            </ul>
            <div v-if="typing" class="absolute bottom-2">
                <div class="px-4 py-2 text-gray-700">{{ userTyping.nick_name }} esta escribiendo...</div>
            </div>

            <div v-if="error" class="absolute bottom-2 text-white bg-red-600 py-2 px-4 text-xs rounded z-50">
                {{ error }}
            </div>
        </div>

        <div v-if="visible" class="w-full pb-2 ml-4">
            <div class="w-full flex items-center">
                <span class="text-gray-600 w-0 h-0">
                    <i class="fas fa-circle-notch fa-spin fa-1x"></i>
                </span>
            </div>
            <div class="font-semibold text-base text-gray-600 ml-6">
                Enviando ...
            </div>
        </div>
        <div class="w-full py-3 px-3 flex items-center justify-between border-t border-gray-300">
            <button @click="dispatchImage" class="outline-none focus:outline-none">
                <svg class="text-gray-400 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </button>
            <button @click="dispatchFile" class="outline-none focus:outline-none ml-1">
                <svg class="text-gray-400 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
            </button>

            <input id="file" @change="fileChange" type="file" class="hidden" name="file" accept=".pdf,.txt,.doc,.docx">
            <input id="image" @change="fileChange" type="file" class="hidden" name="image" accept="image/jpeg,image/jpg,image/png">

            <input @keyup="isTyping" v-model="message" @keyup.enter="sendMessage" aria-placeholder="Escribe un mensaje aquí" placeholder="Escribe un mensaje aquí"
                class="py-2 mx-3 pl-5 block w-full rounded-full bg-gray-100 outline-none focus:text-gray-700" type="text" name="message" required/>

            <button v-if="message != ''" @click="sendMessage" class="outline-none focus:outline-none" type="submit">
                <svg class="text-gray-400 h-7 w-7 origin-center transform rotate-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                </svg>
            </button>
        </div>
    </div>

</template>
<script>
import moment from 'moment';
import axios from 'axios';
    export default {
        data(){
            return {
                user: this.userprop,
                typing: false,
                userTyping: '',
                message: '',
                visible: false,
                sendImage: false,
                file: null,
                image:null,
                error: null
            }
        },
        props:['userprop','messages','usercurrent','chatid'],
        methods: {
            getHoursByDate(date){
               return moment(date).format('h:m A') 
            },
            isTyping(){
                const _this = this
                let chat = window.Echo.private('chat.'+this.chatid);

                setTimeout(function(){
                    chat.whisper('typing',{
                        user: _this.$page.props.user,
                        typing: true,
                        chatid: _this.chatid
                    })
                },300);
            },
            async sendMessage(){
                const formData = new FormData()
                formData.append('chat_id',this.chatid)
                formData.append('user_id',this.usercurrent)
                formData.append('message',this.message)
                this.visible = true

                await axios.post('/chat/send-message',formData)
                .then(() => {
                    this.message = ''
                }).finally(() => {
                    this.visible = false
                })
            },
            newMessage(message){
                this.messages.push(message)
            },
            dispatchImage(){
                document.getElementById('image').click()
                this.sendImage = true
            },
            dispatchFile(){
                document.getElementById('file').click()
                this.sendImage = false
            },
            async fileChange(e){
                const __this = this
                const file = e.target.files[0]
                const formData = new FormData()
                formData.append('chatid',this.chatid)
                formData.append('user_id',this.usercurrent)

                if(this.sendImage){
                    this.image = file
                    formData.append('image',this.image)
                }else{
                    this.file = file
                    formData.append('file',this.file)
                }

                this.visible = true
                await axios.post('/send-file',formData,{
                    headers:{
                        'Content-Type' : 'multipart/form-data'
                    }
                }).then(response => {
                    this.file = null
                    this.image = null
                }).catch(error => {
                    if(error.response.status === 422){
                        const _error = error.response.data.error
                        this.error = this.sendImage ? _error.image[0]
                        : _error.file[0]

                        setTimeout(function(){
                            __this.error = null
                        },2000)
                    }
                }).finally(() => {
                    this.visible = false
                })
            },
            scrollToBottom(){
                setTimeout(()=>{
                    this.$refs.toolbarChat.scrollTop = this.$refs.toolbarChat.scrollHeight - this.$refs.toolbarChat.clientHeight
                },50)
            },
            reset(){
                Object.assign(this.$data,this.$options.data.apply(this))
            }

        },
        watch:{
            message(messages){
                this.scrollToBottom()
            },
            chatid(chatid){
                this.scrollToBottom()
                this.reset()
            }
        },
        mounted() {
            const component = this
            this.scrollToBottom()
            var pusher = new Pusher('e99815844fbcceafaf02', {
            cluster: 'us2'
            });

            var channel = pusher.subscribe('Foodgrams-channel');

            channel.bind('new-message', function(data) {
                if(component.chatid === data.message.chat_id){
                    component.newMessage(data.message)
                }
            });

            channel.bind('offline', function(data) {
                if(component.user.id === data.user.id){
                    component.user = data.user
                }
            });

            channel.bind('online', function(data) {
                if(component.user.id === data.user.id){
                    component.user = data.user
                }
            });

            window.Echo.private('chat.'+this.chatid)
            .listenForWhisper('typing',(data) => {
                if(component.chatid === data.chatid){
                    component.userTyping = data.user
                    component.typing = data.typing

                    setTimeout(function(){
                        component.typing = false
                    },900)
                }
            })
        },
    }

</script>

<style>
    .hover-image{
        display:none;
    }

    .file-message:hover .hover-image{
        display: flex;
        opacity: 0.5;
    }
</style>