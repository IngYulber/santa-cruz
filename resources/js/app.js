import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { fas } from '@fortawesome/free-solid-svg-icons'

library.add(fas)
require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('fa', FontAwesomeIcon)

Vue.component('dashboard', require('./pages/Dashboard.vue').default)
Vue.component('colaboradores', require('./pages/Colaboradores.vue').default)
Vue.component('cobranza', require('./pages/Cobranza.vue').default)

const app = new Vue({
    el: '#app'
})
