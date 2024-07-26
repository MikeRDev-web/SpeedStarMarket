<script>
export default {
    data() {
        return {
            formData: {
                name: '',
                email: '',
                msg: '',
                vehicleId: this.vehicleId || null
            },
            publicationId: null,
            dataIsSubmitting: false,
            errorSubmitting: false,
        };
    },
    props: {
        vehicleId: {
            type: Number,
            required: true
        }
    },
    watch: {
        vehicleId(newVal) {
            this.formData.vehicleId = newVal;
        }
    },
    methods: {
        async submitForm() {
            this.dataIsSubmitting = true;
            const formData = new FormData();
            for (let key in this.formData) {
                formData.append(key, this.formData[key]);
            }

            try {
                const response = await fetch('https://gray-leopard-153303.hostingersite.com/api/contactForm.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.status === 'success') {
                    this.dataIsSubmitting = true;
                } else {
                    this.errorSubmitting = true;
                }
            } catch (error) {
                console.error('Error: ', error);
                this.errorSubmitting = true;
            } 
        }
    }
};
</script>

<template>
    <form @submit.prevent="submitForm">
        <p>Compártenos tus datos y te contactaremos</p>
        <div class="formSection">
            <label for="name" class="formSection__text">Nombre:</label>
            <input type="text" id="name" v-model="formData.name" required>
        </div>
        <div class="formSection">
            <label for="email">Correo:</label>
            <input type="email" id="email" v-model="formData.email" required>
        </div>
        <div class="formSection">
            <label for="msg">Mensaje:</label>
            <textarea id="msg" rows="5" required v-model="formData.msg"></textarea>
        </div>
        <input type="text" v-model="formData.vehicleId" readonly class="hiddenInput">
        <button class="submit" v-if="!dataIsSubmitting">Enviar mis datos</button>
        <button class="submit__ok" v-else-if="dataIsSubmitting">Gracias, en breve te contactaremos</button>
        <button class="submit__error" v-if="errorSubmitting">No ha sido posible enviar tus datos</button>
    </form>
</template>

<style scoped>
form {
    width: 50%;
    background-color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 2rem;
    border-radius: 1rem;
    position: relative;
    margin-top: 2rem;
    gap: 1rem;
}
form p {
    font-size: 2rem;
    font-weight: bold;
    margin: 1rem
}
.formSection {
    display: flex;
    flex-direction: column;
    width: 90%;
    gap: 1rem
}
.formSection label {
    font-weight: bold;
    font-size: 1.2rem;
}
.formSection input {
    width: 90%;
    height: 30px;
    border-radius: 1rem;
    border: 1px solid grey;
    padding: 10px;
    font-size: 1rem;
    font-weight: 400;
}
.formSection textarea {
    border-radius: 1rem;
    width: 95%;
    padding: 10px;
    font-size: 1rem;
    font-weight: 400;
    letter-spacing: 1px;
}
.submit {
    width: 50%;
    height: 50px;
    border: 1px solid black;
    background-color: transparent;
    font-size: 1.5rem;
    font-weight: 500;
    border-radius: 1rem;
    transition: all .2s ease-in;
    cursor: pointer;
}
.submit:hover {
    width: 60%;
    background-color: black;
    color: white;
}
.submit__ok {
    border-radius: 1rem;
    padding: 10px;
    border: 2px solid rgba(0, 128, 0, 0.541);
    width: 50%;
    height: 50px;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    user-select: none;
    pointer-events: none;
    background-color: rgba(0, 128, 0, 0.322);
}
.submit__error {
    border-radius: 1rem;
    padding: 10px;
    border: 2px solid rgba(128, 0, 0, 0.541);
    width: 50%;
    height: 50px;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    user-select: none;
    pointer-events: none;
    background-color: rgba(128, 0, 0, 0.322);
}

.hiddenInput {
    display: none;
}
</style>