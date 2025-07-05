<script lang="ts">
import MainLayout from '@/layouts/MainLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
export default {
    layout: MainLayout,
};
</script>
<script setup lang="ts">
const form = useForm({
    email: null,
    password: null
});

const login = () => form.post(route('course-login-store'))
</script>


<template>
    <form @submit.prevent="login">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="email" class="label">Email</label>
                <input type="text" class="input" id="email" v-model="form.email" />
                <div class="input-error" v-if="form.errors.email">{{ form.errors.email }}</div>
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input type="password" class="input" id="password" v-model="form.password" />
                <div class="input-error" v-if="form.errors.password">{{ form.errors.password }}</div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary w-full" type="submit">Login</button>
                <div class="mt-2 text-center">
                    <Link :href="route('user-account.create')" class="text-sm text-gray-500 hover:underline">New here? Create an account</Link>
                </div>
            </div>
        </div>
    </form>
</template>