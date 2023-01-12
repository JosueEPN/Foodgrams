<template>
    <div class=" max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl w-full">
         <button @click="changeStateShowCreatePost" class="w-full mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]" > Crea tu Receta </button>
         <div v-if="posts.length > 0">

             <post-component v-for="post in posts" :key="post.id"
                :post="post" @post="setPost"></post-component>
        </div>
        <div v-else class="text-3xl">No hay publicaciones</div>

        <div>
        </div>
        <modal-post :show="show" :post="post" @show="changeStateModalPost"></modal-post>
    </div>
</template>

<script >
 import PostComponent from '@/Components/PostComponent';
 import { Inertia } from '@inertiajs/inertia';
 import ModalPost from '@/Components/ModalPost';
 

 export default{
    props:{
        posts:Array
    },
    data(){        
        return{
            show:false,
            post:[],      
    }},
    components:{
        PostComponent,
        Inertia,
        ModalPost
        

    },
    methods:{
         changeStateShowCreatePost(){
                Inertia.visit(route('post.index'));
        },
        changeStateModalPost(){
                this.show = !this.show
        },
         setPost(post){   
                this.show = !this.show             
                this.post = post
        }     
    },
   
 }

</script>
