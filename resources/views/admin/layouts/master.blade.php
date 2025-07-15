<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @include('admin.layouts.links')

        <title>Online Auction</title>
    </head>

    <body>
        <!--start wrapper-->
        <div class="wrapper">

            @include('admin.layouts.sidebar')

            @include('admin.layouts.header')

            <!-- start page content wrapper-->
            <div class="page-content-wrapper">

                @yield('body')

            </div>
            <!--end page content wrapper-->

            @include('admin.layouts.footer')

            <!--Start Back To Top Button-->
            <a href="javaScript:;" class="back-to-top">
                <ion-icon name="arrow-up-outline"></ion-icon>
            </a>
            <!--End Back To Top Button-->


        </div>
        <!--end wrapper-->

        @include('admin.layouts.scripts')

    </body>

</html>