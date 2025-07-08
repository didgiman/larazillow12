<script setup lang="ts">
import ListingPrice from '@/components/Listing/ListingPrice.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Box from '@/components/ui/box/Box.vue';
import { Button } from '@/components/ui/button';
import { ListingOffer } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Handshake } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    offer: ListingOffer,
    listingPrice: number,
    isSold: boolean
}>();

const difference = computed(() => props.offer.amount - props.listingPrice);

const madeOn = computed(() => new Date(props.offer.created_at).toLocaleString('nl-BE'));
</script>

<template>
    <Box>
        <template #header>Offer #{{ offer.id }} <Badge v-if="offer.accepted_at" class="dark:bg-green-900 dark:text-green-200 bg-green-200 text-green-900 uppercase ml-1">Accepted</Badge> </template>

        <section class="flex items-center justify-between">
            <div>
                <ListingPrice :price="offer.amount" class="text-xl" />
                <div class="text-gray-500">Difference <ListingPrice :price="difference" /></div>
                <div class="text-sm text-gray-500">Made by {{ offer.bidder.name }}</div>
                <div class="text-sm text-gray-500">Made on {{ madeOn }}</div>
            </div>
            <div>
                <Link v-if="!isSold" :href="route('realtor.offer.accept', { offer: offer.id })" method="put">
                    <Button><Handshake />Accept</Button>
                </Link>
            </div>
        </section>
        <!-- <slot></slot> -->
    </Box>
</template>
