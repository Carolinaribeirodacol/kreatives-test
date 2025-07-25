<template>
  <div class="login">
    <h2>Login</h2>
    <form @submit.prevent="submitLogin">
      <input v-model="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Senha" />
      <button type="submit">Entrar</button>
      <p v-if="errorMessage" style="color: red">{{ errorMessage }}</p>
    </form>
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
