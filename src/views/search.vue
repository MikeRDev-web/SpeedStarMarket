<script setup>
import { ref, onMounted, inject } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

import headerComponent from '/src/components/headerComponent.vue'
import vehicleCard from '/src/components/vehicleCard.vue'

const vehicles = ref([])
const error = ref(null)
const loading = ref(true)
const searchTerm = ref('')

const route = useRoute()
const router = useRouter()
const apilink = inject('apilink');

async function fetchData() {
  if (searchTerm.value.trim() === '') return
  loading.value = true
  try {
    const response = await axios.get(`${apilink}/search.php?search=${searchTerm.value}`)
    vehicles.value = response.data
  } catch (err) {
    error.value = ''
  } finally {
    loading.value = false
  }
}

function goHome() {
  router.push({ name: 'Home' })
}

onMounted(() => {
  searchTerm.value = route.query.search || ''
  fetchData()
})
</script>

<template>
  <div>
    <headerComponent />
    <div class="pageContent">
      <div v-if="loading">Cargando...</div>
      <div v-else-if="error">{{ error }}</div>
      <div v-if="vehicles.length === 0" class="IGGM">
        <h2 class="IGGM__msg">No hay resultados para el termino " {{ searchTerm }} ", puedes buscar un termino diferente.</h2>
        <h2 class="IGGM__notResults" @click="goHome">Ir al inicio</h2>
      </div>
      <div v-else class="results__container">
            <h2 class="searchTerm">Se encontraron <span class="searchTerm-span">{{ vehicles.length  }}</span> resultados para " <span class="searchTerm-span">{{ searchTerm }}</span> "</h2>
        <span class="results__container-items">
            <vehicleCard v-for="vehicle in vehicles" :key="vehicle.id" :vehicleParam="vehicle.id" />
        </span>
      </div>
    </div>
  </div>
</template>

<style scoped>
@media (min-width: 1025px) {

  .pageContent {
      margin: 70px auto;
      width: 90%;
      padding: 10px
  }
  .results__container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 1rem;
  }
  .results__container-items{
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      flex-wrap: wrap;
  }
  .searchTerm {
      font-size: 1.5rem;
      font-weight: 300;
  }
  .searchTerm-span {
      font-weight: bold;
      padding: 0 1px;
  }
  .IGGM {
      height: 50vh;
      padding: 1rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 3rem;
  }
  .IGGM__msg {
      font-size: 3rem;
  }
  .IGGM__notResults {
      font-size: 2rem;
      border: 1px solid black;
      padding: 1rem;
      border-radius: 1rem;
      letter-spacing: 1px;
      cursor: pointer;
      transition: all .2s ease;
      width: 20%;
      text-align: center
  }
  .IGGM__notResults:hover {
      background-color: black;
      color: white;
      width: 30%;
  }
}
@media (max-width: 480px) {
  .pageContent {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-bottom: 20px;
  }
  .results__container {
    width: 90%;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding: 0 5px;
    align-items: center;
    justify-content: center;
  }
  .searchTerm {
    width: 100%;
    font-size: 100%;
    border-bottom: 1px solid var(--blackColor);
    padding-bottom: 10px;
  }
  .results__container-items {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 10px 0;
  }
}
</style>