<script lang="ts">
import { computed } from 'vue';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import Filters from '@/pages/Listing/Index/Components/Filters.vue';
export default {
    layout: MainLayout,
};
</script>

<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue';
import { usePage } from '@inertiajs/vue3';
import ListingComponent from './Index/Components/Listing.vue';

import type { AppPageProps, PaginatedListings, ListingFilters } from '@/types';

defineProps<{
    listings: PaginatedListings,
    filters: ListingFilters
}>();

const listingToHighlight = computed(() => page.props.flash.listingToHighlight);

const page = usePage<AppPageProps>();
</script>

<template>
    <Filters :filters="filters" />
    <div class="text-center mb-4">
        {{ listings.total }} listing{{ listings.total === 1 ? '' : 's' }}
    </div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <ListingComponent
            v-for="listing in listings.data"
            :key="listing.id"
            :listing="listing"
            :class="{
                'bg-green-200 dark:bg-green-900': listing.id === listingToHighlight,
            }"
        ></ListingComponent>
    </div>
    <div v-if="listings.data.length" class="w-full my-4">
        <!-- <Pagination :links="listings.links" /> -->
        <Pagination :details="{ ...listings, data: [] }" />
    </div>
</template>
