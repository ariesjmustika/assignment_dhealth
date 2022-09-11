<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PT. Arkmaya |
    {{ Request::is('login') ? 'Login' : 'Register' }}
  </title>

  <!-- Icon  -->
  <link rel="shortcut icon" href="https://www.arkamaya.co.id/assets/images/arka/favicon2.png">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset ('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset ('assets/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset ('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

  <style>
    #background-video {
        width: 100vw;
        height: 100vh;
        object-fit: cover;
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: -1;
    }
  </style>
</head>
<body class="hold-transition login-page">

    <video id="background-video" autoplay loop >
        <source src="{{ asset ('assets/video/background.mp4') }}" type="video/mp4">
    </video>
@yield('content')

<!-- jQuery -->
<script src="{{ asset ('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset ('assets/plugins/jquery-validation/jquery.validate.js') }}"></script>
<script src="{{ asset ('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset ('assets/js/custom.js') }}">

</script>
</body>
</html>
