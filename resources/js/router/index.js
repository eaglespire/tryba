import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    {
      path: '/',
      name: 'Home',
      component: () => import('../views/Home.vue')
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('../views/Home.vue')
    },
    {
      path: '/register',
      name: 'Register',
      component: () => import('../views/Home.vue')
    },
    {
      path: '/pricing',
      name: 'Pricing',
      component: () => import('../views/Pricing.vue')
    },
    {
      path: '/features',
      name: 'Features',
      component: () => import('../views/Features.vue')
    },
    {
      path: '/support',
      name: 'Support',
      component: () => import('../views/Support.vue')
    },
    {
      path: '/checkout/open-banking/:id',
      name: 'Checkout',
      component: () => import('../views/Checkout.vue')
    },

  ]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 }
    },
})


export default router
