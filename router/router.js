import{ createRouter, createWebHistory } from 'vue-router';
import vehicleView from '/src/views/vehicleView.vue';
import Home from '/src/views/home.vue';
import Search from '/src/views/search.vue';
import SellMyVehicle from '/src/views/sellMyVehicle.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/vehicle',
        name: 'vehicleView',
        component: vehicleView
    },
    {
        path: '/searching',
        name: 'searching',
        component: Search
    },
    {
        path: '/sell-my-vehicle',
        name: 'sellMyVehicle',
        component: SellMyVehicle
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;