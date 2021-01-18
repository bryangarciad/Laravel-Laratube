<template>
    <div class="card mt-5 p-5" >
        <div v-if="userLogged" class="media">
            <div class="media-body">
                <div class="form-inline my-4 w-full comment-container">
                    <!-- <img class="rounded-circle mr-3"  :src="userimage" alt=""> -->
                    <Avatar v-if="currentUser.name" :username="currentUser.name" :size="30" ></Avatar>

                    <input type="text" class="fomr-control form-control-sm w-90 ml-2" placeholder="Add a comment">
                    <button class="btn btn-sm btn-primary ml-2">Comment</button>
                </div>
            </div>
        </div>
        <h4>Comments</h4>
        <hr>
        <div class="media" v-if="isDataFetched">
            <!-- COMMENT -->
            <div class="media-body">
                <div class="comment-container mt-3 d-flex" v-for="singleComment in dataComments" :key="singleComment.id">
                    <div class="mr-3">
                        <!-- <img v-if="getName(singleComment.id).name" :src="`/public/thumbnail/${getName(singleComment.id).id}.png`" class="rounded-circle mr-1"/> -->
                        <Avatar v-if="getName(singleComment.id).name" :username="getName(singleComment.id).name" :size="40"></Avatar>
                    </div>
                    <div class="div">
                        <h4>{{getName(singleComment.id).name}}</h4>
                        <small>{{singleComment.body}}</small> 
                    </div>
                </div> 
            </div>
        </div>
        <div class="text-center" v-if="dataComments.length > 0">
            <button v-if="!btnDisabled" @click="fetchComments" class=" btn btn-success mt-2">load more</button>
        </div>
    </div>
</template>

<script>
import Avatar from 'vue-avatar'

    export default {
        name: "comments",
        components:{Avatar},
        props:{
            video:{type: Object, required: true, default: ()=>({})},
            channel:{required: true, default: ()=>({})},
            userimage: ""
        },
        data: function(){
            return{
                dataComments: [],
                isDataFetched: false,
                userInf: [],
                page: 1,
                userLogged: false,
                btnDisabled: false,
                currentUser: {}
            }
        },
        methods:{
            getName: function(id){
                let user = this.userInf.filter((item)=>{
                    // console.log(item.comment_id + "==" + id)
                    return item.comment_id == id;
                })
                if(user[0]){
                    // console.log(user[0].name);
                    return user[0];
                }
                else{
                    return "    "
                }
            },
            fetchComments: function(){
                // console.log(`/videos/${this.video.id}/comments?page=${this.page}`);
                // hide button when max page ######
                axios.get(`/videos/${this.video.id}/comments?page=${this.page}`)
                .then((response)=>{
                    console.log(response.data);
                    let newData = response.data.data
                    const maxPage = response.data.last_page;
                    if(this.page <= maxPage){
                        newData.forEach(item => {
                            this.dataComments.push(item)
                        })
                        this.dataComments.forEach(element => {
                            axios.get(`/user/${element.user_id}`).then((res)=>{
                                console.log(res);
                                res.data['comment_id'] = element.id;
                                this.userInf = [
                                    ...this.userInf,
                                    res.data,
                                ];
                            });
                        });

                        this.page == maxPage ? this.btnDisabled=true : this.btnDisabled=false;

                        this.isDataFetched = true;
                        this.$forceUpdate();
                        this.page++;
                    }
                    else{
                        this.this.btnDisabled = true; 
                        alert('No more comments to load');
                    }
                })
                
            }
        },
        mounted() {
            this.fetchComments();
            console.log('Comments mounted.')
            if(__auth()){
                this.userLogged = true;
                this.currentUser = __auth();
            }
        }
    }
</script>

<style  scoped>
.comment-container{
    display: flex;
    flex-direction: row;
    align-content: left;;
}
.comment-container img{
    width: 50px;
    height: 50px;
}
.rounded-circle{
    width: 50px;
    height: 50px;
}
input{
    width: 70%;
    border: solid gray 1px;
    border-top: 0px;
    border-left: 0px;
    border-right: 0px;
}

</style>
