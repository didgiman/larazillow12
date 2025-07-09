<script setup lang="ts">
import ListingPrice from '@/components/Listing/ListingPrice.vue';
import { Button } from '@/components/ui/button';
import EmptyState from '@/components/ui/empty-state/EmptyState.vue';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { PaginatedNotifications } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Eye } from 'lucide-vue-next';

defineProps<{
    notifications: PaginatedNotifications;
}>();
</script>

<template>
    <MainLayout>
        <h1 class="mb-4 text-3xl">Your notifications</h1>
        <section v-if="notifications.data.length" class="text-gray-700 dark:text-gray-400">
            <div
                v-for="notification in notifications.data"
                :key="notification.id"
                class="flex items-center justify-between border-b border-gray-200 py-4 dark:border-gray-800"
            >
                <div>
                    <span v-if="notification.type === 'App\\Notifications\\OfferMade'">
                        Offer <ListingPrice :price="notification.data.amount as number" /> for
                        <Link
                            :href="route('realtor.listings.show', { listing: notification.data.listing_id })"
                            class="text-indigo-600 dark:text-indigo-400"
                            >listing</Link
                        >
                        was made
                    </span>
                </div>
                <div>
                    <Link v-if="!notification.read_at" :href="route('notification.seen', { notification: notification.id })" method="put">
                        <Button variant="outline" class="uppercase"><Eye />Mark as read</Button>
                    </Link>
                </div>
            </div>
        </section>

        <EmptyState v-else>No notifications yet</EmptyState>

        <section v-if="notifications.data.length" class="flex w-full justify-center">
            <Pagination :details="{ ...notifications, data: [] }" />
        </section>
    </MainLayout>
</template>
