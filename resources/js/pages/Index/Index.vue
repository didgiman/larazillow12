<script lang="ts">
    
</script>

<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    message: String,
});
</script>

<template>
    <MainLayout>
        <div class="font-bold text-3xl">
            Index
        </div>
        <Link href="/hello" class="underline">Show page</Link>
        <p>{{ message }}</p>
    </MainLayout>
</template>