<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
      <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Login</h2>

      <form @submit.prevent="submitLogin" class="space-y-4">
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        />

        <input
          v-model="password"
          type="password"
          placeholder="Senha"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          required
        />

        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
        >
          Entrar
        </button>

        <p v-if="errorMessage" class="text-red-600 text-sm text-center mt-2">
          {{ errorMessage }}
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useUserStore } from '../stores/userStore'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const emit = defineEmits(['loggedIn'])

const userStore = useUserStore()

const submitLogin = async () => {
  try {
    await userStore.login(email.value, password.value)
    emit('loggedIn')
  } catch (error) {
    errorMessage.value = 'Credenciais inválidas'
  }
}
</script>
