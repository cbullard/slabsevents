<template>
  <div class="about">
    <h1>This is an about page</h1>
  </div>
</template>

<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>

<script>

import axios from 'axios'

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://streamlabs.code';
// defineProps({
//   msg: {
//     type: String,
//     required: true
//   }
// })
export default {
  name: 'dashboard',
    props: {
      // translations: {
      //     required: true,
      //     type: String
      // }
    },
    data() {
        return {
            dashboardTitle: 'Stream Events'
        }
    },
}
</script>