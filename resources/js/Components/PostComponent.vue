<template>
    <!--PostComponent-->

    <div
        class="rounded overflow-hidden border w-auto bg-white mx-3 md:mx-0 lg:mx-0"
    >
        <div class="w-full flex justify-between p-3">
            <div class="flex">
                <Link :href="'/profile/' + post.user.nick_name">
                    <div
                        class="rounded-full h-8 w-8 bg-gray-500 flex items-center justify-center overflow-hidden"
                    >
                        <img
                            :src="post.user.profile_photo_url"
                            :alt="post.user.name"
                            class="h-8 w-8 rounded-full object-cover"
                        />
                    </div>
                    <!-- Nick Name User-->
                    <div>
                        <p class="block ml-2 font-bold">
                            {{ post.user.nick_name }}
                        </p>
                        <span class="block ml-2 text-xs text-gray-600">{{
                            getDifferenceTime(post.created_at)
                        }}</span>
                    </div>
                </Link>
            </div>
            <div>
                <div
                    class="group inline-block"
                    v-if="post.user_id === $page.props.user.id"
                >
                    <button>
                        <span>
                            <svg
                                class="fill-current h-4 w-4 transform group-hover:-rotate-180 transition duration-150 ease-in-out"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                />
                            </svg>
                        </span>
                    </button>
                    <ul
                        class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute transition duration-150 ease-in-out origin-top min-w-32"
                    >
                        <li class="rounded-sm px-3 py-1 hover:bg-gray-100">
                            <Link
                                :href="
                                    '/post/' +
                                    post.id +
                                    '/' +
                                    post.user_id +
                                    '/edit'
                                "
                            >
                                Editar
                            </Link>
                        </li>
                        <li
                            class="rounded-sm px-3 py-1 hover:bg-gray-100"
                            @click="DeleteCreador(post.id, post.user_id)"
                            type="button"
                        >
                            Eliminar
                        </li>
                    </ul>
                </div>
                <div
                    class="group inline-block"
                    v-if="
                        $page.props.user.permission.includes(
                            'admin.recetas.create'
                        ) && $page.props.user.id !== post.user_id
                    "
                >
                    <button>
                        <span>
                            <svg
                                class="fill-current h-4 w-4 transform group-hover:-rotate-180 transition duration-150 ease-in-out"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                />
                            </svg>
                        </span>
                    </button>
                    <ul
                        class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute transition duration-150 ease-in-out origin-top min-w-32"
                    >
                        <li class="rounded-sm px-3 py-1 hover:bg-gray-100">
                            <Link
                                :href="
                                    '/Admin/post/' +
                                    post.id +
                                    '/' +
                                    post.user_id +
                                    '/edit'
                                "
                            >
                                Editar
                            </Link>
                        </li>
                        <li
                            class="rounded-sm px-3 py-1 hover:bg-gray-100"
                            @click="DeleteAdmin(post.id, post.user_id)"
                            type="button"
                        >
                            Eliminar
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Imagen de la comida-->
        
        <a @click="viewpost(post.id)" class="grid grid-cols-1 justify-center text-center">
            <img
                class="w-full max-w-full min-w-full"
                :src="post.image_path"
                :alt="post.title"
            />

            <div>
                <h2 class="text-xl font-semibold">{{ post.title }}</h2>
            </div>
        </a>
        <div class="px-3 pb-2">
            <div class="pt-2">
                <div class="flex items-center">
                    <span
                        @click="likeDislike"
                        class="mr-3 inline-flex items-center cursor-pointer"
                    >
                        <svg
                            class="text-red-500 inline-block h-7 w-7"
                            :class="[
                                post.likes.find(
                                    (like) =>
                                        like.user_id === $page.props.user.id
                                )
                                    ? 'fill-current'
                                    : 'hover:fill-current',
                            ]"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                            />
                        </svg>
                    </span>
                    <span
                       
                        class="mr-3 inline-flex items-center cursor-pointer"
                    >
                        <svg
                            class="text-gray-700 inline-block h-7 w-7"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                            />
                        </svg>
                    </span>
                </div>
                <!-- Calificacion -->
                <span class="text-sm text-gray-400 font-medium"
                    >{{ post.countLikes }} Likes</span
                >
            </div>
          
            <div class="">
                <a class="text-gray-400 text-sm cursor-pointer font-semibold"
                    >{{ post.countComments }} comments</a
                >
            </div>
            <div class="mb-2">
                <div class="px-6 pt-4 pb-3">
                    <div class="flex items-start">
                        <input
                            @keyup.enter="comment($page.props.user.id)"
                            v-model="textComment"
                            class="w-full resize-none outline-none appearance-none"
                            aria-label="Agrega un comentario..."
                            placeholder="Agrega un comentario..."
                            autocomplete="off"
                            autocorrect="off"
                            style="height: 36px"
                        />
                        <button
                            v-if="textComment.length > 0"
                            @click="comment($page.props.user.id)"
                            class="mb-2 focus:outline-none border-none bg-transparent text-blue-600"
                        >
                            Publicar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal-->
</template>

<script>
import Comments from "@/Components/Comments";
import { Inertia } from "@inertiajs/inertia";
import moment from "moment";
import { Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
export default {
    data() {
        return {
            textComment: "",
           
        };
    },

    props: ["post"],
    components: {
        Comments,
        Inertia,
        Link,
    },
    methods: {
        getDifferenceTime(date) {
            return moment(date).toNow(true);
        },
        DeleteAdmin(id, user_id) {
            var resultado = window.confirm("Seguro de Eliminar el Post?");
            if (resultado === true) {
                Inertia.get("/Admin/post/" + id + "/" + user_id + "/delete");
            }
        },
        DeleteCreador(id, user_id) {
            var resultado = window.confirm("Seguro de Eliminar el Post?");
            if (resultado === true) {
                Inertia.get("/post/" + id + "/" + user_id + "/delete");
            }
        },
        async likeDislike() {
            await axios
                .post("/like-post", { post_id: this.post.id })
                .then((response) => {
                    this.post.likes = response.data.likes;
                    if (response.data.like) {
                        this.post.countLikes++;
                    } else {
                        --this.post.countLikes;
                    }
                });
        },
        async comment(userId) {
            await axios
                .post("/comment", {
                    post_id: this.post.id,
                    user_id: userId,
                    comment: this.textComment,
                })
                .then((response) => {
                    this.post.comments.push(response.data);
                    this.post.countComments++;
                    this.textComment = "";
                });
        },
        viewpost(post) {
            Inertia.get("/post/view", { post: post });
        },
    },
};
</script>
