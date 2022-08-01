import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import http from "./plugins/axios";
import mitt from 'mitt';
const emitter = mitt();
import './assets/main.css'
const app = createApp(App)
import VueTheMask from 'vue-the-mask'
app.use(VueTheMask)
app.use(router)
app.config.globalProperties.emitter = emitter;
app.mount('#app')
