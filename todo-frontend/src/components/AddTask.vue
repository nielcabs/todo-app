<template>
  <form @submit.prevent="handleAdd">
    <input v-model="title" placeholder="Task title" required />
    <select v-model="priority" required>
      <option disabled value="">Select priority</option>
      <option value="low">Low</option>
      <option value="medium">Medium</option>
      <option value="high">High</option>
    </select>
    <button type="submit">Add Task</button>
  </form>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useTaskStore } from '@/stores/taskStore'

const store = useTaskStore()
const title = ref('')
const priority = ref<'low' | 'medium' | 'high' | ''>('')

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
</script>
