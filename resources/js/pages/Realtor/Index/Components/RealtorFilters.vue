<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { watchDebounced } from '@vueuse/core';
import { reactive, computed } from 'vue';

const sortLabels = {
    created_at: [
        {
            label: 'Latest',
            value: 'desc'
        },
        {
            label: 'Oldest',
            value: 'asc'
        },
    ],
    price: [
        {
            label: 'Pricey',
            value: 'desc'
        },
        {
            label: 'Cheapest',
            value: 'asc'
        }
    ]
};

const sortOptions = computed(() => sortLabels[filterForm.by as keyof typeof sortLabels]);

const props = defineProps<{
    filters: {
        deleted: boolean,
        active: boolean,
        by: string,
        order: string
    }
}>();

const filterForm = reactive({
    deleted: props.filters.deleted ?? false,
    active: props.filters.active ?? false,
    by: props.filters.by ?? 'created_at',
    order: props.filters.order ?? 'asc'
});

// watch(filterForm, (newValue, oldValue) => console.log(newValue, oldValue));
// watch(filterForm, () =>
//     router.get(route('realtor.listings.index'), filterForm, {
//         preserveState: true,
//         preserveScroll: true,
//     }),
// );

watchDebounced(
    filterForm,
    () =>
        router.get(
            route('realtor.listings.index'), filterForm, {
                preserveState: true,
                preserveScroll: true,
            }
        ),
    { debounce: 500, maxWait: 5000 },
);
</script>

<template>
    <form>
        <div class="my-4 flex flex-wrap gap-4">
            <div class="flex flex-nowrap items-center gap-2">
                <input
                    v-model="filterForm.deleted"
                    id="deleted"
                    type="checkbox"
                    class="w-4- h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <label for="deleted">Deleted</label>
            </div>
            <div class="flex flex-nowrap items-center gap-2">
                <input
                    v-model="filterForm.active"
                    id="active"
                    type="checkbox"
                    class="w-4- h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <label for="active">Active</label>
            </div>
            <div>
                <select class="input-filter-l w-24" v-model="filterForm.by">
                    <option value="created_at">Added</option>
                    <option value="price">Price</option>
                </select>
                <select class="input-filter-r w-24" v-model="filterForm.order">
                    <option v-for="option in sortOptions" :value="option.value" :key="option.value">{{ option.label }}</option>
                </select>
            </div>
        </div>
    </form>
</template>
