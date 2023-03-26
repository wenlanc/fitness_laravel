    <!-- Main Header-->
    <header class="main-header header-style-one">

        <!--Header-Upper-->
        <div class="header-upper">
            <div class="outer-container">
                <div class="inner-container clearfix">

                    <!-- Logo Box -->
                    <div class="logo-box">
                        <div class="logo"><a href="<?= route('landing_page') ?>"><img src="<?= getStoreSettings('logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>" title=""></a></div>
                    </div>

                    <!-- Logo -->
                    <div class="mobile-logo pull-left">
                        <a href="<?= route('landing_page') ?>" title=""><img src="<?= getStoreSettings('logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>" title=""></a>
                    </div>

                    <!-- Header Social Box -->
                    <div class="header-social-box clearfix">
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-instagram"></a>
                        <a href="#" class="fa fa-linkedin"></a>
                    </div>

                    <div class="outer-box clearfix">

                        <!-- Hidden Nav Toggler -->
                        <div class="nav-toggler mr-4">
                            <div class="nav-btn"><button class="hidden-bar-opener"><a href="<?= route('user.sign_up') ?>">SIGN UP</a></button></div>
                        </div>
                        <div class="nav-toggler mr-4">
                            <div class="nav-btn"><button class="hidden-bar-opener"><a href="<?= route('user.login') ?>">LOG IN</a></button></div>
                        </div>
                        <div class="nav-toggler" id="nav-toggler">
                            <div class="nav-btn"><button class="hidden-bar-opener">MENU</button></div>
                        </div>
                        <!-- / Hidden Nav Toggler -->

                    </div>

                    <div class="nav-outer clearfix">
                        <!--Mobile Navigation Toggler-->
                        <div class="mobile-nav-toggler"><span class="icon"><img src="dist/blackfit/images/icons/burger.svg" alt="" /></span></div>
                        <!-- Main Menu -->
                        <nav class="main-menu navbar-expand-md">
                            <div class="navbar-header">
                                <!-- Toggle Button -->
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <li><a href="<?= route('landing_page') ?>">HOME</a></li>
                                    <li><a href="<?= route('user.sign_up') ?>">SIGN UP</a></li>
                                    <li><a href="<?= route('user.login') ?>">LOG IN</a></li>
                                    <li><a href="<?= route('about_page') ?>">BLOG</a></li>
                                    <li><a href="<?= route('about_page') ?>">ABOUT US</a></li>
                                    <li><a href="<?= route('about_page') ?>">CONTACT US</a></li>
                                </ul>
                            </div>
                        </nav>

                    </div>

                </div>

            </div>
        </div>
        <!--End Header Upper-->

        <!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container clearfix">
                <!--Logo-->
                <div class="logo pull-left">
                    <a href="<?= route('landing_page') ?>" title=""><img src="<?= getStoreSettings('logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>" title=""></a>
                </div>
                <!--Right Col-->
                <div class="pull-right">
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <!--Keep This Empty / Menu will come through Javascript-->
                    </nav><!-- Main Menu End-->

                </div>
            </div>
        </div><!-- End Sticky Menu -->

        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="icon flaticon-multiply"></span></div>

            <nav class="menu-box">
                <div class="nav-logo"><a href="<?= route('landing_page') ?>"><img src="<?= getStoreSettings('logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>" title=""></a></div>
                <div class="menu-outer">
                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                </div>
            </nav>

        </div>
        <!-- End Mobile Menu -->

    </header>
    <!-- End Main Header -->

    <!-- FullScreen Menu -->
    <div class="fullscreen-menu">
        <!--Close Btn-->
        <div class="close-menu"><span>Close</span></div>

        <div class="menu-outer-container">
            <div class="menu-box">
                <nav class="full-menu">
                    <ul class="navigation">
                        <li><a href="<?= route('landing_page') ?>">HOME</a></li>
                        <li><a href="<?= route('user.sign_up') ?>">SIGN UP</a></li>
                        <li><a href="<?= route('user.login') ?>">LOG IN</a></li>
                        <li><a href="<?= route('about_page') ?>">BLOG</a></li>
                        <li><a href="<?= route('about_page') ?>">ABOUT US</a></li>
                        <li><a href="<?= route('about_page') ?>">CONTACT US</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- End FullScreen Menu -->