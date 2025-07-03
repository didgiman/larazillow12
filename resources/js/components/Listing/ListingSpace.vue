<script setup lang="ts">
    import type { Listing } from '@/types';
    
    defineProps<{
        listing: Listing
    }>();
</script>

<template>
    <div>
        <span class="font-bold">{{ listing.beds }}</span> bds
        <span class="text-gray-400 px-2">|</span>
        <span class="font-bold">{{ listing.baths }}</span> ba
        <span class="text-gray-400 px-2">|</span>
        <span class="font-bold">{{ listing.area }}</span> m²
    </div>
</template>