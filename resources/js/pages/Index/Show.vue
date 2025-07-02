<script lang="ts">
    import MainLayout from '@/layouts/MainLayout.vue';
    export default {
        layout: MainLayout
    }
</script>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="font-bold text-3xl">
        Show
    </div>
    <Link href="/" class="underline">Index page</Link>
</template>