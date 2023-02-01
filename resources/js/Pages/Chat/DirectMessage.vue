<template>
    <app-layout>
        <div class="w-7/12">
            <div class="grid grid-cols-3 min-w-full border rounded" style="min-height: 80vh;">
                <div class="col-span-3 bg-white">
                    <chat :userprop="chat.userrecive.id === $page.props.user.id ? chat.usersent : chat.userrecive" 
                    :messages="chat.messages" :usercurrent="$page.props.user.id" :chatid="chat.id"></chat>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Chat from '@/Components/Chat'

    export default {
        props:['chat'],
        components:{
            Chat,
            AppLayout
        }
    }
</script>
