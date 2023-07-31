<template>
  <div class="follower">
    <div>
        <span class="follower__name">
          <slot name="person"></slot>
        </span> - 
        Followed you!
    </div>
  </div>
</template>
<style lang="scss" scoped>
  .follower {
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #d5d3d3;
    font-size: 1.0rem;
    
    &__name{
      // margin-right: 0.5rem;
      font-style: italic;
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