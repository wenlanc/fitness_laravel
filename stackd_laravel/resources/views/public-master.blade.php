<!-- include header -->
@include('includes.header')
<!-- /include header -->

<body id="page-top" class="lw-page-bg lw-public-master">
    <!-- Page Wrapper -->
    <div id="wrapper" class="p-3 mb-2">
        <!-- include sidebar -->
        @if(isLoggedIn())
        @include('includes.public-sidebar')
        @endif
        <!-- /include sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column lw-page-bg position-relative">
            <div id="content">
                <!-- include top bar -->
                @if(isLoggedIn() && 0)
                  <!-- Topbar  -->  
                  @include('includes.public-top-bar')
                @endif
                <?php 
                    $sponer_side_show = (Route::getCurrentRoute()->getName() != "user.read.messenger" && Route::getCurrentRoute()->getName() != "user.read.pt_list" && Route::getCurrentRoute()->getName() != "user.profile_view" && Route::getCurrentRoute()->getName() != "user.pt_profile_view" );
                    $sponser_bottom_show = (Route::getCurrentRoute()->getName() == "user.read.messenger");
                ?>
                <!-- /include top bar -->
                <div style="display: flex;width: 100%;<?= $sponer_side_show?"height:100%;":"" ?>">
                    <!-- Begin Page Content -->
                    <div class="lw-page-content" style="width:100%;min-height:calc( 22vw + 860px );;margin-bottom: 0px; max-height:min-height:calc( 22vw + 860px );; overflow-y: auto; overflow-x:hidden;">
                        <!-- header advertisement -->
                        @if(!getFeatureSettings('no_adds') and getStoreSettings('header_advertisement')['status'] == 'true')
                        <!-- <div class="lw-ad-block-h90">
                            <?php 
                                //echo getStoreSettings('header_advertisement')['content']; 
                            ?>
                        </div> -->
                        @endif
                        <!-- /header advertisement -->
                        @if(isset($pageRequested))
                        <?php echo $pageRequested; ?>
                        @endif
                        <!-- footer advertisement -->
                        @if(!getFeatureSettings('no_adds') and getStoreSettings('footer_advertisement')['status'] == 'true')
                        <div class="lw-ad-block-h90">
                            <?= getStoreSettings('footer_advertisement')['content'] ?>
                        </div>
                        @endif
                        <!-- /footer advertisement -->
                    </div>
                    @if($sponer_side_show)
                        @include('includes.sponsers')
                    @endif

                </div>
                    
                @if($sponser_bottom_show)
                    @include('includes.sponsers_chat')
                @endif
                <!-- /.container-fluid -->
            </div>
        </div>
        <!-- End of Content Wrapper -->
        
    </div>
    <!-- End of Page Wrapper -->

    @if((Route::getCurrentRoute()->getName() == "user.profile_view") || Route::getCurrentRoute()->getName() == "user.pt_profile_view")
            @include('includes.sponsers_profile')
        @endif

    <div class="lw-cookie-policy-container row p-4" id="lwCookiePolicyContainer">
        <div class="col-sm-11">
            @include('includes.cookie-policy')
        </div>
        <div class="col-sm-1 mt-2"><button id="lwCookiePolicyButton" class="btn btn-primary"><?= __tr('OK') ?></button></div>
    </div>
    <!-- include footer -->
    @include('includes.footer')
    <!-- /include footer -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- /Scroll to Top Button-->
    @include('modals.logout')
    @include('modals.support')
    
</body>

</html>