<template>
  <div>
    asdada
    <button class="btn btn-dark ml-auto" type="button" @click="login">
      login with
      <!-- <fa :icon="['fab', 'github']" /> -->
    </button>
  </div>
</template>

<script>
import axios from 'axios'
axios.defaults.withCredentials = true;
  export default {
    name: 'LoginGithub',

    data() {
      return {
        githubAuth: false,
        apiPath: 'http://streamlabs.code',
        // url: '/api/oauth/github',
      }
    },
    computed: {
      // githubAuth: () => window.config.githubAuth,
      // githubAuth: false,
      // url() {
      //   return '/api/oauth/github'
      // }
      // url: {
      //   get: function(){
      //     return '/api/oauth/github'
      //   },
      //   // set: function(url) {
      //   //   var role = this.roles.filter(role => role.id === id)[0];
      //   //   Vue.set(this.form.roles, 0, role);
      //   // }
      // }
    },

    mounted () {
      console.log('github mounted');
    //   axios.get('/sanctum/csrf-cookie').then(response => {
    // // Login...
    //     console.log(response);
    //   });

      window.addEventListener('message', this.onMessage, false)
    },

    beforeDestroy () {
      window.removeEventListener('message', this.onMessage)
    },

    methods: {
      async login () {
        const newWindow = openWindow('', 'login')

        const url = await this.fetchOauthUrl('github')
        // console.log('url', url);
        newWindow.location.href = url
      },

      async fetchOauthUrl (provider) {
        console.log('fetchOauthUrl');
        const { data } = await axios.post(`http://streamlabs.code/api/oauth/${provider}`)
        // return 'a'
        return data.url
      },
      /**
       * @param {MessageEvent} e
       */
      onMessage (e) {
        if (e.origin !== window.origin || !e.data.token) {
          return
        }

        this.$store.dispatch('auth/saveToken', {
          token: e.data.token
        })

        this.$router.push({ name: 'home' })
      }
    }
  }

  /**
   * @param  {Object} options
   * @return {Window}
   */
  function openWindow (url, title, options = {}) {
    if (typeof url === 'object') {
      options = url
      url = ''
    }

    options = { url, title, width: 600, height: 720, ...options }

    const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
    const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
    const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
    const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height

    options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
    options.top = ((height / 2) - (options.height / 2)) + dualScreenTop

    const optionsStr = Object.keys(options).reduce((acc, key) => {
      acc.push(`${key}=${options[key]}`)
      return acc
    }, []).join(',')

    const newWindow = window.open(url, title, optionsStr)

    if (window.focus) {
      newWindow.focus()
    }

    return newWindow
  }
</script>