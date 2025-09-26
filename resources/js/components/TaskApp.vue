<template>
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Task Manager</h1>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
      <h2 class="text-xl font-semibold mb-4">Add New Task</h2>
      <form @submit.prevent="addTask">
        <div class="mb-4">
          <label class="block text-sm font-medium mb-2">Task Title</label>
          <input
            v-model="newTask.task_title"
            type="text"
            class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
            placeholder="Enter task title"
            maxlength="255"
          />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium mb-2">Task Content</label>
          <textarea
            v-model="newTask.task_content"
            class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            rows="4"
            required
            placeholder="Enter task description"
          ></textarea>
        </div>
        <div class="flex gap-2">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200"
            :disabled="isSubmitting"
          >
            <span v-if="isSubmitting">Adding...</span>
            <span v-else>Add Task</span>
          </button>
          <button
            type="button"
            @click="resetForm"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors duration-200"
          >
            Clear
          </button>
        </div>
      </form>
    </div>

    <TaskList :formatDate="formatDate" ref="taskList" />
  </div>
</template>

<script>
import TaskList from "./TaskList.vue";

export default {
  name: "TaskApp",
  components: {
    TaskList,
  },
  data() {
    return {
      isSubmitting: false,
      newTask: {
        task_title: "",
        task_content: "",
      },
    };
  },
  methods: {
    async addTask() {
      this.isSubmitting = true;
      try {
        const response = await axios.post("/api/tasks", this.newTask);
        if (response.status === 201) {
          this.resetForm();
          this.$refs.taskList.fetchTasks();
          console.log("Task added successfully!");
        }
      } catch (error) {
        console.error("Error adding task:", error);
        if (error.response?.status === 422) {
          console.error("Validation errors:", error.response.data.errors);
        }
      } finally {
        this.isSubmitting = false;
      }
    },

    resetForm() {
      this.newTask = {
        task_title: "",
        task_content: "",
      };
    },

    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString("pt-BR", {
        year: "numeric",
        month: "2-digit",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      });
    },
  },
};
</script>