<template>
    <div class="container">
        <nav class="navbar fixed-top navbar-light bg-faded" style="background-color: #e3f2fd;">
         <a class="navbar-brand" href="#">News Around the World</a>
     </nav>
     <section id="content" class="section-dropdown">
         <p class="select-header"> Select a news source: </p>
         <label class="select">
             <select name="news_sources" id="news_sources">
                 <option v-bind:value="allNewsData.sourceId">{{ allNewsData.sourceName }}</option>
                <option v-bind:value="newsSource.id" v-for="newsSource in allNewsData.newsSource" :key="newsSource.id">{{newsSource.name}}</option>
             </select>
         </label>
         <object id="spinner" data="spinner.svg" type="image/svg+xml" hidden></object>
     </section>
     <div id="news">
         <p> News Source : {{allNewsData.sourceName}} </p>

         <section class="news">
                <article v-for="selectedNews in allNewsData.news" :key="selectedNews.message">
                    <img v-bind:src="selectedNews.urlToImage" alt=""/>
                    <div class="text">
                        <h1>{{selectedNews.title}}</h1>
                        <p style="font-size: 14px">{{selectedNews.description}} <a v-bind:href="selectedNews.url"
                                                                                    target="_blank">
                                <small>read more...</small>
                            </a></p>
                        <div style="padding-top: 5px;font-size: 12px">
                            Author: {{selectedNews.author ? "" : "Unknown" }}
                        </div>
                        <div style="padding-top: 5px;" v-if="selectedNews.publishedAt !== null">Date
                            Published: {{ selectedNews.publishedAt }}</div>
                        <div style="padding-top: 5px;" v-else>Date Published: Unknown</div>
                        <div style="padding-top: 5px;">
                            <!-- <a v-bind:href="url" class="btn btn-primary">VIEW</a> -->
                            <router-link to="/news-detail" class="btn btn-primary">VIEW</router-link>
                        </div>
                    </div>
                </article>
         </section>
         </div>
    </div>
</template>

<script>
    export default {
        props: {
            url: String,
        },
        data() {
            return {
                allNewsData: [],
            }
        },
        mounted() {
            this.read();
        },
        methods: {
            read() {
                axios.get('/api/get-news')
                    .then((response) => {
                        let newsData = response.data;
                        console.log(response.data);
                        this.allNewsData = newsData;
                    });
            },
            detail(id) {

            },
            likeNews(url){
                axios.get('/api/like-news/' + url).then((response) => {
                    console.log(response);
                })
            },
            dislikeNews(){
                axios.get('/api/dislike-news/' + url).then((response) => {
                    console.log(response);
                })
            }
        }
    }
</script>
