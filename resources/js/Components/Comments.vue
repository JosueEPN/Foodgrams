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

        <Link v-if ="post_user_id == $page.props.user.id" :href="'/comment/'+id +'/'+post_id+'/delete'"> <button  class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"> Eliminar </button> </Link>
        <Link v-if ="user_id == $page.props.user.id && post_user_id != $page.props.user.id" :href="'/comment/'+id +'/'+post_id+'/delete'"> <button  class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]">Eliminar </button> </Link>
        <Link v-if ="$page.props.user.permission.includes('admin.recetas.create') && user_id != $page.props.user.id && post_user_id != $page.props.user.id " :href="'/comment/'+id +'/'+post_id+'/delete'"> <button  class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"> Eliminar </button> </Link>
        
    </div>

    

</template>
<script>
import moment from 'moment';
import { Link } from '@inertiajs/inertia-vue3';
    export default {
        props:['id','comment','nickName','urlImage','create','post_user_id', 'user_id'],
        components:{
            moment,
            Link,
         
        },
        methods: {
            
            getDifferenceTime(date){
                return moment(date).toNow(true)
            },
        }
    }
    
</script>