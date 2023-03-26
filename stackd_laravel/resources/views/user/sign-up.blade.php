<?php $pageTitle = __tr('Create an Account'); ?>
@section('page-title', $pageTitle)
@section('head-title', $pageTitle)
@section('keywordName', strip_tags(__tr('Create an Account!')))
@section('keyword', strip_tags(__tr('Create an Account!')))
@section('description', strip_tags(__tr('Create an Account!')))
@section('keywordDescription', strip_tags(__tr('Create an Account!')))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- include header -->
@include('front-include.header')
<!-- /include header -->

<style>
    body {
        background: #282828;
    }

    .custom-control-input:checked~.custom-check {
        background: #ff4141;
    }

    li.active span.sw-number {
        background: rgba(255, 255, 255, 0.303649);
    }
    .lw-user-gym-select-box div.items div.item{
        border-radius: 14px!important;
        border: 2px solid #ff4141!important;
        background: transparent!important;
        color: #ff4141!important;
    }

    .pt_availablity_weekday {
        font-family: Nunito Sans;
        font-style: normal;
        font-weight: bold;
        font-size: 13px;
        line-height: 18px;
        /* identical to box height */
        flex:1;

        color: #FF3F3F;
    }

    .pt_availablity_weekday_daytime,.pt_availablity_weekday_nighttime {
        border-radius: 10px;
        height: 22px;
        border: none;
        align-content: center;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0px;
        display:flex;
        max-width:65px;
        color:white;
    }

    .pt_availablity_weekday_daytime.checked,.pt_availablity_weekday_nighttime.checked {
        background: #FF3F3F;
    }

    .pt_availablity_weekday_daytime i,.pt_availablity_weekday_nighttime i {
        font-size:14px;
    }
    .pt_availablity_weekday, .pt_availablity_time
    {
        flex:1;
    }
    .pt_availablity_time{
        padding-left:0.25rem;
        padding-right:0.25rem
    }

    .custom-checkbox input:invalid:required ~ .custom-control-label:after,
    .custom-checkbox select:invalid:required ~ .custom-control-label:after,
    .custom-checkbox textarea:invalid:required ~ .custom-control-label:after {
        content: " *";
        color: #ff4141;
        left: unset;
        right: -18px;
        top: 2px;
    }
    .custom-checkbox label.lw-validation-error {
        text-align: left;
    }
    .custom-control-input:checked~.custom-check {
        background: #FF3F3F;
        border:1px solid #FF3F3F;
    }
    .custom-control-input~.custom-check {
        background: transparent;
        border: 1px solid #C4C4C4;
        box-sizing: border-box;
    }

    .custom-control-input:checked~.custom-check {
        background: #FF3F3F;
        border:1px solid #FF3F3F;
    }
    .custom-checkbox .custom-control-input:disabled:checked ~ .custom-control-label::before {
        background-color: #686976;
        border-color: #686976;
    }

    .table-pricing thead th{
        border: none;
        background-color: transparent;
    }    

    .table-pricing td {
        border: none;
    }
    .table-pricing {
        border: none;
    }

    .table-pricing th, .table-pricing td {
        padding: 0.5rem;
    }

    @media (min-width: 992px) {
    .modal-lg,
    .modal-xl {
        max-width: 800px; } }

    @media (min-width: 1200px) {
    .modal-xl {
        max-width: 1140px; } }

    .custom-radio .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #ff4141;
    }

</style>
<link href="{{ asset('dist/smartwizard/smartwizard.css') }}" rel="stylesheet">
<link href="{{ asset('dist/flatpicker/flatpickr.css') }}" rel="stylesheet">
<link href="{{ asset('dist/cropper/cropper.css') }}" rel="stylesheet">

