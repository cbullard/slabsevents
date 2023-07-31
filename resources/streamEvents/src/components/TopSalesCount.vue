<template>
  <div class="sales">
    <span class="sales__title">Top Item Sales</span>
      <div class="sales__items" v-for="(item, key) in sales" :key='key'>
        {{ item.item_name }}: {{ item.quantity }}
      </div>
  </div>
</template>
<style lang="scss" scoped>
  .sales {
    margin-bottom: 0.8rem;
    padding:0 0.8rem;
    font-size: 1.0rem;
    width: 12rem;
    background-color: aliceblue;
    color: #3e3e3e;
    

    &__items{
      display: flex;
      justify-content: center;
      font-size: 0.8rem;
    }

    &__title{
      display: flex;
      justify-content: center;
      font-weight: 700;
    }

    &__amount{
    font-weight: 700;
    color: #3e3e3e;
    }

    &__message{
      font-size: 0.9rem;
      color: #3e3e3e;
      margin-left: 1rem;
    }
  }
</style>
<script>
export default {
  name: 'TopSalesCount',
  props: {
    sales: {
        required: true,
    }
  },
}
</script>