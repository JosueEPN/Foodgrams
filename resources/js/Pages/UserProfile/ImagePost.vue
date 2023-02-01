<template>
    <Link @click=" viewpost(post.id)" id="post-profile" class="cursor-pointer relative" style="width:300px; height:300px">
        <img :src="post.image_path"
            class="foto w-full h-full object-cover"
            :alt="post.title" />
        
        <div id="hover-post" class=" absolute top-0 bottom-0 right-0 left-0 items-center justify-center">

            <div class=" decoration-solid text-white inline ">
                {{ post.title }}
            </div>

            <div class="flex flex-nowrap">

                <div >
                    <svg class="text-white inline h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="ml-1 text-white">{{ post.countLikes }}</span>
                </div>
                <div class="ml-5">
                    <svg class="text-white inline h-7 w-7 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span class="ml-1 text-white">{{ post.countComments }}</span>
                </div>

            </div>
           
        </div>
    </Link>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'
    export default {
        props:['post'],
        components:{
            Link,
            Inertia
        },
        methods: {
            viewpost(post){
                Inertia.get('/post/view', {post:post})
            }
        },
    }
</script>

<style>
    #hover-post{
        display:none;
        background-color: rgba(0,0,0,0.6);
    }

    #post-profile:hover #hover-post{
        display:flex;
        flex-direction: column;
    }
</style>