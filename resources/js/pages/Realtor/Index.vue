<script setup lang="ts">
import ListingAddress from '@/components/Listing/ListingAddress.vue';
import ListingPrice from '@/components/Listing/ListingPrice.vue';
import ListingSpace from '@/components/Listing/ListingSpace.vue';
import Box from '@/components/ui/box/Box.vue';
import Button from '@/components/ui/button/Button.vue';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { PaginatedListings } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ArchiveRestore, HandCoins, Images, ScanEye, SquarePen, Trash2 } from 'lucide-vue-next';
import RealtorFilters from './Index/Components/RealtorFilters.vue';
import Badge from '@/components/ui/badge/Badge.vue';

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
                        <Badge v-if="listing.sold_at != null" class="text-xs font-bold dark:bg-green-900 dark:text-green-200 bg-green-200 text-green-900 uppercase">Sold</Badge>
                        <div class="items-center gap-2 xl:flex">
                            <ListingPrice :price="listing.price" class="text-2xl font-medium" />
                            <ListingSpace :listing="listing" />
                        </div>
                        <ListingAddress :listing="listing" class="text-gray-500" />
                    </div>
                    <section>
                        <div class="flex items-center justify-end gap-1 text-gray-600 dark:text-gray-300">
                            <a v-if="!listing.deleted_at" :href="route('listings.show', { listing: listing.id })" target="_blank" title="Preview"><Button variant="outline"><ScanEye /></Button></a>
                            <Link :href="route('realtor.listings.edit', { listing: listing.id })" title="Edit"><Button><SquarePen /></Button></Link>
                            <Link
                                v-if="!listing.deleted_at"
                                :href="route('realtor.listings.destroy', { listing: listing.id })"
                                method="delete"
                                title="Delete"
                                ><Button variant="destructive"><Trash2/></Button></Link
                            >
                            <Link
                                v-else
                                :href="route('realtor.listing.restore', { listing: listing.id })"
                                method="put"
                                title="Restore"
                                ><Button variant="outline" class="!border-green-900"><ArchiveRestore /></Button></Link
                            >
                        </div>
                        <div class="mt-2">
                            <Link :href="route('realtor.listings.image.create', { listing: listing.id })" class="block w-full">
                                <Button variant="outline" class="w-full"><Images />Images ({{ listing.images_count }})</Button>
                            </Link>
                            <!-- <Link :href="route('realtor.listings.image.create', { listing: listing.id })" class="block w-full btn-">Images</Link> -->
                        </div>
                        <div class="mt-2">
                            <Link :href="route('realtor.listings.show', { listing: listing.id })" class="block w-full">
                                <Button variant="secondary" class="w-full"><HandCoins /> Offers ({{ listing.offers_count }})</Button>
                            </Link>
                        </div>
                    </section>
                </div>
            </Box>
        </section>
        <section class="my-4 w-full">
            <Pagination :details="{ ...listings, data: [] }" />
        </section>
    </MainLayout>
</template>
