import "./bootstrap";

import { createApp } from "vue";
import TaskApp from "./components/TaskApp.vue";

const app = createApp({});
app.component("task-app", TaskApp);
app.mount("#app");
