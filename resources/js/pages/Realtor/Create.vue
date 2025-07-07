<script lang="ts">
    
</script>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import ListingFormInput from '@/components/Listing/ListingFormInput.vue';
import MainLayout from '@/layouts/MainLayout.vue';

const form = useForm({
    beds: 0,
    baths: 0,
    area: 0,
    street: '',
    street_nr: 0,
    city: '',
    code: 0,
    price: 0,
})

type FormField = 'beds' | 'baths' | 'area' | 'street' | 'street_nr' | 'city' | 'code' | 'price'

function clearError(field: string): void {
    form.clearErrors(field as FormField);
}
</script>

<template>
  <MainLayout>
    <form @submit.prevent="form.post(route('realtor.listings.store'))">
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
          type="text"
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

        <div class="col-span-6">
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </div>
    </form>
  </MainLayout>
</template>