<script lang="ts">
import { computed } from 'vue';
export default {
    layout: MainLayout,
};
</script>

<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue';
import { usePage } from '@inertiajs/vue3';
import ListingComponent from './Index/Components/Listing.vue';

import type { AppPageProps, Listing } from '@/types';

defineProps<{
    listings: Listing[];
}>();

const listingToHighlight = computed(() => page.props.flash.listingToHighlight);

// const timer = ref(0);
// setInterval(() => {
//     timer.value++;
// }, 1000);

const page = usePage<AppPageProps>();
</script>

<template>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <ListingComponent
            v-for="listing in listings"
            :key="listing.id"
            :listing="listing"
            :class="{
                'bg-green-200 dark:bg-green-900': listing.id === listingToHighlight,
            }"
        ></ListingComponent>
    </div>
</template>
