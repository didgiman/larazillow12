<script setup lang="ts">
import ListingPrice from '@/components/Listing/ListingPrice.vue';
import Box from '@/components/ui/box/Box.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { useForm } from '@inertiajs/vue3';
import { watchDebounced } from '@vueuse/core';
import { HandCoins, Undo } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    listingId: number,
    price: number
}>();
const form = useForm({
    amount: props.price
});

const makeOffer = () => form.post(
    route('listings.offer.store', {listing: props.listingId}),
    {
        preserveScroll: true,
        preserveState: true
    }
)

const difference = computed(() => form.amount - props.price);
const min = computed(() => Math.round(props.price / 2));
const max = computed(() => Math.round(props.price * 2));

const emit = defineEmits(['offerUpdated']);

watchDebounced(
    () => form.amount,
    (amount) =>
        emit('offerUpdated', amount),
    { debounce: 500, maxWait: 5000 },
);
</script>

<template>
    <Box>
        <template #header>Make an offer</template>
        <div>
            <form class="space-y-2" @submit.prevent="makeOffer">
                <Input v-model.number="form.amount" type="number" :min="min" :max="max" />
                <input
                    v-model.number="form.amount"
                    type="range"
                    :min="min"
                    :max="max"
                    step="1"
                    class="h-4 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 dark:bg-gray-700"
                />

                <div class="flex gap-2">
                    <Button variant="outline" type="submit" class="flex-1">
                        <HandCoins />Make an offer
                    </Button>
                    <Button type="reset" variant="ghost" @click.prevent="form.reset()">
                        <Undo />Reset
                    </Button>
                </div>

            </form>
        </div>
        <div class="flex justify-between text-gray-500 mt-2">
            <div>
                Difference
            </div>
            <div><ListingPrice :price="difference" /></div>
        </div>
    </Box>
</template>