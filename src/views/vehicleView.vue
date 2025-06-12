<script setup>
import { ref, onMounted, watch, inject } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

import maybeInteresing from '/src/components/maybeInteresing.vue'
import contactForm from '/src/components/contactForm.vue'
import locationIcon from '/src/assets/icons/location.svg';

const route = useRoute()

const vehicleId = ref(null)
const error = ref(null)
const vehicleObj = ref(null)
const loading = ref(true)
const modalState = ref(false)
const apilink = inject('apilink')

async function loadVehicleData() {
  loading.value = true
  vehicleId.value = route.query.id

  try {
    const response = await axios.get(`${apilink}index.php?id=${vehicleId.value}`)
    if (response.data.message) {
      error.value = response.data.message
    } else {
      vehicleObj.value = response.data[0]
    }
  } catch (err) {
    error.value = 'Error fetching vehicle details'
  } finally {
    loading.value = false
  }
}

function getImageUrl(imageName) {
  return `${apilink}vehiclesImgs/${imageName}`
}

function openForm() {
  modalState.value = true
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function closeForm() {
  modalState.value = false
}

onMounted(() => {
  loadVehicleData()
})

watch(() => route.query.id, () => {
  loadVehicleData()
})
</script>

<template>
    <div class="modalContact" v-if="modalState">
        <!-- <button class="closeForm" @click="closeForm">X</button> -->
        <contactForm :vehicleId="vehicleObj.id" @close="closeForm"/>
    </div>
    <div class="vehicleView__container">
        <h1 v-if="loading">
            Cargando vehiculo...
        </h1>
        <h1 v-else-if="error">{{ error }}</h1>
        <div v-else class="vehicle__conatiner">
            <div class="vehicle__generalDetails">
                <img :src="getImageUrl(vehicleObj.image)" alt="imagen" class="vehicle__generalDetails-img">
                <span class="vehicle__generalDetails-details">
                    <div class="vehicle__generalDetails-details-mostImportant">
                        <h1 class="vehicle__generalDetails-details-title">{{ vehicleObj.brand }} {{ vehicleObj.model }} {{ vehicleObj.year }}</h1>
                        <h2 class="vehicle__generalDetails-details-price">$ {{ vehicleObj.price }}</h2>
                        <h3 class="vehicle__generalDetails-details-location">
                            <img :src="locationIcon" alt="Localizacion" class="locationIco">
                            <span>{{ vehicleObj.location }}</span>
                        </h3>
                    </div>
                    <span class="vehicle__specs">
                        <h2 class="vehicle__generalDetails-details-specsTitle">Detalles</h2>
                        <span class="spectContainer">Marca: <span class="vehicle__specs-spec">{{ vehicleObj.brand }}</span></span>
                        <span class="spectContainer">Modelo: <span class="vehicle__specs-spec">{{ vehicleObj.model }}</span></span>
                        <span class="spectContainer">Año: <span class="vehicle__specs-spec">{{ vehicleObj.year }}</span></span>
                        <span class="spectContainer">Km: <span class="vehicle__specs-spec">{{ vehicleObj.mileage }}</span></span>
                        <span class="spectContainer">Color: <span class="vehicle__specs-spec">{{ vehicleObj.color }}</span></span>
                        <span class="spectContainer">Combustible: <span class="vehicle__specs-spec">{{ vehicleObj.fuel }}</span></span>
                        <span class="spectContainer">Transmision: <span class="vehicle__specs-spec">{{ vehicleObj.transmission }}</span></span>
                    </span>
                    <button class="contactBtn" @click="openForm">Quiero adquirirlo</button>
                    <p class="priceDisclaimer">Todos nuestros precios se encuentran en pesos mexicanos</p>
                </span>
            </div>
            <div class="vehicle__description">
                <h3>Descripción</h3>
                <p v-if="vehicleObj.description === ''">El vendedor no agrego una descripcion.</p>
                <p v-else>{{ vehicleObj.description }}</p>
            </div>
        </div>
        <maybeInteresing 
            v-if="vehicleObj" 
            :brand="vehicleObj.brand" 
            :type="vehicleObj.type">
        </maybeInteresing>
    </div>
</template>

<style scoped>
@media (min-width: 1025px) {
    .vehicleView__container {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        z-index: 8;
        width: 100%;
        height: 100%;
        margin-top: 90px;
        flex-direction: column;
    } 
    .vehicle__conatiner {
        width: 90%;
        height: max-content;
    }
    .vehicle__generalDetails {
        display: flex;
        gap: 20px;
        border-bottom: 2px solid black;
        padding-bottom: 20px
    }
    .vehicle__description {
        font-size: 30px;
        width: 30%;
    }
    .vehicle__generalDetails-img {
        width: 60%;
        height: 700px;
        border-radius: 1rem;
    }
    .vehicle__generalDetails-details-mostImportant {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 1rem;
    }
    .vehicle__generalDetails-details {
        width: 40%;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .vehicle__generalDetails-details-title {
        font-size: 50px;
    }
    .vehicle__generalDetails-details-price {
        font-size: 40px;
    }
    .vehicle__generalDetails-details-location {
        font-size: 20px;
        display: flex;
        gap: 0.5rem;
    }
    .vehicle__generalDetails-details-location span {
        font-weight: 500;
    }
    .vehicle__generalDetails-details-specsTitle {
        font-size: 30px;
        border-bottom: none;
        padding: 5px
    }
    .vehicle__specs {
        display: flex;
        flex-direction: column;
    }
    .vehicle__specs p {
        font-size: 18px;
        font-weight: bold;
        border-bottom: 1px solid black;
        display: flex;
        justify-content: space-between;
        padding: 1rem;
    }
    .vehicle__specs p span {
        font-weight: 500;
    }
    .priceDisclaimer {
        font-weight: 500;
        color: grey;
        margin-left: 1rem
    }
    .contactBtn {
        width: 50%;
        height: 50px;
        margin: 20px auto;
        background-color: transparent;
        border: 1px solid black;
        font-size: 25px;
        letter-spacing: 1px;
        border-radius: 1rem;
        color: black;
        font-weight: 500;
        cursor: pointer;
        transition: all .1s ease-in;
    }
    .contactBtn:hover {
        width: 60%;
        background-color: black;
        color: white;
    }
    .vehicle__description {
        margin: 1rem;
        width: 100%;
        padding-bottom: 1rem;
        border-bottom: 2px solid black;
    }
    .vehicle__description h3 {
        font-size: 30px;
        margin: 1rem;
    }
    .vehicle__description p {
        margin: 1.5rem;
        width: 90%;
    }
    
    /*modal*/
    
    .modalContact {
        position: fixed;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        background-color: rgba(0, 0, 0, 0.658);
        display: flex;
        align-items: start;
        justify-content: center;
    }
    
    .closeForm {
        position: absolute;
        top: 20px;
        right: 40px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 1px solid black;
        background-color: rgba(255, 0, 0, 0.658);
        font-weight: bold;
        transition: all .2s ease-in;
        cursor: pointer;
        z-index: 10;
        color: white;
        font-size: 1.5rem;
    }
    .closeForm:hover {
        background-color: red;
        color: white;
    }
}
@media (max-width: 480px) {
    .vehicleView__container {
        width: 100%;
        height: max-content;
        display: flex;
        flex-direction: column;
        margin-top: 60px;
        margin-bottom: 1rem;
    }
    .vehicle__generalDetails {
        width: 100%;
        height: max-content;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .vehicle__generalDetails-img {
        width: 98%;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
    }
    .vehicle__generalDetails-details {
        width: 100%;
        height: max-content;
        display: flex;
        flex-direction: column;
        padding: 10px;
        gap: 1rem;
    }
    .vehicle__generalDetails-details-mostImportant {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .vehicle__generalDetails-details-location {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .locationIco {
        width: 20px;
    }
    .vehicle__specs {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .vehicle__specs-spec {
        font-size: 110%;
    }
    .vehicle__generalDetails-details-specsTitle {
        border-bottom: 1px solid var(--blackColor);
        padding-bottom: 5px;
    }
    .spectContainer {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 110%;
        border-bottom: 1px solid var(--blackColor);
        padding-bottom: 5px;
    }
    .contactBtn {
        width: 100%;
        height: 40px;
        border: 1px solid var(--blackColor);
        background-color: transparent;
        font-size: 130%;
        letter-spacing: 1px;
        border-radius: 5px;
    }
    .contactBtn:active {
        transform: scale(0.9);
    }
    .modalContact {
        position: fixed;
        top: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.644);
        z-index: 99;
        display: flex;
        justify-content: center;
    }
    .priceDisclaimer {
        font-size: 100%;
        font-weight: 300;
        width: 100%;
        text-align: center;
    }
    .vehicle__description {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 0 10px;
        margin-bottom: 1rem;
    }
    .vehicle__description > h3 {
        font-size: 130%;
    }
}

.contactBtn:active {
    transform: scale(0.9);
}
</style>