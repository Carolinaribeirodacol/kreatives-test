<template>
  <div>
    <h2>Usuários</h2>
    <input v-model="search" placeholder="Buscar" @input="fetchUsers" />

    <ul>
      <li v-for="user in users" :key="user.id">
        {{ user.name }} - {{ user.email }}

        <button @click="edit(user)">Editar</button>

        <button @click="confirmDelete(user.id)">Deletar</button>
      </li>
    </ul>

    <button @click="showAdd = true">Adicionar Usuário</button>

    <!-- Modais -->
    <div v-if="showAdd">
      <h3>Novo usuário</h3>

      <form @submit.prevent="submitAdd">
        <input v-model="newUser.name" placeholder="Nome" />

        <input v-model="newUser.email" placeholder="Email" />

        <input v-model="newUser.password" placeholder="Senha" type="password" />

        <div v-if="isAdmin">
          <label class="block text-sm font-medium text-gray-700"
            >Tipo de usuário</label
          >
          <select
            v-model="form.role_slug"
            class="mt-1 block w-full border rounded p-2"
          >
            <option value="usuario">Usuário</option>
            <option value="adm">Administrador</option>
          </select>
        </div>

        <button type="submit">Salvar</button>

        <button @click="showAdd = false">Cancelar</button>
      </form>
    </div>

    <div v-if="showEdit">
      <h3>Editar usuário</h3>
      <form @submit.prevent="submitEdit">
        <input v-model="userToEdit.name" placeholder="Nome" />
        <input v-model="userToEdit.email" placeholder="Email" />
        <button type="submit">Atualizar</button>
        <button @click="showEdit = false">Cancelar</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useUserStore } from "../stores/userStore";

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
  role_slug: "",
});

const fetchUsers = async () => {
  await store.fetchUsers(search.value);
  users.value = store.users;
};

const submitAdd = async () => {
  await store.addUser(newUser.value);
  newUser.value = { name: "", email: "", password: "" };
  showAdd.value = false;
};

const edit = (user) => {
  userToEdit.value = { ...user };
  showEdit.value = true;
};

const submitEdit = async () => {
  await store.updateUser(userToEdit.value.id, userToEdit.value);
  showEdit.value = false;
};

const confirmDelete = async (id) => {
  if (confirm("Tem certeza que deseja excluir?")) {
    await store.deleteUser(id);
    await fetchUsers();
  }
};

onMounted(fetchUsers);
</script>
