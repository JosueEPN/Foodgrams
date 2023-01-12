<template>
    <div class="text-sm mb-2 flex flex-start items-center">
        <a href="#" class="cursor-pointer flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
            <img class="h-8 w-8 rounded-full object-cover"
            :src="urlImage"
            :alt="nickName" />
        </a>
        <p class="font-bold ml-2">
            <a class="cursor-pointer">{{ nickName }}  </a>
            <a class="text-sm text-gray-500">Hace {{ getDifferenceTime(create) }}:</a>

            <span class="text-gray-700 font-medium ml-1">
                {{ comment }}
            </span>
        </p>
    </div>

</template>
<script>
import moment from 'moment'
    export default {
        props:['comment','nickName','urlImage','create'],
        methods: {
            
            getDifferenceTime(date){
                return moment(date).toNow(true)
            },
        }
    }
    
</script>