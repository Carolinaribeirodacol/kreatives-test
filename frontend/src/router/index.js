import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/views/Login.vue'
import Users from '@/views/Users.vue'
import Home from '@/views/Home.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  { path: '/users', component: Users },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router