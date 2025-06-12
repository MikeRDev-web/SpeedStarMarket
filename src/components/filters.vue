<script setup>
function handleFilter(type, dataBtn) {
  filterCards(type)
  applyClassBtn(dataBtn)
}

function filterCards(type) {
  const cardsInDom = document.querySelectorAll('.vehicle__Card')
  cardsInDom.forEach(card => {
    const cardType = card.getAttribute('data-card-type')
    card.style.display = (type === 'all' || cardType === type) ? 'flex' : 'none'
  })
}

function applyClassBtn(dataBtn) {
  const filterBtns = document.querySelectorAll('.filters__btn')
  filterBtns.forEach(btn => {
    const btnData = btn.getAttribute('data-filter')
    btn.classList.toggle('filters__btn-active', btnData === dataBtn)
  })
}
</script>

<template>
    <div class="filters__container">
      <button class="filters__btn" @click="handleFilter('car', 'cars')" :data-filter="'cars'">Autos</button>
      <button class="filters__btn" @click="handleFilter('motorcycle', 'bikes')" :data-filter="'bikes'">Motocicletas</button>
      <button class="filters__btn" @click="handleFilter('all', 'all')" :data-filter="'all'">Todo</button>
    </div>
  </template>

<style scoped>
@media (min-width: 1025px) {
  .filters__container {
      width: 90%;
      height: 50px;
      margin: 1rem auto;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 4rem;
  }
  .filters__btn {
      width: 40%;
      height: 40px;
      border: none;
      border-radius: 0.5rem;
      font-size: 1.5rem;
      padding: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      letter-spacing: 1px;
      cursor: pointer;
      transition: all .2s ease;
  }
  .filters__btn:hover {
      background-color: black;
      color: white;
  }
}
@media (max-width: 480px) {
    .filters__container {
      width: 100%;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px 0;
      gap: 10px;
    }
    .filters__btn {
      flex: 1;
      height: 40px;
      border-radius: 5px;
      border: none;
      font-size: 100%;
      letter-spacing: 1px;
    }
}


.filters__btn-active {
  background-color: black;
  color: white;
}
.filters__btn:active {
  transform: scale(0.9);
}
</style>