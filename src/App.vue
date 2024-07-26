<script setup>

</script>

<template>
 
  <router-view></router-view>

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

.sectionTitle {
  font-size: 40px
}
</style>
