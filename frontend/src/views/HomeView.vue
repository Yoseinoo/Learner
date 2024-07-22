<script setup lang="ts">
import { useUsers } from '@/stores/user';

const userStore = useUsers();

function logout() {
  userStore.logout()
}
</script>

<template>
  <main>
    <h1>Learner</h1>
    <nav>
      <div v-if="userStore.authenticatedUser == undefined">
        <RouterLink to="/login">Se connecter</RouterLink>
      </div>
      <div v-else>
        <p>Utilisateur : {{ userStore.authenticatedUser?.name }}</p>
        <RouterLink to="/decks">Mes decks</RouterLink>
        <button type="button" @click="logout">Déconnexion</button>
      </div>
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
