<template>
    <div class=" max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl w-full">
         <button @click="changeStateShowCreatePost" class="w-full mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]" > Crea tu Receta </button>
         <div v-if="posts.length > 0">

             <post-component v-for="(post,index) in posts" :key="index"
                :post="post"></post-component>
        </div>
        <div v-else class="text-3xl">No hay publicaciones</div>
    </div>
</template>

<script >
 import PostComponent from '@/Components/PostComponent';
 import { Inertia } from '@inertiajs/inertia';

 export default{
    data(){
        return{
        posts: [],
        post:[]
    }},
    components:{
        PostComponent,
        Inertia,

    },
    methods:{
         changeStateShowCreatePost(){
                Inertia.visit(route('post.index'));
        },
        async getPosts(){
            await axios.get('list-post')
            .then(response => {
                this.posts = response.data
            })

        },
    },
    mounted(){
            this.getPosts()
    },

 }

</script>