<body class="lw-login-register-page dark-style">

    <!-- Preloder -->
    <div id="preloder" class="preloader">
        <div class="loader"></div>
    </div>
    <!-- Εnd Preloader -->

    <div class="lw-page-bg lw-lazy-img" data-src="<?= __yesset('imgs/home/random/*.jpg', false, [
                                                        'random' => true,
                                                    ]); ?>" style="font-family: 'Poppins', sans-serif;"></div>
    
    <div class="container v-center1" id="selectUserTypeContainer" style="padding-bottom:1rem;display: flex;height: 100vh;">
        <div class="signup-outer" style="margin-top:auto; margin-bottom:auto;">
            <div class="d-flex">
                <div class="d-flex" style="z-index: 1000;flex:1;background:#FF3F3F;border-top-left-radius: 2rem;border-bottom-left-radius: 2rem;padding-top:40px;padding-left:35px;">
                    <div class="row" style="font-family: Nunito Sans;font-style: normal;color:white;">
                        <div class="col-lg-12 d-flex" style="font-weight: bold;font-size: 1.5rem;line-height: 24px;"> 
                            <div style="background: #C4C4C4;border-radius: 10px;width:50px;height:50px;margin-top: 10px;">

                            </div>
                            <div style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 30px;line-height: 41px;display: flex;align-items: center;padding-left: 20px;">
                                STACKD
                            </div>                        
                        </div>
                        <div class="col-lg-12" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;text-align: center;">
                             <img src="/imgs/partner_signup_logo.png" style="margin-top:-40px;"/>                             
                        </div>
                        <div class="col-lg-12" style="font-weight: bold;font-size: 40px;line-height: 56px;text-align:center;margin-top:-20px;"> 
                             PARTNER                       
                        </div>
                        <div class="col-lg-12" style="font-weight: bold;font-size: 24px;line-height: 36px;text-align:center;padding-top:10px;">
                            Training at the gym just became a lot more social. Find your friends in your area.
                        </div>
                        <div class="col-lg-12 text-center" > 
                            <button class="" id="btnSelectPartner" style="margin-bottom:30px;margin-top:40px;padding:10px 20px;border-radius: 14px;font-weight: bold;font-size: 16px;line-height: 22px;color: #FF3F3F;">
                                <span style="padding-right:7px;"> Partner </span> 
                                <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7903 5.3871L15.7071 5.29289L10.7071 0.292893C10.3166 -0.0976311 9.68342 -0.0976311 9.29289 0.292893C8.93241 0.653377 8.90468 1.22061 9.2097 1.6129L9.29289 1.70711L12.585 5H1C0.447715 5 0 5.44772 0 6C0 6.51284 0.38604 6.93551 0.883379 6.99327L1 7H12.585L9.29289 10.2929C8.93241 10.6534 8.90468 11.2206 9.2097 11.6129L9.29289 11.7071C9.65338 12.0676 10.2206 12.0953 10.6129 11.7903L10.7071 11.7071L15.7071 6.70711C16.0676 6.34662 16.0953 5.77939 15.7903 5.3871Z" fill="#FF3F3F"/>
                                </svg>
                            </button>                       
                        </div>
                    </div>
                </div>

                <div class="p-4 d-flex" style="z-index: 1000;flex:1;background:#191919; border-top-right-radius: 2rem;border-bottom-right-radius: 2rem;">
                    <div class="row" style="font-family: Nunito Sans;font-style: normal;color:white;">
                        <div class="col-lg-12 d-flex" style="font-weight: bold;font-size: 1.5rem;line-height: 24px;"> 
                                              
                        </div>

                        <div class="col-lg-12" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;text-align: center;">
                             <img src="/imgs/pt_signup_logo.png" style="margin-top:60px;"/>                             
                        </div>

                        <div class="col-lg-12" style="font-weight: bold;font-size: 40px;line-height: 56px;text-align:center;margin-top:-20px;"> 
                            PERSONAL TRAINER                       
                        </div>
                        <div class="col-lg-12" style="font-weight: bold;font-size: 24px;line-height: 36px;text-align:center;padding-top:10px;">
                            Japan’s only dedicated platform for fitness. Build your business and enhance your reputation.
                        </div>

                        <div class="col-lg-12 text-center" > 
                            <button class="" id="btnSelectPt" style="margin-bottom:30px;margin-top:40px;padding:10px 20px;border-radius: 14px;font-weight: bold;font-size: 16px;line-height: 22px;color: white;background: #FF4141;">
                                <span style="padding-right:7px;"> &nbsp;&nbsp;&nbsp;&nbsp;PT&nbsp;&nbsp;&nbsp;&nbsp; </span> 
                                <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7903 5.3871L15.7071 5.29289L10.7071 0.292893C10.3166 -0.0976311 9.68342 -0.0976311 9.29289 0.292893C8.93241 0.653377 8.90468 1.22061 9.2097 1.6129L9.29289 1.70711L12.585 5H1C0.447715 5 0 5.44772 0 6C0 6.51284 0.38604 6.93551 0.883379 6.99327L1 7H12.585L9.29289 10.2929C8.93241 10.6534 8.90468 11.2206 9.2097 11.6129L9.29289 11.7071C9.65338 12.0676 10.2206 12.0953 10.6129 11.7903L10.7071 11.7071L15.7071 6.70711C16.0676 6.34662 16.0953 5.77939 15.7903 5.3871Z" fill="white"/>
                                </svg>
                            </button>                       
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container v-center1" id="selectUserRegisterContainer" style="display:none;padding-bottom:1rem;">
        <div class="signup-outer" style="height: 100vh;display:flex;">
            <div id="smartwizard-6" class="user smartwizard-vertical-left" style="margin-top:auto; margin-bottom:auto;min-height: 750px;">
                <ul class="card px-4 pt-3 mr-3 step-signup col-4">
                    <div class="w-100 color-white app-name mt-5">
                        {{ getStoreSettings('name') }}
                    </div>
                    <div class="w-100 color-white start mt-5 mb-5">
                        Get started
                    </div>
                    <li class="w-100 position-relative"><a href="#smartwizard-6-step-1" class="text-nowrap mb-3 ">
                            <span class="sw-done-icon ion ion-md-checkmark"></span>
                            <span class="sw-number"></span>
                            Welcome
                        </a>
                        <div class="progressbar"></div>
                    </li>
                    <li class="w-100 position-relative"><a href="#smartwizard-6-step-2" class="text-nowrap mb-3">
                            <span class="sw-done-icon ion ion-md-checkmark"></span>
                            <span class="sw-number"></span>
                            Your Details
                        </a>
                        <div class="progressbar"></div>
                    </li>
                    <li class="w-100 position-relative"><a href="#smartwizard-6-step-3" class="text-nowrap mb-3">
                            <span class="sw-done-icon ion ion-md-checkmark"></span>
                            <span class="sw-number"></span>
                            Availablity
                        </a>
                        <div class="progressbar"></div>
                    </li>
                    <li class="w-100 position-relative"><a href="#smartwizard-6-step-4" class="text-nowrap mb-3">
                            <span class="sw-done-icon ion ion-md-checkmark"></span>
                            <span class="sw-number"></span>
                            Location and Gyms
                        </a>
                    </li>
                </ul>
                <div class="step-container">
                    
                    <div id="smartwizard-6-step-1" class="card animated fadeIn">
                        <div class="card-body padding-box">
                            <div class="text-center">
                                <label class="color-app-red">Step 1/4</label>
                            </div>
                            <div class="text-center mt-2">
                                <label class="step-title" style="color:white;">Welcome</label>
                            </div>

                            <div class="text-center mt-2">
                                <div class="btn p-0 mr-2 partner">
                                    <button class="btn btn-secondary w-100 usertype type-partner" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 18px;line-height: 30px;border-radius: 10px;padding:3px 15px;border:none;">Partner</button>
                                </div>
                                <div class="btn p-0 mr-2 pt">
                                    <button class="btn btn-secondary w-100 usertype type-pt" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 18px;line-height: 30px;border-radius: 10px;padding:3px 15px;border:none;">&nbsp;&nbsp;&nbsp;&nbsp;PT&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                </div>
                            </div>
                            
                            <!-- <div class="form-group">
                                <div class="btn-group btn-group-lg justify-content-between w-100">
                                    <div class="btn p-0 mr-2">
                                        <button class="btn btn-secondary w-100 usertype type-partner" style="border-radius: 10px;border:none;" onclick="ChooseType('partner', event)">Partner</button>
                                    </div>
                                    <div class="btn p-0 mr-2">
                                        <button class="btn btn-secondary w-100 usertype type-pt" style="border-radius: 10px;border:none;" onClick="ChooseType('pt', event)">PT</button>
                                    </div> 
                                    <div class="btn p-0">
                                        <button type="button" class="btn btn-secondary dropdown-toggle usertype type-gym type-brand w-100" data-toggle="dropdown" aria-expanded="false">Business</button>
                                        <div class="dropdown-menu w-100 p-0">
                                            <a class="dropdown-item usertype type-gym" onClick="ChooseType('gym', event)">Gym</a>
                                            <a class="dropdown-item usertype type-brand" onClick="ChooseType('brand', event)">Brand</a>
                                        </div>
                                    </div> 
                                </div>
                            </div> -->
                            
                            <form id="form_step_0" action="<?= route('user.sign_up.process') ?>" method="post" class="user lw-ajax-form lw-form smartwizard-vertical-left" data-show-processing="true" data-secured="false" data-callback="onSignupCallback" >
                                <input type="hidden" name="usertype" id="usertype" value="" />
                                
                                <div class="form-group  partner pt business">
                                    <label>UserName <span class="text-danger">*</span></label>
                                    <input name="username" type="text" placeholder="<?= __tr('Username'); ?>" class="form-control form-control-user required">
                                </div>

                                <div class="form-group">
                                    <label>Email Address <span class="text-danger">*</span></label>
                                    <input name="email" id="email" type="email" placeholder="<?= __tr('Email'); ?>" class="form-control form-control-user required">
                                </div>
                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="<?= __tr('Password'); ?>" required minlength="6">
                                        <i class="fa fa-eye my-auto input-icon " id="togglePassword"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control form-control-user" name="repeat_password" id="confirm" placeholder="<?= __tr('Confirm Password'); ?>" required minlength="6">
                                        <i class="fa fa-eye my-auto input-icon " id="toggleConfirm"></i>
                                    </div>
                                </div>
                                <p><span class="text-danger">*</span> Mandatory</p>
                            </form>

                        </div>
                    </div>
                    <div id="smartwizard-6-step-2" class="card animated fadeIn">
                        
                    </div>
                    <div id="smartwizard-6-step-3" class="card animated fadeIn">
                        
                    </div>
                    <div id="smartwizard-6-step-4" class="card animated fadeIn">
                        
                    </div>
                </div>
            </div>    
        </div>
    </div>
                               

