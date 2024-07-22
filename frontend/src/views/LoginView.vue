
<script setup lang="ts">
import { useUsers } from '@/stores/user';
import { type Ref, ref } from 'vue'

const form = ref({
    name: 'test',
    email: '',
    password: ''
})

const userStore = useUsers()

function login() {
    userStore.login(form)
}

function register() {
    userStore.register(form)
}
</script>

<template>
    <div class="login-form">
        <div>
            <label for="email">Email : </label>
            <input type="email" name="email" id="remail" v-model="form.email" />
        </div>

        <div>
            <label for="password">Password : </label>
            <input type="password" name="password" id="password" v-model="form.password" />
        </div>

        <button type="button" @click="login">Se connecter</button>
        <button type="button" @click="register">S'inscrire</button>
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