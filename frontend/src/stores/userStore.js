import { defineStore } from 'pinia'
import api from '../services/api'

export const useUserStore = defineStore('user', {
  state: () => ({
    token: localStorage.getItem('token') || '',
    users: [],
    user: null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  actions: {
    async login(email, password) {
      const res = await api.post('/login', { email, password })
      this.token = res.data.token
      localStorage.setItem('token', this.token)
    },

    async logout() {
      this.token = ''
      localStorage.removeItem('token')
    },

    async fetchUsers() {
      const res = await api.get('/users')
      this.users = res.data
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
