<template>
  <div
    v-if="visible"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
  >
    <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-lg">
      <h3 class="text-lg font-semibold mb-4">Editar usuário</h3>

      <form @submit.prevent="submit" class="space-y-4">
        <input v-model="form.name" placeholder="Nome" required class="w-full p-2 border rounded" />
        <input v-model="form.email" type="email" placeholder="Email" required class="w-full p-2 border rounded" />

        <div v-if="isAdmin">
          <label class="block text-sm font-medium">Tipo de usuário</label>
          <select v-model="form.role_slug" required class="w-full p-2 border rounded">
            <option value="usuario">Usuário</option>
            <option value="adm">Administrador</option>
          </select>
        </div>

        <div class="flex justify-end space-x-2 pt-4">
          <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Atualizar
          </button>
          <button @click="$emit('close')" type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
            Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useUserStore } from '../stores/userStore'

const props = defineProps({
  visible: Boolean,
  user: Object,
  isAdmin: Boolean
})

const emit = defineEmits(['close', 'updated'])

const store = useUserStore()
const form = ref({ name: '', email: '', role_slug: 'usuario' })

watch(
  () => props.user,
  (user) => {
    if (user) {
      form.value = { ...user }
    }
  },
  { immediate: true }
)

const submit = async () => {
  try {
    await store.updateUser(form.value.id, form.value)
    emit('updated')
    emit('close')
  } catch (e) {
    if (e.response?.status === 403) {
      alert('Você não tem permissão para editar usuários.')
    }
  }
}
</script>