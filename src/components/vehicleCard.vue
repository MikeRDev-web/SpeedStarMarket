<script>
import axios from 'axios';

export default {
  props: {
    vehicleParam: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      vehicle: null,
      loading: true,
      error: null
    };
  },
  mounted() {
    this.getVehicleDetails(this.vehicleParam);
  },
  methods: {
    async getVehicleDetails(vehicleParam) {
      try {
        const response = await axios.get(`https://gray-leopard-153303.hostingersite.com/api/index.php?id=${vehicleParam}`);
        if (response.data.message) {
          this.error = response.data.message;
        } else {
          this.vehicle = response.data[0];
        }
      } catch (error) {
        this.error = 'Error fetching vehicle details';
      } finally {
        this.loading = false;
      }
    },
    getImageUrl(imageName) {
      return `https://gray-leopard-153303.hostingersite.com/api/vehiclesImgs/${imageName}`;
    },
    goToView(){
      this.$router.push({ name: 'vehicleView', query: { id: this.vehicleParam } });
    }
  }
};
</script>

<template>
   <div v-if="error" class="vehicle__Card">
    <p class="vehicle__Card-title-e404">No hay vehiculo para mostrar</p>
  </div>
  <div v-if="vehicle" class="vehicle__Card" @click="goToView" :data-card-type="vehicle.type">
    <p class="vehicle__Card-title">{{ vehicle.brand }} {{ vehicle.model }} {{ vehicle.year }}</p>
    <img :src="getImageUrl(vehicle.image)" :alt="vehicle.model" class="vehicle__Card-img"/>
    <p class="vehicle__card-price">${{ vehicle.price }} - Km: {{ vehicle.mileage }}</p>
    <p class="vehicle__card-location">{{ vehicle.location }}</p>
  </div>
</template>

<style scoped>
.vehicle__Card {
  border: 2px solid rgb(0, 0, 0);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  width: 250px;
  height: 290px;
  gap: 10px;
  border-radius: 1rem;
  transition: all .2s ease;
  padding: 5px;
  transform: scale(0.9);
  cursor: pointer;
}
.vehicle__Card-img {
  width: 220px;
  height: 150px;
  border-radius: 10px;
}
.vehicle__Card-title {
  font-size: 20px;
  font-weight: bold;
}
.vehicle__Card:hover {
  box-shadow: 0 0 1rem black;
  transform: scale(1);
}
.vehicle__Card-title-e404 {
  font-size: 20px;
}
.vehicle__card-price {
  font-size: 20px;
  margin: 5px auto;
}
.vehicle__card-location {
  margin: 5px;
  font-size: 15px;
  font-weight: 500;
}
</style>