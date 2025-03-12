<template>
    <div>
      <h1>Dashboard</h1>
      <p v-if="user">Welcome, {{ user.name }}</p>
      <p v-else>Please log in</p>

      <!-- Show Task List -->
      <TaskList v-if="user" />

      <button @click="logout">Logout</button>
    </div>
  </template>

  <script>
  import axios from "axios";
  import TaskList from "./TaskList.vue"; // Import TaskList component

  export default {
    components: {
      TaskList,
    },
    data() {
      return {
        user: null,
      };
    },
    async mounted() {
      try {
        let response = await axios.get("http://127.0.0.1:8000/api/user", {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        });
        this.user = response.data;
      } catch (err) {
        this.$router.push("/login"); // Redirect if not authenticated
      }
    },
    methods: {
      async logout() {
        await axios.post(
          "http://127.0.0.1:8000/api/logout",
          {},
          {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
          }
        );
        localStorage.removeItem("token");
        this.$router.push("/login");
      },
    },
  };
  </script>
