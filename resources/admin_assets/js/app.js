window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import Vue from 'vue'
import vuetify from './plugins/vuetify' // path to vuetify export
import App from './components/App'
import router from './router'
import store from './store';
import CKEditor from '@ckeditor/ckeditor5-vue';

window.tinymce = require('tinymce/tinymce');

Vue.use(CKEditor);

new Vue({
    vuetify,
    router,
    store,
    el: '#app',
    render: h => h(App),
})
