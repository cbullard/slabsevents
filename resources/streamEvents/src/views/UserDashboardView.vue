<script setup>
  import DonationItem from '../components/DonationItem.vue'
  import FollowerItem from '../components/FollowerItem.vue'
  import SubscriberItem from '../components/SubscriberItem.vue'
  import MerchItem from '../components/MerchItem.vue'
  import FollowerCount from '../components/FollowerCount.vue'
  import TopSalesCount from '../components/TopSalesCount.vue'
  import TotalSales from '../components/TotalSales.vue'
</script>


<template>
  <div>

    <div class="stats">
      <div class="stats__title">
        <h1 class="stats__header green">User Dashboard</h1>
        30 day totals
      </div>
      <div class="stats__totals">
        <TotalSales :totalSales="totalSales"></TotalSales>
        <FollowerCount> {{ followerCount }} </FollowerCount>
        <TopSalesCount :sales="topSales"></TopSalesCount>
      </div>
    </div>

    Showing {{ Object.keys(userDetails).length }} Results
         <div @scroll="handleScroll" id="activity" class="activity">
            <span
              v-for="(item, key) in userDetails" :key='key'>
                <span class="activity__date">{{ formatDate(item.created_at) }}</span>
                <DonationItem v-if="item.message">
                  <template #person>
                    {{ item.name }}
                  </template>
                  <template #dontation>
                    {{ item.amount }}
                  </template>
                  <template #currency>
                    {{ item.currency }}
                  </template>
                  <template #message>
                    "{{ item.message }}"
                  </template>
                </DonationItem>

                <SubscriberItem v-else-if="item.subscription_tier">
                  <template #person>
                      {{ item.name }}
                  </template>
                  <template #tier>
                      {{ item.subscription_tier }}
                  </template>
                </SubscriberItem>

                <MerchItem v-else-if="item.item_name">
                  <template #person>
                      {{ item.name }}
                  </template>
                  <template #item>
                      {{ item.item_name }}
                  </template>
                  <template #amount>
                      {{ item.amount }}
                  </template>
                  <template #currency>
                      {{ item.currency }}
                  </template>
                </MerchItem>
                
                <FollowerItem v-else-if="!!item.name">
                  {{ item.created_at }}
                  <template #person>
                      {{ item.name }}
                  </template>
                </FollowerItem>
              </span>
        </div>
  </div>
</template>
<style lang="scss" scoped>
    .stats {
      font-size: 1.0rem;

      &__header {
        // display: flex;
        // justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
      }

      &__title {
        margin-top: 2rem;
        text-align: center;
        font-weight: bold;
        margin-bottom: 1rem;
        text-transform: capitalize;
        color: #fff;
      }

      &__totals {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
      }
    }

    .activity {
        margin:5px;
        padding:5px;
        color:#000;
        background-color: #FFF;
        width: 1000px;
        height: 500px;
        overflow: auto;
        text-align:justify;
    }

  .detail__date {
    font-size: 0.8rem;
  }
</style>

<script>
import axios from 'axios'
import _ from 'lodash';

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://streamlabs.code';

  export default {
    name: 'UserDashboard',

    data() {
      return {
        githubAuth: false,
        userDetails: {},
        cardLimit: 100,
        cardIncrease: 10,
        currentPage: 1,
        followerCount: 0,
        topSales: 0,
        totalSales: 0,
        activityFeedOffset: 0,
        activityFeedLimit: 25,

        scrollTop: 0,
        // url: '/api/oauth/github',
      }
    },
    computed: {

    },

    mounted () {
      this.getDashboardDetails(this.activityFeedOffset, this.activityFeedLimit);
      this.getFollowerCount();
      this.getTopSales();
      this.getTotalSales();
      

      // window.addEventListener("scroll", handleInfiniteScroll);

      

    //   const cardContainer = document.getElementById("card-container");
    //   const cardCountElem = document.getElementById("card-count");
    //   const cardTotalElem = document.getElementById("card-total");
    //   const loader = document.getElementById("loader");
      
    //   cardTotalElem.innerHTML = this.cardLimit;
      
    //   const pageCount = Math.ceil(this.cardLimit / this.cardIncrease);
    //   const getRandomColor = () => {
    //     const h = Math.floor(Math.random() * 360);
    //     return `hsl(${h}deg, 90%, 85%)`;
    //   };
    //   const createCard = (index) => {
    //     const card = document.createElement("div");
    //     card.className = "card";
    //     card.innerHTML = index;
    //     card.style.backgroundColor = getRandomColor();
    //     cardContainer.appendChild(card);
    //   };

    //   const addCards = (pageIndex) => {
    //     this.currentPage = pageIndex;
        
    //     const startRange = (pageIndex - 1) * this.cardIncrease;
    //     const endRange = this.currentPage == pageCount ? this.cardLimit : pageIndex * this.cardIncrease;
        
    //     cardCountElem.innerHTML = endRange;

    //     for (let i = startRange + 1; i <= endRange; i++) {
    //       createCard(i);
    //     }
    //   };

    // addCards(this.currentPage);

    // const handleInfiniteScroll = () => {
    //   const endOfPage = window.innerHeight + window.pageYOffset >= document.body.offsetHeight;
    //   console.log('endOfPage', endOfPage);
    //   if (endOfPage) {
    //     addCards(this.currentPage + 1);
    //   }
    // };
    // window.addEventListener("scroll", handleInfiniteScroll);

  },

    beforeDestroy () {
      window.removeEventListener('message', this.onMessage)
    },

    methods: {
      handleScroll(event) {
        const activityContainer = document.getElementById("activity");
        this.scrollTop = event.currentTarget.scrollTop;
        // console.log('you be scollin', this.scrollTop);
        console.log(activityContainer.scrollTop, activityContainer.scrollHeight - activityContainer.offsetHeight-1);
        if( activityContainer.scrollTop >= (activityContainer.scrollHeight - activityContainer.offsetHeight - 1))
        {
          console.log('bottom');
          this.activityFeedOffset += this.activityFeedLimit;
          this.getDashboardDetails(this.activityFeedOffset, this.activityFeedLimit);
        }
      },

      formatDate(date) {
        if (!date) return;
        return new Date(date).toLocaleDateString("en-US");
      },
      // async login () {
      //   const newWindow = openWindow('', 'login')

      //   const url = await this.fetchOauthUrl('github')
      //   // console.log('url', url);
      //   newWindow.location.href = url
      // },

      // async fetchOauthUrl (provider) {
      //   console.log('fetchOauthUrl');
      //   const { data } = await axios.post(`http://streamlabs.code/api/dashboard_details/1`)
      //   // return 'a'
      //   return data.url
      // },

      async getTotalSales () {
        const totalSales = await axios.get(`/api/total_sales/1`);
        this.totalSales = totalSales.data;
      },

      async getFollowerCount () {
        const followers = await axios.get(`/api/follower_count/1`);
        this.followerCount = followers.data;
      },

      async getTopSales () {
        const top_sales = await axios.get(`/api/top_sales/1`);
        this.topSales = top_sales.data;
      },

      async getDashboardDetails (offset, limit) {
        console.log('offset', offset, 'limit', limit);
        const { data } = await axios.get(`/api/recent_activity/1/${offset}/${limit}`)
        // const { data } = await axios.get(`/api/recent_activity/1/${offset}/${limit}`)
        let activity = _.reverse(_.sortBy(data, ['created_at']));
console.log('activity', activity);
        if(Object.keys(this.userDetails).length) {
          this.userDetails = this.userDetails.concat(activity);
        } else {
          this.userDetails = activity;
        }
        console.log(this.userDetails);
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