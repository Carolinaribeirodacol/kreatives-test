import { defineStore } from 'pinia'
import api from '../services/api'

export const useUserStore = defineStore('user', {
  state: () => ({
    token: localStorage.getItem('token') || '',
    users: [],
    user: JSON.parse(localStorage.getItem('user')) || null,
  }),

   // Vou usar para acessar no componente e validar
  getters: {
    isAuthenticated: (state) => !!state.token,
    isAdmin: (state) => state.user?.role_slug === 'adm',
  },

  actions: {
    async login(email, password) {
      const response = await api.post('/login', { email, password })

      this.token = response.data.token
      localStorage.setItem('token', this.token)
      
      const me = await api.get('/me')
      this.user = me.data

      localStorage.setItem('user', JSON.stringify(this.user))
    },

    async logout() {
      this.token = ''
      this.user = null
      
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    },

    async fetchUsers(search = "") {
      try {
        const params = search ? { search } : {};
        const response = await api.get("/users", { params });
        this.users = response.data;
      } catch (error) {
        console.error("Erro ao buscar usuários:", error);
      }
    },

    async addUser(data) {
      await api.post('/users', data)
      await this.fetchUsers()
    },

    async updateUser(id, data) {
      await api.put(`/users/${id}`, data)
      await this.fetchUsers()
    },

    async deleteUser(id) {
      await api.delete(`/users/${id}`)
      await this.fetchUsers()
    }
  },
})
