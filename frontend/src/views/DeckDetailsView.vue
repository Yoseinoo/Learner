<script setup lang="ts">
import type { Deck } from '@/models/Deck';
import CardItem from '@/components/CardItem.vue';
import type { Card } from '@/models/Card';
import { onMounted, ref, type Ref } from 'vue';
import { useRoute } from 'vue-router';
import axiosInstance from '@/modules/axios';
import router from '@/router';

const defaultDeck: Deck = {
    id: 0,
    label: '',
    description: '',
    active: false,
    public: false
}
const deck: Ref<Deck> = ref(defaultDeck);
const route = useRoute();
const cardList: Ref<Card[]> = ref([]);

onMounted(() => {
    if (route.params.id) {
        getDeck();
    } else {
        console.log("Nouveau deck");
    }
});

/**
 * Récupère le deck en bdd en utilisant l'id trouvé dans les params d'url
 */
function getDeck() {
    console.log("getting deck with id : " + route.params.id);

    //Get the deck then get cards of this deck
    axiosInstance
    .get<Deck>("/api/deck/" + route.params.id)
    .then(resp => {
        deck.value = resp.data;
        getCards();
    })
    .catch(err => console.error("Error getting deck : " + err))
}

/**
 * Récupère les cartes liées au deck
 */
function getCards() {
    if (deck.value == undefined || deck.value.id == 0)
        return;

    console.log("getting cards for deck: " + deck.value.id);    

    axiosInstance
    .get<Card[]>("/api/cards/" + deck.value.id)
    .then(resp => {
        cardList.value = resp.data;
    })
    .catch(err => console.error("Error getting cards for deck : " + err));
}

/**
 * Créé un deck ou update le deck existant
 */
function saveDeck() {
    axiosInstance
    .post("/api/deck", {
        deck: deck.value
    })
    .then(resp => {
        //Si nouveau deck alors on se rend sur son url
        console.log('updated')
        if (deck.value.id == 0) {
            router.push('/deck/' + resp.data.id);
        }
    })
    .catch(err => console.error("Error saving deck : " + err))
}

function saveCard() {

}
</script>

<template>
<div class="container">
    <div class="deck-details">
        <label for="label">Titre :</label>
        <input type="text" name="label" v-model="deck.label"/>

        <label for="description">Description :</label>
        <textarea name="description" v-model="deck.description"></textarea>

        <label for="active">Actif :</label>
        <input type="checkbox" name="active" v-model="deck.active" />

        <label for="public">Publique :</label>
        <input type="checkbox" name="public" v-model="deck.public" />
    </div>

    <div class="cards-container">
        <p v-if="cardList.length < 1">Aucune carte dans ce deck</p>
        <CardItem
            v-for="card in cardList"
            :card="card"
            :deletable="true"
        ></CardItem>
    </div>

    <div class="buttons">
        <button>Ajouter une carte</button>
        <button @click="saveDeck">Sauvegarder</button>
    </div>
</div>
</template>

<style>
.container {
    width: 100%;

    display: flex;
    flex-direction: column;
    gap: 10px;
}

.deck-details {
    width: 100%;

    display: flex;
    flex-direction: column;
    gap: 10px;
}
</style>