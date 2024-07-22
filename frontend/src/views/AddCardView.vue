<script setup lang="ts">
import type { Card } from '@/models/Card';
import axiosInstance from '@/modules/axios';
import router from '@/router';
import { ref, type Ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();

const card: Ref<Card> = ref({
    id: 0,
    question: '',
    answer: '',
    level: 1,
    deck_id: Number(route.params.id)
})

function addCard() {
    console.log("adding card to deck with id :" + card.value.deck_id);
    axiosInstance
    .post("/api/card", {
        card: card.value
    })
    .then(resp => {
        console.log('card created : ', resp.data);
        router.push('/deck/' + card.value.deck_id);
    })
    .catch(err => console.error("Error saving deck : " + err))
}
</script>

<template>
    <div>
        <label for="question">Question :</label>
        <textarea name="question" v-model="card.question"></textarea>
    </div>

    <div>
        <label for="answer">Réponse :</label>
        <textarea name="answer" v-model="card.answer"></textarea>
    </div>

    <button type="button" @click="addCard">Ajouter</button>
</template>