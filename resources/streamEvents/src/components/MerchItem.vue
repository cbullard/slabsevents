<template>
  <div class="merch">
    <div>
        <span class="merch__name">
          <slot name="person"></slot>
        </span> - 
        Bought a <slot name="item"></slot> from to you for <slot name="amount"></slot><slot name="currency"></slot>!
    </div>
  </div>
</template>
<style lang="scss" scoped>
  .merch {
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #d5d3d3;
    font-size: 1.0rem;
    
    &__name{
      font-style: italic;
    }
  }
</style>