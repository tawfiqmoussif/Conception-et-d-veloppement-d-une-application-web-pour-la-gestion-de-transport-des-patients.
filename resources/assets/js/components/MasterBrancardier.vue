<template>
  <!-- Navbar -->

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input
          class="form-control form-control-navbar"
          type="search"
          placeholder="Search"
          aria-label="Search"
        />
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" @click="makeAsRead" data-toggle="dropdown" href="#">
          <i class="fas fa-bell"></i>
          <span v-show="unreadNotifications.length!=0" class="badge badge-danger navbar-badge">{{unreadNotifications.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{notifications.length}} Notifications</span>
          <div class="dropdown-divider"></div>
          <div v-for="notification in notifications" :key="i">
           <router-link to="/demandesBrancardier" class="dropdown-item">
              {{notification.data.serviceSource[0].intitule}} to  {{notification.data.serviceDestination[0].intitule}} 
              <span class="float-right text-muted text-sm">{{notification.data.demande.created_at}}</span>
           </router-link>
            <div class="dropdown-divider"></div>
          </div>
         <router-link to="/demandesBrancardier" class="dropdown-item dropdown-footer">See All Notifications</router-link>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fa fa-th-large"></i>
        </a>
      </li>
    </ul>
    <!-- SEARCH FORM --
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    -->
    <!-- Right navbar links -->
  </nav>
  <!-- /.navbar -->
</template>
<script>
import VueTimers from 'vue-timers'
export default {
  resolve: {
    alias: {
      va: "vue2-admin-lte/src"
    }
  },
  data() {
    return {
      notifications: [],
      user: "",
      timer: '',
    };
  },
   props: ['userid'],
  computed: {
    unreadNotifications() {
      return this.notifications.filter(notification => {
        return notification.read_at == null;
      });
    }
  },
  methods: {
    makeAsRead(){
       axios.get('/api/mark-all-read/'+this.user.id).then(response=>{
         this.unreadNotifications=[],
         this.loadNotifications();
         unreadNotifications();
       });
       
    },
    loadNotifications() {
      axios
        .get("api/notifications")
        .then(
          ({ data }) => (
            (this.notifications = data.notifications.notifications),
            (this.user = data.user)
          )
        );
    },
  },
  created() {
    //this.notifications=window.user.demande.notifications;
    //console.log('user',window.user)
    this.loadNotifications();
    this.$options.interval = setInterval(this.loadNotifications, 1000)
    console.log(this.$options.interval !== null)  
     this.fetchEventsList();
        this.timer = setInterval(this.fetchEventsList, 1000)

  },
  mounted() {
    // Do something useful with the data in the template
    //  console.log("broadcast");
      Echo.private(`demandes.${this.userid}`)
      .listen('NewDemande',(e) => {
        console.log(e.demande) 
      })
  },
  beforeDestroy () {
      clearInterval(this.$options.interval)
    }
};
</script>

<style>
@import "/css/adminelte.min.css";
</style>
