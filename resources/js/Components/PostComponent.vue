<template>
   <div class=" rounded overflow-hidden border w-auto bg-white mx-3 md:mx-0 lg:mx-0">
    <div class="w-full flex justify-between p-3">
      <div class="flex">
        <div class="rounded-full h-8 w-8 bg-gray-500 flex items-center justify-center overflow-hidden">
          <img :src="post.user.profile_photo_url"
                    :alt="post.user.name" class="h-8 w-8 rounded-full object-cover"/>
        </div>
        <!-- Nick Name User-->
        <p class="block ml-2 font-bold">{{ post.user.nick_name }}</p>
      </div>
      <span class="px-2 hover:bg-gray-300 cursor-pointer rounded"><i class="fas fa-ellipsis-h pt-2 text-lg"></i></span>
    </div>
    <!-- Imagen de la comida-->
    <img class="w-full max-w-full min-w-full"
        :src="post.image_path" :alt="post.description">
    <div class="px-3 pb-2">
      <div class="pt-2">
        <i class="far fa-heart cursor-pointer"></i>
        <!-- Calificacion -->
        <span class="text-sm text-gray-400 font-medium">{{ post.countLikes  }} Likes</span>
      </div>
      <div class="flex-row ">
        <h2> {{post.title}}</h2>
        <span> {{post.portion}}</span>
      </div>

      <div class="pt-1">
        <div class="mb-2 text-sm">
          <h3 class="text-black text-lg" >Ingredientes</h3>
          <div class=" text-gray-800 "> Lord of the Rings is my favorite film-series. One day I'll make my way to New Zealand to visit the Hobbiton set! </div>
        </div>

        <div class="mb-2 text-sm">
          <h3 class="text-black text-lg">Preparacion</h3>
          <div class=" text-gray-800 "> Lord of the Rings is my favorite film-series. One day I'll make my way to New Zealand to visit the Hobbiton set! </div>
        </div>
      </div>
      <div class="text-sm mb-2 text-gray-400 cursor-pointer font-medium">View all {{ post.countComments }} comments</div>
      <div class="mb-2">
        <div class="px-6 pt-4 pb-3">
            <div class="flex items-start">
                <input v-model="textComment" class="w-full resize-none outline-none appearance-none" aria-label="Agrega un comentario..." placeholder="Agrega un comentario..."  autocomplete="off" autocorrect="off" style="height: 36px;"/>
                <button v-if="textComment.length > 0" class="mb-2 focus:outline-none border-none bg-transparent text-blue-600">Publicar</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
    data(){
        return{
            textComment:''
        }
    },

    props:{
        post:Array
    }


}
</script>
