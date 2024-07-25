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
      <div v-else class="menu">
        <p>Utilisateur : {{ userStore.authenticatedUser.name }}</p>
        <RouterLink :to="'/decks/' + userStore.authenticatedUser.id">Mes decks</RouterLink>
        <RouterLink to="/revision">Débuter la révision du jour</RouterLink>
        <button type="button" @click="logout">Déconnexion</button>
      </div>
    </nav>
  </main>
</template>

<style>
  .menu {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
</style>
