<header class="header">

    <!-- Topbar - start -->
    <div class="header_top">
        <div class="container">
@include('allstor::inc.headersocial')
        </div>
    </div>
    <!-- Topbar - end -->

    <!-- Logo, Shop-menu - start -->
    <div class="header-middle">
        <div class="container header-middle-cont">
            <div class="toplogo">
                <a href="index.html">
                    <img src="{{ Module::asset('allstor:img/logo.png') }}" alt="AllStore - MultiConcept eCommerce Template">
                </a>
            </div>
            <div class="shop-menu">
                @include('allstor::inc.headertopmenu')
                
            </div>
        </div>
    </div>
    <!-- Logo, Shop-menu - end -->

    <!-- Topmenu - start -->
    <div class="header-bottom">
        <div class="container">
            <nav class="topmenu">
@include('allstor::inc.headermenu')        

            </nav>		
        </div>
    </div>
    <!-- Topmenu - end -->

</header>