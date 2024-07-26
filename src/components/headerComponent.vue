<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

function goHome() {
    router.push({ name: 'Home' });
}

function goSell() {
    router.push({ name: 'sellMyVehicle' });
}
</script>

<template>
    <header>
        <a class="header__name" @click="goHome">
            <img src="/public/logo.svg" alt="logotipo" class="header__logo">
            <h1 class="header__title">SpeedStar Market</h1>
        </a>
            <a class="header__sale" @click.prevent="goSell">
                Vender mi vehiculo
            </a>
    </header>
</template>

<style scoped>
    header {
        width: 90%;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(0, 0, 0, 0.452);
        position: fixed;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        padding: 3px 10px;
        z-index: 9;
        background-color: rgba(255, 255, 255, 0.932);
    }

    .header__name{
        display: flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        cursor: pointer;
    }
    .header__title {
        font-size: 20px;
        color: black;
    }
    .header__logo {
        width: 20px;
        height: 20px
    }
    .header__sale {
        font-size: 15px;
        text-decoration: none;
        border: 1px solid black;
        padding: 10px;
        border-radius: 10px;
        color: black;
        transition: all .2s ease;
        font-weight: bold;
        cursor: pointer;
    }
    .header__sale:hover {
        background-color: black;
        color: white;
    }
    .header__sale:active {
        transform: scale(0.9);
    }
    .header__opts {
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>