<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Pages/Welcome.vue';
defineProps({
    posts: Array,
});
</script>

<template>
    <AppLayout >
        
        <Welcome :posts="posts"/>
    </AppLayout>
</template>
