<template>
    <div>
      <h1>To-Do List</h1>
      <input v-model="newTask" placeholder="Enter a task" />
      <button @click="addTask">Add Task</button>
      <ul>
        <li v-for="task in tasks" :key="task.id">
          <span :class="{ completed: task.completed }">{{ task.task }}</span>
          <button @click="toggleTask(task)">✔</button>
          <button @click="deleteTask(task.id)">❌</button>
        </li>
      </ul>
    </div>
  </template>

  <script>
  import axios from "axios";

  export default {
    data() {
      return {
        tasks: [],
        newTask: "",
      };
    },
    methods: {
      async fetchTasks() {
        try {
          const userId = localStorage.getItem("user_id");
          let response = await axios.get("http://127.0.0.1:8000/api/tasks", {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
          });
          this.tasks = response.data;
        } catch (error) {
          console.error(error);
        }
      },
      async addTask() {
        if (!this.newTask) return;
        try {
          const userId = localStorage.getItem("user_id");
          let response = await axios.post(
            "http://127.0.0.1:8000/api/tasks",
            { task: this.newTask, description: "", completed: false},
            {
              headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
            }
          );
          this.tasks.push(response.data);
          this.newTask = "";
        } catch (error) {
        if (error.response && error.response.status === 422) {
            console.error('Validation errors:', error.response.data.errors);
        } else {
            console.error(error);
        }
    }
      },
      async toggleTask(task) {
        try {
          await axios.put(
            `http://127.0.0.1:8000/api/tasks/${task.id}`,
            { completed: !task.completed },
            {
              headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
            }
          );
          task.completed = !task.completed;
        } catch (error) {
          console.error(error);
        }
      },
      async deleteTask(id) {
        try {
          await axios.delete(`http://127.0.0.1:8000/api/tasks/${id}`, {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
          });
          this.tasks = this.tasks.filter(task => task.id !== id);
        } catch (error) {
          console.error(error);
        }
      },
    },
    mounted() {
      this.fetchTasks();
    },
  };
  </script>

  <style>
  .completed {
    text-decoration: line-through;
  }
  </style>
