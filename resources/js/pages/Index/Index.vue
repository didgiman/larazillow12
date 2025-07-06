<script lang="ts">
    
</script>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';

    defineProps({
        message: String,
    });
</script>

<template>
    <div class="font-bold text-3xl">
        Index
    </div>
    <Link href="/hello" class="underline">Show page</Link>
    <p>{{ message }}</p>
</template>