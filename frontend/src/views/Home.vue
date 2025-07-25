<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Olá, {{ store.user.name }}</h1>
    
    <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
      <h2 class="text-lg font-medium text-gray-700 mb-2">Total de usuários</h2>
      <p class="text-4xl font-bold text-blue-600">{{ total }}</p>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useUserStore } from '../stores/userStore'

const store = useUserStore()
const total = computed(() => store.users.length)

onMounted(async () => {
  await store.fetchUsers()
})
</script>
