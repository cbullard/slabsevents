<template>
  <div class="donation">
    <div>
        <span class="donation__name">
          <slot name="person"></slot>
        </span> - 
        Donated <span class="donation__amount"><slot name="dontation"></slot> <slot name="currency"></slot></span> to you!
        <div class="donation__message">
          <slot name="message"></slot>
        </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>
  .donation {
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #d5d3d3;
    font-size: 1.0rem;
    
    &__name{
      font-style: italic;
    }

    &__message{
      font-size: 0.9rem;
      color: #3e3e3e;
      margin-left: 1rem;
    }
  }
</style>