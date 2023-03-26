<?php 
$pageTitle = __tr('Update profile'); 
use Carbon\Carbon;
?>
@section('page-title', $pageTitle)
@section('head-title', $pageTitle)
@section('keywordName', strip_tags(__tr('Update profile')))
@section('keyword', strip_tags(__tr('Update profile')))
@section('description', strip_tags(__tr('Update profile')))
@section('keywordDescription', strip_tags(__tr('Update profile')))
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
        padding: 3px 7px;
    }

    .pt_availablity_weekday {
        font-family: Nunito Sans;
        font-style: normal;
        font-weight: bold;
        font-size: 13px;
        line-height: 18px;
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

    .roundBox{
        box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);
        border-radius: 24px;
    }

    .flatpickr-calendar {
        background:black!important;
    }

    .base {
		background: #2C2C2D;
		border: 1px solid #FFFFFF;
		box-sizing: border-box;
		box-shadow: 0px 1px 2px rgb(184 200 224 / 22%);
		border-radius: 14px;
		padding: 15px 15px 15px 10px;
		height: 48px;
	}

    .form-group label {
        margin-bottom:0px;
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
    
    <div class="container v-center1" id="selectUserRegisterContainer" style="padding-bottom:1rem;">
        <div class="signup-outer" style="height: 100vh;display:flex;">
            <div id="smartwizard-6" class="user smartwizard-vertical-left" style="padding:1rem;margin-top:auto;margin-bottom:auto;min-height: 750px;">
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
                    
                    <div id="smartwizard-6-step-1" class="card animated fadeIn"> <form> </form>
                    </div>
                    <div id="smartwizard-6-step-2" class="card animated fadeIn">
                        <div class="card-body padding-box" style="padding-bottom:0px;">
                            <div class="text-center">
                                <label class="color-app-red">Step 2/4</label>
                            </div>

							<div class="text-center">
                                <div class="btn p-0 mr-2 partner">
                                    <button class="btn btn-secondary w-100 usertype type-partner" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 18px;line-height: 30px;border-radius: 10px;padding:3px 15px;border:none;">Partner</button>
                                </div>
                                <div class="btn p-0 mr-2 pt">
                                    <button class="btn btn-secondary w-100 usertype type-pt" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 18px;line-height: 30px;border-radius: 10px;padding:3px 15px;border:none;">&nbsp;&nbsp;&nbsp;&nbsp;PT&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                </div>
                            </div>
							
                            <div class="text-center mt-2">
                                <label class="step-title">Your Details</label>
                            </div>

                            <form id="form_step_1" action="<?= route('user.sign_up_profile.process') ?>" method="post" class="user lw-ajax-form lw-form smartwizard-vertical-left" data-show-processing="true" data-secured="false" data-callback="onSignupProfileCallback" >

                                <div class="row justify-content-around mt-2">
                                    <div class="profile-btn-container">
                                        <label class="add-profile-btn position-relative">
                                            <img id="profile_image" class="preview-profile" src="" />
                                            <input type="file" class="sr-only" id="cropper-example-inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                                            <i class="fa fa-plus "></i>
                                        </label>
                                        <label>Upload your profile pic</label>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <input id="profile_image_val" name="profile_image" type="text" class="form-control form-control-user tooltip position-absolute required">
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

                                <div class="form-group partner pt">
                                    <label>Birthday Date <span class="text-danger">*</span></label>

                                    <div class="flatpickr" style="position:relative;">
                                        <input type="text" name="dob" min="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.maximum'))->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.minimum'))->format('Y-m-d') }}" class="form-control form-control-user required" required="true" placeholder="Select Date.." data-input> <!-- input is mandatory -->
                                        <a class="d-none input-button" style="position: absolute; right: 10px;  top: 10px;" title="toggle" data-toggle>
                                            <i class="fa fa-calendar" style="font-size:18px;"></i>
                                        </a>
                                    </div>

                                    <!-- <input type="text"  class="form-control form-control-user datepicker1" name="dob" placeholder="<?= __tr(''); ?>" required="true"> -->
                                </div>

                                <div class="form-group pt">
                                    <label>Qualified Since <span class="text-danger">*</span></label>
                                    <div class="flatpickr" style="position:relative;">
                                        <input type="text" name="do_qualify" min="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.maximum'))->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.minimum'))->format('Y-m-d') }}" class="form-control form-control-user required" required="true" placeholder="Select Date.." data-input> <!-- input is mandatory -->
                                        <a class="d-none input-button" style="position: absolute; right: 10px;  top: 10px;" title="toggle" data-toggle>
                                            <i class="fa fa-calendar" style="font-size:18px;"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group partner pt">
                                    <label>Gender</label>
                                    <div class="position-relative">
                                        <select size name="gender" class="form-control form-control-user lw-user-gender-select-box" id="select_gender" required>
                                            <option value="" selected disabled><?= __tr('Choose your gender'); ?></option>
                                            @foreach($genders as $genderKey => $gender)
                                            <option value="<?= $genderKey; ?>"><?= $gender; ?></option>
                                            @endforeach
                                        </select>
                                        <i class="fa fa-angle-down my-auto input-icon " id="togglePassword"></i>
                                    </div>
                                </div>


                                <div class="form-group business">
                                    <label>Starting Date <span class="text-danger">*</span></label>
                                    <div class="flatpickr" style="position:relative;">
                                        <input type="text" name="do_start" min="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.maximum'))->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.minimum'))->format('Y-m-d') }}" class="form-control form-control-user required" required="true" placeholder="Select Date.." data-input> <!-- input is mandatory -->
                                        <a class="d-none input-button" style="position: absolute; right: 10px;  top: 10px;" title="toggle" data-toggle>
                                            <i class="fa fa-calendar" style="font-size:18px;"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group business">
                                    <label>Website <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-user" name="website" id="website" placeholder="<?= __tr('Web Url'); ?>" required>
                                        <i class="fa fa-globe my-auto input-icon " id="toggleConfirm"></i>
                                    </div>
                                </div>
                            </form>                                
                        </div>
                    </div>
                    <div id="smartwizard-6-step-3" class="card animated fadeIn">
                        <div class="card-body padding-box">
                            <div class="text-center">
                                <label class="color-app-red">Step 3/4</label>
                            </div>
                            <div class="text-center mt-2">
                                <label class="step-title partner pt">Availability</label>
                                <label class="step-title business">Operation Hours</label>
                            </div>

                            <form id="form_step_2" action="<?= route('user.sign_up_availability.process') ?>" method="post" class="user lw-ajax-form lw-form smartwizard-vertical-left" data-show-processing="true" data-secured="false" data-callback="onSignupAvailabilityCallback" >


                                <div class="d-flex align-v-center" style="padding-top: 20px;text-align: center;">
                                    <label class="pt_availablity_weekday" style="flex: 1;">月曜日</label>
                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="mon_start" id="mon_start" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['mon_s']==1) checked @endif>
                                        <label  for="mon_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['mon_s']==1) checked @endif"><i class="fa fa-sun-o"></i></label>
                                    </div>
                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="mon_end" id="mon_end" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['mon_e']==1) checked @endif>
                                        <label  for="mon_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['mon_e']==1) checked @endif"><i class="fa fa-moon-o"></i></label>
                                    </div>
                                </div>
                                <div class="d-flex align-v-center" style="padding-top: 20px;text-align: center;">
                                    <label class="pt_availablity_weekday">火曜日</label>
                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="tue_start" id="tue_start" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['tue_s']==1) checked @endif>
                                        <label for="tue_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['tue_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                                    </div>

                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="tue_end" id="tue_end" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['tue_e']==1) checked @endif>
                                        <label for="tue_end"  class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['tue_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                                    </div>
                                </div>
                                <div class="d-flex align-v-center" style="padding-top: 20px;text-align: center;">
                                    <label class="pt_availablity_weekday">水曜日</label>
                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="wed_start" id="wed_start" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['wed_s']==1) checked @endif>
                                        <label  for="wed_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['wed_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                                    </div>

                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="wed_end" id="wed_end" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['wed_e']==1) checked @endif>
                                        <label  for="wed_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['wed_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                                    </div>
                                </div>
                                <div class="d-flex align-v-center" style="padding-top: 20px;text-align: center;">
                                    <label class="pt_availablity_weekday">木曜日</label>
                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="thu_start" id="thu_start" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['thu_s']==1) checked @endif>
                                        <label  for="thu_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['thu_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                                    </div>

                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="thu_end" id="thu_end" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['thu_e']==1) checked @endif>
                                        <label  for="thu_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['thu_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                                    </div>
                                </div>
                                <div class="d-flex align-v-center" style="padding-top: 20px;text-align: center;">
                                    <label class="pt_availablity_weekday">金曜日</label>
                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="fri_start" id="fri_start" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['fri_s']==1) checked @endif>
                                        <label  for="fri_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['fri_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                                    </div>

                                    <div class="pt_availablity_time" >
                                        <input type="checkbox" name="fri_end" id="fri_end" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['fri_e']==1) checked @endif>
                                        <label  for="fri_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['fri_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                                    </div>
                                </div>
                                <div class="d-flex align-v-center" style="padding-top: 20px;text-align: center;">
                                    <label class="pt_availablity_weekday">土曜日</label>
                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="sat_start" id="sat_start" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['sat_s']==1) checked @endif>
                                        <label  for="sat_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['sat_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                                    </div>

                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="sat_end" id="sat_end" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['sat_e']==1) checked @endif>
                                        <label  for="sat_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['sat_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                                    </div>
                                </div>
                                <div class="d-flex align-v-center" style="padding-top: 20px;text-align: center;">
                                    <label class="pt_availablity_weekday">日曜日</label>
                                    <div class="pt_availablity_time">
                                        <input type="checkbox" name="sun_start" id="sun_start" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['sun_s']==1) checked @endif>
                                        <label  for="sun_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['sun_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                                    </div>

                                    <div class="pt_availablity_time" >
                                        <input type="checkbox" name="sun_end"  id="sun_end" class="custom-control-input btn-availability"  @if($userAvailability && $userAvailability['sun_e']==1) checked @endif>
                                        <label  for="sun_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['sun_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                                    </div>
                                </div>
                            </form>                        

                        </div>
                    </div>
                    <div id="smartwizard-6-step-4" class="card animated fadeIn">
                        <div class="card-body padding-box">
                            <div class="text-center">
                                <label class="color-app-red">Step 4/4</label>
                            </div>
                            <div class="text-center mt-2">
                                <label class="step-title" style="color:white;">Location and Gyms</label>
                            </div>
                            <form id="form_step_3" action="<?= route('user.sign_up_location.process') ?>" method="post" class="user lw-ajax-form lw-form smartwizard-vertical-left" data-show-processing="true" data-secured="false" data-callback="onSignupLocationCallback" >

                                @if(getStoreSettings('allow_google_map'))
                                <div class="form-group" style="padding-left: 3rem;padding-right: 3rem;width: 100%;">
                                    <label>Gyms</label>
                                    <div class="d-flex" style="width: 100%;">
                                        <div class="position-relative" style="width: 100%;" id="lw-user-gym-select-container">
                                            <select id="selectGym" name="selectGym" mutiple class="form-control form-control-user lw-user-gym-select-box" required="" style="width: 100%;border-color: white;">
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="gym_selected_list" id="gym_selected_list" value="" >

                                <div id="text-map-container" style="width:100%;height:200px;margin-top:1rem; ">
                                    <div style="width: 100%; height: 100%" id="text-map"></div>
                                </div>
                                <div class="form-group" style="padding-left:3rem;padding-right:3rem;margin-top:1rem;">
                                    <label>Location</label>
                                    <div class="d-flex">
                                        <input type="text" name="input_location" id="text-input" class="form-control map-input form-control-user" placeholder="<?= __tr('Enter a location'); ?>" required>
                                        <input type="hidden" name="address-latitude" id="text-latitude" value="" />
                                        <input type="hidden" name="address-longitude" id="text-longitude" value="" />
                                        <input type="hidden" name="address_address" id="text_address" value="" />
                                    </div>
                                </div>
                            
                                @elseif(getStoreSettings('use_static_city_data'))
                                <div class="form-group">
                                    <label for="selectGym"><?= __tr('Gym'); ?></label>
                                    <input type="text" id="selectGym" name="selected_gym_id" class="form-control form-control-user" placeholder="<?= __tr('Enter a Gym'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="selectLocationCity"><?= __tr('Location'); ?></label>
                                    <input type="text" id="selectLocationCity" name="selected_city_id" class="form-control form-control-user" placeholder="<?= __tr('Enter a location'); ?>" required>
                                </div>
                                @else
                                <!-- info message -->
                                <div class="alert alert-info">
                                    <?= __tr('Something went wrong with Google Api Key, please contact to system administrator.'); ?>
                                </div>
                                <!-- / info message -->
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <!-- /container end -->
    <div class="modal" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <div class="cropper-example-container">
                        <img id="cropper-example-image" alt="Picture">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="set_profile_image">Save</button>
                </div>
            </div>
        </div>
    </div>
   @if($user_role==2)
    <div class="modal fade" id="lwBillingProDialog" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="userReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content" style="background-color: #191919;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/border-radius: 24px; ">
                
                <div class="modal-header" style="border-bottom:none;display:none;">
                    <h5 class="modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 27px;line-height: 37px;color: #FFFFFF;">
                        Try STACKD PRO
                    </h5>
                    <button type="button" style="color:#FFFFFF;margin-top: -20px; " class="close" data-dismiss="modal" aria-label="Close">
                        <span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body" style="color:#FFFFFF;border-radius: 24px;background-image: url('/imgs/pro_background.png');background-repeat: no-repeat;background-size: 50% 100%;min-height: 780px;">

                    <div class="d-flex">

                        <div class="p-1" style="flex:1;">
                            <div class="row" style="font-family: Nunito Sans;font-style: normal;color:white;">
                                <div class="col-lg-12 d-flex pt-2" style="font-weight: bold;font-size: 1.5rem;line-height: 24px;"> STACKD </div>
                                <div class="col-lg-12 d-flex pt-4 mt-2" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Do more with STACKD Pro. </div>
                                <div class="col-lg-12 d-flex pt-3" style="font-weight: normal;font-size: 1rem;line-height: 24px;"> Your fitness hub unlocked to its full potential. </div>
                                <div class="col-lg-12 d-flex pt-4 mt-4">
                                    <table class="table table-hover table-pricing" style="color:white;">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="text-align:center;border-right:1px solid #515151;"><span>STACKD Free</span></th>
                                                <th style="text-align:center;"><span>STACKD Pro</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span style="font-size:13px;">Unlimited follows everyday</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.70711 0.292893C1.31658 -0.097631 0.683418 -0.0976311 0.292893 0.292893C-0.097631 0.683417 -0.0976312 1.31658 0.292893 1.70711L5.5858 7.00002L0.292922 12.2929C-0.0976021 12.6834 -0.0976021 13.3166 0.292922 13.7071C0.683447 14.0976 1.31661 14.0976 1.70714 13.7071L7.00001 8.41423L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41423 7.00002L13.7071 1.70711C14.0977 1.31658 14.0977 0.683419 13.7071 0.292895C13.3166 -0.0976298 12.6834 -0.0976294 12.2929 0.292895L7.00001 5.5858L1.70711 0.292893Z" fill="#6F767E"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span style="font-size:13px;">Featured profile in search results</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.70711 0.292893C1.31658 -0.097631 0.683418 -0.0976311 0.292893 0.292893C-0.097631 0.683417 -0.0976312 1.31658 0.292893 1.70711L5.5858 7.00002L0.292922 12.2929C-0.0976021 12.6834 -0.0976021 13.3166 0.292922 13.7071C0.683447 14.0976 1.31661 14.0976 1.70714 13.7071L7.00001 8.41423L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41423 7.00002L13.7071 1.70711C14.0977 1.31658 14.0977 0.683419 13.7071 0.292895C13.3166 -0.0976298 12.6834 -0.0976294 12.2929 0.292895L7.00001 5.5858L1.70711 0.292893Z" fill="#6F767E"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span style="font-size:13px;">See who views your page</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.70711 0.292893C1.31658 -0.097631 0.683418 -0.0976311 0.292893 0.292893C-0.097631 0.683417 -0.0976312 1.31658 0.292893 1.70711L5.5858 7.00002L0.292922 12.2929C-0.0976021 12.6834 -0.0976021 13.3166 0.292922 13.7071C0.683447 14.0976 1.31661 14.0976 1.70714 13.7071L7.00001 8.41423L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41423 7.00002L13.7071 1.70711C14.0977 1.31658 14.0977 0.683419 13.7071 0.292895C13.3166 -0.0976298 12.6834 -0.0976294 12.2929 0.292895L7.00001 5.5858L1.70711 0.292893Z" fill="#6F767E"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                <td>
                                                    <span style="font-size:13px;">Incognito private browsing of profiles</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.70711 0.292893C1.31658 -0.097631 0.683418 -0.0976311 0.292893 0.292893C-0.097631 0.683417 -0.0976312 1.31658 0.292893 1.70711L5.5858 7.00002L0.292922 12.2929C-0.0976021 12.6834 -0.0976021 13.3166 0.292922 13.7071C0.683447 14.0976 1.31661 14.0976 1.70714 13.7071L7.00001 8.41423L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41423 7.00002L13.7071 1.70711C14.0977 1.31658 14.0977 0.683419 13.7071 0.292895C13.3166 -0.0976298 12.6834 -0.0976294 12.2929 0.292895L7.00001 5.5858L1.70711 0.292893Z" fill="#6F767E"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr> -->
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="p-4" style="flex:1;">
                            <div class="row">                        
                                <a href="<?= route('user.login') ?>" style="color:#FFFFFF;margin-top: -20px;font-weight: bold;font-size: 13px;line-height: 24px;margin-left: auto; " >
                                    <!-- <span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span> -->
                                    Skip STACKD VIP for now 
                                    <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.361949 9.80474C0.1016 9.54439 0.1016 9.12228 0.361949 8.86193L4.22388 5L0.361949 1.13807C0.101599 0.877721 0.101599 0.45561 0.361949 0.195261C0.622298 -0.0650892 1.04441 -0.0650893 1.30476 0.195261L5.16669 4.05719C5.68739 4.57789 5.68738 5.42211 5.16669 5.94281L1.30476 9.80474C1.04441 10.0651 0.622299 10.0651 0.361949 9.80474Z" fill="white"/>
                                    </svg>
                                </a>
                            </div>                        
                            <form id="payment-form" class="lw-ajax-form1 lw-form1" method="post" data-show-message="true" action="<?= route('user.write.setting-subscription') ?>" data-callback="onSubscriptionStripeCallback" >
                            <div id="payment_type_container" class="p-4 row" style="font-family: Nunito Sans;font-style: normal;color:white;">
                                <div class="col-lg-12 d-flex pt-2 pb-2" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Try STACKD PRO for free </div>
                                <div class="col-lg-12 d-flex pt-2 pb-2" style="padding-left:20px;font-weight: bold;font-size: 0.75rem;line-height: 24px;"> Free 30 day trial, cancel any time</div>
                                
									@foreach( $premiumPlanData["premiumPlans"]['pro'] as $plan_key=>$plan_val)
										@if( $plan_val["enable"])
										<div class="col-lg-12" >
											<div class="col-lg-12 d-flex pt-2 mt-2 pl-5 pr-2 custom-control custom-radio custom-control-inline">
												<input type="radio" checked="" id="lwSelectMembership_<?= $plan_key ?>" value="<?= $plan_key ?>" name="plan_id" class="custom-control-input">
												<label id="containerMembershipTitle_<?= $plan_key ?>" class="custom-control-label" for="lwSelectMembership_<?= $plan_key ?>" style="font-weight: bold;font-size: 13px;line-height: 24px;">
													<?= $plan_val["title"] ?>

													@if ($plan_key == 'year')
													&nbsp;&nbsp;&nbsp;<span class="pl-3 pr-3 pt-1 pb-1" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 9px;line-height: 24px;text-align: center;letter-spacing: 1px;color: #FFFFFF;background: #FF4141;border-radius: 10px;">  BEST DEAL ￥<?= $premiumPlanData["premiumPlans"]['pro']["one_month"]["price"] * 12 - $plan_val["price"] ?> OFF </span>
													@endif
												</label>
													
											</div>
											<div class="ml-4 pl-4 col d-flex pt-1" id="containerMembershipPrice_<?= $plan_key ?>" style="font-weight: bold;font-size: 11px;"> ￥<?= $plan_val["price"]?> 
												@if ($plan_key == 'year')
												<span>( ￥<?= round($plan_val["price"]/12, 2) ?> / month ) </span> 
												@endif
											</div>
										</div>	
										@endif
									@endforeach


                                <!-- <div class="ml-3 col-lg-12 d-flex pt-4" style="font-weight: bold;font-size: 11px;"> Due January 22, 2022 <span style="margin-left: auto;"> ￥4,800 </span></div>
                                <div class="ml-3 col-lg-12 d-flex pt-1" style="font-weight: bold;font-size: 11px;"> Due today <span style="margin-left: auto;"> ￥0 </span></div> -->
        
                                <div class="pt-4 ml-4 pl-4 mr-4 pr-4 col-lg-12 d-flex"> 
                                    <button type="button" id="paymentSubscribeBtn" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;border: none;">
										Try for free for 30 days
									</button>
                                </div>
                                <div class="ml-4 pl-4 col-lg-12 d-flex1 pt-2" style="font-weight: bold;font-size: 13px; text-align:center;"> Cancel any time </div>
                            
                            </div>	
                            
                            <div id="payment_card_container" class="p-4 row" style="display:none;font-family: Nunito Sans;font-style: normal;color:white;">
                                <div class="col-lg-12 d-flex pt-2" style="font-weight: bold;font-size: 1.25rem;line-height: 24px;"> Try STACKD PRO </div>
								<div class="col-lg-12 d-flex pt-2 pl-4" style="font-weight: bold;font-size: 0.75rem;line-height: 24px;"> Free 30 day trial, cancel any time </div>                              

                                <div class="col-lg-12 ml-1 pt-2 form-group mb-0">
                                    <div id="paymentResponse"></div>
                                    
                                    <!--  success messages  -->
                                    <div class="alert alert-success alert-dismissible fade show" id="lwSuccessMessage" style="display:none;"></div>
                                    <!--  /success messages  -->

                                    <!--  error messages  -->
                                    <div class="alert alert-danger alert-dismissible fade show" id="lwErrorMessage" style="display:none;"></div>
                                    <!--  /error messages -->
                                    
                                </div>

                                <div class="col-lg-12 ml-1 pt-2 form-group mb-0" id="selectedMembershipContainer">
                                    <div class="col-lg-12 d-flex custom-control custom-radio custom-control-inline">
                                        <input type="radio" checked="" id="lwSelectMembership_selected" value="" name="selected_plan_id" class="custom-control-input">
										<label id="containerMembershipTitleSelected" class="custom-control-label" for="lwSelectMembership_selected" style="font-weight: bold;font-size: 13px;line-height: 24px;">
										</label>			
                                    </div>
                                    <div class="pl-3 col-lg-12 d-flex pt-1" id="lwSelectMembership_selected_text" style="font-weight: bold;font-size: 11px;">  </div>
                                </div>

								
                                <div class="ml-2 col-lg-12 d-flex pt-2" style="font-weight: bold;font-size: 11px;"> First payment due <?= \Carbon\Carbon::now()->addDays(30)->format('F d, Y')?> <span id="dueSelectedPrice" style="margin-left: auto;"> </span></div>
                                <div class="ml-2 col-lg-12 d-flex pt-1" style="font-weight: bold;font-size: 11px;padding-bottom:5px;border-bottom:1px solid #515151;"> Due today <span style="margin-left: auto;"> ￥0 </span></div>
        
								<div class="col-lg-12 ml-1 d-flex pt-2" style="font-weight: bold;font-size: 11px;"> 
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 10C2.44772 10 2 10.4477 2 11V17C2 18.6569 3.34315 20 5 20H19C20.6569 20 22 18.6569 22 17V11C22 10.4477 21.5523 10 21 10H3ZM5 14C4.44772 14 4 14.4477 4 15C4 15.5523 4.44772 16 5 16H11C11.5523 16 12 15.5523 12 15C12 14.4477 11.5523 14 11 14H5Z" fill="white"/>
                                    <path d="M2 7C2 5.34315 3.34315 4 5 4H19C20.6569 4 22 5.34315 22 7C22 7.55228 21.5523 8 21 8H3C2.44772 8 2 7.55228 2 7Z" fill="white"/>
                                    </svg> 
                                    &nbsp;&nbsp;
                                    <span> Credit or Debit Card </span> 
                                </div>

                                <div class="col-lg-12 ml-1 pt-2 form-group mb-0">
                                    <label for="name" class="mb-0">Name</label>
                                    <input type="text" name="custName" class="form-control" style="color:white;background: #2C2C2D;border: 1px solid #FFFFFF;box-sizing: border-box;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 14px;height:48px;padding-left:5px;"> 
                                </div>
                                <div class="d-none col-lg-12 ml-1 pt-1 form-group mb-0">
                                    <label for="email" class="mb-0">Email</label>
                                    <input type="email" name="custEmail" class="form-control" style="color:white;background: #2C2C2D;border: 1px solid #FFFFFF;box-sizing: border-box;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 14px;height:48px;padding-left:5px;"> 
                                </div>
                                <div class="col-lg-12 ml-1 pt-1 form-group mb-0">
                                    <label class="mb-0">Card Number</label>
                                    <div id="cardNumber" class=""> </div>
                                    <!-- <input type="text" name="cardNumber" size="20" autocomplete="off" id="cardNumber" class="form-control"  style="color:white;"/> -->
                                </div>

                                <div class="col-lg-12 ml-1 pt-1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="mb-0">CVC</label>
                                                <div id="cardCVC" class=""> </div>
                                                <!-- <input type="text" name="cardCVC" size="4" autocomplete="off" id="cardCVC" class="form-control"  style="color:white;"/> -->
                                            </div>
                                        </div> <div class="col-md-1"></div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="mb-0">Expiration (MM/YY)</label>
                                                
                                                <div id="cardExp" class=""> </div>
                                                    <!-- <input type="text" name="cardExp" placeholder="MM" size="2" id="cardExp" class="form-control"  style="color:white;"/> -->

                                                <!-- <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="cardExpMonth" placeholder="MM" size="2" id="cardExpMonth" class="form-control"  style="color:white;"/>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="cardExpYear" placeholder="YY" size="4" id="cardExpYear" class="form-control"  style="color:white;"/>
                                                    </div>
                                                </div> -->

                                            </div>
                                        </div>
                                    </div>	
                                </div>
                                <input type="hidden" name="membership" value="pro">
                                <div class="pt-2 ml-3 pl-2 mr-4 pr-4 col-lg-12 d-flex"> 
                                    <button type="button" id="paymentCardRequestBtn" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;border: none;">
										Get your free trial
									</button>
                                </div>

                                <div class="ml-3 pl-2 col-lg-12 d-flex1 pt-2" style="font-weight: bold;font-size: 13px; text-align:center;"> 
                                    <button class="btn" id="backToPaymentTypeBtn" style="text-decoration: underline;background: transparent;color: white;"> Back </button>
                                </div>
                                <div class="ml-3 pl-2 col-lg-12 d-flex1 pt-2" style="font-weight: bold;font-size: 13px; text-align:center;"> Cancel any time </div>
                            </div>	
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
   @endif
   
   @if($user_role==3)
   <?php 
    $userSubscription = getUserSubscriptionStripe();
    $subscriptionStatus = !is_null($userSubscription)?$userSubscription["status"]:0;  // 2 - canceled , 3 - billing failed
   ?>
    <div class="modal fade" id="lwBillingProDialog" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="userReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content" style="background-color: #191919;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/border-radius: 24px; ">
                
                <div class="modal-header" style="border-bottom:none;display:none;">
                    <h5 class="modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 27px;line-height: 37px;color: #FFFFFF;">
                        Try STACKD PRO
                    </h5>
                    <button type="button" style="color:#FFFFFF;margin-top: -20px; " class="close" data-dismiss="modal" aria-label="Close">
                        <span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body" style="color:#FFFFFF;border-radius: 24px;background-image: url('/imgs/pro_background.png');background-repeat: no-repeat;background-size: 50% 100%;min-height: 750px;">

                    <div class="d-flex">

                        <div class="p-1" style="flex:1;">
                            <div class="row" style="font-family: Nunito Sans;font-style: normal;color:white;">
                                <div class="col-lg-12 d-flex pt-2" style="font-weight: bold;font-size: 1.5rem;line-height: 24px;"> STACKD </div>
                                
                                <?php 
                                if( $subscriptionStatus == 3) { ?>
                                <div class="col-lg-12 d-flex pt-4 mt-2" style="font-weight: bold;font-size: 1.5rem;line-height: 24px;"> It appears your subscription payment failed. </div>
                                <div class="col-lg-12 d-flex pt-3" style="font-weight: normal;font-size: 1rem;line-height: 24px;"> Your fitness hub unlocked to its full potential. </div>
                                <?php
                                } else if( $subscriptionStatus == 2) {
                                ?>
                                <div class="col-lg-12 d-flex pt-4 mt-2" style="font-weight: bold;font-size: 1.5rem;line-height: 24px;"> It appears that your subscription has expired. </div>
                                <div class="col-lg-12 d-flex pt-3" style="font-weight: normal;font-size: 1rem;line-height: 24px;"> To continue using STACKD please select a new plan. </div>
                                <?php } else { ?>
                                <div class="col-lg-12 d-flex pt-4 mt-2" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Do more with STACKD Pro. </div>
                                <div class="col-lg-12 d-flex pt-3" style="font-weight: normal;font-size: 1rem;line-height: 24px;"> To continue using STACKD please select a new plan. </div>
                                <?php } ?>

                                <div class="col-lg-12 d-flex pt-4 mt-4">
                                    <table class="table table-hover table-pricing" style="color:white;">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="text-align:center;border-right:1px solid #515151;"><span>PT Basic</span></th>
                                                <th style="text-align:center;"><span>PT Pro</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span style="font-size:13px;">Unlimited messaging</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span style="font-size:13px;">Business in one spot</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span style="font-size:13px;">See who views your page</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span style="font-size:13px;">Upload pricing</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
													<svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr>

											<tr>
                                                <td>
                                                    <span style="font-size:13px;">Access to customers worldwide</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr>
											<tr>
                                                <td>
                                                    <span style="font-size:13px;">Priority features in search results</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.70711 0.292893C1.31658 -0.097631 0.683418 -0.0976311 0.292893 0.292893C-0.097631 0.683417 -0.0976312 1.31658 0.292893 1.70711L5.5858 7.00002L0.292922 12.2929C-0.0976021 12.6834 -0.0976021 13.3166 0.292922 13.7071C0.683447 14.0976 1.31661 14.0976 1.70714 13.7071L7.00001 8.41423L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41423 7.00002L13.7071 1.70711C14.0977 1.31658 14.0977 0.683419 13.7071 0.292895C13.3166 -0.0976298 12.6834 -0.0976294 12.2929 0.292895L7.00001 5.5858L1.70711 0.292893Z" fill="#6F767E"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr>
											<tr>
                                                <td>
                                                    <span style="font-size:13px;">Unlimited follows everyday</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.70711 0.292893C1.31658 -0.097631 0.683418 -0.0976311 0.292893 0.292893C-0.097631 0.683417 -0.0976312 1.31658 0.292893 1.70711L5.5858 7.00002L0.292922 12.2929C-0.0976021 12.6834 -0.0976021 13.3166 0.292922 13.7071C0.683447 14.0976 1.31661 14.0976 1.70714 13.7071L7.00001 8.41423L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41423 7.00002L13.7071 1.70711C14.0977 1.31658 14.0977 0.683419 13.7071 0.292895C13.3166 -0.0976298 12.6834 -0.0976294 12.2929 0.292895L7.00001 5.5858L1.70711 0.292893Z" fill="#6F767E"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr>
											<!-- <tr>
                                                <td>
                                                    <span style="font-size:13px;">Incognito private browsing of profiles</span>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid #515151;">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.70711 0.292893C1.31658 -0.097631 0.683418 -0.0976311 0.292893 0.292893C-0.097631 0.683417 -0.0976312 1.31658 0.292893 1.70711L5.5858 7.00002L0.292922 12.2929C-0.0976021 12.6834 -0.0976021 13.3166 0.292922 13.7071C0.683447 14.0976 1.31661 14.0976 1.70714 13.7071L7.00001 8.41423L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41423 7.00002L13.7071 1.70711C14.0977 1.31658 14.0977 0.683419 13.7071 0.292895C13.3166 -0.0976298 12.6834 -0.0976294 12.2929 0.292895L7.00001 5.5858L1.70711 0.292893Z" fill="#6F767E"/>
                                                    </svg>
                                                </td>
                                                <td style="text-align:center;">
                                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                                    </svg>
                                                </td>
                                            </tr> -->
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="p-4" style="flex:1;">
                                 
                            @if(isLoggedIn())
                                    <div class="chat-user-item d-flex position-relative"> 
                                        <div class="d-none chat-user-avatar">
                                            <img style="border-radius: 50%; width:44px; height:44px;border: 2px solid #FFFFFF;" src="<?= array_get(getUserAuthInfo() , 'profile.profile_picture_url' )?>">
                                        </div>
                                        <div class="chat-item-username" style="padding-left: 1.25rem;margin-top: -1rem; margin-left: auto;"> 
                                            <span class="d-none row" style="font-size: 1rem;line-height: 1.5rem;">
                                                <?= array_get(getUserAuthInfo() , 'profile.username' ) ?>
                                            </span>
                                            <span class="row" style="font-size: 0.85rem;line-height: 1.25rem;color: #91929E;">
                                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.0165 5.38948V4.45648C13.0165 2.42148 11.3665 0.771484 9.33146 0.771484H4.45646C2.42246 0.771484 0.772461 2.42148 0.772461 4.45648V15.5865C0.772461 17.6215 2.42246 19.2715 4.45646 19.2715H9.34146C11.3705 19.2715 13.0165 17.6265 13.0165 15.5975V14.6545" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M19.8096 10.0214H7.76855" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16.8818 7.10632L19.8098 10.0213L16.8818 12.9373" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <a style="margin-left:0.25rem;color: #FFFFFF;" href="<?= route('user.logout') ?>"><?= __tr('Sign Out') ?></a>
                                            </span>
                                        </div>
                                    </div> 
                            @endif
                        
                            <form id="payment-form" class="lw-ajax-form1 lw-form1" method="post" data-show-message="true" action="<?= route('user.write.setting-subscription') ?>" data-callback="onSubscriptionStripeCallback" >
                            <div id="payment_type_container" class="p-4 row" style="font-family: Nunito Sans;font-style: normal;color:white;">
                                
                                <?php 
                                if( $subscriptionStatus == 3) { ?>
                                <div class="col-lg-12 d-flex pt-2 pb-2" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Try STACKD PT Basic</div>
                                <?php
                                } else if( $subscriptionStatus == 2) {
                                ?>
                                <div class="col-lg-12 d-flex pt-2 pb-2" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Try STACKD PT Basic</div>
                                <?php } else { ?>
                                <div class="col-lg-12 d-flex pt-2 pb-2" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Try STACKD PT Basic for free </div>
                                <div class="col-lg-12 d-flex pt-2 pb-2" style="padding-left:20px;font-weight: bold;font-size: 0.75rem;line-height: 24px;"> Free 30 day trial, cancel any time</div>
                                <?php } ?>

									@foreach( $premiumPlanData["premiumPlans"]['standard'] as $plan_key=>$plan_val)
										@if( $plan_val["enable"])
										<div class="col-lg-12" >
											<div class="col-lg-12 d-flex pt-2 mt-1 pl-5 pr-2 custom-control custom-radio custom-control-inline">
												<input type="radio" checked="" id="lwSelectMembershipStandard_<?= $plan_key ?>" value="<?= $plan_key ?>" name="standard_plan_id" class="custom-control-input">
												<label id="containerMembershipTitleStandard_<?= $plan_key ?>" class="custom-control-label" for="lwSelectMembershipStandard_<?= $plan_key ?>" style="font-weight: bold;font-size: 13px;line-height: 24px;">
													<?= $plan_val["title"] ?>

													@if ($plan_key == 'year')
													&nbsp;&nbsp;&nbsp;<span class="pl-3 pr-3 pt-1 pb-1" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 9px;line-height: 24px;text-align: center;letter-spacing: 1px;color: #FFFFFF;background: #FF4141;border-radius: 10px;">  BEST DEAL ￥<?= $premiumPlanData["premiumPlans"]['standard']["one_month"]["price"] * 12 - $plan_val["price"] ?> OFF </span>
													@endif
												</label>
													
											</div>
											<div class="ml-4 pl-4 col d-flex pt-1" id="containerMembershipPriceStandard_<?= $plan_key ?>" style="font-weight: bold;font-size: 11px;"> ￥<?= $plan_val["price"]?> 
												@if ($plan_key == 'year')
												<span>( ￥<?= round($plan_val["price"]/12,2) ?> / month ) </span> 
												@endif
											</div>
										</div>	
										@endif
									@endforeach

                                <!-- <div class="ml-3 col-lg-12 d-flex pt-4" style="font-weight: bold;font-size: 11px;"> Due January 22, 2022 <span style="margin-left: auto;"> ￥4,800 </span></div>
                                <div class="ml-3 col-lg-12 d-flex pt-1" style="font-weight: bold;font-size: 11px;"> Due today <span style="margin-left: auto;"> ￥0 </span></div> -->
        
                                <div class="pt-4 ml-4 pl-4 mr-4 pr-4 col-lg-12 d-flex"> 
                                    <button type="button" id="paymentStandardSubscribeBtn" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;border: none;">
                                        <?php 
                                        if( $subscriptionStatus == 3) { ?>
                                            Join today
                                        <?php
                                        } else if( $subscriptionStatus == 2) {
                                        ?>
                                            Join today
                                        <?php } else { ?>
                                            Try for free for 30 days
                                        <?php } ?>
									</button>
                                </div>

								<div class="col-lg-12 pt-4 pb-4" style="text-align:center;font-weight: bold;font-size: 1.25rem;line-height: 24px;"> Or </div>

								<div class="col-lg-12 d-flex pt-2 pb-2" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Try STACKD PT Pro </div>
                                
									@foreach( $premiumPlanData["premiumPlans"]['premium'] as $plan_key=>$plan_val)
										@if( $plan_val["enable"])
										<div class="col-lg-12" >
											<div class="col-lg-12 d-flex pt-2 mt-1 pl-5 pr-2 custom-control custom-radio custom-control-inline">
												<input type="radio" checked="" id="lwSelectMembershipPremium_<?= $plan_key ?>" value="<?= $plan_key ?>" name="premium_plan_id" class="custom-control-input">
												<label id="containerMembershipTitlePremium_<?= $plan_key ?>" class="custom-control-label" for="lwSelectMembershipPremium_<?= $plan_key ?>" style="font-weight: bold;font-size: 13px;line-height: 24px;">
													<?= $plan_val["title"] ?>

													@if ($plan_key == 'year')
													&nbsp;&nbsp;&nbsp;<span class="pl-3 pr-3 pt-1 pb-1" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 9px;line-height: 24px;text-align: center;letter-spacing: 1px;color: #FFFFFF;background: #FF4141;border-radius: 10px;">  BEST DEAL ￥<?= $premiumPlanData["premiumPlans"]['premium']["one_month"]["price"] * 12 - $plan_val["price"] ?> OFF </span>
													@endif
												</label>
													
											</div>
											<div class="ml-4 pl-4 col d-flex pt-1" id="containerMembershipPricePremium_<?= $plan_key ?>" style="font-weight: bold;font-size: 11px;"> ￥<?= $plan_val["price"]?> 
												@if ($plan_key == 'year')
												<span>( ￥<?= round($plan_val["price"]/12,2) ?> / month ) </span> 
												@endif
											</div>
										</div>	
										@endif
									@endforeach

                                <!-- <div class="ml-3 col-lg-12 d-flex pt-4" style="font-weight: bold;font-size: 11px;"> Due January 22, 2022 <span style="margin-left: auto;"> ￥4,800 </span></div>
                                <div class="ml-3 col-lg-12 d-flex pt-1" style="font-weight: bold;font-size: 11px;"> Due today <span style="margin-left: auto;"> ￥0 </span></div> -->
        
                                <div class="pt-4 ml-4 pl-4 mr-4 pr-4 col-lg-12 d-flex"> 
                                    <button type="button" id="paymentPremiumSubscribeBtn" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;border: none;">
										Join today
									</button>
                                </div>

                            </div>	
                            
                            <div id="payment_card_container" class="p-4 row" style="display:none;font-family: Nunito Sans;font-style: normal;color:white;">
                            
                                <?php 
                                if( $subscriptionStatus == 3) { ?>
                                <div class="col-lg-12 d-flex pt-2 title" style="font-weight: bold;font-size: 1.25rem;line-height: 24px;"> Subscribe to STACKD PT Basic </div>
								<div class="col-lg-12 d-flex pt-2 pl-4 subtitle" style="font-weight: bold;font-size: 0.75rem;line-height: 24px;">  </div>                              
                                <?php
                                } else if( $subscriptionStatus == 2) {
                                ?>
                                <div class="col-lg-12 d-flex pt-2 title" style="font-weight: bold;font-size: 1.25rem;line-height: 24px;"> Subscribe to STACKD PT Basic </div>
								<div class="col-lg-12 d-flex pt-2 pl-4 subtitle" style="font-weight: bold;font-size: 0.75rem;line-height: 24px;"> </div>                              
                                <?php } else { ?>
                                <div class="col-lg-12 d-flex pt-2 title" style="font-weight: bold;font-size: 1.25rem;line-height: 24px;"> Try STACKD PRO </div>
								<div class="col-lg-12 d-flex pt-2 pl-4 subtitle" style="font-weight: bold;font-size: 0.75rem;line-height: 24px;"> Free 30 day trial, cancel any time </div>                              
                                <?php } ?>
                                
                                <div class="col-lg-12 ml-1 pt-2 form-group mb-0">
                                    <div id="paymentResponse"></div>
                                    
                                    <!--  success messages  -->
                                    <div class="alert alert-success alert-dismissible fade show" id="lwSuccessMessage" style="display:none;"></div>
                                    <!--  /success messages  -->

                                    <!--  error messages  -->
                                    <div class="alert alert-danger alert-dismissible fade show" id="lwErrorMessage" style="display:none;"></div>
                                    <!--  /error messages -->
                                    
                                </div>
								<input type="hidden" name="membership" id="pt_membership_type" value="" >
								<input type="hidden" name="plan_id" id="pt_plan_id" value="" >					
                                <div class="col-lg-12 ml-1 pt-2 form-group mb-0" id="selectedMembershipContainer">
                                    <div class="col-lg-12 d-flex custom-control custom-radio custom-control-inline">
                                        <input type="radio" checked="" id="lwSelectMembership_selected" value="" name="selected_plan_id" class="custom-control-input">
										<label id="containerMembershipTitleSelected" class="custom-control-label" for="lwSelectMembership_selected" style="font-weight: bold;font-size: 13px;line-height: 24px;">
										</label>			
                                    </div>
                                    <div class="pl-3 col-lg-12 d-flex pt-1" id="lwSelectMembership_selected_text" style="font-weight: bold;font-size: 11px;">  </div>
                                </div>
								
                                <div class="ml-2 col-lg-12 d-flex pt-2" style="font-weight: bold;font-size: 11px;"> <span id="dueSelectedDate">First payment due <?= \Carbon\Carbon::now()->addDays(30)->format('F d, Y')?></span> <span id="dueSelectedPrice" style="margin-left: auto;"> </span></div>
                                <div class="ml-2 col-lg-12 d-flex pt-1" style="font-weight: bold;font-size: 11px;padding-bottom:5px;border-bottom:1px solid #515151;"> Due today <span id="dueTodaySelectedPrice" style="margin-left: auto;"> ￥0 </span></div>
        
								<div class="col-lg-12 ml-1 d-flex pt-2" style="font-weight: bold;font-size: 11px;"> 
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 10C2.44772 10 2 10.4477 2 11V17C2 18.6569 3.34315 20 5 20H19C20.6569 20 22 18.6569 22 17V11C22 10.4477 21.5523 10 21 10H3ZM5 14C4.44772 14 4 14.4477 4 15C4 15.5523 4.44772 16 5 16H11C11.5523 16 12 15.5523 12 15C12 14.4477 11.5523 14 11 14H5Z" fill="white"/>
                                    <path d="M2 7C2 5.34315 3.34315 4 5 4H19C20.6569 4 22 5.34315 22 7C22 7.55228 21.5523 8 21 8H3C2.44772 8 2 7.55228 2 7Z" fill="white"/>
                                    </svg> 
                                    &nbsp;&nbsp;
                                    <span> Credit or Debit Card </span> 
                                </div>

                                <div class="col-lg-12 ml-1 pt-2 form-group mb-0">
                                    <label class="mb-0" for="name">Name</label>
                                    <input type="text" name="custName" class="form-control" style="color:white;background: #2C2C2D;border: 1px solid #FFFFFF;box-sizing: border-box;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 14px;height:48px;padding-left:5px;"> 
                                </div>
                                <div class="d-none col-lg-12 ml-1 pt-1 form-group mb-0">
                                    <label class="mb-0" for="email">Email</label>
                                    <input type="email" name="custEmail" class="form-control" style="color:white;background: #2C2C2D;border: 1px solid #FFFFFF;box-sizing: border-box;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 14px;height:48px;padding-left:5px;"> 
                                </div>
                                <div class="col-lg-12 ml-1 pt-1 form-group mb-0">
                                    <label class="mb-0">Card Number</label>
                                    <div id="cardNumber" class=""> </div>
                                    <!-- <input type="text" name="cardNumber" size="20" autocomplete="off" id="cardNumber" class="form-control"  style="color:white;"/> -->
                                </div>

                                <div class="col-lg-12 ml-1 pt-1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="mb-0">CVC</label>
                                                <div id="cardCVC" class=""> </div>
                                                <!-- <input type="text" name="cardCVC" size="4" autocomplete="off" id="cardCVC" class="form-control"  style="color:white;"/> -->
                                            </div>
                                        </div> <div class="col-md-1"></div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="mb-0">Expiration (MM/YY)</label>
                                                
                                                <div id="cardExp" class=""> </div>
                                                    <!-- <input type="text" name="cardExp" placeholder="MM" size="2" id="cardExp" class="form-control"  style="color:white;"/> -->

                                                <!-- <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="cardExpMonth" placeholder="MM" size="2" id="cardExpMonth" class="form-control"  style="color:white;"/>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="cardExpYear" placeholder="YY" size="4" id="cardExpYear" class="form-control"  style="color:white;"/>
                                                    </div>
                                                </div> -->

                                            </div>
                                        </div>
                                    </div>	
                                </div>
                                
                                <div class="pt-2 ml-3 pl-2 mr-4 pr-4 col-lg-12 d-flex"> 
                                    <button type="button" id="paymentCardRequestBtn" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;border: none;">
										Get your free trial
									</button>
                                </div>

                                <div class="ml-3 pl-2 col-lg-12 d-flex1 pt-2" style="font-weight: bold;font-size: 13px; text-align:center;"> 
                                    <button class="btn" id="backToPaymentTypeBtn" style="text-decoration: underline;background: transparent;color: white;"> Back </button>
                                </div>
                                <div class="d-none ml-3 pl-2 col-lg-12 d-flex1 pt-2" style="font-weight: bold;font-size: 13px; text-align:center;"> Cancel any time </div>
                            </div>	
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
   @endif  

