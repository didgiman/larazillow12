<script setup lang="ts">
    import type { Listing } from '@/types';
    
    defineProps<{
        listing: Listing
    }>();
</script>

<template>
    <span>
         {{ listing.street }} {{ listing.street_nr }}, {{ listing.city }}
    </span>
</template>