</body>
<!-- Javascript -->
@include('front-include.js')
<script src="{{ asset('dist/flatpicker/flatpickr.js') }}"></script>

<script>

    function ChooseType(type, e) {
        e.preventDefault();
        $('.usertype').removeClass('bg-app-red');
        $('.type-' + type).addClass('bg-app-red');
        showDetailScreen(type)
    }

    
    function showDetailScreen(type) {
        $('.partner').addClass('hidden');
        $('.pt').addClass('hidden');
        $('.business').addClass('hidden');
        let usertype = 2;
        switch (type) {
            case "partner":
                $('.partner').removeClass('hidden');
                usertype = 2;
                break;
            case "pt":
                $('.pt').removeClass('hidden');
                usertype = 3;
                break;
            case "gym":
                $('.business').removeClass('hidden');
                usertype = 4;
                break;
            case "brand":
                $('.business').removeClass('hidden');
                usertype = 5;
                break;
            default:
                break;
        }
        $('#usertype').val(usertype);

    }

    $(function() {

        $("#btnSelectPartner").click(function(event){
            $("#selectUserTypeContainer").hide();
            $("#selectUserRegisterContainer").show();
            ChooseType('partner', event)
        });

        $("#btnSelectPt").click(function(event){
            $("#selectUserTypeContainer").hide();
            $("#selectUserRegisterContainer").show();
            ChooseType('pt', event)
        });

    });

    $(function() {

        var $wizard_container = $('#smartwizard-6');
        var $btnFinish = $('<button class="btn-finish btn btn-primary hidden mr-2" type="button">Finish</button>');

        // Set up validator
        var $forms = $wizard_container.find('form');
        $forms.each( function(){ 
            $(this).validate({
                errorPlacement: function errorPlacement(error, element) {
                    $(element).parents('.form-group').append(
                        error.addClass('invalid-feedback small d-block')
                    )
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                rules: {
                    'wizard-confirm': {
                        equalTo: 'input[name="wizard-password"]'
                    },
                    'repeat_password': {
                        equalTo: 'input[name="password"]'
                    }
                }
            });
        });
        
        // Initialize wizard
        $wizard_container.smartWizard({
                selected: 0,
                autoAdjustHeight: true,
                backButtonSupport: false,
                useURLhash: false,
                showStepURLhash: false,
                transition: {
                    animation: 'slide-horizontal', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
                    speed: '400', // Transion animation speed
                    easing: '' // Transition animation easing. Not supported without a jQuery easing plugin
                },
                toolbarSettings: {
                    toolbarPosition: 'bottom', // none, top, bottom, both
                    toolbarButtonPosition: 'right', // left, right, center
                    showNextButton: true, // show/hide a Next button
                    showPreviousButton: true, // show/hide a Previous button
                    toolbarExtraButtons: [] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
                },
                lang: { // Language variables for button
                    next: 'Next',
                    previous: 'Previous'
                },
            }).on('leaveStep', function(e, anchorObject, stepNumber, stepDirection) {
                let usertype = $('#usertype').val();
                if (usertype == "") {
                    showErrorMessage('User Type should be selected!');
                    return false;
                }
                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                if (stepDirection === 'forward') {

                        if($($forms[stepNumber]) && $($forms[stepNumber]).valid())
                        {
                            // First step - Signup with Email, password
                            $($forms[stepNumber]).submit();
                        } 
                        return false;
                        
                } else {
                    return true;
                }

            })
            .on('showStep', function(e, anchorObject, stepNumber, stepDirection) {
                var $fbtn = $wizard_container.find('.btn-finish');
                var $nbtn = $wizard_container.find('.sw-btn-next');

                // Enable finish button only on last step
                if (stepNumber === 3) {
                    $fbtn.removeClass("hidden");
                    $nbtn.addClass("hidden");
                } else {
                    $fbtn.addClass("hidden");
                    $nbtn.removeClass("hidden");
                }
            });
            

        $('#smartwizard-6 .sw-toolbar').appendTo($('#smartwizard-6 .sw-container'));
        $wizard_container.find('.sw-btn-group').removeClass('btn-group');
        $wizard_container.find('.sw-btn-group').addClass('w-100');
        $wizard_container.find('.btn-toolbar').addClass('w-100');
        $wizard_container.find('.sw-btn-next').addClass('float-right');
        $wizard_container.find('.sw-btn-prev').html("<i class='fa fa-arrow-left'></i> Previous");
        $wizard_container.find('.sw-btn-next').html("Next Step <i class='fa fa-arrow-right'></i>");
        $wizard_container.find('.sw-btn-group').append('<button class="btn btn-secondary float-right btn-finish hidden" type="button">Submit <i class="fa fa-arrow-right"></i></button>')
        
    });

    $('#togglePassword').on('click', function(e) {
        e.preventDefault();
        let x = document.getElementById("password");
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
    $('#toggleConfirm').on('click', function(e) {
        e.preventDefault();
        let x = document.getElementById("confirm");
        if (x.type === "password") {
            x.type = "text";
            $('#toggleConfirm').removeClass('fa-eye');
            $('#toggleConfirm').addClass('fa-eye-slash');
        } else {
            x.type = "password";
            $('#toggleConfirm').removeClass('fa-eye-slash');
            $('#toggleConfirm').addClass('fa-eye');
        }
    });

</script>
<!-- / Javascript -->
</html>