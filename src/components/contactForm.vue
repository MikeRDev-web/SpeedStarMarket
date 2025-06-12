<script setup>
import { ref, reactive, watch, inject, defineEmits } from 'vue'
import { useAttrs } from 'vue'

const props = defineProps({
  vehicleId: {
    type: Number,
    required: true
  }
})

const formData = reactive({
  name: '',
  email: '',
  msg: '',
  vehicleId: props.vehicleId || null
})

const dataIsSubmitting = ref(false)
const errorSubmitting = ref(false)
const apilink = inject('apilink');

const emit = defineEmits([
    'close'
])

watch(() => props.vehicleId, (newVal) => {
  formData.vehicleId = newVal
})

async function submitForm() {
  dataIsSubmitting.value = true
  const form = new FormData()
  for (let key in formData) {
    form.append(key, formData[key])
  }

  try {
    const response = await fetch(`${apilink}/contactForm.php`, {
      method: 'POST',
      body: form
    })
    const result = await response.json()
    if (result.status === 'success') {
      dataIsSubmitting.value = true
      setTimeout(() => {
          emit('close');
      }, 1000);
    } else {
      errorSubmitting.value = true
    }
  } catch (error) {
    errorSubmitting.value = true
  }
}

const closeForm = () => {
    emit('close');
}
</script>

<template>
    <form @submit.prevent="submitForm">
        <span class="formHeader">
            <span>Compártenos tus datos y te contactaremos</span>
            <button type="button" class="closeForm" @click="closeForm">X</button>
        </span>
        <div class="formSection">
            <label for="name" class="formSection__text">Nombre</label>
            <input type="text" id="name" v-model="formData.name" required>
        </div>
        <div class="formSection">
            <label for="email" class="formSection__text">Correo</label>
            <input type="email" id="email" v-model="formData.email" required>
        </div>
        <div class="formSection">
            <label for="msg" class="formSection__text">Mensaje</label>
            <textarea id="msg" rows="5" required v-model="formData.msg"></textarea>
        </div>
        <input type="text" v-model="formData.vehicleId" readonly class="hiddenInput">
        <button class="submit" v-if="!dataIsSubmitting">Enviar mis datos</button>
        <button class="submit__ok" v-else-if="dataIsSubmitting">Gracias, en breve te contactaremos</button>
        <button class="submit__error" v-if="errorSubmitting">No ha sido posible enviar tus datos</button>
    </form>
</template>

<style scoped>
@media (min-width: 1025px) {
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
    .closeForm {
        width: 25px;
        height: 25px;
        background-color: rgba(255, 0, 0, 0.712);
        border: none;
        border-radius: 50%;
        color: var(--background-page);
        font-size: 100%;
        margin-left: auto;
        position: absolute;
        right: 10px;
        top: 10px;
    }
    .formHeader > span {
        font-size: 110%;
        margin-bottom: 10px;
        font-weight: bold;
    }
}

@media (max-width: 480px) {


    form {
        width: 95%;
        height: max-content;
        background-color: var(--background-page);
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        padding: 10px;
        margin-top: 1rem;
    }
    .formHeader {
        width: 100%;
        display: flex;
        align-items: center;
        position: relative;
    }
    .formHeader > span {
        width: 80%;
        font-size: 100%;
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .formSection {
        width: 100%;
        display: flex;
        align-items: first baseline;
        justify-content: space-between;
    }
    .formSection > input {
        width: 65%;
        height: 30px;
        border: none;
        background-color: transparent;
        border-bottom: 1px solid var(--blackColor);
        outline: none;
    }
    .formSection > textarea {
        width: 65%;
        height: 200px;
        outline: none;
        padding: 3px;
    }
    .formSection__text {
        width: calc(100% - 70%);
    }
    .submit, .submit__ok {
        min-width: 150px;
        height: 30px;
        font-size: 100%;
        margin-left: auto;
        border: 1px solid var(--blackColor);
        background-color: transparent;
        border-radius: 5px;
        font-weight: 500;
        letter-spacing: 1px;
        padding: 0 5px;
    }
    .submit__ok {
        pointer-events: none;
    }
    .hiddenInput {
        display: none;
    }
    .closeForm {
        width: 25px;
        height: 25px;
        background-color: rgba(255, 0, 0, 0.712);
        border: none;
        border-radius: 50%;
        color: var(--background-page);
        font-size: 100%;
        margin-left: auto;
        position: absolute;
        right: 0;
        top: 0;
    }
}

@keyframes show {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
}

form {
    animation: show 1s forwards;
}
</style>