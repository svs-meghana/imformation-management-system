<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IMS Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{URL::asset('assets/vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{URL::asset('assets/css/argon.css')}}" rel="stylesheet">
    <!-- Docs CSS -->

    <link type="text/css" href="{{URL::asset('assets/css/main.css')}}" rel="stylesheet">
    <link type="text/css" href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{URL::asset('assets/css/style.css')}}">
  @yield('head')
</head>

@yield('content')


<script src="{{URL::asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/popper/popper.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/headroom/headroom.min.js')}}"></script>
<!-- Optional JS -->
<script src="{{URL::asset('assets/vendor/onscreen/onscreen.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/nouislider/js/nouislider.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Argon JS -->
<script src="{{URL::asset('assets/js/argon.js')}}"></script>
<script src="{{URL::asset('assets/js/particles.js')}}"></script>
<script src="{{URL::asset('assets/js/app.js')}}"></script>
<!-- <script type="text/javascript" src="{{URL::asset('assets/js/jquery.min.js')}}"></script> -->
</body>

</html>