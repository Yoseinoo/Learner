<script setup lang="ts">
import type { Deck } from '@/models/Deck'
import axiosInstance from '@/modules/axios';
import router from '@/router';

const props = defineProps<{
    deck: Deck
}>()

function remove() {
    axiosInstance
    .delete("/api/deck/" + props.deck.id)
    .then(resp => {
        //TODO: Emit event that deck item has been removed instead of reloading page
        router.go(0);
    })
    .catch(err => console.error("error deleting deck with id :" + props.deck.id))
}

function toDeck() {
    router.push('/deck/' + props.deck.id);
}
</script>

<template>
    <div class="deck">
        <h1>{{ deck.label }}</h1>
        <p>{{ deck.description }}</p>
        <h3>{{ deck.active ? 'activé' : 'desactivé' }}</h3>
        <button @click="toDeck">Voir</button>
        <button @click="remove">Supprimer</button>
    </div>
</template>