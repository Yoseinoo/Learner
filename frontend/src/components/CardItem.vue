<script setup lang="ts">
import type { Card } from '@/models/Card';
import axiosInstance from '@/modules/axios';
import router from '@/router';

const props = defineProps<{
    card: Card,
    deletable: boolean
}>()

const emit = defineEmits(['cardDeleted']);

function remove() {
    axiosInstance
    .delete("/api/card/" + props.card.id)
    .then(resp => {
        emit("cardDeleted");
    })
    .catch(err => console.error("error deleting card with id :" + props.card.id))
}
</script>

<template>
    <div class="card">
        <h1>{{ card.question }}</h1>
        <h3>{{ card.answer }}</h3>
        <p>{{ card.level }}</p>

        <button v-if="props.deletable" @click="remove">Supprimer</button>
    </div>
</template>

<style lang="css">
    .card {
        padding: 10px;
        border: solid 3px white;
        border-radius: 10px;
    }

    h1 {
        font-size: 22px;
    }

    h3 {
        font-size: 14px;
    }
</style>