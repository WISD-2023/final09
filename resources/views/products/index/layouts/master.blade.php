<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="icon" type="image/x-icon" href="{{asset('assets/favicon.ico')}}" />
{{--        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">--}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <link href="{{asset('css/homepage-styles.css')}}" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .custom-link {
                color: black; /* 設置字體顏色為黑色 */
                text-decoration: none; /* 移除下劃線 */
            }
        </style>
    </head>
    <body>
        @include('layouts.partials.navigation')
        <section id="location">
            <hr>
            <div style="padding-left: 150px;">
                @yield('page-path')
            </div>
            @yield('content')
        </section>
        @include('layouts.partials.footer')
    </body>
<html>
