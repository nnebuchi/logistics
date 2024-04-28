<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <base href="{{url('')}}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        <meta name="csrf-token" content="{{csrf_token()}}">

        <meta name="theme-color" content="" />
        <meta name="apple-mobile-web-app-status-bar-style" content="" />
        <title>Ziga Afrika Dashboard</title>
        <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/favicon.png')}}" />
        <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />
        <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/sweetalert2.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Buchi JS plugin  -->
        <script src="{{asset('assets/plugins/buchi.js')}}"></script>
        <?php date_default_timezone_set("Africa/Lagos"); ?>

        <script>
            const url = "{{ url('/') }}";
          </script>
    </head>
    <style>
        .error{
            color: red;
            font-size: 14px;
        }
    </style>
    <body>