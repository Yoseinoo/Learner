
import type { User } from '@/models/User'
import axiosInstance from '@/modules/axios'
import router from '@/router'
import { defineStore } from 'pinia'
import { ref, type Ref } from 'vue'

const csrf = () => axiosInstance.get('/sanctum/csrf-cookie')

export const useUsers = defineStore('users', () => {
    const authenticatedUser : Ref<User|undefined> = ref(undefined);

    //Get the current user when store is created
    getUser();

    async function getUser() {
        axiosInstance
        .get('/api/user')
        .then(response => {
            console.log("Got user : ", response.data)
            authenticatedUser.value = response.data
        })
        .catch(error => {
            if (error.response.status !== 409) throw error

            router.push('/verify-email')
        })
    }
    
    async function login(form: Ref) {
        await csrf()

        axiosInstance
        .post('/api/login', form.value)
        .then((result) => {
            console.log('Connexion réussie');
            getUser();
            router.push('/');
        })
        .catch((err) => {
            console.log('invalid credential')
        })
    }

    async function register(form: Ref) {
        await csrf()

        const postData = {
            name: form.value.name,
            email: form.value.email,
            password: form.value.password,
            password_confirmation: form.value.password
        }

        axiosInstance
        .post('/register', postData)
        .then(response => {
            console.log('Enregistrement réussi')
            router.push('/login')
        })
        .catch(error => {
            console.log('error registering : ', error)
        })
    }

    async function logout() {
        axiosInstance
        .post('/logout')
        .then(() => {
            console.log("Déconnexion réussie")
            authenticatedUser.value = undefined
            router.push('/')
        })
        .catch(error => {
            if (error.response.status !== 422) throw error
        })
    }

    return {
        authenticatedUser,
        login,
        logout,
        register
    }
})