<template>
  <div class="min-h-screen flex flex-col">
    <nav class="bg-gray-800 text-white p-4 flex justify-between items-center">
      <div class="flex space-x-4">
        <span v-if="isLoggedIn">
          <button
            @click="page = 'home'"
            class="px-3 py-2 rounded hover:bg-gray-700"
          >
            Home
          </button>
  
          <button
            @click="page = 'users'"
            class="px-3 py-2 rounded hover:bg-gray-700"
          >
            Usuários
          </button>
        </span>

        <button
          v-if="!isLoggedIn"
          @click="page = 'login'"
          class="px-3 py-2 rounded hover:bg-gray-700"
        >
          Login
        </button>
      </div>

      <div
        v-if="isLoggedIn"
        class="flex flex-col items-center text-right space-y-2"
      >
        <span class="text-sm text-gray-200">{{ user?.name }}</span>
        
        <button
          @click="logout"
          class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition"
        >
          Sair
        </button>
      </div>
    </nav>

    <main class="flex-grow p-6 bg-gray-50">
      <Home v-if="page === 'home'" />
      <Users v-else-if="page === 'users' && isLoggedIn" :is-admin="isAdmin" />
      <Login v-else-if="page === 'login'" @loggedIn="handleLogin" />
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import Home from "./views/Home.vue";
import Users from "./views/Users.vue";
import Login from "./views/Login.vue";
import { useUserStore } from "./stores/userStore";

const page = ref("home");
const store = useUserStore();

const isLoggedIn = computed(() => store.isAuthenticated);
const user = computed(() => store.user);
const isAdmin = computed(() => store.isAdmin);

function handleLogin() {
  page.value = "home";
}

function logout() {
  store.logout();
  page.value = "login";
}
</script>
