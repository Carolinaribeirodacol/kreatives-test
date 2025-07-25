<template>
  <div class="min-h-screen flex flex-col">
    <nav class="bg-gray-800 text-white p-4 flex space-x-4">
      <button @click="page = 'home'" class="px-3 py-2 rounded">
        Home
      </button>

      <button v-if="isLoggedIn" @click="page = 'users'" class="px-3 py-2 rounded">
        Usuários
      </button>

      <button v-if="!isLoggedIn" @click="page = 'login'" class="px-3 py-2 rounded">
        Login
      </button>

      <button v-else @click="logout" class="px-3 py-2 rounded">
        Sair
      </button>
    </nav>

    <main class="flex-grow p-6 bg-gray-50">
      <Home v-if="page === 'home'" />
      <Users v-else-if="page === 'users' && isLoggedIn" :is-admin="isAdmin" />
      <Login v-else-if="page === 'login'" @loggedIn="handleLogin" />
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import Home from './views/Home.vue'
import Users from './views/Users.vue'
import Login from './views/Login.vue'
import { useUserStore } from './stores/userStore'

const page = ref('home')
const store = useUserStore()

const isAdmin = computed(() => !!store.token)
const isAdmin = computed(() => store.user?.role_slug === 'adm')

function handleLogin() {
  page.value = 'home'
}

function logout() {
  store.logout()
  page.value = 'login'
}
</script>
