<script>
import headerComponent from '/src/components/headerComponent.vue';
import sellForm from '/src/components/sellForm.vue';

export default {
    name: 'sellMyVehicle',
    components: {
        sellForm,
        headerComponent
    }
}
</script>

<template>
    <headerComponent/>
    <div class="pageContent">
        <h1>Vender mi Vehiculo</h1>
        <sellForm/>
    </div>
</template>

<style>
</style>