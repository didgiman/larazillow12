<script lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
</script>
<script setup lang="ts">
const form = useForm({
    email: null,
    password: null
});

const login = () => form.post(route('course-login-store'))

const loginWithSocial = (social: string) => window.location.href = '/login/' + social;
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
                <button class="btn btn-primary w-full" type="submit">Log in</button>
                <div class="mt-2 text-center">
                    <Link :href="route('user-account.create')" class="text-sm text-gray-500 hover:underline">New here? Create an account</Link>
                </div>
            </div>
            <div class="mt-4">
                 <button @click="loginWithSocial('google')" class="w-full text-left hover:underline cursor-pointer mb-2">Log in with Google</button>
                 <button @click="loginWithSocial('github')" class="w-full text-left hover:underline cursor-pointer mb-2">Log in with Github</button>
                 <button @click="loginWithSocial('facebook')" class="w-full text-left hover:underline cursor-pointer mb-2">Log in with Facebook</button>
            </div>
        </div>
    </form>
</template>