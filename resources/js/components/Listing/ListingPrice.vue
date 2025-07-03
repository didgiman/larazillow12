<script setup lang="ts">
    import { computed } from 'vue';

    const props = defineProps<{
        price: number | string
    }>();

    const formattedPrice = computed(
        () => Number(props.price).toLocaleString('nl-BE', {
            style: 'currency',
            currency: 'EUR',
            maximumFractionDigits: 0
        })
    );
</script>

<template>
    <span>{{ formattedPrice }}</span>
</template>