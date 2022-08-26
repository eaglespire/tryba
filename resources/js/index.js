import { createApp } from 'vue'
import App from "./App.vue";
import router from './router'
import formatNumber from './format-number.js';

const app = createApp(App).use(router)
app.config.globalProperties.formatNumber=formatNumber
app.mount("#app");
