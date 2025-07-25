<template>
  <div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Usuários</h2>

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
            :disabled="!isAdmin"
            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
          >
            Deletar
          </button>
        </div>
      </li>
    </ul>

    <button
      @click="showAdd = true"
      :disabled="!isAdmin"
      class="mb-6 px-4 py-2 rounded-lg transition text-white bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
    >
      Adicionar Usuário
    </button>

    <!-- CARD DE CRIAÇÃO -->
    <div v-if="showAdd" class="bg-white p-6 rounded-lg shadow-md mb-6">
      <h3 class="text-lg font-semibold mb-4">Novo usuário</h3>
      <form @submit.prevent="submitAdd" class="space-y-4">
        <input
          v-model="newUser.name"
          placeholder="Nome"
          required
          class="w-full p-2 border border-gray-300 rounded"
        />

        <input
          v-model="newUser.email"
          placeholder="Email"
          type="email"
          required
          class="w-full p-2 border border-gray-300 rounded"
        />

        <input
          v-model="newUser.password"
          placeholder="Senha"
          type="password"
          required
          class="w-full p-2 border border-gray-300 rounded"
        />

        <div v-if="isAdmin">
          <label class="text-sm font-medium text-gray-700">Tipo de usuário</label>
          <select
            v-model="newUser.role_slug"
            class="w-full p-2 border border-gray-300 rounded"
            required
          >
            <option value="usuario">Usuário</option>
            <option value="adm">Administrador</option>
          </select>
        </div>

        <div class="flex justify-end space-x-2">
          <button
            type="submit"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
          >
            Salvar
          </button>
          <button
            type="button"
            @click="showAdd = false"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
          >
            Cancelar
          </button>
        </div>
      </form>
    </div>

    <!-- CARD DE EDIÇÃO -->
    <div v-if="showEdit" class="bg-white p-6 rounded-lg shadow-md">
      <h3 class="text-lg font-semibold mb-4">Editar usuário</h3>
      <form @submit.prevent="submitEdit" class="space-y-4">
        <input
          v-model="userToEdit.name"
          placeholder="Nome"
          required
          class="w-full p-2 border border-gray-300 rounded"
        />
        <input
          v-model="userToEdit.email"
          placeholder="Email"
          type="email"
          required
          class="w-full p-2 border border-gray-300 rounded"
        />

        <div v-if="isAdmin">
          <label class="text-sm font-medium text-gray-700">Tipo de usuário</label>
          <select
            v-model="userToEdit.role_slug"
            class="w-full p-2 border border-gray-300 rounded"
            required
          >
            <option value="usuario">Usuário</option>
            <option value="adm">Administrador</option>
          </select>
        </div>

        <div class="flex justify-end space-x-2">
          <button
            type="submit"
            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600"
          >
            Atualizar
          </button>

          <button
            type="button"
            @click="showEdit = false"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
          >
            Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useUserStore } from "../stores/userStore";
import { maskEmail } from '../utils/masks.js'

const store = useUserStore();
const search = ref("");
const users = ref([]);
const showAdd = ref(false);
const showEdit = ref(false);
const userToEdit = ref(null);

const newUser = ref({
  name: "",
  email: "",
  password: "",
  role_slug: "usuario",
});

const isAdmin = computed(() => store.isAdmin);

const fetchUsers = async () => {
  await store.fetchUsers(search.value);
  users.value = store.users;
};

const submitAdd = async () => {
  try {
    await store.addUser(newUser.value);

    newUser.value = { name: "", email: "", password: "", role_slug: "usuario" };
    showAdd.value = false;

    await fetchUsers();
  } catch (error) {
    if (error.response?.status === 403) {
      alert('Você não tem permissão para criar usuários.');
    }
  }
};

const edit = (user) => {
  userToEdit.value = { ...user };
  showEdit.value = true;
};

const submitEdit = async () => {
  try {
    await store.updateUser(userToEdit.value.id, userToEdit.value);

    showEdit.value = false;

    await fetchUsers();
  } catch (error) {
    if (error.response?.status === 403) {
      alert('Você não tem permissão para editar usuários.');
    }
  }
};

const confirmDelete = async (id) => {
  if (confirm("Tem certeza que deseja excluir?")) {
    try {
      await store.deleteUser(id);

      await fetchUsers();
    } catch (error) {
      if (error.response?.status === 403) {
        alert('Você não tem permissão para excluir usuários.');
      }
    }
  }
};

onMounted(fetchUsers);
</script>
