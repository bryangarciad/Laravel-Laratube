require('./bootstrap');

window.Vue = require('vue').default;


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('subscribe-button', require('./components/subscribe-button.vue').default);
Vue.component('channel-uploads', require('./components/channel-uploads.vue').default);
Vue.component('comments', require('./components/comments.vue').default);
Vue.component('votes', require('./components/votes.vue').default);


const app = new Vue({
    el: '#app',
});


