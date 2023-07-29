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
              <!-- <has-error :form="form" field="email" /> -->
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ 'password' }}</label>
            <div class="col-md-7">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <!-- <has-error :form="form" field="password" /> -->
            </div>
          </div>

          <!-- Remember Me -->
          <div class="form-group row">
            <div class="col-md-3" />
            <div class="col-md-7 d-flex">
              <!-- <checkbox v-model="remember" name="remember">
                {{ 'remember_me' }}
              </checkbox> -->

              <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                {{ 'forgot_password' }}
              </router-link>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <span>lkjaldja</span>
              <!-- Submit Button -->
              <button :loading="form.busy">
                login
              </button>

              <!-- GitHub Login Button -->
              <login-github />
              <!-- <github/> -->
              <!-- <dashboard-view/> -->
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
import DashboardView from '../views/DashboardView.vue'
import axios from 'axios'

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://streamlabs.code';

export default {
  components: { DashboardView },
  // middleware: 'guest',

  // components: {
  //   LoginGithub
  // },

  metaInfo () {
    return { title: 'login' }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  created() {
    console.log('login vue');
  },
  methods: {
    async login () {
      axios.get('/sanctum/csrf-cookie').then(response => {
        console.log('login',response);
      // Submit the form.
        axios.post('/login', {
          email: this.form.email,
          password: this.form.password,
        }).then(response => {
          console.log(response);  
        });
      });
      // const { data } = await this.form.post('/api/login')

      // // Save the token.
      // this.$store.dispatch('auth/saveToken', {
      //   token: data.token,
      //   remember: this.remember
      // })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>