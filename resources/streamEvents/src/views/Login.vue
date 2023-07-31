<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <div :title="'login'">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ 'email' }}</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ 'password' }}</label>
            <div class="col-md-7">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-3" />
            <div class="col-md-7 d-flex">

              <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                {{ 'forgot_password' }}
              </router-link>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <button :loading="form.busy">
                login
              </button>

              <login-github />

            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

import LoginGithub from '../components/LoginGitHub.vue'
import axios from 'axios'

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://streamlabs.code';

export default {

  metaInfo () {
    return { title: 'login' }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    user: {},    
    remember: false
  }),

  created() {

  },
  methods: {
    async login () {
      await axios.get('/sanctum/csrf-cookie').then(response => {

      });
       await axios.post('/api/login', {
          email: this.form.email,
          password: this.form.password,
        }).then(response => {
          this.user = response.data;
        });
    }
  }
}
</script>