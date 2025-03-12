import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home.vue'; // New landing page
import Login from './components/Auth/Login.vue';
import Register from './components/Auth/Register.vue';
import Dashboard from './components/Dashboard.vue';
import TaskList from './components/TaskList.vue';

const routes = [
    { path: '/', component: Home }, // Show Home Page instead of redirecting to /login
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    {
        path: '/dashboard',
        component: Dashboard,
        meta: { requiresAuth: true }, // Protect the dashboard
        children: [ // Add a child route for tasks
            { path: 'tasks', component: TaskList }
        ]
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard for Authentication
router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('token'); // Check if token exists
    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/login'); // Redirect to login if not authenticated
    } else {
        next();
    }
});

export default router;
