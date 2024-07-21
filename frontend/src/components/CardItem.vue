<script setup lang="ts">
import type { Card } from '@/models/Card';

const props = defineProps<{
    card: Card,
    deletable: boolean
}>()

function remove() {

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
</style>