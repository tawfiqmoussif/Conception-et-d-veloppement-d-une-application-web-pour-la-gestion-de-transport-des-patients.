<template>
    <!-- Navbar -->
    
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
     
    </ul>
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link"  @click="makeAsRead" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="fas fa-user-plus"></i>
          <span v-show="unreadNotifications.length!=0" class="badge badge-danger navbar-badge">{{unreadNotifications.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div v-for="notification in notifications" :key="i">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="User" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  {{notification.data.user.name}}
                  <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">{{notification.data.user.email}}</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          </div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="fa fa-th-large"></i></a>
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
      'va': 'vue2-admin-lte/src'
    }
  },
   props: ['userid'],
   data () {
        return {
           notifications:[],
           user:''
        }
  },
  computed:{
      unreadNotifications(){
        
        return this.notifications.filter(notification=>{
          return notification.read_at == null
        })
      }
  },
  methods:{
    makeAsRead(){
       axios.get('/api/mark-all-read/'+this.user.id).then(response=>{
         this.unreadNotifications=[],
         this.loadNotifications();
         unreadNotifications();
       });
       
    },
    loadNotifications(){
      axios.get('api/notifications').then(({data})=>(
         this.notifications=data.notifications.notifications,
         this.user=data.user
     ));
    }

  },
  created(){
    //this.notifications=window.user.demande.notifications;
    //console.log('user',window.user)
     this.$options.interval = setInterval(this.loadNotifications, 1000)
    console.log(this.$options.interval !== null)  
    this.loadNotifications();
  /*  Echo.private(`App.User.`+this.user.id)
    .notification((notification) => {
        console.log(notification,'new notif');
    });*/
  
  },
   mounted () {
      // Do something useful with the data in the template
      //console.log(this.userId)
      // Echo.private('App.User.' + this.userid)
      //   .notification((notification) => {
      //       console.log(notification);
      //   });
    },
    beforeDestroy () {
      clearInterval(this.$options.interval)
    }
}

</script>

<style>
  @import '/css/adminelte.min.css';
</style>
