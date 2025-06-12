import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import Router from '/router/router.js'

const app = createApp(App)

app.use(Router)
app.provide('apilink', 'http://localhost/speedstarmarket/')
app.mount('#app')
