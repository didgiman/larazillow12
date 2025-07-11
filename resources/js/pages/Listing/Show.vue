<script lang="ts">
import ListingPrice from '@/components/Listing/ListingPrice.vue';
import ListingSpace from '@/components/Listing/ListingSpace.vue';
import Box from '@/components/ui/box/Box.vue';
import MainLayout from '@/layouts/MainLayout.vue';
import MakeOffer from './Show/Components/MakeOffer.vue';
import OfferMade from './Show/Components/OfferMade.vue';
import EmptyState from '@/components/ui/empty-state/EmptyState.vue';
</script>

<script setup lang="ts">
import ListingAddress from '@/components/Listing/ListingAddress.vue';
import type { Listing } from '@/types';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import type { AppPageProps } from '@/types';
import { computed } from 'vue';

import { useMonthlyPayment } from '@/composables/useMonthlyPayment';

const interestRate = ref(2.5);
const duration = ref(25);
// const monthlyPayment = computed(() => {
//     const principle = props.listing.price;
//     const monthlyInterest = interestRate.value / 100 / 12;
//     const numberOfPaymentMonths = duration.value * 12;

//     return principle * monthlyInterest * (Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) / (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
// });

const props = defineProps<{
    listing: Listing,
    offerMade: {
        id: number,
        amount: number,
        created_at: Date
    }
}>();

const offer = ref(props.listing.price);

const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(offer, interestRate, duration);

const page = usePage<AppPageProps>();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <MainLayout>
        <div class="flex grid-cols-12 flex-col-reverse gap-4 md:grid">
            <Box v-if="listing.images.length" class="flex w-full items-center md:col-span-7">
                <div class="grid grid-cols-2 gap-1">
                    <img v-for="image in listing.images" :key="image.id" :src="image.src" />
                </div>
            </Box>
            <EmptyState v-else class="flex w-full items-center md:col-span-7">
                No Images
            </EmptyState>

            <div class="space-y-4 md:col-span-5">
                <Box>
                    <template #header>Basic Info</template>
                    <ListingPrice :price="listing.price" class="text-2xl font-bold" />
                    <ListingSpace :listing="listing" class="text-lg" />
                    <ListingAddress :listing="listing" class="text-gray-400" />
                </Box>
                <Box>
                    <template #header> Monthly Payment </template>
                    <div>
                        <label class="label">Interest rate ({{ interestRate }}%)</label>
                        <input
                            v-model.number="interestRate"
                            type="range"
                            min="0.1"
                            max="30"
                            step="0.1"
                            class="h-4 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 dark:bg-gray-700"
                        />
                            
                        <label class="label">Duration ({{ duration }} years)</label>
                        <input
                            v-model.number="duration"
                            type="range"
                            min="3"
                            max="35"
                            step="1"
                            class="h-4 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 dark:bg-gray-700"
                        />

                        <div class="mt-2 text-gray-600 dark:text-gray-300">
                            <div clas="text-gray-400">Your monthly payment</div>
                            <ListingPrice :price="monthlyPayment" class="text-3xl"></ListingPrice>
                        </div>
                        <div class="mt-2 text-gray-500">
                            <div class="flex justify-between">
                                <div>Total paid:</div> <ListingPrice :price="totalPaid" />
                            </div>
                        </div>
                        <div class="mt-2 text-gray-500">
                            <div class="flex justify-between">
                                <div>Principle paid:</div> <ListingPrice :price="offer" />
                            </div>
                        </div>
                        <div class="mt-2 text-gray-500">
                            <div class="flex justify-between">
                                <div>Total interest:</div><ListingPrice :price="totalInterest" />
                            </div>
                        </div>                            
                    </div>
                </Box>

                <MakeOffer v-if="user && !offerMade" :listing-id="listing.id" :price="listing.price" @offer-updated="offer = $event" />
                <OfferMade v-if="user && offerMade" :offer="offerMade" />
            </div>
        </div>
    </MainLayout>
</template>
