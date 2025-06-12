<script setup>
import { ref, onMounted, inject } from 'vue'
import headerComponent from '/src/components/headerComponent.vue'
import vehicleCard from '/src/components/vehicleCard.vue'
import searchBanner from '/src/components/searchBanner.vue'
import filters from '/src/components/filters.vue'
import axios from 'axios'

const vehicles = ref([])
const error = ref(null)
const loading = ref(true)
const apilink = inject('apilink');

async function getVehicles () {
  try {
    const response = await axios.get(`${apilink}/allContent.php`)
    const preLoading = response.data

    function insertShuffled(array, item) {
      const j = Math.floor(Math.random() * (array.length + 1))
      array.splice(j, 0, item)
    }

    preLoading.forEach(item => {
      insertShuffled(vehicles.value, item.id)
    })

  } catch (err) {
    error.value = 'Error al conectar con el servidor'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  getVehicles()
})
</script>

<template>
 <div class="pageContent">
  <searchBanner></searchBanner>
  <filters/>
   <div class="cardsContainer">
    <vehicleCard v-for="vehicle in vehicles" :key="vehicle.id" :vehicleParam="vehicle" />
   </div>
  </div>
</template>

<style scoped>
@media (min-width: 1025px) {
  .cardsContainer {
    width: 90%;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin: 1rem auto;
  }
}
@media (max-width: 480px) {
  .cardsContainer {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
  }
}
</style>