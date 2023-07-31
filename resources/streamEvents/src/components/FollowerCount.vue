<template>
  <div class="follower">
    <span class="follower__title">Followers</span>
    <div class="follower__count">
          <slot></slot>
    </div>
  </div>
</template>
<style lang="scss" scoped>
  .follower {
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    font-size: 1.0rem;
    width: 12rem;
    background-color: aliceblue;
    color: #3e3e3e;
    
    &__title{
      display: flex;
      justify-content: center;
      font-weight: 700;
    }

    &__count{
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 2.5rem;
      // height: 100%;
      // width: 100%;
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