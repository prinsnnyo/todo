<template>
    <div>
      <h2>My To-Do List</h2>
      <!-- Form to add a new task -->
      <form @submit.prevent="addTask" class="task-form">
        <input
          v-model="newTask"
          type="text"
          placeholder="Add a new task"
          required
          :class="{ 'input-error': newTask.trim() === '' }"
        />
        <button type="submit" :disabled="newTask.trim() === ''">Add Task</button>
      </form>
  
      <!-- Task List -->
      <ul class="task-list">
        <li v-for="task in tasks" :key="task.id" :class="{ completed: task.completed }">
          <div class="task-item">
            <!-- Checkbox to mark task as completed -->
            <input
              type="checkbox"
              v-model="task.completed"
              @change="updateTask(task)"
            />
            <!-- Task text with edit functionality -->
            <span v-if="!task.editing" @dblclick="editTask(task)">
              {{ task.task }}
            </span>
            <input
              v-if="task.editing"
              type="text"
              v-model="task.task"
              @blur="saveTask(task)"
              @keyup.enter="saveTask(task)"
            />
            <!-- Buttons for edit and delete -->
            <div class="actions">
              <button @click="editTask(task)" v-if="!task.editing">Edit</button>
              <button @click="deleteTask(task.id)">Delete</button>
            </div>
          </div>
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
    mounted() {
      this.fetchTasks();
    },
    methods: {
  fetchTasks() {
    axios.get('/api/tasks').then(response => {
      this.tasks = response.data;
    }).catch(error => {
      console.error("Error fetching tasks:", error.response);
    });
  },
  addTask() {
    axios.post('/api/tasks', { task: this.newTask })
      .then(response => {
        this.tasks.push(response.data);
        this.newTask = '';
      })
      .catch(error => {
        console.error("Error adding task:", error.response);
      });
  },
  updateTask(task) {
    axios.patch(`/api/tasks/${task.id}`, { completed: task.completed })
      .catch(error => {
        console.error("Error updating task:", error.response);
      });
  },
  deleteTask(id) {
    axios.delete(`/api/tasks/${id}`)
      .then(() => {
        this.tasks = this.tasks.filter(task => task.id !== id);
      })
      .catch(error => {
        console.error("Error deleting task:", error.response);
      });
  },
  editTask(task) {
    this.tasks.forEach((t) => (t.editing = false)); // Close other edits
    task.editing = true;
  },
  saveTask(task) {
    task.editing = false;
    axios.patch(`/api/tasks/${task.id}`, { task: task.task });
  }
}
  };
  </script>
  
  <style scoped>
  .task-form {
    margin-bottom: 1em;
  }
  
  .input-error {
    border: 1px solid red;
  }
  
  .task-list {
    list-style: none;
    padding: 0;
  }
  
  .task-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5em;
    border-bottom: 1px solid #ddd;
  }
  
  .task-item.completed span {
    text-decoration: line-through;
    color: gray;
  }
  
  .actions button {
    margin-left: 0.5em;
  }
  
  button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
  }
  </style>
  