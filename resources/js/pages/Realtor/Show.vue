<script setup lang="ts">
import ListingAddress from '@/components/Listing/ListingAddress.vue';
import ListingPrice from '@/components/Listing/ListingPrice.vue';
import ListingSpace from '@/components/Listing/ListingSpace.vue';
import Box from '@/components/ui/box/Box.vue';
import { Button } from '@/components/ui/button';
import MainLayout from '@/layouts/MainLayout.vue';
import { Listing } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import { computed } from 'vue';
import Offer from './Show/Components/Offer.vue';

const props = defineProps<{
    listing: Listing
}>();

const hasOffers = computed(
    () => props.listing.offers.length
);
</script>

<template>
    <MainLayout>
        <div class="mb-4">
            <Link :href="route('realtor.listings.index')">
                <Button variant="ghost">
                    <ArrowLeft />Go back to Listings
                </Button>
            </Link>
        </div>
        <section class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
            <Box v-if="!hasOffers" class="flex md:col-span-7 items-center">
                <div class="w-full text-center font-medium text-gray-500">
                    No offers
                </div>
            </Box>
            <div v-else class="md:col-span-7 flex flex-col gap-4">
                <Offer v-for="offer in listing.offers" :offer="offer" :listing-price="listing.price" :is-sold="listing.sold_at != null" :key="offer.id">
                    {{ offer }}
                </Offer>
            </div>
            <Box class="md:col-span-5">
                <template #header>Basic Info</template>
                <ListingPrice :price="listing.price" class="text-2xl font-bold" />
                <ListingSpace :listing="listing" class="text-lg" />
                <ListingAddress :listing="listing" class="text-gray-500" />
            </Box>
        </section>
    </MainLayout>
</template>