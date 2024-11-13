<template> 
    <div> 
        <h2>My To-Do List</h2> 
        <form @submit.prevent="addTask"> 
            <input v-model="newTask" type="text" placeholder="Add a new task" required /> 
            <button type="submit">Add Task</button> 
        </form> 
        <ul> 
            <li v-for="task in tasks" :key="task.id"> 
                <input type="checkbox" v-model="task.completed" @change="updateTask(task)" 
/> 
                {{ task.task }} 
                <button @click="deleteTask(task.id)">Delete</button> 
            </li> 
        </ul> 
    </div> 
</template> 
 
<script> 
export default { 
    data() { 
        return { 
            tasks: [], 
            newTask: '' 
        }; 
    }, 
    mounted() { 
        this.fetchTasks(); 
    }, 
    methods: { 
        fetchTasks() { 
            axios.get('/api/tasks').then(response => { 
                this.tasks = response.data; 
            }); 
        }, 
        addTask() { 
            axios.post('/api/tasks', { task: this.newTask }).then(response => { 
                this.tasks.push(response.data); 
                this.newTask = ''; 
            }); 
        }, 
        updateTask(task) { 
            axios.patch(`/api/tasks/${task.id}`, { completed: task.completed }); 
        }, 
        deleteTask(id) { 
            axios.delete(`/api/tasks/${id}`).then(() => { 
                this.tasks = this.tasks.filter(task => task.id !== id); 
            }); 
        } 
    } 
}; 
</script>