<script>
import headerComponent from '/src/components/headerComponent.vue';
import maybeInteresing from '/src/components/maybeInteresing.vue';
import contactForm from '/src/components/contactForm.vue';
import axios from 'axios';

export default {
    name: 'vehicleView',
    components: {
        headerComponent,
        maybeInteresing,
        contactForm
    },
    data() {
        return {
            vehicleId: null,
            error: null,
            vehicleObj: null,
            loading: true,
            modalState: false
        };
    },
    watch: {
        '$route.query.id': 'loadVehicleData'
    },
    async mounted() {
        await this.loadVehicleData(); 
    },
    methods: {
        async loadVehicleData() {
            this.loading = true; 
            this.vehicleId = this.$route.query.id; 

            try {
                const response = await axios.get(`https://gray-leopard-153303.hostingersite.com/api/index.php?id=${this.vehicleId}`);
                if (response.data.message) {
                    this.error = response.data.message;
                } else {
                    this.vehicleObj = response.data[0];
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
        openForm() {
            this.modalState = true;
        },
        closeForm() {
            this.modalState = false;
        }
    }
}
</script>

<template>
    <headerComponent></headerComponent>
    <div class="modalContact" v-if="modalState">
        <button class="closeForm" @click="closeForm">X</button>
        <contactForm :vehicleId="this.vehicleObj.id"/>
    </div>
    <div class="vehicleView__container">
        <h1 v-if="loading">
            Cargando vehiculo...
        </h1>
        <h1 v-else-if="error">{{ error }}</h1>
        <div v-else class="vehicle__conatiner">
            <div class="vehicle__generalDetails">
                <img :src="getImageUrl(vehicleObj.image)" alt="imagen" class="vehicle__generalDetails-img">
                <span class="vehicle__generalDetails-details">
                    <div class="vehicle__generalDetails-details-mostImportant">
                        <h1 class="vehicle__generalDetails-details-title">{{ vehicleObj.brand }} {{ vehicleObj.model }} {{ vehicleObj.year }}</h1>
                        <h3 class="vehicle__generalDetails-details-location">Publicado en: <span>{{ vehicleObj.location }}</span></h3>
                        <h2 class="vehicle__generalDetails-details-price">$ {{ vehicleObj.price }}</h2>
                    </div>
                    <span class="vehicle__specs">
                        <h2 class="vehicle__generalDetails-details-specsTitle">Especificaciones:</h2>
                        <p>Marca: <span class="vehicle__specs-spec">{{ vehicleObj.brand }}</span></p>
                        <p>Modelo: <span class="vehicle__specs-spec">{{ vehicleObj.model }}</span></p>
                        <p>Año: <span class="vehicle__specs-spec">{{ vehicleObj.year }}</span></p>
                        <p>Km: <span class="vehicle__specs-spec">{{ vehicleObj.mileage }}</span></p>
                        <p>Color: <span class="vehicle__specs-spec">{{ vehicleObj.color }}</span></p>
                        <p>Combustible: <span class="vehicle__specs-spec">{{ vehicleObj.fuel }}</span></p>
                        <p>Transmision: <span class="vehicle__specs-spec">{{ vehicleObj.transmission }}</span></p>
                    </span>
                    <button class="contactBtn" @click="openForm">Quiero adquirirlo</button>
                    <p class="priceDisclaimer">*Todos nuestros precios se encuentran en pesos mexicanos</p>
                </span>
            </div>
            <div class="vehicle__description">
                <h3>Descripción:</h3>
                <p v-if="vehicleObj.description === ''">El vendedor no agrego una descripcion.</p>
                <p v-else>{{ vehicleObj.description }}</p>
            </div>
        </div>
        <maybeInteresing 
            v-if="vehicleObj" 
            :brand="vehicleObj.brand" 
            :type="vehicleObj.type">
        </maybeInteresing>
    </div>
</template>

<style scoped>
.vehicleView__container {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    z-index: 8;
    width: 100%;
    height: 100%;
    margin-top: 90px;
    flex-direction: column;
} 
.vehicle__conatiner {
    width: 90%;
    height: max-content;
}
.vehicle__generalDetails {
    display: flex;
    gap: 20px;
    border-bottom: 2px solid black;
    padding-bottom: 20px
}
.vehicle__description {
    font-size: 30px;
    width: 30%;
}
.vehicle__generalDetails-img {
    width: 60%;
    height: 700px;
    border-radius: 1rem;
}
.vehicle__generalDetails-details-mostImportant {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-bottom: 1rem;
}
.vehicle__generalDetails-details {
    width: 40%;
    display: flex;
    flex-direction: column;
    position: relative;
}
.vehicle__generalDetails-details-title {
    font-size: 50px;
}
.vehicle__generalDetails-details-price {
    font-size: 40px;
}
.vehicle__generalDetails-details-location {
    font-size: 20px;
    display: flex;
    gap: 0.5rem;
}
.vehicle__generalDetails-details-location span {
    font-weight: 500;
}
.vehicle__generalDetails-details-specsTitle {
    font-size: 30px;
    border-bottom: none;
    padding: 5px
}
.vehicle__specs {
    display: flex;
    flex-direction: column;
}
.vehicle__specs p {
    font-size: 18px;
    font-weight: bold;
    border-bottom: 1px solid black;
    display: flex;
    justify-content: space-between;
    padding: 1rem;
}
.vehicle__specs p span {
    font-weight: 500;
}
.priceDisclaimer {
    font-weight: 500;
    color: grey;
    margin-left: 1rem
}
.contactBtn {
    width: 50%;
    height: 50px;
    margin: 20px auto;
    background-color: transparent;
    border: 1px solid black;
    font-size: 25px;
    letter-spacing: 1px;
    border-radius: 1rem;
    color: black;
    font-weight: 500;
    cursor: pointer;
    transition: all .1s ease-in;
}
.contactBtn:hover {
    width: 60%;
    background-color: black;
    color: white;
}
.vehicle__description {
    margin: 1rem;
    width: 100%;
    padding-bottom: 1rem;
    border-bottom: 2px solid black;
}
.vehicle__description h3 {
    font-size: 30px;
    margin: 1rem;
}
.vehicle__description p {
    margin: 1.5rem;
    width: 90%;
}

/*modal*/

.modalContact {
    position: fixed;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    z-index: 10;
    background-color: rgba(0, 0, 0, 0.658);
    display: flex;
    align-items: start;
    justify-content: center;
}

.closeForm {
    position: absolute;
    top: 20px;
    right: 40px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 1px solid black;
    background-color: rgba(255, 0, 0, 0.658);
    font-weight: bold;
    transition: all .2s ease-in;
    cursor: pointer;
    z-index: 10;
    color: white;
    font-size: 1.5rem;
}
.closeForm:hover {
    background-color: red;
    color: white;
}
</style>