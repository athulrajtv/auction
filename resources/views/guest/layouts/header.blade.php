<div id="main-wrapper">

    <!--Header section start-->
    <header class="header header-transparent header-sticky  d-lg-block d-none">
        <div class="header-deafult-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-2 col-md-4 col-12">
                        <!--Logo Area Start-->
                        <div class="logo-area">
                            <a href="index.php">
                                <h1 class="bidderhd">Bidderboy</h1>
                            </a>
                        </div>
                        <!--Logo Area End-->
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-4 d-none d-lg-block col-12">

                    </div>
                    <div class="col-xl-5 col-lg-4 col-md-5 col-12">
                        <!--Header Search And Mini Cart Area Start-->
                        <div class="header-search-cart-area">
                            <ul>
                                <li><a class=" slider__content--btn primary__btn" href="#">You have 2 credits</a></li>
                                <li><a class=" slider__content--btn primary__btn" href="#">Top up credits</a></li>
                                @if(Auth::check())
                                <li class="currency-menu"><a class=" slider__content--btn primary__btn" href="#">{{ Auth::user()->name }} - My Account</a>
                                    <!--Crunccy dropdown-->
                                    <ul class="currency-dropdown">


                                        <!--Account Currency Start-->
                                        <li><a href="my-account.php">My account</a>
                                            <ul>
                                                <li><a href="{{ route('guest.login.logout') }}">logout</a></li>
                                     

                                            </ul>
                                        </li>
                                        <!--Account Currency End-->
                                    </ul>
                                    <!--Crunccy dropdown-->
                                </li>
                                @endif

                            </ul>
                        </div>
                        <!--Header Search And Mini Cart Area End-->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--Header section end-->

</div>