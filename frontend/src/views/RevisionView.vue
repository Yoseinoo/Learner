<script setup lang="ts">
import CardItem from '@/components/CardItem.vue';
import { useRevision } from '@/stores/revision';

const revisionStore = useRevision()
</script>

<template>
  <div class="revision-container">
    <div v-if="revisionStore.currentCard" class="carousel">
      <CardItem
        :card="revisionStore.currentCard"
        :deletable="false"
      ></CardItem>
      <button type="button" @click="revisionStore.failed">Erreur</button>
      <button type="button" @click="revisionStore.succeeded">Succès</button>
    </div>
    <div v-else>
      <p>Toutes les cartes ont été révisées</p>
    </div>
  </div>
</template>