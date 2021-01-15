<template>
    <div class="text-center">
        <button  @click="toggleSubscription" class="btn btn-danger" v-if="!owner">{{ (subscribed ? 'Unsubscribe' : 'Subscribe') }}</button>
        <span style="color:white" class="badge badge-info">{{count}} subscriber</span>
    </div>
</template>

<script>
import numeral from 'numeral';

    export default {
        name: 'subscribe-button',
        props:{
            initialsubscriptions: { type: Array, required: true, default: ()=>[]},
            channel: {type: Object, required: true, default: ()=>[]}
        },
        data: function(){
            return{
                subscriptions: this.initialsubscriptions
            }
        },
        mounted() {
            console.log(__auth());
        },
        computed: {
            subscribed:function(){
                if(!__auth() || this.channel.id === __auth().id) return false;
                return !! this.subscription;
            },
            owner: function(){
                if(!__auth()) return false;
                if(this.channel.user_id === __auth().id) return true;
                return false;
            },
            count(){
                return numeral(this.subscriptions.length).format('0a');
            },
            subscription: function (){
                if(!__auth()) return null;
                return this.subscriptions.find(item => item.user_id === __auth().id);
            }
        },
        methods:{
            toggleSubscription: function (){
                if(!__auth()){
                    console.log(__auth());
                    return alert('please login to subscribe');
                }
                else{

                }

                if(this.owner){
                    return alert("You're the owner man");
                }

                if(this.subscribed){
                    axios.delete(`/channels/${this.channel.id}/subscriptions/${this.subscription.id}`)
                    .then((res)=>{
                        this.subscriptions = this.subscriptions.filter(s => s.id !== this.subscription.id);
                    });
                }
                else{
                    axios.post(`/channels/${this.channel.id}/subscriptions`)
                    .then((res)=>{
                            this.subscriptions = [
                                ...this.subscriptions,
                                res.data
                            ]
                    });
                }
            }
        }
    }
</script>

