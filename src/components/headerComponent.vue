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
            <span class="header__title">SpeedStarMarket</span>
        </a>
            <a class="header__sale" @click.prevent="goSell">
                Vender mi vehiculo
            </a>
    </header>
</template>

<style scoped>
    @media (min-width: 1025px) {
        header {
            width: 100%;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0, 0, 0, 0.452);
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 0 10px;
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

    } 

    @media (max-width: 480px) {
        header {
            width: 100vw;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            z-index: 9;
            background-color: var(--background-page);
            border-bottom: 1px solid var(--blackColor);
            padding: 0 10px;
        }
        .header__name {
            width: 40%;
            height: 50px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .header__logo {
            width: 20px;
            height: 20px;
        }
        .header__title {
            font-size: 90%;
            font-weight: 600;
        }
        .header__sale {
            border: 1px solid var(--blackColor);
            padding: 5px;
            border-radius: 5px;
            font-size: 90%;
            font-weight: 600;
        }
    }
</style>