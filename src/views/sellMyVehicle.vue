<script setup>
import sellForm from '/src/components/sellForm.vue';
</script>

<template>
    <div class="pageContent">
        <h1>Vender mi Vehiculo</h1>
        <sellForm/>
    </div>
</template>

<style scoped>
.pageContent > h1 {
    width: 100%;
    font-size: 110%;
    border-bottom: 1px solid var(--blackColor);
    padding-bottom: 5px;
}
</style>