<template>
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Task Manager</h1>

    <TaskForm @task-added="fetchTasks" />
    <TaskGrid
      :tasks="tasks"
      @task-updated="fetchTasks"
      @task-deleted="fetchTasks"
    />
  </div>
</template>

<script>
import TaskForm from "../components/forms/TaskForm.vue";
import TaskGrid from "../components/TaskGrid.vue";

export default {
  name: "TaskList",
  components: {
    TaskForm,
    TaskGrid,
  },
  data() {
    return {
      tasks: [],
    };
  },
  mounted() {
    this.fetchTasks();
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await axios.get("/api/tasks");
        this.tasks = response.data;
      } catch (error) {
        console.error("Error fetching tasks:", error);
      }
    },
  },
};
</script>