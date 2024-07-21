<script setup lang="ts">
import { onMounted, ref, type Ref } from 'vue';
import axiosInstance from '@/modules/axios';
import type { Card } from '@/models/Card';
import CardItem from '@/components/CardItem.vue';

const cardList: Ref<Card[]> = ref([]);

//TODO: Si non connecté alors trouver les data dans indexed DB sinon récupérer les data dans sql
onMounted(() => {
  console.log("Get cards to review")
  axiosInstance
  .get<Card[]>("/api/cards")
  .then(resp => {
    cardList.value = resp.data;
    console.log(resp);
  })
  .catch(err => console.error("Error getting cards : " + err))
});
</script>

<template>
  <div class="revision-container">
    <CardItem
        v-for="card in cardList"
        :card="card"
        :deletable="false"
      ></CardItem>
  </div>
</template>