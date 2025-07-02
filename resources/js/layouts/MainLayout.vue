<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const timer = ref(0);
setInterval(() => {
    timer.value++;
}, 1000);
</script>

<template>
    <nav class="flex gap-4">
        <Link href="/" class="underline">Index page</Link>
        <Link href="/hello" class="underline">Show page</Link>
    </nav>
    The page with time {{ timer }}
    <slot></slot>
</template>
