<script setup lang="ts">
import ListingAddress from '@/components/Listing/ListingAddress.vue';
import Price from '@/components/Listing/ListingPrice.vue';
import ListingSpace from '@/components/Listing/ListingSpace.vue';
import Box from '@/components/ui/box/Box.vue';
import { Link } from '@inertiajs/vue3';
import { useMonthlyPayment } from '@/composables/useMonthlyPayment';

import type { Listing } from '@/types';

const props = defineProps<{listing: Listing}>();

const { monthlyPayment } = useMonthlyPayment(props.listing.price, 2.5, 25);
</script>

<template>
    <Box>
        <div>
            <!-- <Link :href="`/listings/${listing.id}`">
                <ListingAddress :listing="listing" />
            </Link> -->
            <!-- <Link :href="route('listings.show', listing.id)" class="hover:underline">
                <ListingAddress :listing="listing" />
            </Link> -->
            <Link :href="route('listings.show', { listing: listing.id })" class="hover:underline">
                <div class="flex items-center">
                    <Price :price="listing.price" class="text-2xl font-bold" />
                    <div class="text-xs text-gray-500 ml-2"><Price :price="monthlyPayment" /> pm</div>
                </div>
                <ListingSpace :listing="listing" class="text-lg" />
                <ListingAddress :listing="listing" class="text-gray-400" />
            </Link>
        </div>
        <div>
            <!-- <Link :href="`/listings/${listing.id}/edit`">
                Edit
            </Link> -->
            <Link :href="route('listings.edit', listing.id)"> Edit </Link>
        </div>
        <div>
            <!-- <Link :href="`/listings/${listing.id}`" method="delete">
                Delete
            </Link> -->
            <Link :href="route('listings.destroy', listing.id)" method="delete"> Delete </Link>
        </div>
    </Box>
</template>
