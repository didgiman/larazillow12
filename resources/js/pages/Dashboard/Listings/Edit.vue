<script lang="ts"></script>

<script setup lang="ts">
import ListingFormInput from '@/components/Listing/ListingFormInput.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Listing, type BreadcrumbItem } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

import { Button } from '@/components/ui/button'
import { Save  } from 'lucide-vue-next'

const props = defineProps<{
    listing: Listing;
}>();

const form = useForm({
    beds: props.listing.beds,
    baths: props.listing.baths,
    area: props.listing.area,
    street: props.listing.street,
    street_nr: props.listing.street_nr,
    city: props.listing.city,
    code: props.listing.code,
    price: props.listing.price,
});

type FormField = 'beds' | 'baths' | 'area' | 'street' | 'street_nr' | 'city' | 'code' | 'price';

function clearError(field: string): void {
    form.clearErrors(field as FormField);
}

const update = () => form.put(route('realtor.listings.update', props.listing.id));

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Listings',
        href: '/dashboard/listings',
    },
    {
        title: props.listing.street + ' ' + props.listing.street_nr + ' ' + props.listing.city,
        href: '/dashboard/listings',
    },
];
</script>

<template>
    <Head title="Edit Listing" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <form @submit.prevent="update">
                <div v-if="form.isDirty">There are unsaved form changes.</div>
                <div v-if="form.hasErrors">The form has validation errors</div>
                <div class="grid grid-cols-6 gap-4">
                    <ListingFormInput
                        label="Beds"
                        v-model="form.beds"
                        type="number"
                        name="beds"
                        :error="form.errors.beds"
                        @input="clearError"
                        class="col-span-2"
                    />

                    <ListingFormInput
                        label="Baths"
                        v-model="form.baths"
                        type="number"
                        name="baths"
                        :error="form.errors.baths"
                        @input="clearError"
                        class="col-span-2"
                    />

                    <ListingFormInput
                        label="Area"
                        v-model="form.area"
                        type="number"
                        name="area"
                        :error="form.errors.area"
                        @input="clearError"
                        class="col-span-2"
                    />

                    <ListingFormInput
                        label="City"
                        v-model="form.city"
                        type="text"
                        name="city"
                        :error="form.errors.city"
                        @input="clearError"
                        class="col-span-4"
                    />

                    <ListingFormInput
                        label="Post Code"
                        v-model="form.code"
                        type="number"
                        name="code"
                        :error="form.errors.code"
                        @input="clearError"
                        class="col-span-2"
                    />

                    <ListingFormInput
                        label="Street"
                        v-model="form.street"
                        type="text"
                        name="street"
                        :error="form.errors.street"
                        @input="clearError"
                        class="col-span-4"
                    />

                    <ListingFormInput
                        label="Street Nr"
                        v-model="form.street_nr"
                        type="number"
                        name="street_nr"
                        :error="form.errors.street_nr"
                        @input="clearError"
                        class="col-span-2"
                    />

                    <ListingFormInput
                        label="Price"
                        v-model="form.price"
                        type="number"
                        name="price"
                        :error="form.errors.price"
                        @input="clearError"
                        class="col-span-6"
                    />

                    <div>
                        <!-- <button type="submit" class="btn btn-primary">Edit</button> -->
                        <Button type="submit">
                            <Save class="mr-1" />Save
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
