<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 mt-5">
        <!-- Go Back to Home Page -->
        <router-link to="/" class="btn btn-success">Go Back</router-link>
        <div class="col-md-12">
          <h1>{{ singleNewsData.title }}</h1>
          <div class="container">
              <img :src="singleNewsData.urlToImage" alt="" height="400" width="400">
          </div>
          <p class="m-5">
            {{ singleNewsData.description }}
          </p>
          <div>
            <span class="badge">Posted 2012-08-02 20:47:04</span>
            <span class="label label-info">{{ likes }} Likes</span>
            <span class="label label-warning">{{ disLikes }} Dislikes</span>
            <div class="pull-right">
              <span class="btn btn-default" v-on:click="likeNews(singleNewsData.url)">Like</span>
              <span class="btn btn-danger" v-on:click="dislikeNews(singleNewsData.url)">Dislike</span>
            </div>
          </div>
          <hr />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {},
  data() {
    return {
      singleNewsData: {},
      likes: 0,
      disLikes: 0
    };
  },
  created() {

  },
  mounted() {
      this.singleNewsData = this.$route.params.news;
      this.getNewsInfo();
  },
  methods: {
    getNewsInfo(){
        axios.post("/api/get-news-likes-info", {
          url: this.$route.params.news.url
      }).then((response) => {
          this.likes = response.data.like_count;
          this.disLikes = response.data.dislike_count;
      });
    },
    likeNews(newsUrl) {
      axios.post("/api/like-news", {
          url: newsUrl
      }).then((response) => {
          this.likes = response.data.like_count;
      });
    },
    dislikeNews(newsUrl) {
      axios.post("/api/dislike-news", {
          url: newsUrl
      }).then((response) => {
          this.disLikes = response.data.dislike_count;
      });
    },
  },
};
</script>
