<template>
  <div class="greetings">
    <h1 class="green">{{ dashboardTitle }}</h1>
    <h3>
      Stream Events
      <a target="_blank" href="https://vitejs.dev/">Sign In</a> +
      <a target="_blank" href="https://v2.vuejs.org/">Vue 2</a>.
    </h3>
  </div>
</template>

<style scoped>
h1 {
  font-weight: 500;
  font-size: 2.6rem;
  top: -10px;
}

h3 {
  font-size: 1.2rem;
}

.greetings h1,
.greetings h3 {
  text-align: center;
}

@media (min-width: 1024px) {
  .greetings h1,
  .greetings h3 {
    display: block;
    text-align: left;
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
    created() {
      // this.loadTranslationData(this.translations);
    },
    methods: {
      // monitorPageUpdates(pageData) {
        // this.lastPage = pageData.current >= pageData.total ? true : false;
      // },
    },
}
</script>