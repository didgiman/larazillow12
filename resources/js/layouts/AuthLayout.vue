<script setup lang="ts">
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';
import MainLayout from './MainLayout.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <MainLayout>
        <AuthLayout :title="title" :description="description">
            <slot />
        </AuthLayout>
    </MainLayout>
</template>
