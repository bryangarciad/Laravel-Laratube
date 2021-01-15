<template>
     <div class="col-md-8">
            <div class="card p-3 d-flex justify-content-center align-items-center" v-if="!selected">
                <svg onclick="document.getElementById('video-files').click()" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="100px" height="100px" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16">
                    <g fill="#ff0000">
                        <path fill-rule="evenodd" d="M2.667 7C2.022 7 1.5 7.522 1.5 8.167v5.666c0 .645.522 1.167 1.167 1.167h6.666c.645 0 1.167-.522 1.167-1.167V8.167C10.5 7.522 9.978 7 9.333 7H2.667zM.5 8.167C.5 6.97 1.47 6 2.667 6h6.666c1.197 0 2.167.97 2.167 2.167v5.666C11.5 15.03 10.53 16 9.333 16H2.667A2.167 2.167 0 0 1 .5 13.833V8.167z"/>
                        <path fill-rule="evenodd" d="M11.25 9.15l2.768-1.605a.318.318 0 0 1 .482.263v6.384c0 .228-.26.393-.482.264l-2.767-1.605l-.502.865l2.767 1.605c.859.498 1.984-.095 1.984-1.129V7.808c0-1.033-1.125-1.626-1.984-1.128L10.75 8.285l.502.865zM3 5a2 2 0 1 0 0-4a2 2 0 0 0 0 4zm0 1a3 3 0 1 0 0-6a3 3 0 0 0 0 6z"/>
                        <path fill-rule="evenodd" d="M9 5a2 2 0 1 0 0-4a2 2 0 0 0 0 4zm0 1a3 3 0 1 0 0-6a3 3 0 0 0 0 6z"/>
                    </g>
                </svg>
                <input type="file" ref="videos" id="video-files" name="vide-files" style="display:none" @change="upload" multiple>
                <p class="text-center" style="margin-top: 10px; font-size:large">Upload Videos</p>
            </div>
            <div class="card p-3" v-else>
                <div class="my-4" v-for="video in videos" :key="video.name">
                    <div class="progress mb-3">
                        <div :style="{width:`${video.percentage || progress[video.name]}%`}" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-value>
                            {{video.percentage ? video.percentage == "100" ? 'video Processing Completed' : 'Processing' : 'Uploading'}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div v-if="!video.thumbnail" class="d-flex justify-content-cneter align-items-center">
                                Loading thumbnail...
                            </div>
                            <img v-else :src="video.thumbnail" alt="" style="width:100%">
                        </div>
                        <div class="col-md-4">
                            <a :href="`/videos/${video.id}`" v-if="video.percentage && video.percentage == '100'">
                                {{ video.title}}
                            </a>
                            <div v-else class="text-center">
                                {{video.title || video.name}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        name: "channel-uploads",
        mounted() {
            console.log('channel uploads mounted.')
        },
        data: function(){
            return{
                selected: false,
                videos: [],
                progress: {},
                uploads: [],
                intervals: {}
            }
        },
        props:{
            channel: {required: true, type:Object, default:()=>({})}
        },
        methods:{
            upload: function(){
                this.selected = true;
                this.videos = Array.from(this.$refs.videos.files);
                const uploaders = this.videos.map( video => {
                    const form = new FormData();
                    this.progress[video.name] = 0;
                    form.append('video', video);
                    form.append('title', video.name)

                    return axios.post(`/channels/${this.channel.id}/videos`, form, {
                        onUploadProgress: (event) => {
                            this.progress[video.name] = Math.ceil((event.loaded / event.total)*100);
                            this.$forceUpdate();
                        }
                    })
                    .then(({ data }) =>{
                        this.uploads = [
                            ...this.uploads,
                            data
                        ]
                    });
                });
                
                axios.all(uploaders).then(()=>{
                    this.videos = this.uploads;
                    this.videos.forEach(video => {
                        this.intervals[video.id] = setInterval(() => {
                            axios.get(`/videos/${video.id}`).then(({ data })=> {
                                if(data.percetage == "100"){
                                    clearInterval(this.intervals[video.id]);
                                }
                                this.videos = this.videos.map(v =>{
                                    if(v.id === data.id){
                                        return data;
                                    }
                                    else{
                                        return v;
                                    }
                                })
                            })
                        }, 3000)
                    });
                })
                console.log(this.videos);
            }
        }
    }
</script>

