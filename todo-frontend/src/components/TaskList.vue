<template>
  <div class="container">
    <h1>📝 To-Do List</h1>

    <form @submit.prevent="handleAdd" class="task-form">
      <input v-model="title" type="text" placeholder="Task title" required />
      <select v-model="priority" required>
        <option disabled value="">Priority</option>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
      </select>
      <button type="submit">Add Task</button>
    </form>

    <ul class="task-list">
      <li v-for="task in store.tasks" :key="task.id" :class="{ done: task.is_done }">
        <div>
          <strong>{{ task.title }}</strong>
          <span class="priority">{{ task.priority }}</span>
        </div>
        <div>
          <button @click="markDone(task)" :disabled="task.is_done">✔</button>
          <button @click="deleteTask(task.id)">🗑️</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useTaskStore } from '@/stores/taskStore'
import type { Task } from '@/stores/taskStore'

const store = useTaskStore()
const title = ref('')
const priority = ref<'low' | 'medium' | 'high' | ''>('')

store.fetchTasks()

const handleAdd = async () => {
  if (!title.value || !priority.value) return

  await store.addTask({
    title: title.value,
    priority: priority.value,
    is_done: false,
  })

  title.value = ''
  priority.value = ''
}

const markDone = (task: Task) => {
  if (!task.is_done) {
    store.updateTask({ ...task, is_done: true })
  }
}

const deleteTask = (id: number) => {
  store.deleteTask(id)
}

</script>

<style scoped>
body {
  background: #fdfdfd;
  font-family: sans-serif;
  color: #333;
}

.container {
  max-width: 500px;
  margin: 40px auto;
  padding: 20px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}

.task-form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

input,
select,
button {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 1rem;
}

button {
  background: #333;
  color: white;
  cursor: pointer;
  transition: background 0.2s;
}

button:hover {
  background: #111;
}

.task-list {
  list-style: none;
  padding: 0;
  margin-top: 20px;
}

.task-list li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  border-bottom: 1px solid #eee;
}

.task-list li.done strong {
  text-decoration: line-through;
  color: gray;
}

.priority {
  font-size: 0.8rem;
  margin-left: 10px;
  background: #eee;
  padding: 2px 6px;
  border-radius: 4px;
}
</style>
