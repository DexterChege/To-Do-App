<template>
    <div>
      <nav v-if="$route.path !== '/'">
        <router-link to="/login">Login</router-link> |
        <router-link to="/register">Register</router-link> |
        <router-link to="/dashboard">Dashboard</router-link>
      </nav>

      <router-view />
    </div>
  </template>

  <script>
  export default {
    name: "App",
  };
  </script>

  <style>
  nav {
    padding: 1rem;
    background-color: #f8f9fa;
  }

  nav a {
    margin-right: 15px;
    text-decoration: none;
    color: #007bff;
  }

  nav a:hover {
    text-decoration: underline;
  }
  </style>
