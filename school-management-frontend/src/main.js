import { createApp } from 'vue';
import App from './App.vue';
import { createRouter, createWebHistory } from 'vue-router';
import axios from './axios'; // Import the Axios instance from your file
import routes from './routes';
import './assets/css/tailwind.css';

const app = createApp( App );

// Make the Axios instance available globally in your Vue app
app.config.globalProperties.$axios = axios;

const router = createRouter( {
    history: createWebHistory(),
    routes,
} );

app.use( router );

app.mount( '#app' );
