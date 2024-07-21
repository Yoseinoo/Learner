
<script setup lang="ts">
import axiosInstance from '@/modules/axios'
import { type Ref, ref } from 'vue'
import { useRouter } from 'vue-router'

const email: Ref<string> = ref('')
const password: Ref<string> = ref('')
const router = useRouter()

function login() {
    axiosInstance
    .get('/sanctum/csrf-cookie')
    .then((response) => {
        console.log('csrf token ok, trying to login')
        axiosInstance
            .post('/login', { email: email.value, password: password.value })
            .then((result) => {
                console.log('Connexion réussie')
                router.push('/')
            })
            .catch((err) => {
                console.log('invalid credential')
            })
    })
    .catch((error) => {
        console.log('error while getting csrf token')
    })
}
</script>

<template>
    <div class="login-form">
        <div>
            <label for="email">Email : </label>
            <input type="email" name="email" id="remail" v-model="email" />
        </div>

        <div>
            <label for="password">Password : </label>
            <input type="password" name="password" id="password" v-model="password" />
        </div>

        <button type="button" @click="login">Se connecter</button>
    </div>
</template>

<style>
.login-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: center;
    justify-content: center;
}
</style>