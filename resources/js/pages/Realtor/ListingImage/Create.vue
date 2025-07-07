<script setup lang="ts">
import Box from '@/components/ui/box/Box.vue';
import Button from '@/components/ui/button/Button.vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { Listing } from '@/types';
import { Link, useForm } from '@inertiajs/vue3';
import { ImageUp, ListRestart, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const fileInput = ref<HTMLInputElement | null>(null);

const props = defineProps<{
    listing: Listing;
}>();

const form = useForm({
    images: [] as File[],
});

const imageErrors = computed(() => Object.values(form.errors));

const canUpload = computed(() => form.images.length);

function upload() {
    form.post(route('realtor.listings.image.store', { listing: props.listing.id }), {
        onSuccess: () => {
            form.reset('images');
            if (fileInput.value) {
                fileInput.value.value = '';
            }
        },
    });
}

const addFiles = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files) {
        for (const image of target.files) {
            form.images.push(image);
        }
    }
};

const reset = () => form.reset('images');
</script>

<template>
    <MainLayout>
        <Box>
            <template #header>Upload new images</template>

            <form @submit.prevent="upload" class="my-6 flex items-center justify-center gap-8">
                <div>
                    <input
                        type="file"
                        multiple
                        @input="addFiles"
                        ref="fileInput"
                        class="rounded-md border border-gray-200 file:mr-4 file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:font-medium file:text-gray-700 file:hover:cursor-pointer file:hover:bg-gray-200 dark:border-gray-700 file:dark:bg-gray-800 file:dark:text-gray-400 file:dark:hover:bg-gray-700"
                    />
                </div>
                <div class="space-x-4">
                    <Button type="submit" :disabled="!canUpload"><ImageUp />Upload</Button>
                    <Button type="reset" @click="reset" variant="outline"><ListRestart />Reset</Button>
                </div>
            </form>
            <!-- <div>
                <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="block w-full">
                {{ form.progress.percentage }}%
                </progress>
            </div> -->
            <div v-if="imageErrors.length" class="input-error">
                <div v-for="(error, index) in imageErrors" :key="index">
                    {{ error }}
                </div>
            </div>
        </Box>

        <Box class="mt-4" v-if="listing.images.length">
            <template #header>Current Listing Images</template>
            <section class="mt-4 grid grid-cols-3 gap-4">
                <div v-for="image in listing.images" :key="image.id" class="flex flex-col justify-between">
                    <img :src="image.src" class="rounded-md" />
                    <Link :href="route('realtor.listings.image.destroy', { listing: listing, image: image })" method="delete" class="mt-2"
                        ><Button variant="outline" class="w-full"><Trash2 />Delete</Button
                    ></Link>
                </div>
            </section>
        </Box>
    </MainLayout>
</template>
