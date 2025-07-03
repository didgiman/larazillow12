<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import type { AppPageProps } from '@/types';
// import { ref } from 'vue';
import { computed } from 'vue';

const flashSuccess = computed(() => page.props.flash.success);
const flashError = computed(() => page.props.flash.error);
const flashWarning = computed(() => page.props.flash.warning);
const flashInfo = computed(() => page.props.flash.info);

// const timer = ref(0);
// setInterval(() => {
//     timer.value++;
// }, 1000);

const page = usePage<AppPageProps>();
</script>

<template>

    <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 w-full">
        <div class="container mx-auto">
            <nav class="p-4 flex items-center justify-between">
                <div>
                    <Link :href="route('home')" class="underline">Index page</Link>
                </div>
                <div>
                    <Link :href="route('show')" class="underline">Show page</Link>
                </div>
                <div>
                    <Link :href="route('listings.index')" class="text-xl font-bold text-indigo-600 dark:text-indigo-300 text-center">LaraZillow</Link>
                </div>
                <div>
                    <Link :href="route('listings.create')" class="btn btn-primary">+ Create Listing</Link>
                </div>
            </nav>
        </div>
    </header>

    <main class="container mx-auto p-4">
        <!-- Flash Messages -->
        <div v-if="flashSuccess" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ flashSuccess }}
        </div>
        <div v-if="flashError" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ flashError }}
        </div>
        <div v-if="flashWarning" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
            {{ flashWarning }}
        </div>
        <div v-if="flashInfo" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
            {{ flashInfo }}
        </div>
        
        <slot></slot>
    </main>
</template>
