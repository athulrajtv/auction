<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bidderboy</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @include('guest.layouts.links')
        
    </head>
    <body>

        @include('guest.layouts.header')

        @yield('body')

        @include('guest.layouts.scripts')

    </body>
</html>