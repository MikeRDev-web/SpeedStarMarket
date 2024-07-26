<script>

import headerComponent from '/src/components/headerComponent.vue';
import vehicleCard from '/src/components/vehicleCard.vue';
import searchBanner from '/src/components/searchBanner.vue';
import filters from '/src/components/filters.vue';
import axios from 'axios';

export default {
  name: 'Home',
  components: {
    headerComponent,
    vehicleCard,
    searchBanner,
    filters
  },
  data() {
    return {
      vehicles: [],
      error: null,
      loading: true,
    };
  },
  methods: {
    async getVehicles () {
      try {
        const response = await axios.get('https://gray-leopard-153303.hostingersite.com/api/allContent.php');
        let preLoading = [];
        preLoading = response.data;
          function insertShuffled(array, item) {
            const j = Math.floor(Math.random() * (array.length + 1));
            array.splice(j, 0, item);
          }
          preLoading.forEach(item => {
            insertShuffled(this.vehicles, item.id);
          });
       
      } catch (error){
        this.error = 'Error al conectar con el servidor';
      } finally {
        this.loading = false;
      }
    }
  },
  mounted() {
    this.getVehicles()
  }
};
</script>

<template>
 <headerComponent></headerComponent>
 <div class="pageContent">
  <searchBanner></searchBanner>
  <filters/>
   <div class="cardsContainer">
    <vehicleCard v-for="vehicle in vehicles" :key="vehicle.id" :vehicleParam="vehicle" />
   </div>
  </div>
</template>

<style scoped>
.cardsContainer {
  width: 90%;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  margin: 1rem auto;
}
.pageContent {
  width: 90%;
  height: max-content;
  display: flex;
  flex-direction: column;
  margin: 70px auto;
  padding: 10px;
}
</style>