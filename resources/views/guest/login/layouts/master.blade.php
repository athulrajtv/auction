<!doctype html>
<html lang="en" class="light-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- loader-->
    @include('guest.login.layouts.links')

    <title>Login Page</title>
</head>
<body class="bg-white">

    <!--start wrapper-->
    <div class="wrapper">
        @yield('content')
    

    </div>
    @include('guest.login.layouts.scripts')
</body>
</html>