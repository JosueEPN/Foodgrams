<template>
    <a @click="emitEvent" class="hover:bg-gray-100 border-b border-gray-300 px-3 py-2 cursor-pointer flex items-center text-sm focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
        <img class="h-10 w-10 rounded-full object-cover"
        :src="image"
        :alt="username" />
        <div class="w-full pb-2">
            <div class="flex justify-between">
                <span class="block ml-2 font-semibold text-base text-gray-600 ">{{ username }}</span>
                <span v-if="message.length > 0" class="block ml-2 text-sm text-gray-600">{{ 'Hace '+getDifferenceTime(message[0].created_at) }}</span>
            </div>
            <span v-if="message.length > 0" class="block ml-2 text-sm text-gray-600">{{ message[0].message }}</span>
        </div>
    </a>
</template>

<script>
import moment from 'moment';

    export default{
        props:{
            username:{
                type:String,
                required:true
            },
            image:{
                type:String,
                required:true
            },
            message:{
                type:Array,
                required:true
            },
            chatid:{
                type:Number,
                required:false
            },
            userid:{
                type:Number,
                required:false
            }
        },
        methods: {
            getDifferenceTime(date){
                return moment(date).toNow(true)
            },
            emitEvent(){
                if(this.chatid){
                    this.$emit('getChat',this.chatid)
                }else{
                    this.$emit('getNewChat',this.userid)
                }
            }

        },
    }

</script>