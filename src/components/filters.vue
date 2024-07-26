<script>
export default {
  methods: {
    handleFilter(type, dataBtn) {
      this.filterCards(type);
      this.applyClassBtn(dataBtn);
    },
    filterCards(type) {
        const cardsInDom = document.querySelectorAll('.vehicle__Card');
      cardsInDom.forEach(card => {
        const cardType = card.getAttribute('data-card-type');
        if (type === 'all' || cardType === type) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    },
    applyClassBtn(dataBtn) {
      const filterBtns = document.querySelectorAll('.filters__btn');
      filterBtns.forEach(btn => {
        const btnData = btn.getAttribute('data-filter');
        if (btnData === dataBtn) {
          btn.classList.add('filters__btn-active');
        } else {
          btn.classList.remove('filters__btn-active');
        }
      });
    }
  }
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
        background-color: transparent;
        border: 1px solid black;
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
    .filters__btn-active {
        background-color: black;
        color: white;
    }
</style>