import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import DeckView from '../views/DeckView.vue'
import RevisionView from '@/views/RevisionView.vue'
import LoginView from '@/views/LoginView.vue'
import DeckDetailsView from '@/views/DeckDetailsView.vue'
import AddCardView from '@/views/AddCardView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/decks/:id?',
      name: 'decks',
      component: DeckView
    },
    {
      path: '/deck/:id?',
      name: 'deck details',
      component: DeckDetailsView
    },
    {
      path: '/card/:id',
      name: 'add card',
      component: AddCardView
    },
    {
      path: '/revision',
      name: 'revision',
      component: RevisionView
    }
  ]
})

export default router
