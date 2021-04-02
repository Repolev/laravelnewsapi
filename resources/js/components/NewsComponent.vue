<template>
    <div class="container">
        <nav class="navbar fixed-top navbar-light bg-faded" style="background-color: #e3f2fd;">
         <a class="navbar-brand" href="#">News Around the World</a>
     </nav>
     <div class="row">
        <div class="col-md-6">
            <section id="content" class="section-dropdown">
            <p class="select-header"> Select a news source: </p>
            <label class="select">
                <select name="news_sources" id="news_sources" v-model="selectKey" @change="getNewsFromSource($event)">
                    <option v-bind:value="allNewsData.sourceId + ':' + allNewsData.sourceName" >{{ allNewsData.sourceName }}</option>
                    <option v-bind:value="newsSource.id + ':' + newsSource.name" v-for="newsSource in allNewsData.newsSources" :key="newsSource.id">{{newsSource.name}}</option>
                </select>
            </label>
            <object id="spinner" data="spinner.svg" type="image/svg+xml" hidden></object>
        </section>
        </div>
        <div class="col-md-6">
            <section id="content" class="section-dropdown">
            <p class="select-header"> Select a country: </p>
            <label class="select">
                <select name="news_sources" id="news_sources" v-model="selectCountryKey" @change="getNewsFromCountry($event)">
                    <option value="us">U.S</option>
                    <option value="tr">Turkey</option>
                    <option value="sg">Singapore</option>
                    <option value="ph">Philippines</option>
                </select>
            </label>
            <object id="spinner" data="spinner.svg" type="image/svg+xml" hidden></object>
        </section>
        </div>
    </div>
     <div id="news">
         <!-- News Source -->
         <p> News Source : {{allNewsData.sourceName}} </p>

         <section class="news">
             <!-- News Loop -->
                <article v-for="selectedNews in allNewsData.news" :key="selectedNews.message">
                    <!-- Image -->
                    <img v-bind:src="selectedNews.urlToImage" alt=""/>
                    <div class="text">
                        <h1>{{selectedNews.title}}</h1>
                        <p style="font-size: 14px">{{selectedNews.description}} <a v-bind:href="selectedNews.url"
                                                                                    target="_blank">
                                <small>read from source...</small>
                            </a></p>
                        <!-- Author -->
                        <div style="padding-top: 5px;font-size: 12px">
                            Author: {{selectedNews.author ? selectedNews.author : "Unknown" }}
                        </div>
                        <!-- Published At -->
                        <div style="padding-top: 5px;" v-if="selectedNews.publishedAt !== null">Date
                            Published: {{ selectedNews.publishedAt }}</div>
                        <div style="padding-top: 5px;" v-else>Date Published: Unknown</div>
                        <div style="padding-top: 5px;">
                            <!-- Router Link for News Detail -->
                            <router-link :to="{ name: 'news.detail', params: {news: selectedNews} }" class="btn btn-primary">VIEW</router-link>
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
                selectKey: "",
                selectCountryKey: "",
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
                        this.allNewsData = newsData;
                    });
            },
            getNewsFromSource(event){
                let sourceData = event.target.value;
                axios.post('/api/sourceId', {
                    source: sourceData,
                }).then((response) => {
                    let sourceData = response.data;
                    this.allNewsData = sourceData;
                })
            },
            getNewsFromCountry(event){
                let country = event.target.value;
                axios.post('/api/get-by-country', {
                    country: country,
                }).then((response) => {
                    let sourceData = response.data;
                    this.allNewsData = sourceData;
                })
            }
        }
    }
</script>
