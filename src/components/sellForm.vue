<script setup>
import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const formData = ref({
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
})

const isSubmitting = ref(true)
const loading = ref(false)
const publicationId = ref(null)

const postSuccess = ref(false);

const apilink = inject('apilink')

function handleFileUpload(event) {
  formData.value.image = event.target.files[0]
}

async function submitForm() {
  isSubmitting.value = false
  loading.value = true

  const data = new FormData()
  for (const key in formData.value) {
    data.append(key, formData.value[key])
  }

  try {
    const response = await fetch(`${apilink}sellVehicle.php`, {
      method: 'POST',
      body: data
    })

    const result = await response.json()

    if (result.status === 'success') {
      publicationId.value = result.id
    } else {
      console.error('Error al publicar:', result.message)
    }
  } catch (error) {
    console.error('Error:', error)
  } finally {
    isSubmitting.value = true
  }
}

function goToView() {
  router.push({ name: 'vehicleView', query: { id: publicationId.value } })
}
</script>

<template>
  <div class="form-container">
    <div class="publicationStatus__container" v-if="loading">
      <div class="publicationStatus__content">
        <img src="/src/assets/icons/loading.gif" alt="Cargando" v-if="isSubmitting === false">
        <p v-if="isSubmitting === false">Publicando vehículo, por favor espera...</p>
        <img src="/src/assets/icons/check.gif" alt="Cargando" v-if="isSubmitting">
        <p v-if="isSubmitting">Vehículo publicado con éxito</p>
        <button v-if="isSubmitting" @click="goToView" class="goPublication">Ver publicación</button>
      </div>
    </div>
    <form @submit.prevent="submitForm" v-else>
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

    </form>
  </div>
</template>

<style scoped>
@media (min-width: 1025px) {

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
}

@media (max-width: 480px) {
  form {
    width: 95%;
    padding: 15px;
    display: flex;
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
    border-radius: 0.5rem;
  }

  .form-group,
  .selectGroup,
  .form-group-selectGroup {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  label {
    width: 100%;
    font-size: 0.95rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }

  input[type="text"],
  input[type="number"],
  textarea,
  .selectInput {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border-radius: 0.5rem;
    border: 1px solid #ccc;
    box-sizing: border-box;
  }

  textarea {
    min-height: 80px;
    resize: vertical;
  }

  input[type="file"] {
    width: 100%;
    margin-top: 0.5rem;
  }

  .imgProduct {
    width: 100%;
    margin-top: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .imgProduct__label {
    text-align: center;
    font-size: 0.95rem;
  }

  button[type="submit"] {
    font-size: 1rem;
    padding: 10px;
    width: 100%;
    background-color: transparent;
    border: 1px solid black;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  button[type="submit"]:hover {
    background-color: black;
    color: white;
  }

  .publicationStatus__content {
    width: 90%;
    padding: 1rem;
    border-radius: 1rem;
    gap: 1rem;
    border: 1px solid var(--blackColor);
    margin: auto;
    display: flex;
    flex-direction: column;
  }

  .publicationStatus__content p {
    font-size: 1.1rem;
    text-align: center;
  }

  .publicationStatus__content button {
    width: 100%;
    font-size: 1rem;
    width: 90%;
    margin: auto;
    height: 30px;
    border: 1px solid var(--blackColor);
    border-radius: 5px;
    font-size: 110%;
    background-color: transparent;
    font-weight: 600;
  }
  .publicationStatus__content img {
    width: 50px;
    height: 50px;
    margin: auto;
  }
}
</style>