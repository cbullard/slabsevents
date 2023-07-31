<template>
  <div class="subscriber">
    <div>
        <span class="subscriber__name">
          <slot name="person"></slot>
        </span> - 
        (Tier <slot name="tier"></slot>)
        Subscribed to you!
    </div>
  </div>
</template>
<style lang="scss" scoped>
  .subscriber {
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #d5d3d3;
    font-size: 1.0rem;
    
    &__name{
      font-style: italic;
    }
  }
</style>