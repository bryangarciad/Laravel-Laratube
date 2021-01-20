<template>
    <details v-if="loaded" class="flex-xl-fill wrapper ">
        <summary class="text-center">View replies</summary>
        <div  class="flex-xl-fill wrapper ml-5 mb-5">
            <div  class="form-inline my-4 w-full replies-wrapper">
                <Avatar :username="currentUser.name" :size="25" ></Avatar>
                <input v-model="replyBody" type="text"  class="fomr-control form-control-sm w-90 ml-2" placeholder="Reply">
                <button @click="addReply" :disabled="!replyBody.length>0" class="btn btn-sm btn-primary ml-2">Reply</button>
            </div>
            <div v-for="reply in replies"  :key="reply.id" class="comment-container mt-3 d-flex" >
                <div class="mr-3">
                    <Avatar :username="reply.user.name" :size="25"></Avatar>
                </div>
                <div class="w-90">
                    <h4>{{reply.user.name}}</h4>
                    <small>{{reply.body}}</small> 
                </div>
            </div> 
        </div>
    </details>
</template>

<script>
import Avatar from 'vue-avatar'


export default {
    name: "replies",
    components: {Avatar},
    props:{
        commentId:{type: String, required: true, default:()=>{""}},
        currentUser:{type: Object, required:true, default:()=>({})},
        currentVideo: {type: Object, required: true, default:()=>({})}
    },
    data: function(){
        return{
            isUserLogged: false,
            replies: [],
            loaded: false,
            replyBody: ""
        };
    },
    methods:{
        getReplies: function(){
            axios.get(`/comments/${this.commentId}/replies`)
            .then((response)=>{
                if(response.data.length > 0){
                    this.replies = response.data.reverse();
                }
                this.loaded = true;
                console.log(response);
                this.$forceUpdate();
            })
        },
        addReply: function(){
            if(this.replyBody){
                const data = {
                    body: this.replyBody,
                    comment_id: this.commentId
                }

                axios.post(`/comments/${this.currentVideo.id}/comment`, data )
                .then((response)=>{
                    console.log(response);
                    this.replyBody = "";
                    const newReply = response.data;
                    newReply['user'] = __auth();
                    this.replies = [
                        newReply,
                        ...this.replies
                    ]
                })
            }
        },
    },
    mounted() {
        if(this.currentUser){
            this.getReplies();
        }
    }
}
</script>

<style scoped>
.wrapper{
    flex-basis: 100% !important;
margin-left: 0%;
}

input{
    width: 70%;
    border: solid gray 1px;
    border-top: 0px;
    border-left: 0px;
    border-right: 0px;
}

details summary::-webkit-details-marker {
  display:none;
}
details summary{
    color:blue
}
</style>
