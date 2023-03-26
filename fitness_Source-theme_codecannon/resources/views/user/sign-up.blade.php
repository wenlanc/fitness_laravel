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
</style>
<link href="{{ asset('dist/smartwizard/smartwizard.css') }}" rel="stylesheet">
<link href="{{ asset('dist/flatpicker/flatpickr.css') }}" rel="stylesheet">

<body class="lw-login-register-page dark-style">

    <!-- Preloder -->
    <div id="preloder" class="preloader">
        <div class="loader"></div>
    </div>
    <!-- Εnd Preloader -->

    <div class="lw-page-bg lw-lazy-img" data-src="<?= __yesset("imgs/home/random/*.jpg", false, [
                                                        'random' => true
                                                    ]) ?>" style="font-family: 'Poppins', sans-serif;"></div>
    <div class="container v-center">
        <div class="signup-outer">
            <form id="smartwizard-6" method="post" action="<?= route('user.sign_up.process') ?>" class="user lw-ajax-form lw-form smartwizard-vertical-left" data-show-processing="true" data-secured="false">
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
                            Type of user
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
                            Preferences
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
                                <label class="color-app-red">Step 4/1</label>
                            </div>
                            <div class="text-center mt-2">
                                <label class="step-title">What type of user are you?</label>
                            </div>

                            <div class="form-group">
                                <div class="btn-group btn-group-lg justify-content-between w-100">
                                    <div class="btn p-0 mr-2">
                                        <button class="btn btn-secondary w-100 usertype type-partner" onclick="ChooseType('partner', event)">Partner</button>
                                    </div>
                                    <div class="btn p-0 mr-2">
                                        <button class="btn btn-secondary w-100 usertype type-pt" onClick="ChooseType('pt', event)">PT</button>
                                    </div>
                                    <div class="btn p-0">
                                        <button type="button" class="btn btn-secondary dropdown-toggle usertype type-gym type-brand w-100" data-toggle="dropdown" aria-expanded="false">Business</button>
                                        <div class="dropdown-menu w-100 p-0">
                                            <a class="dropdown-item usertype type-gym" onClick="ChooseType('gym', event)">Gym</a>
                                            <a class="dropdown-item usertype type-brand" onClick="ChooseType('brand', event)">Brand</a>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="usertype" id="usertype" value="" />
                            </div>

                            <div class="form-group">
                                <label>Email Address <span class="text-danger">*</span></label>
                                <input name="email" type="email" class="form-control form-control-user required">
                            </div>
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="<?= __tr('Password') ?>" required minlength="6">
                                    <i class="fa fa-eye my-auto input-icon " id="togglePassword"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" class="form-control form-control-user" name="repeat_password" id="confirm" placeholder="<?= __tr('Confirm Password') ?>" required minlength="6">
                                    <i class="fa fa-eye my-auto input-icon " id="toggleConfirm"></i>
                                </div>
                            </div>

                            <p><span class="text-danger">*</span> Mandatory</p>
                        </div>
                    </div>
                    <div id="smartwizard-6-step-2" class="card animated fadeIn">
                        <div class="card-body padding-box">
                            <div class="text-center">
                                <label class="color-app-red">Step 4/2</label>
                            </div>
                            <div class="text-center mt-2">
                                <label class="step-title">Your Details</label>
                            </div>

                            <div class="form-group  partner pt">
                                <label>Full Name Kanji <span class="text-danger">*</span></label>
                                <input name="kanji_name" type="text" class="form-control form-control-user required">
                            </div>
                            <div class="form-group  partner pt">
                                <label>Katakana <span class="text-danger">*</span></label>
                                <input name="kata_name" type="text" class="form-control form-control-user required">
                            </div>

                            <div class="form-group  business">
                                <label>Parent Company Name <span class="text-danger">*</span></label>
                                <input name="company_name" type="text" class="form-control form-control-user required">
                            </div>

                            <div class="form-group  business">
                                <label>Brand Name <span class="text-danger">*</span></label>
                                <input name="brand" type="text" class="form-control form-control-user required">
                            </div>

                            <div class="form-group  partner pt business">
                                <label>UserName <span class="text-danger">*</span></label>
                                <input name="username" type="text" class="form-control form-control-user required">
                            </div>

                            <div class="form-group partner pt">
                                <label>Birthday Date <span class="text-danger">*</span></label>
                                <input type="date" min="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.maximum'))->format('Y-m-d') }}" 
                                max="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.minimum'))->format('Y-m-d') }}" 
                                class="form-control form-control-user" name="dob" placeholder="<?= __tr('YYYY-MM-DD') ?>" required="true">
                            </div>

                            <div class="form-group pt">
                                <label>Qualified Since <span class="text-danger">*</span></label>
                                <input type="date" min="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.maximum'))->format('Y-m-d') }}" 
                                max="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.minimum'))->format('Y-m-d') }}" 
                                class="form-control form-control-user" name="do_qualify" placeholder="<?= __tr('YYYY-MM-DD') ?>" required="true">
                            </div>

                            <div class="form-group partner pt">
                                <label>Gender</label>
                                <div class="position-relative">
                                    <select size name="gender" class="form-control form-control-user lw-user-gender-select-box" id="select_gender" required>
                                        <option value="" selected disabled><?= __tr('Choose your gender') ?></option>
                                        @foreach($genders as $genderKey => $gender)
                                        <option value="<?= $genderKey ?>"><?= $gender ?></option>
                                        @endforeach
                                    </select>
                                    <i class="fa fa-angle-down my-auto input-icon " id="togglePassword"></i>
                                </div>
                            </div>


                            <div class="form-group business">
                                <label>Starting Date <span class="text-danger">*</span></label>
                                <input type="date" min="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.maximum'))->format('Y-m-d') }}" 
                                max="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.minimum'))->format('Y-m-d') }}" 
                                class="form-control form-control-user" name="do_start" placeholder="<?= __tr('YYYY-MM-DD') ?>" required="true">
                            </div>

                            <div class="form-group business">
                                <label>Website <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-user" name="website" id="website" placeholder="<?= __tr('Web Url') ?>" required>
                                    <i class="fa fa-globe my-auto input-icon " id="toggleConfirm"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="smartwizard-6-step-3" class="card animated fadeIn">
                        <div class="card-body padding-box">
                            <div class="text-center">
                                <label class="color-app-red">Step 4/3</label>
                            </div>
                            <div class="text-center mt-2">
                                <label class="step-title partner pt">Availability</label>
                                <label class="step-title business">Operation Hours</label>
                            </div>
                            <div class="form-group preferences mon-pref">
                                <label class="form-label">Monday</label>
                                <div class="d-flex monday justify-content-center">
                                    <div class="d-flex">
                                        <input type="text" class="form-control time-picker time-start" name="mon_start[0]" id="flatpickr-time-m1">
                                        <label>-</label>
                                        <input type="text" class="form-control time-picker time-end" name="mon_end[0]" id="flatpickr-time-m2">
                                    </div>
                                    <button class="time-control" onclick="addTimeInterval('mon', event)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="form-group preferences tue-pref">
                                <label class="form-label">Tuesday</label>
                                <div class="d-flex monday justify-content-center">
                                    <div class="d-flex">
                                        <input type="text" class="form-control time-picker time-start" name="tue_start[0]" id="flatpickr-time-m1">
                                        <label>-</label>
                                        <input type="text" class="form-control time-picker time-end" name="tue_end[0]" id="flatpickr-time-m2">
                                    </div>
                                    <button class="time-control" onclick="addTimeInterval('tue', event)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="form-group preferences wed-pref">
                                <label class="form-label">Wednesday</label>
                                <div class="d-flex monday justify-content-center">
                                    <div class="d-flex">
                                        <input type="text" class="form-control time-picker time-start" name="wed_start[0]" id="flatpickr-time-m1">
                                        <label>-</label>
                                        <input type="text" class="form-control time-picker time-end" name="wed_end[0]" id="flatpickr-time-m2">
                                    </div>
                                    <button class="time-control" onclick="addTimeInterval('wed', event)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="form-group preferences thu-pref">
                                <label class="form-label">Thursday</label>
                                <div class="d-flex monday justify-content-center">
                                    <div class="d-flex">
                                        <input type="text" class="form-control time-picker time-start" name="thu_start[0]" id="flatpickr-time-m1">
                                        <label>-</label>
                                        <input type="text" class="form-control time-picker time-end" name="thu_end[0]" id="flatpickr-time-m2">
                                    </div>
                                    <button class="time-control" onclick="addTimeInterval('thu', event)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="form-group preferences fri-pref">
                                <label class="form-label">Friday</label>
                                <div class="d-flex monday justify-content-center">
                                    <div class="d-flex">
                                        <input type="text" class="form-control time-picker time-start" name="fri_start[0]" id="flatpickr-time-m1">
                                        <label>-</label>
                                        <input type="text" class="form-control time-picker time-end" name="fri_end[0]" id="flatpickr-time-m2">
                                    </div>
                                    <button class="time-control" onclick="addTimeInterval('fri', event)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="form-group preferences sat-pref">
                                <label class="form-label">Saturday</label>
                                <div class="d-flex monday justify-content-center">
                                    <div class="d-flex">
                                        <input type="text" class="form-control time-picker time-start" name="sat_start[0]" id="flatpickr-time-m1">
                                        <label>-</label>
                                        <input type="text" class="form-control time-picker time-end" name="sat_end[0]" id="flatpickr-time-m2">
                                    </div>
                                    <button class="time-control" onclick="addTimeInterval('sat', event)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="form-group preferences sun-pref">
                                <label class="form-label">Sunday</label>
                                <div class="d-flex monday justify-content-center">
                                    <div class="d-flex">
                                        <input type="text" class="form-control time-picker time-start" name="sun_start[0]" id="flatpickr-time-m1">
                                        <label>-</label>
                                        <input type="text" class="form-control time-picker time-end" name="sun_end[0]" id="flatpickr-time-m2">
                                    </div>
                                    <button class="time-control" onclick="addTimeInterval('sun', event)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="smartwizard-6-step-4" class="card animated fadeIn">
                        <div class="card-body padding-box">
                            <div class="text-center">
                                <label class="color-app-red">Step 4/4</label>
                            </div>
                            <div class="text-center mt-2">
                                <label class="step-title">Location and Gyms</label>
                            </div>

                            <div class="form-group">
                                <label>Gyms</label>
                                <div class="d-flex">
                                    <select size name="gym" class="form-control form-control-user lw-user-gender-select-box" id="select_gender" required>
                                        <option value="" selected disabled><?= __tr('Choose Gym') ?></option>
                                        @foreach($genders as $genderKey => $gender)
                                        <option value="<?= $genderKey ?>"><?= $gender ?></option>
                                        @endforeach
                                    </select>
                                    <button class="btn-plus" onclick=""><i class="fa fa-plus"></i></button>
                                </div>
                            </div>

                            <div class="form-group map text-center">
                                <img src="{{ asset('dist/blackfit/images/rectangle-38@1x.png') }}" />
                            </div>
                            <div class="form-group">
                                <label>Location</label>
                                <div class="d-flex">
                                    <select size name="location" class="form-control form-control-user lw-user-gender-select-box" id="select_gender" required>
                                        <option value="" selected disabled><?= __tr('Choose Location') ?></option>
                                        @foreach($genders as $genderKey => $gender)
                                        <option value="<?= $genderKey ?>"><?= $gender ?></option>
                                        @endforeach
                                    </select>
                                    <button class="btn-plus"  onclick=""><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /container end -->

</body>
<!-- Javascript -->
@include('front-include.js')
<script src="{{ asset('dist/flatpicker/flatpickr.js') }}"></script>
<script>
    $(function() {
        var $form = $('#smartwizard-6');
        var $btnFinish = $('<button class="btn-finish btn btn-primary hidden mr-2" type="button">Finish</button>');

        // Set up validator
        $form.validate({
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
                }
            }
        });

        // Initialize wizard
        $form
            .smartWizard({
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
                    next: 'Next Step',
                    previous: 'Previous'
                },
            })
            .on('leaveStep', function(e, anchorObject, stepNumber, stepDirection) {
                let usertype = $('#usertype').val();
                if (usertype == "") {
                    showErrorMessage('User Type should be selected!');
                    return false;
                }
                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                if (stepDirection === 'forward') {
                    return $form.valid();
                }
                return true;
            })
            .on('showStep', function(e, anchorObject, stepNumber, stepDirection) {
                var $fbtn = $form.find('.btn-finish');
                var $nbtn = $form.find('.sw-btn-next');

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
        $form.find('.sw-btn-group').removeClass('btn-group');
        $form.find('.sw-btn-group').addClass('w-100');
        $form.find('.btn-toolbar').addClass('w-100');
        $form.find('.sw-btn-next').addClass('float-right');
        $form.find('.sw-btn-prev').html("<i class='fa fa-arrow-left'></i> Previous");
        $form.find('.sw-btn-next').html("Next Step <i class='fa fa-arrow-right'></i>");
        $form.find('.sw-btn-group').append('<button class="btn btn-secondary float-right btn-finish hidden" type="button">Submit <i class="fa fa-arrow-right"></i></button>')
        // Click on finish button
        $form.find('.btn-finish').on('click', function() {
            if (!$form.valid()) {
                return;
            }

            // Submit form
            $form.submit();
            return false;
        });

        $(".time-picker").each(function() {
            this.flatpickr({
                enableTime: true,
                noCalendar: true,
                altInput: true
            });
        });
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

    function ChooseType(type, e) {

        e.preventDefault();
        $('.usertype').removeClass('bg-app-red');
        $('.type-' + type).addClass('bg-app-red');
        showDetailScreen(type);
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

    function addTimeInterval(day, event) {
        event.preventDefault();
        let count = $('.' + day + '-time-interval').length;
        let max = count;
        $('.' + day + '-time-interval').each(function(item) {
            let idx = $(this).attr('index');
            max = Math.max(idx, max);
        });

        count = max + 1;
        console.log(max);
        let html = '<div class="d-flex monday justify-content-center mt-2 ' + day + '-time-interval" index="' + count + '" id="' + day + '_time_' + count + '">' +
            '<div class="d-flex">' +
            '<input type="text" class="form-control time-picker time-start" name="' + day + '_start[' + count + ']" id="flatpickr-time-start' + day + count + '">' +
            '<label>-</label>' +
            '<input type="text" class="form-control time-picker time-end" name="' + day + '_end[' + count + ']" id="flatpickr-time-end' + day + count + '">' +
            '</div>' +
            '<button class="time-control" onclick="removeTimeInterval(\'' + day + '_time_' + count + '\', event)"><i class="fa fa-minus"></i></button>' +
            '</div>';
        $('.' + day + '-pref').append(html);
        $('#flatpickr-time-start' + day + count).flatpickr({
            enableTime: true,
            noCalendar: true,
            altInput: true
        });
        $('#flatpickr-time-end' + day + count).flatpickr({
            enableTime: true,
            noCalendar: true,
            altInput: true
        });
    }

    function removeTimeInterval(id, event) {
        event.preventDefault();
        $('#' + id).remove();
    }
</script>
<!-- / Javascript -->

</html>