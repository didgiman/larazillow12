<script lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
</script>
<script setup lang="ts">
const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    email_confirmation: null
});

const register = () => form.post(route('user-account.store'));

const loginWithSocial = (social: string) => window.location.href = '/login/' + social;
</script>


<template>
    <form @submit.prevent="register">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="name" class="label">Name</label>
                <input type="text" class="input" id="name" v-model="form.name" />
                <div class="input-error" v-if="form.errors.name">{{ form.errors.name }}</div>
            </div>
            <div class="mt-4">
                <label for="email" class="label">Email</label>
                <input type="text" class="input" id="email" v-model="form.email" />
                <div class="input-error" v-if="form.errors.email">{{ form.errors.email }}</div>
            </div>
            <div class="mt-4">
                <label for="email_confirmation" class="label">Email (again)</label>
                <input type="text" class="input" id="email_confirmation" v-model="form.email_confirmation" />
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input type="password" class="input" id="password" v-model="form.password" />
                <div class="input-error" v-if="form.errors.password">{{ form.errors.password }}</div>
            </div>
            <div class="mt-4">
                <label for="password_confirmation" class="label">Password (again)</label>
                <input type="password" class="input" id="password_confirmation" v-model="form.password_confirmation" />
            </div>
            <div class="mt-4">
                <button class="btn btn-primary w-full" type="submit">Create Account</button>
                <div class="mt-2 text-center">
                    <Link :href="route('course-login')" class="text-sm text-gray-500 hover:underline">Already have an account? Log in</Link>
                </div>
            </div>
            <div class="mt-4">
                 <button @click="loginWithSocial('google')" class="w-full text-left hover:underline cursor-pointer mb-2">Register with Google</button>
                 <button @click="loginWithSocial('github')" class="w-full text-left hover:underline cursor-pointer mb-2">Register with Github</button>
                 <button @click="loginWithSocial('facebook')" class="w-full text-left hover:underline cursor-pointer mb-2">Register with Facebook</button>
            </div>
        </div>
    </form>
</template>