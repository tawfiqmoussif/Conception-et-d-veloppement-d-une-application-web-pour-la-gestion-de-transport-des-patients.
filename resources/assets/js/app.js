/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import store from './vuex/store'


window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';


import "chart.js"
import "hchs-vue-charts"
Vue.use(window.VueCharts)

import Vue from 'vue'
import Datetime from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(Datetime)

Vue.config.productionTip = false
Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('MM/DD/YYYY')
  }
});

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);


import swal from 'sweetalert2'
window.swal = swal;

const Toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.Toast = Toast;


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));


import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })
  
import VueGoodWizard from 'vue-good-wizard';

Vue.use(VueGoodWizard);

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue') },
    { path: '/developer', component: require('./components/Developer.vue') },
    { path: '/users', component: require('./components/Utilisateurs.vue') },
    { path: '/profile', component: require('./components/Profile.vue') },
    { path: '/brancardiers', component: require('./components/Brancardiers.vue')},
    { path: '/demandeurs', component: require('./components/Demandeurs.vue')},
    { path: '/majors', component: require('./components/Major.vue')},
    { path: '/services', component: require('./components/Services.vue')},
    { path: '/majorService', component: require('./components/MajorService.vue')},
    { path: '/coordinateurs', component: require('./components/Coordinateurs.vue')},
    { path: '/login', component: require('./components/auth/Login.vue')},
    { path: '/affecations', component: require('./components/Affecations.vue')},
    { path: '/affecationsBrancardier', component: require('./components/AffecationsBrancardier.vue')},
    { path: '/affecationsMajor', component: require('./components/AffecationsMajor.vue')},
    { path: '/urgencenormaux', component: require('./components/UrgenceNormaux.vue')},
    { path: '/urgencenormaux1', component: require('./components/UrgenceNormaux1.vue')},
    { path: '/Demandes', component: require('./components/Demandes.vue')},
    { path: '/DemandesMajor', component: require('./components/DemandesMajor.vue')},
    { path: '/DemandesBrancardier', component: require('./components/DemandesBrancardier.vue')},
    { path: '/DemandesDemandeurs', component: require('./components/DemandesDemandeurs.vue')},
    { path: '/declarerdemande', component: require('./components/DeclarerDemande.vue')},
    { path: '/declarerdemandemajor', component: require('./components/DeclarerDemandeMajor.vue')},
    { path: '/AffecterDemandes', component: require('./components/AffecterDemandes.vue')},
    { path: '/brancardiersMajor', component: require('./components/BrancardiersMajor.vue')},
    { path: '*', component: require('./components/Dashboard.vue') },
    
]

const router = new VueRouter({
    mode: 'hash',
    routes // short for routes: routes
  })



Vue.filter('upText', function(text){
    if(Text ==='') return Text;
    else
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate',function(created){
    return moment(created).format('DD MMMM YYYY', 'fr');
});

Vue.filter('changeTemp',function(Text){
    if(Text===1) return 'Oui'; 
    else return 'Non';
});

Vue.filter('Heure',function(created){
    return moment(created).format('HH');
});

Vue.filter('DateTest',function(created){
    return moment(created).format('MM/DD/YYYY'); 
});


Vue.filter('DateTrans',function(created){
    return moment(created).format('YYYY-MM-DD'); 
});



Vue.filter('DateComplet',function(created){
    return moment(created).format('YYYY-MM-DD HH:mm:ss'); 
});

Vue.filter('sans',function(Text){
    if(Text==='Sans') return 'not_active'; return Text;
});
window.Fire =  new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    'vue-login',
    require('./components/auth/Login.vue')
);

Vue.component(
    'DeclarerDemande',
    require('./components/DeclarerDemande')
);
Vue.component(
    'DemandesBrancardier',
    require('./components/DemandesBrancardier')
);
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);



Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue')
);

Vue.component(
    'vue-master',
    require('./components/Master.vue')
);

Vue.component(
    'master-brancardier',
    require('./components/MasterBrancardier.vue')
);

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    store,
    el: '#app',
    router,
    data:{
  
    },
    methods:{
        printme() {
            window.print();
        }
    }

});

    