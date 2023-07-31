<template>
  <div class="sales">
    <span class="sales__title">Total Revenue</span>
    <div class="sales__items">
      <div>Donations: {{ totalSales.donations }}</div>
      <div>Subscriptions: {{ totalSales.subscriptions }}</div>
      <div>Merch: {{ totalSales.merch_sales }}</div>
      <div class="sales__total">Total: {{ totalSales.total }}</div>
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
    
      &__total{
        border-top: 1px solid #3e3e3e;
        // font-size: 0.9rem;
        font-weight: 700;
        color: #3e3e3e;
      }

    &__items{
      // display: flex;
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
  }
</style>
<script>
export default {
  name: 'TopSalesCount',
  props: {
    totalSales: {
        required: true,
        // type: Array
    }
  },
  data() {
    return {
      item: {
        item_name: 'No item sold yet'
      }
    }
  },
}
</script>