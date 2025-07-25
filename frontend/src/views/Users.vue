<template>
  <div class="max-w-3xl mx-auto p-6">
    <div
      v-if="showSuccess"
      class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded"
    >
      {{ successMessage }}
    </div>

    <!-- MODAL DE CRIAÇÃO -->
    <UserCreateModal
      :visible="showAdd"
      :isAdmin="isAdmin"
      @close="showAdd = false"
      @created="
        () => {
          fetchUsers();
          showMessage('Usuário criado com sucesso!');
        }
      "
    />

    <!-- MODAL DE EDIÇÃO -->
    <UserEditModal
      :visible="showEdit"
      :user="userToEdit"
      :isAdmin="isAdmin"
      @close="showEdit = false"
      @updated="
        () => {
          fetchUsers();
          showMessage('Usuário atualizado com sucesso!');
        }
      "
    />

    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold mb-4 text-gray-800">Usuários</h2>

      <button
        @click="showAdd = true"
        :disabled="!isAdmin"
        class="mb-6 px-4 py-2 rounded-lg transition text-white bg-green-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
      >
        Criar Usuário
      </button>
    </div>

    <ul class="space-y-2 mb-6">
      <li
        v-for="user in users"
        :key="user.id"
        class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm"
      >
        <div>
          <p class="text-gray-800 font-medium">{{ user.name }}</p>
          <p class="text-sm text-gray-500">{{ maskEmail(user.email) }}</p>
        </div>

        <div class="flex space-x-2">
          <button
            @click="edit(user)"
            :disabled="!isAdmin"
            class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
          >
            Editar
          </button>

          <button
            @click="confirmDelete(user.id)"
            :disabled="!isAdmin || user.id === store.user.id"
            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
          >
            Deletar
          </button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useUserStore } from "../stores/userStore";
import { maskEmail } from "../utils/masks.js";
import UserCreateModal from "@/components/UserCreateModal.vue";
import UserEditModal from "@/components/UserEditModal.vue";

const store = useUserStore();
const search = ref("");
const users = ref([]);
const showAdd = ref(false);
const showEdit = ref(false);
const userToEdit = ref(null);

const isAdmin = computed(() => store.isAdmin);

const fetchUsers = async () => {
  await store.fetchUsers(search.value);
  users.value = store.users;
};

const edit = (user) => {
  userToEdit.value = { ...user };
  showEdit.value = true;
};

const successMessage = ref("");
const showSuccess = ref(false);

const showMessage = (message) => {
  successMessage.value = message;
  showSuccess.value = true;
  
  setTimeout(() => {
    showSuccess.value = false;
  }, 3000);
};

const confirmDelete = async (id) => {
  if (confirm("Tem certeza que deseja excluir?")) {
    try {
      await store.deleteUser(id);
      await fetchUsers();
      showMessage("Usuário excluído com sucesso!");
    } catch (error) {
      if (error.response?.status === 403) {
        alert("Você não tem permissão para excluir usuários.");
      }
    }
  }
};

onMounted(fetchUsers);
</script>
