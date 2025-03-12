<template>
    <div>
      <h2>Login</h2>
      <form @submit.prevent="login">
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Password" required />
        <button type="submit">Login</button>
      </form>
      <p v-if="error">{{ error }}</p>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        email: '',
        password: '',
        error: ''
      };
    },
    methods: {
      async login() {
        try {
          let response = await axios.post('http://127.0.0.1:8000/api/login', {
            email: this.email,
            password: this.password
          });

          localStorage.setItem('token', response.data.token);
          localStorage.setItem("user_id", response.data.user.id);
          this.$router.push('/dashboard'); // Redirect after login
        } catch (err) {
          this.error = 'Login failed. Check credentials.';
        }
      }
    }
  };
  </script>

