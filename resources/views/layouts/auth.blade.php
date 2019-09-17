
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
<meta charset="utf-8">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Health medical template project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="/health/styles/bootstrap4/bootstrap.min.css">
<link href="/health/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="/health/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="/health/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="/health/plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="/health/styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="/health/styles/responsive.css">
<link rel="stylesheet" type="text/css" href="/css/login-register.css">
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
<body>

  <div >
    @yield('content')
  </div>

<script src="/js/app.js"></script>
<script src="/js/login-register.js"></script>

<script src="/health/js/jquery-3.3.1.min.js"></script>
<script src="/health/styles/bootstrap4/popper.js"></script>
<script src="/health/styles/bootstrap4/bootstrap.min.js"></script>
<script src="/health/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="/health/plugins/easing/easing.js"></script>
<script src="/health/plugins/parallax-js-master/parallax.min.js"></script>
<script src="/health/js/custom.js"></script>
</body>
</html>