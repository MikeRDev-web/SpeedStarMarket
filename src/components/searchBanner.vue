<script>
export default {
    data() {
        return {
            param: null
        }
    },
    methods: {
        goToSearch() {
            this.$router.push({ name: 'searching', query: { search: this.param } });
        }
    }
}
</script>

<template>
    <div class="banner">
        <img src="/src/assets/banners/principalBanner.jpeg" alt="banner" class="backgroundImg">
        <span class="banner__content">
            <h3 class="banner__text">¡Encuentra tu nuevo vehículo ahora!</h3>
            <form class="banner__form" @submit.prevent="goToSearch">
                <input type="text" placeholder="Busca por marca, modelo o año" class="banner__form-input" v-model="param" required>
                <button type="submit" class="banner__form-submit">
                    Buscar
                </button>
            </form>
        </span>
    </div>
</template>

<style scoped>
.banner {
    width: 100%;
    display: flex;
    position: relative;
}
.backgroundImg {
    width: 100%;
    height: 500px;
    margin: 0 auto 1rem auto;
    border-radius: 1rem;
    filter: blur(3px);
    z-index: 1;
    position: relative;
}
.banner__content {
    position: absolute;
    z-index: 2;
    display: flex;
    flex-direction: column;
    width: 90%;
    top: 10rem;
    left: 2rem;
    gap: 2rem;
}
.banner__text {
    text-shadow: 0 0 1rem rgba(255, 255, 255, 0.993);
    font-size: 3rem;
    color: rgb(0, 0, 0);
}
.banner__form {
    width: 40%;
    display: flex;
    gap: 5px;
    padding: 5px;
    align-items: center
}
.banner__form-input {
    width: 80%;
    height: 40px;
    outline: none;
    border: none;
    background-color: transparent;
    border-bottom: 3px solid rgb(0, 0, 0);
    font-size: 30px;
    color: rgb(0, 0, 0);
    padding: 0 10px;
    font-weight: 500;
    padding-bottom: 5px
}
.banner__form-input::placeholder {
    color: rgb(0, 0, 0);
    text-shadow: 0 0 1rem rgba(255, 255, 255, 0.993);
    font-weight: 250;

}
.banner__form-submit {
    width: 20%;
    height: 40px;
    border: 2px solid black;
    background-color: transparent;
    text-shadow: 0 0 1rem rgba(255, 255, 255, 0.993);
    font-size: 20px;
    font-weight: bold;
    border-radius: 1rem;
    color: rgb(0, 0, 0);
    letter-spacing: 1px;
    transition: all .2s ease-in;

}
.banner__form-submit:hover {
    background-color: black;
    border: 2px solid black;
    color: white;
}
</style>