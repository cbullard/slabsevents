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
        postData: {},
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
      this.postData.id = 1;
      // this.postData.id = "a";
      this.getDashboardDetails(this.activityFeedOffset, this.activityFeedLimit);
      this.getFollowerCount();
      this.getTopSales();
      this.getTotalSales();

  },

    beforeDestroy () {
      window.removeEventListener('message', this.onMessage)
    },

    methods: {
      handleScroll(event) {
        const activityContainer = document.getElementById("activity");
        this.scrollTop = event.currentTarget.scrollTop;
        if( activityContainer.scrollTop >= (activityContainer.scrollHeight - activityContainer.offsetHeight - 1))
        {
          this.activityFeedOffset += this.activityFeedLimit;
          this.getDashboardDetails(this.activityFeedOffset, this.activityFeedLimit);
        }
      },

      formatDate(date) {
        if (!date) return;
        return new Date(date).toLocaleDateString("en-US");
      },

      async getTotalSales () {
        await axios.post('/api/total_sales', this.postData)
          .then(response => {
            if(response.data.message) {
               this.totalSales = 0;
            } 
            else {
              this.totalSales = response.data;
            }
          })
          .catch ((err) => {
            console.log(err);
         })
      },

      async getFollowerCount () {
        await axios.post('/api/follower_count', this.postData)
          .then(response => {
            if(response.data.message) {
               this.followerCount = 0;
            } 
            else {
              this.followerCount = response.data;
            }
          })
          .catch ((err) => {
            console.log(err);
         })
      },

      async getTopSales() {
         await axios.post('/api/top_sales', this.postData)
          .then(response => {
            if(response.data.message) {
               this.topSales = null;
            } 
            else {
              this.topSales = response.data;
            }
          })
          .catch ((err) => {
            console.log(err);
         })
      },

      async getDashboardDetails (offset, limit) {
        this.postData.offset = offset;
        this.postData.limit = limit;

        await axios.post('/api/recent_activity', this.postData)
          .then(response => {
            if(response.data.message) {
               this.topSales = null;
            } 
            else {
              let activity = _.reverse(_.sortBy(response.data, ['created_at']));

              if(Object.keys(this.userDetails).length) {
                this.userDetails = this.userDetails.concat(activity);
              } else {
                this.userDetails = activity;
              }
            }
          })
          .catch ((err) => {
            console.log(err);
        })
      },
    }
  }
</script>