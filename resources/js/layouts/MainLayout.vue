<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import type { AppPageProps } from '@/types';
// import { ref } from 'vue';
import { computed } from 'vue';
import { Bell } from 'lucide-vue-next';

const flashSuccess = computed(() => page.props.flash.success);
const flashError = computed(() => page.props.flash.error);
const flashWarning = computed(() => page.props.flash.warning);
const flashInfo = computed(() => page.props.flash.info);
const user = computed(() => page.props.auth.user);
const notificationCount = computed(() => Math.min(page.props.user.notificationCount, 10));
// const user = computed(() => page.props.user);

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
                <div v-if="user" class="flex items-center gap-4">
                    <div class="text-gray-500 flex relative pr-2 py-2">
                        <Link :href="route('notification.index')">
                            <Bell class="text-yellow-600 dark:text-yellow-500" />
                            <div v-if="notificationCount" class="bg-red-700 dark:bg-red-400 text-white text-xs pt-px font-medium border border-white dark:border-gray-900 rounded-full absolute right-0 top-0 w-5 h-5 text-center">{{ notificationCount > 9 ? '9+' : notificationCount }}</div>
                        </Link>
                    </div>
                    <Link :href="route('realtor.listings.index')" class="text-xs text-gray-500">{{ user.name }}</Link>
                    <Link :href="route('realtor.listings.create')" class="btn btn-primary">+ Create Listing</Link>
                    <!-- <Link :href="route('course-logout')" method="delete" class="cursor-pointer text-red-500">Logout</Link> -->
                    <Link :href="route('logout')" method="post" class="cursor-pointer text-red-500">Logout</Link>
                </div>
                <div v-else class="flex items-center gap-4">
                    <!-- <Link :href="route('user-account.create')">Register</Link> -->
                    <Link :href="route('register')">Register</Link>
                    <!-- <Link :href="route('course-login')">Sign in</Link> -->
                    <Link :href="route('login')">Sign in</Link>
                </div>
            </nav>
        </div>
    </header>

    <main class="container mx-auto p-4 w-full">
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
