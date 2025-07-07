<script setup lang="ts">
import ListingAddress from '@/components/Listing/ListingAddress.vue';
import ListingPrice from '@/components/Listing/ListingPrice.vue';
import ListingSpace from '@/components/Listing/ListingSpace.vue';
import Box from '@/components/ui/box/Box.vue';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import { PaginatedListings } from '@/types';
import { Link } from '@inertiajs/vue3';
import RealtorFilters from './Index/Components/RealtorFilters.vue';
import MainLayout from '@/layouts/MainLayout.vue';

defineProps<{
    listings: PaginatedListings;
    filters: {
        deleted: boolean;
        active: boolean;
        by: string;
        order: string;
    };
}>();
</script>

<template>
    <MainLayout>
        <h1 class="mb-4 text-3xl">Your Listings</h1>
        <section class="mb-4">
            <RealtorFilters :filters="filters" />
        </section>
        <section class="grid grid-cols-1 gap-2 lg:grid-cols-2">
            <Box v-for="listing in listings.data" :key="listing.id" :class="{ 'border-dashed !border-red-700': listing.deleted_at }">
                <div class="flex flex-col justify-between gap-2 md:flex-row md:items-center">
                    <div :class="{ 'opacity-50': listing.deleted_at }">
                        <div class="items-center gap-2 xl:flex">
                            <ListingPrice :price="listing.price" class="text-2xl font-medium" />
                            <ListingSpace :listing="listing" />
                        </div>
                        <ListingAddress :listing="listing" class="text-gray-500" />
                    </div>
                    <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
                        <a :href="route('listings.show', { listing: listing.id })" class="btn btn-outline text-xs font-medium" target="_blank">Preview</a>
                        <Link :href="route('realtor.listings.edit', { listing: listing.id })" class="btn btn-outline text-xs font-medium">Edit</Link>
                        <Link
                            v-if="!listing.deleted_at"
                            class="btn btn-outline text-xs font-medium"
                            :href="route('realtor.listings.destroy', { listing: listing.id })"
                            method="delete"
                            >Delete</Link
                        >
                        <Link
                            v-else
                            class="btn btn-outline text-xs font-medium"
                            :href="route('realtor.listing.restore', { listing: listing.id })"
                            method="put"
                            >Restore</Link
                        >
                    </div>
                </div>
            </Box>
        </section>
        <section class="my-4 w-full">
            <Pagination :details="{ ...listings, data: [] }" />
        </section>
    </MainLayout>
</template>
