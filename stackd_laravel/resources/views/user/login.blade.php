@section('page-title', __tr('Login'))
@section('head-title', __tr('Login'))
@section('keywordName', strip_tags(__tr('Login')))
@section('keyword', strip_tags(__tr('Login')))
@section('description', strip_tags(__tr('Login')))
@section('keywordDescription', strip_tags(__tr('Login')))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- include header -->
@include('front-include.header')
<!-- /include header -->

<body class="lw-login-register-page" style="font-family: 'Poppins', sans-serif;">
    <div class="lw-page-bg lw-lazy-img" data-src="<?= __yesset("imgs/home/random/*.jpg", false, [
                                                        'random' => true
                                                    ]) ?>"></div>
    <!-- Outer Row -->
    <div class="container v-center">
        <div class="card border-2 login-form">
            <div class="row">
                <div class="d-none d-lg-flex col-md-6 p-0">
                    <!-- Text -->
                    <div style="background-image: url('../dist/blackfit/images/rectangle-118@2x.png');" class="ui-bg-cover">

                    </div>
                    <div class="w-100 text-white px-5 left-box mt-5 pt-5" style="z-index: 99;">
                        <a class="font-weight-bolder mb-4">{{ getStoreSettings('name') }}</a>
                        <div class="mt-3 sentence text-large font-weight-light">
                            You place to get {{ getStoreSettings('name') }}. community
                        </div>
                    </div>
                </div>
                <div class="col login-outer">
                    <div class="o-hidden">
                        <div class="card-body p-5">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="login-form">
                                        <div class="text-center">
                                            <hr class="mt-4 mb-4">
                                            <h4 class="signin text-gray-200 mb-4">Sign In to {{ getStoreSettings('name') }}</h4>
                                            @if(session('errorStatus'))
                                            <!--  success message when email sent  -->
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <?= session('message') ?>
                                            </div>
                                            <!--  /success message when email sent  -->
                                            @endif
                                        </div>
                                        <!-- login form -->
                                        <form class="lw-form-has-errors user lw-ajax-form lw-form" data-callback="onLoginCallback" method="post" action="<?= route('user.login.process') ?>" data-show-processing="true" data-secured="false">
                                            <!-- email input field -->
                                            <div class="form-group">
                                                <lable class="form-label">Email Address</lable>
                                                <input type="text" class="form-control form-control-user" name="email_or_username" aria-describedby="emailHelp" placeholder="<?= __tr('Enter Email Address or Username ...') ?>" required>
                                            </div>
                                            <!-- / email input field -->

                                            <!-- password input field -->
                                            <div class="form-group">
                                                <lable class="form-label">Password</lable>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="<?= __tr('Password') ?>" required minlength="6">
                                                    <i class="fa fa-eye col-1 my-auto input-icon " id="togglePassword"></i>
                                                </div>
                                            </div>
                                            <!-- password input field -->

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="cc-container text-gray-200 small"><?= __tr('Remember Me')  ?>
                                                            <input type="checkbox" class="custom-control-input" id="rememberMeCheckbox" name="remember_me">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <!-- forgot password button -->
                                                    <div class="text-right">
                                                        <a class="small forgot" href="<?= route('user.forgot_password') ?>"><?= __tr('Forgot Password?')  ?></a>
                                                    </div>
                                                    <!-- / forgot password button -->
                                                </div>
                                            </div>
                                            <!-- remember me input field -->
                                            <!-- remember me input field -->

                                            <div class="row">
                                                <div class="m-auto">
                                                    <!-- login button -->
                                                    <button type="submit" value="Login" class="lw-ajax-form-submit-action btn btn-main-color btn-user btn-block"><?= __tr('Sign In')  ?>
                                                        <i class="fa fa-arrow-right ml-2"></i>
                                                    </button>
                                                    <!-- / login button -->

                                                </div>
                                            </div>
                                            <!-- social login links -->
                                            @if(getStoreSettings('allow_google_login'))
                                            <a href="<?= route('social.user.login', [getSocialProviderKey('google')]) ?>" class="btn btn-google btn-user btn-block">
                                                <i class="fab fa-google fa-fw"></i> <?= __tr('Login with Google')  ?>
                                            </a>
                                            @endif
                                            @if(getStoreSettings('allow_facebook_login'))
                                            <a href="<?= route('social.user.login', [getSocialProviderKey('facebook')]) ?>" class="btn btn-facebook btn-user btn-block">
                                                <i class="fab fa-facebook-f fa-fw"></i> <?= __tr('Login with Facebook')  ?>
                                            </a>
                                            @endif
                                            <!-- social login links -->
                                        </form>
                                        <!-- / login form -->

                                        <!-- create account button -->
                                        <div class="mt-4 text-center">
                                            <a class="signup" href="<?= route('user.sign_up') ?>">Don't have an Account ?</a>
                                        </div>
                                        <!-- / create account button -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
@include('front-include.js')
<script>
    //on login success callback
    function onLoginCallback(response) {
        //check reaction code is 1 and intended url is not empty
        if (response.reaction == 1 && !_.isEmpty(response.data.intendedUrl)) {
            //redirect to intendedUrl location
            _.defer(function() {
                window.location.href = response.data.intendedUrl;
            })
        }
    }
    $('#togglePassword').on('click', function(e) {
        e.preventDefault();
        let x = document.getElementById("password");
        let toggle = $('#togglePassword');
        if (x.type === "password") {
            x.type = "text";
            $('#togglePassword').removeClass('fa-eye');
            $('#togglePassword').addClass('fa-eye-slash');
        } else {
            x.type = "password";
            $('#togglePassword').removeClass('fa-eye-slash');
            $('#togglePassword').addClass('fa-eye');
        }
    });
</script>