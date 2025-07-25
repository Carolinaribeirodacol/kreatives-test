<template>
  <div class="min-h-screen flex flex-col">
    <nav class="bg-gray-800 text-white p-4 flex space-x-4">
      <button @click="page = 'home'" class="px-3 py-2 rounded">Home</button> |
      <button @click="page = 'users'" class="px-3 py-2 rounded">
        Usuários
      </button>
      |
      <button @click="page = 'login'" class="px-3 py-2 rounded">Login</button>
    </nav>

    <main class="flex-grow p-6 bg-gray-50">
      <Home v-if="page === 'home'" />
      <Users v-else-if="page === 'users'" />
      <Login v-else-if="page === 'login'" @loggedIn="page = 'home'" />
    </main>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Home from "./views/Home.vue";
import Users from "./views/Users.vue";
import Login from "./views/Login.vue";

const page = ref("home");
</script>
