<script setup>
import { ref, onMounted, inject } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const props = defineProps({
  vehicleParam: {
    type: Number,
    required: true
  }
})

const vehicle = ref(null)
const loading = ref(true)
const error = ref(null)
const apilink = inject('apilink')

const router = useRouter()

async function getVehicleDetails(vehicleParam) {
  try {
    const response = await axios.get(`${apilink}/index.php?id=${vehicleParam}`)
    if (response.data.message) {
      error.value = response.data.message
    } else {
      vehicle.value = response.data[0]
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

function goToView() {
  router.push({ name: 'vehicleView', query: { id: props.vehicleParam } })
}

onMounted(() => {
  getVehicleDetails(props.vehicleParam)
})
</script>

<template>
   <div v-if="error" class="vehicle__Card">
    <p class="vehicle__Card-title-e404">No hay vehiculo para mostrar</p>
  </div>
  <div v-if="vehicle" class="vehicle__Card" @click="goToView" :data-card-type="vehicle.type">
    <span class="vehicle__Card-title">{{ vehicle.brand }} {{ vehicle.model }} {{ vehicle.year }}</span>
    <img :src="getImageUrl(vehicle.image)" :alt="vehicle.model" class="vehicle__Card-img"/>
    <span class="vehicle__card-price">${{ vehicle.price }}</span>
    <span class="vehicle__card-mileage">{{ vehicle.mileage }} Km</span>
    <span class="vehicle__card-location">{{ vehicle.location }}</span>
  </div>
</template>

<style scoped>
@keyframes show {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

.vehicle__Card {
  animation: show 1s forwards;
}

@media (min-width: 1025px) {
  .vehicle__Card {
    border: none;
    background-color: buttonface;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    width: 250px;
    height: 310px;
    gap: 10px;
    border-radius: 10px;
    transition: all .2s ease;
    padding: 5px;
    transform: scale(0.9);
    cursor: pointer;
  }
  .vehicle__Card-img {
    width: 240px;
    height: 160px;
    border-radius: 5px;
    object-fit: contain;
  }
  .vehicle__Card-title {
    font-size: 110%;
    width: 100%;
    font-weight: 600;
  }
  .vehicle__Card:hover {
    box-shadow: 0 0 1rem black;
    transform: scale(1);
  }
  .vehicle__Card-title-e404 {
    font-size: 20px;
  }
  .vehicle__card-price {
    width: 100%;
    font-size: 102%;
    font-weight: bold;
    margin-left: 15px;
  }
  .vehicle__card-mileage {
    width: 100%;
    font-size: 100%;
    font-weight: 600;
    margin-left: 15px;
  }
  .vehicle__card-location {
    width: 100%;
    font-size: 90%;
    font-weight: 500;
    letter-spacing: 1px;
    margin-left: 15px;
  }
}
@media (max-width: 480px) {
  .vehicle__Card {
    min-width: 150px;
    height: 260px;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    background-color: buttonface;
    border-radius: 5px;
    padding: 10px;
    gap: 5px;
  }
  .vehicle__Card-img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 5px;
  }
  .vehicle__Card-title {
    font-size: 90%;
    width: 100%;
    font-weight: 600;
  }
  .vehicle__card-price {
    width: 100%;
    font-size: 102%;
    font-weight: bold;
  }
  .vehicle__card-mileage {
    width: 100%;
    font-size: 100%;
    font-weight: 600;
  }
  .vehicle__card-location {
    width: 100%;
    font-size: 90%;
    font-weight: 500;
    letter-spacing: 1px;
  }
}
</style>