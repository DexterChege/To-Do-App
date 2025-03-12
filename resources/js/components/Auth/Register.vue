<template>
    <div>
      <h2>Register</h2>
      <form @submit.prevent="register">
        <input v-model="name" type="text" placeholder="Name" required />
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Password" required />
        <input v-model="password_confirmation" type="password" placeholder="Confirm Password" required />
        <button type="submit">Register</button>
      </form>
      <p v-if="error" style="color: red;">{{ error }}</p>
      <p v-if="success" style="color: green;">{{ success }}</p>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        error: '',
        success: ''
      };
    },
    methods: {
      async register() {
        this.error = '';
        this.success = '';

        try {
          let response = await axios.post('http://127.0.0.1:8000/api/register', {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation
          }, { withCredentials: true });

          this.success = 'Registration successful! Redirecting to login...';

          setTimeout(() => {
            this.$router.push('/login'); // Redirect to login after registration
          }, 2000);
        } catch (err) {
          if (err.response && err.response.data) {
            this.error = err.response.data.message || 'Registration failed. Please try again.';
          } else {
            this.error = 'Something went wrong. Try again later.';
          }
        }
      }
    }
  };
  </script>
