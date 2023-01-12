<template>
    <div>
        <dropdown align="right" width="80" overflow="overflow-y-auto" maxheight="300">
            <template #trigger>
                <div @click="markAsRead" class="mr-3 relative">
                    <div v-if="$page.props.unreadNotifications > 0" class="absolute text-white flex items-center justify-center bg-red-600 w-4 h-4 text-xs top-0 right-0 rounded-full">{{$page.props.unreadNotifications > 9 ? '+9' : $page.props.unreadNotifications}}</div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
            </template>

            <template #content>
                <Link v-if="$page.props.notifications.length > 0" v-for="(notification,index) in $page.props.notifications" :key="index" class="block hover:bg-gray-100 text-xs text-gray-600 flex items-center py-2 px-3">
                    <img :src="notification.data.user.profile_photo_url" :alt="notification.data.user.name" class="w-9 h-9 object-cover rounded-full border">
                    <div class="text-sm font-light text-gray-700 ml-3">
                        <div>{{ notification.data.user.nick_name + ' ' + notification.data.message }}</div>
                        <div class="text-xs text-gray-500">{{ 'Hace '+getDifferenceDate(notification.created_at) }}</div>
                    </div>
                </Link>
                <div v-if="$page.props.notifications.length === 0" class="flex items-center py-2 px-3">
                    <span class="text-gray-500 text-sm font-light">No tienes notificaciones</span>
                </div>
            </template>
        </dropdown>
    </div>
</template>

<script>
    import Dropdown from '@/Components/Dropdown'
    import { Link } from '@inertiajs/inertia-vue3'
    import moment from 'moment'
    import axios from 'axios'

    export default {
        components:{
            Dropdown,
            Link
        },
        methods: {
            markAsRead(){
                axios.post('/markAsRead')
                    .then(response => {
                        this.$page.props.unreadNotifications = 0
                    })
            },
            notification(){
                Echo.private('App.Models.User.'+this.$page.props.user.id)
                .notification((notification) => {
                    this.$page.props.notifications.push({
                        data:{
                            user: notification.user,
                            message: notification.message
                        },
                        created_at: notification.date
                    })
                    this.$page.props.unreadNotifications++
                })
            },
            getDifferenceDate(date){
                return moment(date).toNow(true)
            }
        },
        mounted() {
            this.notification()
        },
    }
</script>