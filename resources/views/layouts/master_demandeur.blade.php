
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Brancardage| Espace Demandeur</title>

  <!-- Font Awesome Icons -->
 <link rel="stylesheet" href="/css/app.css">
 <link rel="shortcut icon" href="/img/logo.ico">
<script>
      window.Laravel ={!! json_encode([
          'csrf' => csrf_token(),
          'pusher' => [
            'key' => config('broadcasting.connections.pusher.key'),
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
          ],
          'user' => auth()->check() ? auth()->user()->id : '',
      ])
      !!}
</script>
</head>
<body class="hold-transition sidebar-mini" style="min-height:100%">
<div class="wrapper" id="app">

  <master-brancardier></master-brancardier>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="./img/Logo_CHU.png" alt="chu Logo" class="img-circle" style="width:50px;height:50px;"
      style="opacity: .8">
      <span class="brand-text font-weight-light">Brancardage</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/img/profile/{{ Auth::user()->photo }}" class="img-circle elevation-2" alt="User Image" style="width:50px;height:50px;margin-left: -17px;">        </div>
        <div class="info">
          <a href="#" class="d-block">
           
            {{ Auth::user()->name }}

          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt #b8c7ce" style="font-size: 14px;"></i>
                  <p style="font-size: 14px;">
                    Dashboard
                    
                  </p>
                </router-link>
              </li>


              <li class="nav-item">
                <router-link to="/profile" class="nav-link">
                <i class="nav-icon fas fa-user #b8c7ce" style="font-size: 14px;"></i>
                  <p style="font-size: 14px;"> 
                    Profile demandeur
                    
                  </p>
                </router-link>
              </li>


              <li class="nav-item">
                <router-link to="/declarerdemande" class="nav-link">
                &nbsp;<i class="fas fa-procedures #b8c7ce" style="font-size: 14px;"></i>
                <p  style="font-size: 14px;">&nbsp;&nbsp;Déclarer une demande</p>
                </router-link>
              </li> 
         
              


                      
            
          <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
         <i class="nav-icon fa fa-power-off #b8c7ce"  style="font-size: 14px;"></i>
         <p style="font-size: 14px;">
            {{ __('Quiter') }}

         </p>
             </a>

             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
             </form>

              </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

          <router-view></router-view>
       
          <vue-progress-bar></vue-progress-bar>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- Main Footer -->
  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->


<script src="/js/app.js"></script>

</body>
</html>
 