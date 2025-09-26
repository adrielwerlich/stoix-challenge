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

    <!-- Tasks List -->
    <div class="bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-xl font-semibold mb-4">Tasks ({{ tasks.length }})</h2>

      <div v-if="isLoading" class="text-center py-4">
        <div class="text-gray-500">Loading tasks...</div>
      </div>

      <div v-else-if="tasks.length === 0" class="text-center py-8">
        <div class="text-gray-500 text-lg">No tasks found.</div>
        <p class="text-gray-400 mt-2">
          Create your first task using the form above.
        </p>
      </div>

      <div v-else class="space-y-4">
        <div
          v-for="task in tasks"
          :key="task.id"
          class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200"
        >
          <div v-if="!task.editing">
            <!-- Display Mode -->
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <h3 class="font-semibold text-lg text-gray-800">
                  {{ task.task_title }}
                </h3>
                <p class="text-gray-600 mt-2 whitespace-pre-wrap">
                  {{ task.task_content }}
                </p>
                <div class="flex items-center mt-3 text-sm text-gray-500">
                  <span class="ml-4"
                    >Created: {{ formatDate(task.created_at) }}</span
                  >
                  <span v-if="task.updated_at !== task.created_at" class="ml-4">
                    Updated: {{ formatDate(task.updated_at) }}
                  </span>
                </div>
              </div>
              <div class="flex gap-2 ml-4">
                <button
                  @click="editTask(task)"
                  class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition-colors duration-200"
                >
                  Edit
                </button>
                <button
                  @click="deleteTask(task.id)"
                  class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors duration-200"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>

          <!-- Edit Mode -->
          <div v-else>
            <div class="mb-4">
              <label class="block text-sm font-medium mb-2">Task Title</label>
              <input
                v-model="task.task_title"
                class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                maxlength="255"
              />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium mb-2">Task Content</label>
              <textarea
                v-model="task.task_content"
                class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                rows="4"
              ></textarea>
            </div>
            <div class="flex gap-2">
              <button
                @click="updateTask(task)"
                class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600 transition-colors duration-200"
                :disabled="task.isUpdating"
              >
                <span v-if="task.isUpdating">Saving...</span>
                <span v-else>Save</span>
              </button>
              <button
                @click="cancelEdit(task)"
                class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600 transition-colors duration-200"
              >
                Cancel
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TaskApp",
  data() {
    return {
      tasks: [],
      isLoading: false,
      isSubmitting: false,
      newTask: {
        task_title: "",
        task_content: "",
      },
    };
  },
  mounted() {
    this.fetchTasks();
  },
  methods: {
    async fetchTasks() {
      this.isLoading = true;
      try {
        const response = await axios.get("/api/tasks");
        this.tasks = response.data;
      } catch (error) {
        console.error("Error fetching tasks:", error);
      } finally {
        this.isLoading = false;
      }
    },

    async addTask() {
      this.isSubmitting = true;
      try {
        const response = await axios.post("/api/tasks", this.newTask);
        if (response.status === 201) {
          this.resetForm();
          this.fetchTasks();
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

    editTask(task) {
      task.editing = true;
      task.originalTitle = task.task_title;
      task.originalContent = task.task_content;
    },

    cancelEdit(task) {
      task.editing = false;
      task.task_title = task.originalTitle;
      task.task_content = task.originalContent;
      delete task.originalTitle;
      delete task.originalContent;
    },

    async updateTask(task) {
      task.isUpdating = true;
      try {
        const response = await axios.put(`/api/tasks/${task.id}`, {
          task_title: task.task_title,
          task_content: task.task_content,
        });

        if (response.status === 200) {
          task.editing = false;
          delete task.originalTitle;
          delete task.originalContent;
          this.fetchTasks();
          console.log("Task updated successfully!");
        }
      } catch (error) {
        console.error("Error updating task:", error);
      } finally {
        task.isUpdating = false;
      }
    },

    async deleteTask(taskId) {
      if (confirm("Are you sure you want to delete this task?")) {
        try {
          const response = await axios.delete(`/api/tasks/${taskId}`);
          if (response.status === 200) {
            this.fetchTasks();
            console.log("Task deleted successfully!");
          }
        } catch (error) {
          console.error("Error deleting task:", error);
        }
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