</body>
<!-- Javascript -->
@include('front-include.js')
<script src="{{ asset('dist/flatpicker/flatpickr.js') }}"></script>
<script src="{{ asset('dist/cropper/cropper.js') }}"></script>
@if(getStoreSettings('allow_google_map'))
<script src="https://maps.googleapis.com/maps/api/js?key=<?= getStoreSettings('google_map_key'); ?>&libraries=places&callback=initialize&language=en" async defer></script>
@endif

<script>

    var isInvoked = [false, false, false, false, false];                                                

    function onSignupProfileCallback(response){ 
        if(response.reaction == 1){ 
            isInvoked[1] = true;
            $("#smartwizard-6").smartWizard("next");
        }
    }

    function onSignupAvailabilityCallback(response){ 
        if(response.reaction == 1){ 
            isInvoked[2] = true;
            $("#smartwizard-6").smartWizard("next");
        }
    }

    function onSignupLocationCallback(response){ console.log(response)
        if(response.reaction == 1){ 
            isInvoked[3] = true;
           // $("#smartwizard-6").smartWizard("next");
			@if($user_role==2)	
           		$("#lwBillingProDialog").modal({backdrop: 'static', keyboard: false});
			@endif
			@if($user_role==3)	
				__Utils.viewReload();
			@endif
        }
    }

    function onSubscriptionStripeCallback(responseData) {
		console.log(responseData)
		if (responseData.reaction == 1) {
            
        }
	}

    $(function() {

        $("#paymentSubscribeBtn").on('click', function(e) {
            e.preventDefault();
            $("#payment_type_container").hide();
            $("#payment_card_container").show();

			console.log($("input[name='plan_id']:checked").val());
			var selectedMembershipvalue = $("input[name='plan_id']:checked").val();
			$("#lwSelectMembership_selected").val(selectedMembershipvalue);
			$("#containerMembershipTitleSelected").html($("#containerMembershipTitle_"+selectedMembershipvalue).html());
			$("#lwSelectMembership_selected_text").html($("#containerMembershipPrice_"+selectedMembershipvalue).html());
			$("#dueSelectedPrice").html($("#containerMembershipPrice_"+selectedMembershipvalue).clone().children().remove().end().text());
        });

		$("#paymentStandardSubscribeBtn").on('click', function(e) {
            e.preventDefault();
            $("#payment_type_container").hide();
            $("#payment_card_container").show();

			console.log($("input[name='standard_plan_id']:checked").val());
			var selectedMembershipvalue = $("input[name='standard_plan_id']:checked").val();
			$("#pt_plan_id").val(selectedMembershipvalue);

			$("#lwSelectMembership_selected").val(selectedMembershipvalue);
			$("#containerMembershipTitleSelected").html($("#containerMembershipTitleStandard_"+selectedMembershipvalue).html());
			$("#lwSelectMembership_selected_text").html($("#containerMembershipPriceStandard_"+selectedMembershipvalue).html());
			$("#dueSelectedPrice").html($("#containerMembershipPriceStandard_"+selectedMembershipvalue).clone().children().remove().end().text());

			$("#pt_membership_type").val('standard');
            
            <?php 
            if( $subscriptionStatus == 3) { ?>
            $("#payment_card_container>div.title").html('Subscribe to STACKD PT Basic');
			$("#payment_card_container>div.subtitle").html('');
            $("#paymentCardRequestBtn").text("Subscribe Now");

            if(selectedMembershipvalue == 'year'){
				$("#dueSelectedDate").html('Renews <?= \Carbon\Carbon::now()->addYears(1)->format('F d, Y')?>');
			} else if(selectedMembershipvalue == 'one_month') {
				$("#dueSelectedDate").html('Renews <?= \Carbon\Carbon::now()->addDays(30)->format('F d, Y')?>');
			}

			$("#dueTodaySelectedPrice").text($("#containerMembershipPriceStandard_"+selectedMembershipvalue).clone().children().remove().end().text());
            <?php
            } else if( $subscriptionStatus == 2) {
            ?>
            $("#payment_card_container>div.title").html('Subscribe to STACKD PT Basic');
			$("#payment_card_container>div.subtitle").html('');
            $("#paymentCardRequestBtn").text("Subscribe Now");

            if(selectedMembershipvalue == 'year'){
				$("#dueSelectedDate").html('Renews <?= \Carbon\Carbon::now()->addYears(1)->format('F d, Y')?>');
			} else if(selectedMembershipvalue == 'one_month') {
				$("#dueSelectedDate").html('Renews <?= \Carbon\Carbon::now()->addDays(30)->format('F d, Y')?>');
			}

			$("#dueTodaySelectedPrice").text($("#containerMembershipPriceStandard_"+selectedMembershipvalue).clone().children().remove().end().text());
            <?php } else { ?>
            $("#payment_card_container>div.title").html('Try STACKD PT Basic for free');
			$("#payment_card_container>div.subtitle").html('Free 30 day trial, cancel any time');
            $("#paymentCardRequestBtn").text("Get your free trial");
            $("#dueSelectedDate").html('First payment due <?= \Carbon\Carbon::now()->addDays(30)->format('F d, Y')?>');
			$("#dueTodaySelectedPrice").text("￥0");
            <?php } ?>
            
			
        });

		$("#paymentPremiumSubscribeBtn").on('click', function(e) {
            e.preventDefault();
            $("#payment_type_container").hide();
            $("#payment_card_container").show();

			console.log($("input[name='premium_plan_id']:checked").val());
			var selectedMembershipvalue = $("input[name='premium_plan_id']:checked").val();
			$("#lwSelectMembership_selected").val(selectedMembershipvalue);
			$("#pt_plan_id").val(selectedMembershipvalue);
			
			$("#containerMembershipTitleSelected").html($("#containerMembershipTitlePremium_"+selectedMembershipvalue).html());
			$("#lwSelectMembership_selected_text").html($("#containerMembershipPricePremium_"+selectedMembershipvalue).html());
			$("#dueSelectedPrice").html($("#containerMembershipPricePremium_"+selectedMembershipvalue).clone().children().remove().end().text());

			$("#pt_membership_type").val('premium');
			$("#payment_card_container>div.title").html('SUBSCRIBE TO STACKD PT Pro');
			$("#payment_card_container>div.subtitle").html('');
			if(selectedMembershipvalue == 'year'){
				$("#dueSelectedDate").html('Renews <?= \Carbon\Carbon::now()->addYears(1)->format('F d, Y')?>');
			} else if(selectedMembershipvalue == 'one_month') {
				$("#dueSelectedDate").html('Renews <?= \Carbon\Carbon::now()->addDays(30)->format('F d, Y')?>');
			}
			$("#paymentCardRequestBtn").text("Subscribe Now");
			$("#dueTodaySelectedPrice").text($("#containerMembershipPricePremium_"+selectedMembershipvalue).clone().children().remove().end().text());
        });

        $("#backToPaymentTypeBtn").on('click', function(e) {
            e.preventDefault();
            $("#payment_type_container").show();
            $("#payment_card_container").hide();
        });

        // Create a token when the form is submitted.
        $("#paymentCardRequestBtn").click(function(e) {
            //e.preventDefault();
            createToken();
        });

		let user_role = <?= $user_role?>;
		if(user_role == 2 ){
			ChooseType('partner');
		} else if( user_role == 3 ) {
			ChooseType('pt');
		}
		
    });

    $(function() {

        // croper js 
        var cropped_image = '';
        var URL = window.URL || window.webkitURL;
        var $image = $('#cropper-example-image');
        var options = {
            aspectRatio: 16 / 16,
            preview: '.cropper-example-preview',
            viewMode: 2, //
            dragMode: 'move',
            autoCropArea: 1.0,
            crop: function(e) {
                $('#cropper-example-dataX').val(Math.round(e.detail.x));
                $('#cropper-example-dataY').val(Math.round(e.detail.y));
                $('#cropper-example-dataHeight').val(Math.round(e.detail.height));
                $('#cropper-example-dataWidth').val(Math.round(e.detail.width));
                $('#cropper-example-dataRotate').val(e.detail.rotate);
                $('#cropper-example-dataScaleX').val(e.detail.scaleX);
                $('#cropper-example-dataScaleY').val(e.detail.scaleY);
            }
        };

        var originalImageURL = $image.attr('src');
        var uploadedImageURL;

        // Cropper
        $image.cropper(options);

        // IE10 fix
        if (typeof document.documentMode === 'number' && document.documentMode < 11) {
            options = $.extend({}, options, {
                zoomOnWheel: false
            });
            setTimeout(function() {
                $image.cropper('destroy').cropper(options);
            }, 1000);
        }

        // Methods
        $('#set_profile_image').on('click', function() {
            
            //let result = $image.cropper('getCroppedCanvas');

            let result = $image.cropper('getCroppedCanvas', 
			{
				'width': 1000,
				'height': 1000,
				//minWidth: 128,
				//minHeight: 128,
				//maxWidth: 4096,
				//maxHeight: 4096,
				//fillColor: '#fff',
				//imageSmoothingEnabled: true,
				//imageSmoothingQuality: 'high',
			});

		    cropped_image = result.toDataURL('image/jpeg', 0.8);  //image/png, ("image/jpeg", 0.7);  // last=quality

            //cropped_image = result.toDataURL();

            $('#profile_image').attr('src', cropped_image);
            $('#profile_image').addClass('add-profile-btn');
            $('#photoModal').modal('hide');
            $('#profile_image_val').val(cropped_image);
        });

        // Import image
        var $inputImage = $('#cropper-example-inputImage');

        if (URL) {
            $inputImage.change(function() {
                $('#photoModal').modal('show');
                var files = this.files;
                var file;

                if (!$image.data('cropper')) {
                    return;
                }

                if (files && files.length) {
                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                        }

                        uploadedImageURL = URL.createObjectURL(file);
                        $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                        $inputImage.val('');

                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            });
        } else {
            $inputImage.prop('disabled', true).parent().addClass('disabled');
        }

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
                    },
                    
                },
                
            });
        });

		
		@if($user_role==3 && !isPremiumUserStripe())	
			$("#lwBillingProDialog").modal({backdrop: 'static', keyboard: false});
		@endif
		
		var stepsStatus = <?= json_encode($profileStatus) ?>;
		var selectedStep = 1;
		var disabledSteps = [0];
		if (stepsStatus.step_one) {
			selectedStep = 2;
			disabledSteps.push(1);
		} else {
			selectedStep = 1;
		}
		if (stepsStatus.step_two) {
			//selectedStep = 3;
			//__Utils.viewReload();
		} 

		//	$('#smartwizard-6').smartWizard('goToStep', 1);
       
        // Initialize wizard
        $wizard_container.smartWizard({
                selected: selectedStep,
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
				disabledSteps: disabledSteps, // Array Steps disabled
				errorSteps: [], // Highlight step with errors
				hiddenSteps: [] // Hidden steps
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

                        if($($forms[stepNumber]) && $($forms[stepNumber]).valid())
                        {
                            // First step - Signup with Email, password
                            if(stepNumber == 0) {
                                return true;
                            } else if( stepNumber == 1 ) {
                                if(!isInvoked[stepNumber]){
                                    $($forms[stepNumber]).submit();
                                    return false;
                                } else {
                                    return true;
                                }
                            } else if( stepNumber == 2) {
                                if(!isInvoked[stepNumber]){
                                    
                                    if( $('input:checkbox:checked').length > 0){
                                        $($forms[stepNumber]).submit();
                                    } else {

                                    }
                                    
                                    return false;
                                } else {
                                    return true;
                                }
                            }
                        } else {
                            return false;
                        }
                        
                } else {

                    isInvoked[stepNumber-1] = false;
                    return true;
                }

                // var form_data = $("#step_"+ stepNumber +"_form").serialize();
                // $.ajax({
                //     type:'post',
                //     url:"ajax.php",
                //     data:form_data,
                //     success:function(data){
                //     // indicate the ajax has been done, release the next step
                //     $("#listing_wizard").smartWizard("next");
                //     }
                // });

                // // Return false to cancel the `leaveStep` event 
                // // and so the navigation to next step which is handled inside success callback.
                // return false;

                // if(anchorObject.prevObject.length - 1 == nextStepIndex){
                //     alert('this is the last step'); 
                // }else{
                //     alert('this is not the last step');                
                // }

            })
            .on('showStep', function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                var $fbtn = $wizard_container.find('.btn-finish');
                var $nbtn = $wizard_container.find('.sw-btn-next');
				var $pbtn = $wizard_container.find('.sw-btn-prev');
                // Enable finish button only on last step
				console.log(stepNumber, stepPosition);
				if (stepNumber === 1){
					$pbtn.addClass("hidden");
				} else if (stepNumber === 3) {
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
        // Click on finish button
        $wizard_container.find('.btn-finish').on('click', function() {
            if(isInvoked[$forms.length-1]){
                
            } else {
                if ($($forms[$forms.length-1]).valid()) {
                    $($forms[$forms.length-1]).submit();
                }
            }           
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

    function ChooseType(type) {
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

        $("#lw-user-gym-select-container").html('');
        $("#lw-user-gym-select-container").append(`
            <select id="selectGym" name="selectGym" mutiple class="form-control form-control-user lw-user-gym-select-box" required="" style="width: 100%;border-color: white;">
            </select> 
        `);
        var gym_list = JSON.parse(`<?= json_encode($gyms)?>`);
        var maxItemCount = 1;
        if ( $('#usertype').val() == 3 ) {
            maxItemCount = 3;
        }
        $('#selectGym').selectize({
            plugins: ['restore_on_backspace', ],  // 'remove_button'
            valueField: '_id',
            labelField: 'name',
            searchField: [
                'name'
            ],
            options: gym_list,
            create: false,
            // loadThrottle: 2000,
            maxItems: maxItemCount,
            render: {
                option: function(item, escape) {
                    return '<div><span class="title"><span class="name">' + escape(item.name) + '</span></span></div>';
                }
            },
            load: function(query, callback) {
                if (!query.length || (query.length < 2)) {
                    return callback([]);
                } else {
                    __DataRequest.post("<?= route('user.read.search_static_gym'); ?>", {
                        'search_query': query
                    }, function(responseData) {
                        callback(responseData.data.search_result);
                    });
                }
            },
            onChange: function(value) {
                if (!value.length) {
                    return;
                };
                $("#gym_selected_list").val(value);
            }
        });

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
    // google location
    function initialize() {

        $('form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        const locationInputs = document.getElementsByClassName("map-input");

        const autocompletes = [];
        const geocoder = new google.maps.Geocoder;
        for (let i = 0; i < locationInputs.length; i++) {

            const input = locationInputs[i];
            const fieldKey = input.id.replace("-input", "");
            const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

            const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || 35.6762;
            const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 139.6503;

            const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
                center: {
                    lat: latitude,
                    lng: longitude
                },
                zoom: 13
            });
            const marker = new google.maps.Marker({
                map: map,
                position: {
                    lat: latitude,
                    lng: longitude
                },
            });

            marker.setVisible(isEdit);

            const autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.key = fieldKey;
            autocompletes.push({
                input: input,
                map: map,
                marker: marker,
                autocomplete: autocomplete
            });
        }

        for (let i = 0; i < autocompletes.length; i++) {
            const input = autocompletes[i].input;
            const autocomplete = autocompletes[i].autocomplete;
            const map = autocompletes[i].map;
            const marker = autocompletes[i].marker;

            google.maps.event.addListener(autocomplete, 'place_changed', function() {

                $('.btn-finish').attr('disabled', true);

                marker.setVisible(false);
                const place = autocomplete.getPlace();
                geocoder.geocode({
                    'placeId': place.place_id
                }, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        const lat = results[0].geometry.location.lat();
                        const lng = results[0].geometry.location.lng();
                        setLocationCoordinates(autocomplete.key, lat, lng, place);
                    }
                });

                if (!place.geometry) {
                    window.alert("No details available for input: '" + place.name + "'");
                    input.value = "";
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
            });
        }
    }

    function setLocationCoordinates(key, lat, lng, placeData) {
        var place = placeData['address_components'];
        var pp = JSON.stringify(place);
        
        $('#' + key + '_address').val(pp);
        $('#' + key + '-latitude').val(lat);
        $('#' + key + '-longitude').val(lng);
        //$('#' + key + '-formatted_address').val(placeData.formatted_address);

        $('.btn-finish').attr('disabled', false);
    };

    $(function() {
        $('#selectLocationCity').selectize({
            // plugins: ['restore_on_backspace'],
            valueField: 'id',
            labelField: 'cities_full_name',
            searchField: [
                'cities_full_name'
            ],
            // options: [],
            create: false,
            // loadThrottle: 2000,
            maxItems: 1,
            render: {
                option: function(item, escape) {
                    return '<div><span class="title"><span class="name">' + escape(item.cities_full_name) + '</span></span></div>';
                }
            },
            load: function(query, callback) {
                if (!query.length || (query.length < 2)) {
                    return callback([]);
                } else {
                    __DataRequest.post("<?= route('user.read.search_static_cities'); ?>", {
                        'search_query': query
                    }, function(responseData) {
                        callback(responseData.data.search_result);
                    });
                }
            },
            onChange: function(value) {
                // if (!value.length) {
                //     return;
                // };
                // __DataRequest.post("<?php //echo route('user.write.store_city'); ?>", {
                //     'selected_city_id': value
                // }, function(responseData) {
                //     var requestData = responseData.data;
                //     __DataRequest.updateModels('profileData', {
                //         city: requestData.city,
                //         country_name: requestData.country_name
                //     });

                //     if (responseData.reaction == 1) {
                //         _.defer(function() {
                //             checkProfileStatus();
                //         });
                //     }
                // });
            }
        });
    });

    $(".flatpickr").flatpickr({
        wrap: true,
        allowInput: true,
        minDate: '<?= Carbon::today()->subYears(getUserSettings('max_age'))->endOfDay()->toDateString()?>',
        maxDate: '<?= Carbon::today()->subYears(getUserSettings('min_age'))->toDateString()?>',
        onReady: function(selectedDates, dateStr, instance){
            if (instance.isMobile) {
                $(instance.mobileInput).attr('step', null);
            }
        },
    });

</script>

<script src="https://js.stripe.com/v3/"></script>
<script>
    //Stripe.setPublishableKey("pk_test_oMg5DiV3yBBC1eB1bnmUVV2G003oMxvArL");
	// Create an instance of the Stripe object
	// Set your publishable API key
	var useTestStripe = "<?= getStoreSettings('use_test_stripe'); ?>",	stripePublishKey = '';

	//check is testing or live
	if (useTestStripe) {
		stripePublishKey = "<?= getStoreSettings('stripe_testing_publishable_key'); ?>";
	} else {
		stripePublishKey = "<?= getStoreSettings('stripe_live_publishable_key'); ?>";
	}

	//create stripe instance
	//var stripe = Stripe(stripePublishKey);
	var stripe;
	try {		
			stripe = Stripe('pk_test_oMg5DiV3yBBC1eB1bnmUVV2G003oMxvArL');

			// Create an instance of elements
			var elements = stripe.elements();

			var style = {
                base: {
                    backgroundColor: '#2C2C2D',
                    color: '#8c8c8c',
                //	lineHeight : '48px',
                    fontSize: "1.25rem",
                    fontWeight : "400",
                    fontFamily : 'Nunito Sans',
                    fontStyle: "normal",
                //	height: '48px',
                    '::placeholder': {
                        color: '#888',
                    },
                },
                invalid: {
                    color: '#eb1c26',
                }
            };

            var classes = {
                base : 'base'
            }

			var cardElement = elements.create('cardNumber', {
				'style': style,
			    'classes' : classes
			});
			cardElement.mount('#cardNumber');

			var exp = elements.create('cardExpiry', {
				'style': style,
			    'classes' : classes
			});
			exp.mount('#cardExp');

			var cvc = elements.create('cardCvc', {
				'style': style,
			    'classes' : classes
			});
			cvc.mount('#cardCVC');

			// Validate input of the card elements
			var resultContainer = document.getElementById('paymentResponse');
			cardElement.addEventListener('change', function(event) {
				if (event.error) {
					resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
				} else {
					resultContainer.innerHTML = '';
				}
			});
	} catch (error) {
		console.error(error);
	}	

    // Create single-use token to charge the user
	function createToken() {
		stripe.createToken(cardElement).then(function(result) {
			if (result.error) {
				// Inform the user if there was an error
				resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
			} else {
				// Send the token to your server
				stripeTokenHandler(result.token);
			}
		});
	}

	// Callback to handle the response from stripe
	function stripeTokenHandler(token) {
		// Insert the token ID into the form so it gets submitted to the server
		var hiddenInput = document.createElement('input');
		hiddenInput.setAttribute('type', 'hidden');
		hiddenInput.setAttribute('name', 'stripeToken');
		hiddenInput.setAttribute('value', token.id);

		$("#payment-form").append(hiddenInput);
		
		__DataRequest.post("<?= route('user.write.setting-subscription') ?>", 
				$("#payment-form").serialize()
		  , function(responseData) {
				console.log(responseData)
				showSuccessMessage(responseData.data.message);
				if(responseData.data.isUpdated)
				{
                    
                    Swal.fire({
                        title: '',
                    // icon: 'info',
                        html:`
                            <svg width="192" height="192" viewBox="0 0 192 192" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="192" height="192" rx="20" fill="#3AA33E"/>
                            <path d="M96 176C140.183 176 176 140.183 176 96C176 81.1392 171.948 67.2247 164.889 55.3013C164.723 55.0218 164.339 54.975 164.109 55.2047L99.3137 120C93.0653 126.248 82.9347 126.248 76.6863 120L54.3431 97.6569C51.219 94.5327 51.219 89.4673 54.3431 86.3431C57.4673 83.2189 62.5327 83.2189 65.6569 86.3431L88 108.686L154.547 42.1865C154.736 41.997 154.743 41.6915 154.56 41.4952C139.955 25.8101 119.123 16 96 16C51.8172 16 16 51.8172 16 96C16 140.183 51.8172 176 96 176Z" fill="white"/>
                            </svg>
                            <span style="display: block;margin-top:15px;font-weight: bold;font-size: 36px;line-height: 48px;text-align: center;"> Success </span>
                            <span style="display: block;margin-top:15px;font-weight: bold;font-size: 18px;line-height: 24px;text-align: center;"> You have successfully subscribed </span>
                            `,
                        showCloseButton: false,
                        showCancelButton: false,
                        //focusConfirm: false,
                        confirmButtonText: 'Continue',
                        //confirmButtonAriaLabel: 'Retry',
                        //cancelButtonText:'<i class="fa fa-thumbs-down"></i>',
                        //cancelButtonAriaLabel: 'Thumbs down',
                        confirmButtonColor: '#FF3F3F',
                        //cancelButtonColor: '#d33',
                        width: 450,
                        padding: '1em 0.5rem',
                        color: '#ffffff',
                        background: '#191919',
                        backdrop: true,
                        // backdrop: `
                        //     rgba(0,0,123,0.4)
                        //     url("/images/nyan-cat.gif")
                        //     left top
                        //     no-repeat
                        // `    
                        customClass: {
                            popup: 'roundBox',
                            // container: '...',
                            // header: '...',
                            // title: '...',
                            // closeButton: '...',
                            // icon: '...',
                            // image: '...',
                            // content: '...',
                            // htmlContainer: '...',
                            // input: '...',
                            // inputLabel: '...',
                            // validationMessage: '...',
                            // actions: '...',
                            // confirmButton: '...',
                            // denyButton: '...',
                            // cancelButton: '...',
                            // loader: '...',
                            // footer: '....'
                            }
                        })    
                
					@if($user_role==2)
					__Utils.viewReload();
					@endif
					@if($user_role==3)
					//$("#lwBillingProDialog").modal('hide');
                    __Utils.viewReload();
					@endif
					//window.location = response.data.redirectURL;
				} else {
                   
                    Swal.fire({
                        title: '',
                    // icon: 'info',
                        html:`
                            <svg width="192" height="192" viewBox="0 0 192 192" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="192" height="192" rx="15" fill="#FF3F3F"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M96 176C140.183 176 176 140.183 176 96C176 51.8172 140.183 16 96 16C51.8172 16 16 51.8172 16 96C16 140.183 51.8172 176 96 176ZM66.3431 125.657C63.219 122.533 63.219 117.467 66.3431 114.343L84.6865 95.9998L66.3439 77.6571C63.2197 74.5329 63.2197 69.4676 66.3439 66.3434C69.4681 63.2192 74.5334 63.2192 77.6576 66.3434L96.0002 84.6861L114.343 66.3431C117.467 63.2189 122.533 63.219 125.657 66.3431C128.781 69.4673 128.781 74.5327 125.657 77.6569L107.314 95.9998L125.658 114.343C128.782 117.468 128.782 122.533 125.658 125.657C122.533 128.781 117.468 128.781 114.344 125.657L96.0002 107.313L77.6569 125.657C74.5327 128.781 69.4673 128.781 66.3431 125.657Z" fill="white"/>
                            </svg>

                            <span style="display: block;margin-top:15px;font-weight: bold;font-size: 36px;line-height: 48px;text-align: center;"> Error </span>
                            <span style="display: block;margin-top:15px;font-weight: bold;font-size: 18px;line-height: 24px;text-align: center;"> Something went wrong </span>
                            `,
                        showCloseButton: false,
                        showCancelButton: false,
                        //focusConfirm: false,
                        confirmButtonText: 'Retry',
                        //confirmButtonAriaLabel: 'Retry',
                        //cancelButtonText:'<i class="fa fa-thumbs-down"></i>',
                        //cancelButtonAriaLabel: 'Thumbs down',
                        confirmButtonColor: '#FF3F3F',
                        //cancelButtonColor: '#d33',
                        width: 450,
                        padding: '1em 0.5rem',
                        color: '#ffffff',
                        background: '#191919',
                        backdrop: true,
                        // backdrop: `
                        //     rgba(0,0,123,0.4)
                        //     url("/images/nyan-cat.gif")
                        //     left top
                        //     no-repeat
                        // `    
                        customClass: {
                            popup: 'roundBox',
                            // container: '...',
                            // header: '...',
                            // title: '...',
                            // closeButton: '...',
                            // icon: '...',
                            // image: '...',
                            // content: '...',
                            // htmlContainer: '...',
                            // input: '...',
                            // inputLabel: '...',
                            // validationMessage: '...',
                            // actions: '...',
                            // confirmButton: '...',
                            // denyButton: '...',
                            // cancelButton: '...',
                            // loader: '...',
                            // footer: '....'
                            }
                        })

                }
		  });
	}
</script>
<!-- / Javascript -->

</html>