<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Listing, type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

import { Button } from '@/components/ui/button'
import { FilePenLine  } from 'lucide-vue-next'

import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import ListingPrice from '@/components/Listing/ListingPrice.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Listings',
        href: '/dashboard/listings',
    },
];

defineProps<{
    listings: Listing[]
}>();
</script>

<template>
    <Head title="Listings" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <Table>
                    <TableCaption>A list of your recent invoices.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]"> Created </TableHead>
                            <TableHead>Address</TableHead>
                            <TableHead>City</TableHead>
                            <TableHead>Beds</TableHead>
                            <TableHead>Baths</TableHead>
                            <TableHead>Area</TableHead>
                            <TableHead class="text-right"> Price </TableHead>
                            <TableHead></TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="listing in listings" :key="listing.id">
                            <TableCell class="font-medium"> {{ new Date(listing.created_at).toLocaleString('nl-BE') }} </TableCell>
                            <TableCell>{{ listing.street }} {{ listing.street_nr }}</TableCell>
                            <TableCell>{{ listing.city }}</TableCell>
                            <TableCell>{{ listing.beds }}</TableCell>
                            <TableCell>{{ listing.baths }}</TableCell>
                            <TableCell>{{ listing.area }}</TableCell>
                            <TableCell class="text-right"> <ListingPrice :price="listing.price" /> </TableCell>
                            <TableCell>
                                <Button>
                                    <Link :href="route('dashboard.listings.edit', { listing: listing.id })" class="flex flex-nowrap items-center">
                                        <FilePenLine class="mr-2" />
                                        Edit
                                    </Link>
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
