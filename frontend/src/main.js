import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from 'axios'
import router from './router'
import App from './App.vue'
import './assets/reset.css'
import {axiosConfig} from './assets/axios.js';
import './registerServiceWorker'
const app=createApp(App);
app.use(router).use(createPinia(), axios)



app.config.globalProperties.$axios= axios.create(axiosConfig);

app.mount('#app');
