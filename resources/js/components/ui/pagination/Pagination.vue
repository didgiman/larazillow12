<script setup lang="ts">
import { LaravelPagination } from '@/types';
import { Link } from '@inertiajs/vue3';

defineProps<{
    // details: PaginationMetaOmit<'data'>
    details: LaravelPagination<[]>
}>();
</script>

<template>
    <div v-if="details.last_page > 1" class="flex justify-between items-center">
        <div class="text-sm text-gray-500">Showing {{ details.from }}-{{ details.to }} of {{ details.total }}</div>
        <div class="flex gap-1">
            <template v-for="(link, index) in details.links" :key="index">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    class="py-2 px-4 rounded-md"
                    :class="{'bg-indigo-500 dark:bg-indigo-800 text-gray-300': link.active}"
                    v-html="link.label"
                />
                <span
                    v-else
                    class="py-2 px-4 rounded-md text-gray-400 cursor-not-allowed"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>