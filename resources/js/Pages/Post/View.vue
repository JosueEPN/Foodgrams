<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Comments from "@/Components/Comments";
import moment from "moment";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import InputError from "@/Jetstream/InputError";

export default {
    data() {
        return {
            text: "",
        };
    },
    props: ["post", "errors"],
    components: {
        Comments,
        Link,
        AppLayout,
        moment,
        InputError,
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
        comment(userId) {
            Inertia.post(
                route("comment.store", {
                    post: this.post,
                    user: userId,
                    comment: this.text,
                })
            );
        },
        scrollToBottom() {
            setTimeout(() => {
                this.$refs.scrollComments.scrollTop =
                    this.$refs.scrollComments.scrollHeight -
                    this.$refs.scrollComments.clientHeight;
            }, 30);
        },
    },
};
</script>

<template>
    <AppLayout>
        <div class="grip grid-cols-3">
            <button
                class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"
            >
                <Link :href="'/dashboard'"> Regresar </Link>
            </button>

            <div
                class="col-span-2 bg-white overflow-hidden shadow-none max-h-full m-2 p-2"
            >
                <div class="grid grid-cols-3 min-w-full">
                    <div class="col-span-1 w-full place-content-center pr-4">
                        <img
                            class="w-{50%} max-w-full min-w-{75%}"
                            :src="post.image_path"
                            :alt="post.title"
                        />
                    </div>

                    <div class="col-span-2 min-h-full">
                        <header class="border-b border-grey-400">
                            <Link
                                :href="'/profile/' + post.user.nick_name"
                                class="block cursor-pointer py-4 flex items-center text-sm outline-none focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out"
                            >
                                <img
                                    :src="post.user.profile_photo_url"
                                    :alt="post.user.nick_name"
                                    class="h-8 w-8 rounded-full object-cover"
                                />
                                <p class="block ml-2 font-bold">
                                    {{ post.user.nick_name }}
                                </p>
                                <span class="block ml-2 text-xs text-gray-600"
                                    >Hace
                                    {{
                                        getDifferenceTime(post.created_at)
                                    }}</span
                                >
                            </Link>

                            <!--Admin Funciones para eliminar y editar-->

                            <div
                                v-if="
                                    $page.props.user.permission.includes(
                                        'admin.recetas.create'
                                    ) && $page.props.user.id !== post.user.id
                                "
                            >
                                <Link
                                    :href="
                                        '/Admin/post/' +
                                        post.id +
                                        '/' +
                                        post.user_id +
                                        '/edit'
                                    "
                                >
                                    <button
                                        class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"
                                    >
                                        Editar
                                    </button>
                                </Link>
                                <!--Modal-->

                                <button
                                    @click="DeleteAdmin(post.id, post.user_id)"
                                    class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"
                                    type="button"
                                >
                                    Eliminar
                                </button>
                            </div>

                            <!--Creador Funciones para eliminar y editar-->
                            <div v-if="$page.props.user.id === post.user_id">
                                <Link
                                    :href="
                                        '/post/' +
                                        post.id +
                                        '/' +
                                        post.user_id +
                                        '/edit'
                                    "
                                >
                                    <button
                                        class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"
                                    >
                                        Editar
                                    </button>
                                </Link>

                                <button
                                    @click="
                                        DeleteCreador(post.id, post.user_id)
                                    "
                                    class="w-20 mx-3 mb-5 text-center bg-[#ff6060] rounded text-white py-2 outline-none focus:outline-none hover:bg-[#ff3232]"
                                    type="button"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </header>
                        <div class="grid grid-rows-1 grid-flow-col ">
                            <div>
                                <h1 class="font-bold mb-3 w-full text-center text-xl">{{ post.title }}</h1>
                                <h2 class="font-bold">Porciones</h2>
                                <p>{{ post.portions }}</p>
                                <div class="grid grid-cols-2">
                                    <div>
                                        <h2 class="font-bold">Ingredientes</h2>
                                        <p>{{ post.ingredients }}</p>
                                    </div>
                                    <div>
                                        <h2 class="font-bold">Preparación</h2>
                                        <p>{{ post.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Comentarios-->
            <div class="col-span-1 pr-4 pl-4 border">
                <div class="bottom-0 left-0 right-0 pl-4">
                    <div class="pt-4">
                        <div class="mb-2">
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
                                                    like.user_id ===
                                                    $page.props.user.id
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
                                <span class="text-gray-600 text-sm font-bold"
                                    >{{ post.countLikes }} Likes</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="scroll" ref="scrollComments">
                        <comments
                            v-if="post.comments.length > 0"
                            v-for="(comment, index) in post.comments"
                            :key="index"
                            :id="comment.id"
                            :comment="comment.comment"
                            :nickName="comment.user.nick_name"
                            :urlImage="comment.user.profile_photo_url"
                            :create="comment.created_at"
                            :post_user_id="post.user.id"
                            :user_id="comment.user_id"
                        ></comments>
                        <div v-else class="w-100 text-grey-500">
                            No hay comentarios
                        </div>
                    </div>
                    <div class="flex flex-col items-start">
                        <input
                            v-model="text"
                            class="w-full resize-none outline-none appearance-none"
                            aria-label="Agrega un comentario..."
                            placeholder="Agrega un comentario..."
                            autocomplete="off"
                            autocorrect="off"
                            style="height: 36px"
                        />
                        <button
                            @click="comment($page.props.user)"
                            @keyup.enter="comment($page.props.user.id)"
                            class="mb-2 focus:outline-none border-none bg-transparent text-blue-600"
                        >
                            Enviar
                        </button>
                        <div class="mb-2 focus:outline-none border-none">
                            {{ errors.comment }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
