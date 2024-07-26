<script>
import headerComponent from '/src/components/headerComponent.vue';
import vehicleCard from '/src/components/vehicleCard.vue';
import axios from 'axios';

export default {
  name: 'searching',
  components: {
    headerComponent,
    vehicleCard
  },
  data() {
    return {
      vehicles: [],
      error: null,
      loading: true,
      searchTerm: ''
    };                                                              
  },
  methods: {
    async fetchData() {
      if (this.searchTerm.trim() === '') {
        return;
      }
      this.loading = true;
      try {
        const response = await axios.get(`https://gray-leopard-153303.hostingersite.com/api/search.php?search=${this.searchTerm}`);
        this.vehicles = response.data;
      } catch (error) {
        this.error = '';
      } finally {
        this.loading = false;
      }
    },
    goHome() {
        this.$router.push({ name: 'Home'});
    }
  },
  mounted() {
    this.searchTerm = this.$route.query.search; 
    this.fetchData();
  }
};
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
</style>