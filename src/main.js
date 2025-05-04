import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import './assets/style.css';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import icons from "v-svg-icons";
import VueLazyLoad from 'vue3-lazyload'


import './axios';

const app = createApp(App);

const baseUrl='https://todo.679f2583.nip.io/todo-api';


app.provide('$baseUrl', baseUrl);

app.component("icon", icons);


app.use(Toast); 
app.use(router);
app.use(VueLazyLoad);
app.mount('#app');
