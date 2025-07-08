<script setup lang="ts">
import ListingPrice from '@/components/Listing/ListingPrice.vue';
import Box from '@/components/ui/box/Box.vue';
import { computed } from 'vue';

const props = defineProps<{
    offer: {
        id: number,
        amount: number,
        created_at: Date
    }
}>();
const offerMadeOn = computed(
    () => new Date(props.offer.created_at).toDateString()
)
</script>

<template>
    <Box>
        <template #header>Offer Made</template>
        <ListingPrice :price="offer.amount" class="text-3xl" />
        <section class="mt-2 flex flex-col md:flex-row justify-between text-gray-500">
            <div>Made on</div>
            <div class="font-bold">{{ offerMadeOn }}</div>
        </section>
    </Box>
</template>