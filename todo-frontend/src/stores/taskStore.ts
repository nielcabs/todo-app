import { defineStore } from 'pinia'
import axios from 'axios'

export interface Task {
  id: number
  title: string
  description?: string
  priority: 'low' | 'medium' | 'high'
  category?: string
  due_date?: string
  is_done: boolean
}

export const useTaskStore = defineStore('task', {
  state: () => ({
    tasks: [] as Task[],
  }),

  actions: {
    async fetchTasks() {
      try {
        const res = await axios.get<Task[]>('http://localhost:8000/api/tasks')
        this.tasks = res.data
      } catch (error) {
        console.error('Failed to fetch tasks:', error)
      }
    },

    async addTask(task: Omit<Task, 'id'>) {
      try {
        const res = await axios.post<Task>('http://localhost:8000/api/tasks', task)
        this.tasks.push(res.data)
      } catch (error) {
        console.error('Failed to add task:', error)
      }
    },
    
    async deleteTask(id: number) {
    try {
        await axios.delete(`http://localhost:8000/api/tasks/${id}`)
        this.tasks = this.tasks.filter(task => task.id !== id)
    } catch (error) {
        console.error('Failed to delete task:', error)
    }
    }

,

    async updateTask(task: Task) {
      try {
        await axios.put(`http://localhost:8000/api/tasks/${task.id}`, task)
        await this.fetchTasks()
      } catch (error) {
        console.error('Failed to update task:', error)
      }
    },
  },
})
