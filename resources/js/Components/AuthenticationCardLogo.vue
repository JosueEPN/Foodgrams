<template>
    <inertia-link :href="'/'">
        <img :src="image" alt="Logo">
    </inertia-link>
</template>

<script>
    import image from '../../image/Logo.png'
    export default {
        data(){
            return{
                image:image
            }
        }
    }
</script>
