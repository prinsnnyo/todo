<template>
    <Head title="Dashboard" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Dashboard
        </h2>
      </template>
  
      <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
              You're logged in!
            </div>
          </div>
        </div>
      </div>
  
      <!-- Todo List Component -->
      <div class="mt-6">
        <div class="p-6 bg-white rounded-lg shadow-lg">
          <h3 class="mb-4 text-2xl font-semibold text-gray-700">My Todo List</h3>
  
          <!-- Add New Task Form -->
          <form @submit.prevent="addTask" class="mb-4">
            <input
              v-model="newTask"
              type="text"
              placeholder="Add a new task"
              class="w-full p-2 mb-2 border border-gray-300 rounded-md"
              required
            />
            <button
              type="submit"
              :disabled="newTask.trim() === ''"
              class="px-4 py-2 text-white bg-blue-500 rounded-md disabled:bg-gray-400"
            >
              Add Task
            </button>
          </form>
  
          <!-- Task List -->
          <ul class="space-y-4">
            <li
              v-for="task in tasks"
              :key="task.id"
              class="flex items-center justify-between p-3 bg-gray-100 rounded-md"
            >
              <div class="flex items-center">
                <!-- Checkbox to mark task as completed -->
                <input
                  type="checkbox"
                  v-model="task.completed"
                  @change="updateTask(task)"
                  class="mr-4"
                />
                <span
                  :class="{
                    'line-through text-gray-400': task.completed,
                    'text-black': !task.completed
                  }"
                  @dblclick="editTask(task)"
                >
                  {{ task.task }}
                </span>
              </div>
  
              <!-- Task Actions (Edit and Delete) -->
              <div class="flex space-x-2">
                <button @click="editTask(task)" v-if="!task.editing" class="text-blue-500">Edit</button>
                <button
                  @click="deleteTask(task.id)"
                  class="text-red-500"
                >
                  Delete
                </button>
              </div>
  
              <!-- Input field for editing task -->
              <input
                v-if="task.editing"
                type="text"
                v-model="task.task"
                @blur="saveTask(task)"
                @keyup.enter="saveTask(task)"
                class="w-2/3 p-2 border rounded-md"
              />
            </li>
          </ul>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const newTask = ref('');
  const tasks = ref([
   
  ]);
  
  // Add a new task to the list
  const addTask = () => {
    if (newTask.value.trim()) {
      tasks.value.push({
        id: Date.now(),
        task: newTask.value,
        completed: false,
        editing: false,
      });
      newTask.value = ''; // Clear the input after adding
    }
  };
  
  // Delete a task from the list
  const deleteTask = (id) => {
    tasks.value = tasks.value.filter((task) => task.id !== id);
  };
  
  // Mark task as completed or update task completion status
  const updateTask = (task) => {
    // You can add logic here to update the task in the backend
  };
  
  // Edit task text
  const editTask = (task) => {
    task.editing = true;
  };
  
  // Save edited task text
  const saveTask = (task) => {
    task.editing = false;
  };
  </script>
  
  <style scoped>
  /* Styles for the Todo List */
  ul {
    list-style-type: none;
    padding-left: 0;
  }
  
  li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    margin-bottom: 1rem;
    background-color: #f7fafc;
    border-radius: 0.375rem;
  }
  
  button:disabled {
    cursor: not-allowed;
    opacity: 0.5;
  }
  
  button {
    transition: background-color 0.3s ease;
  }
  
  button:hover {
    background-color: #e2e8f0;
  }
  
  button.text-blue-500 {
    color: #4299e1;
  }
  
  button.text-red-500 {
    color: #f56565;
  }
  
  button.text-blue-500:hover {
    color: #2b6cb0;
  }
  
  button.text-red-500:hover {
    color: #e53e3e;
  }
  </style>
  