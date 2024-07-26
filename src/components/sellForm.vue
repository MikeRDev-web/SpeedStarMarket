<script>
export default {
  data() {
    return {
      formData: {
        type: '',
        brand: '',
        model: '',
        year: null,
        color: '',
        fuel: '',
        transmission: '',
        mileage: '',
        price: '',
        location: '',
        description: '',
        image: null
      },
      isSubmitting: true,
      loading: false,
      publicationId: null
    };
  },
  methods: {
    handleFileUpload(event) {
      this.formData.image = event.target.files[0];
    },
    async submitForm() {

      this.isSubmitting = false;
      this.loading = true;

      const formData = new FormData();
      for (const key in this.formData) {
        formData.append(key, this.formData[key]);
      }

      try {
        const response = await fetch('https://gray-leopard-153303.hostingersite.com/api/sellVehicle.php', {
          method: 'POST',
          body: formData
        });
        const result = await response.json();
        if (result.status === 'success') {
          this.publicationId = result.id;
        } else {
          this.submitStatus = 'Error al publicar: ' + result.message;
        } 
      } catch (error) {
        console.error('Error: ', error);
      } finally {
        this.isSubmitting = true;
      }
    },
    goToView(){
      this.$router.push({ name: 'vehicleView', query: { id: this.publicationId } });
    }
  }
};
</script>

<template>
  <div class="form-container">
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="brand">Marca:</label>
        <input type="text" id="brand" v-model="formData.brand" required>
      </div>

      <div class="form-group">
        <label for="model">Modelo:</label>
        <input type="text" id="model" v-model="formData.model" required>
      </div>

      <div class="form-group">
        <label for="year">Año:</label>
        <input type="number" id="year" v-model.number="formData.year" min="1900" max="2099" required>
      </div>

      <div class="form-group">
        <label for="mileage">Kilometraje:</label>
        <input type="number" id="mileage" v-model.number="formData.mileage" required>
      </div>

      <div class="form-group">
        <label for="price">Precio:</label>
        <input type="number" id="price" v-model.number="formData.price" required>
      </div>

      <div class="form-group">
        <label for="color">Color:</label>
        <input type="text" id="color" v-model.number="formData.color" required>
      </div>

      <div class="form-group">
        <label for="transmission">Tipo de transmisión:</label>
        <input type="text" id="transmission" v-model="formData.transmission" required>
      </div>

      <div class="form-group">
        <label for="location">Localización del vehículo:</label>
        <input type="text" id="location" v-model="formData.location" required>
      </div>

      <div class="form-group">
        <label for="description">Descripción:</label>
        <textarea id="description" v-model="formData.description" rows="4" required></textarea>
      </div>

      <div class="selectGroup">
        <div class="form-group-selectGroup">
          <label for="type">Tipo de vehículo:</label>
          <select id="type" v-model="formData.type" required class="selectInput">
            <option value="car">Auto</option>
            <option value="motorcycle">Motocicleta</option>
          </select>
        </div>
  
        <div class="form-group-selectGroup">
          <label for="fuel">Combustible:</label>
          <select id="fuel" v-model="formData.fuel" required class="selectInput">
            <option value="Gasolina">Gasolina</option>
            <option value="Electrico">Eléctrico</option>
          </select>
        </div>
      </div>


      <div class="form-group imgProduct">
        <label for="image" class="imgProduct__label">Imagen del vehículo:</label>
        <input type="file" id="image" @change="handleFileUpload" accept="image/*" required>
      </div>

      <button type="submit">Publicar</button>
      <div class="publicationStatus__container" v-if="loading">
        <div class="publicationStatus__content">
          <img src="/src/assets/icons/loading.gif" alt="Cargando" v-if="isSubmitting === false">
          <p v-if="isSubmitting === false">Publicando vehículo, por favor espera...</p>
          <img src="/src/assets/icons/check.gif" alt="Cargando" v-if="isSubmitting">
          <p v-if="isSubmitting">Vehículo publicado con éxito</p>
          <button v-if="isSubmitting" @click="goToView">Ver publicación</button>
        </div>
      </div>
    </form>
  </div>
</template>

<style scoped>
form {
  width: 90%;
  height: max-content;
  margin: 20px auto 0 auto;
  padding: 20px;
  background-color: transparent;
  border: 1px solid black;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.form-group {
    width: 50%;
}

label {
  display: block;
  width: 50%;
  margin-bottom: 8px;
  font-weight: bold;
  font-size: 1rem;
}

input[type="text"],
input[type="number"],
textarea {
  width: calc(100% - 20px);
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  box-sizing: border-box;
}

button[type="submit"] {
  background-color: transparent;
  color: black;
  font-size: 2rem;
  border: 1px solid black;
  padding: 12px 20px;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.2s ease;
  text-align: center;
  width: 80%;
  margin: 1rem auto;
}

button[type="submit"]:hover {
  background-color: black;
  color: white;
  width: 90%;
}

textarea {
  resize: vertical;
  min-height: 100px;
}

input[type="file"] {
  margin-top: 5px;
}

form label {
  color: #333;
}

form input[type="text"],
form input[type="number"],
form textarea {
  background-color: #fff;
  transition: border-color 0.3s ease;
}

form input[type="text"]:focus,
form input[type="number"]:focus,
form textarea:focus {
  outline: none;
  border-color: #007bff;
}

.publicationStatus__container {
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  right: 0;
  z-index: 10;
  background-color: rgba(0, 0, 0, 0.726);
  display: flex;
  justify-content: center;
}
.publicationStatus__content {
  width: 30%;
  height: max-content;
  background-color: white;
  border-radius: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 2rem;
  margin-top: 3rem;
  padding: 1rem;
}

.publicationStatus__content p{
  font-size: 1.5rem;
  font-weight: bold;
}

.publicationStatus__content button {
  background-color: transparent;
  border: 1px solid black;
  padding: 10px;
  width: 50%;
  font-size: 1rem;
  font-weight: bold;
  border-radius: 1rem;
  cursor: pointer;
  transition: all .2s ease-in;
}

.publicationStatus__content button:hover {
  background-color: black;
  color: white;
}

.selectInput {
  width: 100%;
  height: 30px;
  font-size: 1rem;
  font-weight: bold;
  border-radius: 0.5rem;
}

.imgProduct {
  margin: 1rem;
  width: 90%;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
}

.imgProduct__label {
  text-align: center;
  font-size: 1rem;
}

.selectGroup {
  width: 50%;
  display: flex;
  flex-direction: column;
  gap: 10px
}

.form-group-selectGroup {
  width: 95%;
}
</style>