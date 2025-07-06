<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

import { ListingFilters } from '@/types';

const props = defineProps<{ filters: ListingFilters }>();

const filterForm = useForm({
    priceFrom: props.filters.priceFrom ?? null,
    priceTo: props.filters.priceTo ?? null,
    beds: props.filters.beds ?? null,
    baths: props.filters.baths ?? null,
    areaFrom: props.filters.areaFrom ?? null,
    areaTo: props.filters.areaTo ?? null
});

const filter = () => {
    filterForm.get(
        route('listings.index'),
        {
            preserveState: true,
            preserveScroll: true
        }
    )
}

const reset = () => {
    filterForm.priceFrom = null;
    filterForm.priceTo = null;
    filterForm.beds = null;
    filterForm.baths = null;
    filterForm.areaFrom = null;
    filterForm.areaTo = null;

    filter();
}
</script>

<template>
    <form @submit.prevent="filter">
        <div class="mb-4 mt-4 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center">
                <input type="text" class="input-filter-l" placeholder="Price from" v-model.number="filterForm.priceFrom" />
                <input type="text" class="input-filter-r" placeholder="Price to" v-model.number="filterForm.priceTo" />
            </div>
            <div class="flex flex-nowrap items-center">
                <select class="input-filter-l" v-model="filterForm.beds">
                    <option :value="null">Beds</option>
                    <option v-for="n in 5" :key="n">{{ n }}</option>
                    <option value="6">6+</option>
                </select>
                <select class="input-filter-r" v-model="filterForm.baths">
                    <option :value="null">Baths</option>
                    <option v-for="n in 5" :key="n">{{ n }}</option>
                    <option value="6">6+</option>
                </select>
            </div>
            <div class="flex flex-nowrap items-center">
                <input type="text" class="input-filter-l" placeholder="Area from" v-model.number="filterForm.areaFrom" />
                <input type="text" class="input-filter-r" placeholder="Area to" v-model.number="filterForm.areaTo" />
            </div>
            <button type="submit" class="btn btn-normal">Filter</button>
            <button type="reset" @click="reset">Clear</button>
        </div>
    </form>
</template>