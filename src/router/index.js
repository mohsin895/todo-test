import { createRouter, createWebHistory } from 'vue-router'
import Layout from '../layout/mainLayout.vue'
import Heropage from '../views/Login.vue'

import NotFound from '../views/Notfound.vue'

import TodotList from '../views/Todo.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
       path:'/',
       name:'login',
       component: Heropage
    },
    {
      path: '/todo',
      name: 'home',
      component: Layout,
      children:[
  

        {
          path:'todo/list',
          name:'TodotList',
          component: TodotList
        },
       
      ]
    },

   
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
  ]
})

export default router
