<script setup>
import { ref, onMounted, inject } from 'vue'
import vehicleCard from './vehicleCard.vue'

const props = defineProps({
  brand: {
    type: String,
    required: true
  },
  type: {
    type: String,
    required: true
  }
})

const vehicles = ref([])
const loading = ref(true)
const error = ref(null)
const apilink = inject('apilink')

async function fetchVehicles() {
  try {
    const response = await fetch(`${apilink}interesedItems.php?brand=${props.brand}&type=${props.type}`)
    const data = await response.json()
    vehicles.value = data
  } catch (err) {
    error.value = 'Error al cargar los vehículos'
  } finally {
    loading.value = false
  }
}

onMounted(fetchVehicles)
</script>

<template>
    <div class="items">
      <h3 class="items__title">Vehículos relacionados</h3>
      <div v-if="loading">Cargando vehículos...</div>
      <div v-if="error">{{ error }}</div>
      <div v-else class="cards">
        <vehicleCard 
          v-for="vehicle in vehicles" 
          :key="vehicle.id" 
          :vehicleParam="vehicle.id">
        </vehicleCard>
      </div>
    </div>
  </template>

  
  <style scoped>
  @media (min-width: 1025px) {
    .items {
        display: flex;
        margin: 20px auto;
        flex-direction: column;
        align-items: center;
    }
    h3 {
        font-size: 30px;
        margin: 0.5rem;
    }
    .cards {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0;
        margin-bottom: 3rem;
    }
  }

  @media (max-width: 480px) {
    .items {
      width: 100%;
      height: max-content;
      padding: 10px 5px;
      display: flex;
      flex-direction: column;
      gap: 1rem;
      border-top: 1px solid var(--blackColor);
      margin-bottom: 4px;
    }
    .items__title {
      width: 100%;
      padding-left: 5px;
      font-size: 140%;
    }
    .cards {
      width: 100%;
      display: flex;
      padding: 5px;
      gap: 5px;
      flex-direction: column;
    }
  }
  </style>