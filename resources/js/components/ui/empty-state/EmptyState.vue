<script setup lang="ts">
import Box from '../box/Box.vue';
</script>

<template>
    <Box>
        <div class="w-full text-center font-medium text-gray-500">
            <slot />
        </div>
    </Box>
</template>