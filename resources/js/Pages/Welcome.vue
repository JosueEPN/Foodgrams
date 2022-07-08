<template>

    <div class=" max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl w-full">
         <button @click="changeStateShowCreatePost" class="w-full mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]" > Crea tu Receta </button>
       <post-component> </post-component>
    </div>
</template>

<script >
 import PostComponent from '@/Components/PostComponent';
 import { Inertia } from '@inertiajs/inertia';
 import { Link } from '@inertiajs/inertia-vue3';


 export default{
    data(){

    },
    components:{
        PostComponent,
        Inertia,

    },
    methods:{
         changeStateShowCreatePost(){
                Inertia.visit(route('post.create'));
        },
    },
 }

</script>
