<template>
    <div class="items">
        <h3 class="">Vehículos relacionados</h3>
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
  
  <script>
  import vehicleCard from './vehicleCard.vue';
  import axios from 'axios';
  
  export default {
    components: {
      vehicleCard
    },
    props: {
      brand: {
        type: String,
        required: true
      },
      type: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        vehicles: [], 
        loading: true, 
        error: null 
      };
    },
    async mounted() {
      await this.fetchVehicles();
    },
    methods: {
      async fetchVehicles() {
        try {
          const response = await axios.get(`https://gray-leopard-153303.hostingersite.com/api/interesedItems.php?brand=${this.brand}&type=${this.type}`);
          this.vehicles = response.data;
        } catch (error) {
          this.error = 'Error al cargar los vehículos';
        } finally {
          this.loading = false;
        }
      }
    }
  }
  </script>
  
  <style scoped>
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
  </style>