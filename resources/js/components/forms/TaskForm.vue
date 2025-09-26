<template>
  <div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-xl font-semibold mb-4">Add New Task</h2>
    <form @submit.prevent="addTask">
      <div class="mb-4">
        <label class="block text-sm font-medium mb-2">Task Title</label>
        <input
          v-model="newTask.task_title"
          type="text"
          class="w-full p-2 border border-gray-300 rounded"
          required
        />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium mb-2">Task Content</label>
        <textarea
          v-model="newTask.task_content"
          class="w-full p-2 border border-gray-300 rounded"
          rows="3"
          required
        ></textarea>
      </div>
      <button
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Add Task
      </button>
    </form>
  </div>
</template>

<script>
export default {
  name: "TaskForm",
  emits: ["task-added"],
  data() {
    return {
      newTask: {
        task_title: "",
        task_content: "",
      },
    };
  },
  methods: {
    async addTask() {
      try {
        await axios.post("/api/tasks", this.newTask);
        this.newTask = { task_title: "", task_content: "" };
        this.$emit("task-added");
      } catch (error) {
        console.error("Error adding task:", error);
      }
    },
  },
};
</script>