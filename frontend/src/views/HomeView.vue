<script setup lang="ts">
import axiosInstance from '@/modules/axios';

//TODO: remove, should be called whenever error 419 occurs or when login in
axiosInstance
.get('/sanctum/csrf-cookie')
.then((response) => {
  console.log('csrf token ok, trying to login')
})
.catch((error) => {
  console.log('error while getting csrf token')
});
</script>

<template>
  <main>
    <h1>Learner</h1>
    <nav>
      <RouterLink to="/login">Se connecter</RouterLink>
      <RouterLink to="/decks">Decks</RouterLink>
    </nav>

    <RouterLink to="/revision">Débuter la révision du jour</RouterLink>
    
  </main>
</template>

<style>
  .card-items {
    display: flex;
    flex-direction: row;
    gap: 10px;
  }
</style>
