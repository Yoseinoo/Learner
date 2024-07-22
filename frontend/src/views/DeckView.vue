<script setup lang="ts">
import type { Deck } from '@/models/Deck';
import axiosInstance from '@/modules/axios';
import { onMounted, ref, type Ref } from 'vue';
import DeckItem from '@/components/DeckItem.vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const deckList: Ref<Deck[]> = ref([]);

//TODO: Problème ne devrait pas être dans onMounted car c'est utilisé par 2 url et ça repasse pas par unmounted 
onMounted(() => {
    if (route.params.id) {
      getDecksForUser();
    } else {
      getDecks();
    }
});

function getDecks() {
  console.log("Getting all decks");
  axiosInstance
  .get<Deck[]>("/api/decks")
  .then(resp => {
    deckList.value = resp.data;
    console.log(resp);
  })
  .catch(err => console.error("Error getting decks : " + err))
}

function getDecksForUser() {
  console.log("Getting decks for user : " + route.params.id);
  axiosInstance
  .get<Deck[]>("/api/decks/" + route.params.id)
  .then(resp => {
    deckList.value = resp.data;
    console.log(resp);
  })
  .catch(err => console.error("Error getting decks : " + err))
}
</script>

<template>
  <div class="view-container">
    <div class="card-items">
      <DeckItem
        v-for="deck in deckList"
        :deck="deck"
      ></DeckItem>
    </div>

    <div v-if="route.params.id" class="buttons">
      <RouterLink to="/deck">Nouveau</RouterLink>
      <RouterLink to="/decks">Récupérer un deck publique</RouterLink>
    </div>
  </div>
</template>

<style>
.view-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}

.buttons {
  display: flex;
  flex-direction: row;
  gap: 10px;
  justify-content: flex-end;

  width: 100%;
}
</style>