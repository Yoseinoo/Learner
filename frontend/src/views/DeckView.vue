<script setup lang="ts">
import type { Deck } from '@/models/Deck';
import axiosInstance from '@/modules/axios';
import { onMounted, ref, type Ref } from 'vue';
import DeckItem from '@/components/DeckItem.vue';

const deckList: Ref<Deck[]> = ref([]);

//TODO: Si non connecté alors trouver les data dans indexed DB sinon récupérer les data dans sql pour l'utitlisateur connecté
onMounted(() => {
  getDecks();
});

function getDecks() {
  console.log("Getting decks for user : ")
  axiosInstance
  .get<Deck[]>("/api/decks")
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

    <div class="buttons">
      <RouterLink to="/deck">Nouveau</RouterLink>
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