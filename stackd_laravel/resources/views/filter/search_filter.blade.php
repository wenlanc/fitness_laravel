
<!--Search&Filter-->
<div style="position: absolute;top: 0px;right: 0px;max-width: 300px;display: flex;" id="lwPTFilterSearchContainer">
    <div class="position-relative" style="">
        <input type="text" style="padding-left:30px;" class="form-control form-control-user search-text filter_text" id="filter_text" name="filter_text" placeholder="Search">
        <i onclick="requestSearchText()" class="fa fa-search" style="top: 15px;left: 7px;position: absolute;"></i>
    </div>
    <div class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle filter_menu_icon" style="background: #191919;box-shadow: 0px 6px 58px rgba(196, 203, 214, 0.103611);border-radius: 14px;font-size: 1rem;font-weight: 400;line-height: 1.5;" href="#" role="button" data-toggle="dropdown" id="filterDropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-filter fa-fw" style="content: url(/dist/blackfit/images/svg/filter.svg);width: 18px;height: 18px;margin-top: 2px;"></i>
            </a>

            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow search-filter-container lw-basic-filter-container" aria-labelledby="filterDropdown">
                <div class="row">
                    <div class="pull-right" style="width:100%;">
                        <button type="button" style="color:#FFFFFF; " class="close" data-dismiss="modal" aria-label="Close">
                            <span style="padding: 5px 10px;border-radius: 10px;" aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>

                <form  class="search_filter_form p-3" id="search_filter_form">
                    <div class="row" style="">
                        <h5 class="" style="color:#FFFFFF;">Interests</h5>
                    </div>
                    <div class="row mt-1">
                        @if(0)
                            <span class="pt_category_tag_item search_filter_interest_item" style=""> Power Lifting </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Recovery </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Weight Loss </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Yoga </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Power Lifting </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Recovery </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Weight Loss </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Yoga </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Power Lifting </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Recovery </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Weight Loss </span>
                            <span class="pt_category_tag_item search_filter_interest_item"> Recovery </span>
                        <sapn class="search_filter_interests_more"> <a>More</a> </span>
                        @endif
                        <select id="selectFilterExpertise" name="selectFilterExpertise" mutiple class="form-control form-control-user lw-user-expertise-select-box" style="width: 100%;border-color: white;">
                        </select>
                    </div>
                    <input type="hidden" name="filter_expertise_selected_list" id="filter_expertise_selected_list" value="">
                    <div class="row mt-1">
                        <h5 class="" style="color:#FFFFFF;">Locations</h5>
                    </div>

                    @if( isPremiumUserStripe() )
                    <div class="row mt-1">
                        <div class="filter_address_check_container" id="filter_address_check_container"> 
                            
                        </div>

                        <div id="address-map-container" style="margin-top:1.5rem;width:100%;height:200px;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px; ">
                            <div style="width: 100%; height: 100%;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px;" id="address-map"></div>
                        </div>

                        <div class="form-group mt-1" style="width:100%;display:flex;">
                            <input type="text" id="address-input" name="address_address" class="form-control map-input" placeholder="<?= __tr('Enter a location'); ?>">
                            <sapn class="search_filter_interests_more" style="min-width: 120px;"> <a href="javascript:void(0);" id="filter_add_location_btn" class="filter_add_location_btn"><i class="fa fa-plus"> </i> Add a location</a> </span>
                            <!-- show select location on map error -->
                            <div class="alert alert-danger mt-2 alert-dismissible" style="display: none" id="lwShowLocationErrorMessage">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span data-model="locationErrorMessage"></span>
                            </div>
                            <!-- /show select location on map error -->

                            <input type="hidden" name="address_latitude"  id="address-latitude" value="" />
                            <input type="hidden" name="address_longitude"  id="address-longitude" value="" />
                            <input type="hidden" name="address_formatted_address"  id="address-formattedaddress" value="" />
                            <input type="hidden" name="address_placedata"  id="address-placedata" value="" />
                        </div>
                    </div>
                    @else 
                        <div id="address-map-container" style="width:100%;height:200px;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px; ">
                            <div class="d-flex" style="width: 100%; height: 100%;background-image:url('imgs/map_background.png');background-position: center; background-repeat: no-repeat;background-size: cover;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px;" id="address-map">
                                <a href="<?= route('user.read.setting', ['pageType' => 'billing']) ?>" style="margin:auto;" class="pro_btn">        
                                    <span style="padding:0.5rem 1.75rem;background: #FF3F3F;border-radius: 0.75rem; font-size: 1rem;">
                                        <i class="fa fa-star" style="color:#FDC748;"></i> JOIN PRO
                                    </span>
                                </a> 
                            </div>
                        </div>
                    @endif

                    <div class="row mt-1" >
                        <h5 style = "
                                font-family: Nunito Sans;
                                font-style: normal;
                                font-weight: bold;
                                font-size: 20px;
                                line-height: 27px;
                                color: #FFFFFF;
                            "><?= __tr('Availability'); ?></h5>
                    </div>
                    <div class="mb-4">
                            <div class="d-flex align-v-center" style="align-items: center;">
                                <label class="pt_availablity_weekday" style="flex: 1;">月曜日</label>
                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="mon_start" id="mon_start" class="custom-control-input btn-availability" >
                                    <label  for="mon_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></label>
                                </div>
                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="mon_end" id="mon_end" class="custom-control-input btn-availability" >
                                    <label  for="mon_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></label>
                                </div>
                            </div>
                            <div class="d-flex align-v-center">
                                <label class="pt_availablity_weekday">火曜日</label>
                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="tue_start" id="tue_start" class="custom-control-input btn-availability" >
                                    <label for="tue_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
                                </div>

                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="tue_end" id="tue_end" class="custom-control-input btn-availability" >
                                    <label for="tue_end"  class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
                                </div>
                            </div>
                            <div class="d-flex align-v-center">
                                <label class="pt_availablity_weekday">水曜日</label>
                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="wed_start" id="wed_start" class="custom-control-input btn-availability">
                                    <label  for="wed_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
                                </div>

                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="wed_end" id="wed_end" class="custom-control-input btn-availability" >
                                    <label  for="wed_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
                                </div>
                            </div>
                            <div class="d-flex align-v-center">
                                <label class="pt_availablity_weekday">木曜日</label>
                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="thu_start" id="thu_start" class="custom-control-input btn-availability">
                                    <label  for="thu_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
                                </div>

                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="thu_end" id="thu_end" class="custom-control-input btn-availability">
                                    <label  for="thu_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
                                </div>
                            </div>
                            <div class="d-flex align-v-center">
                                <label class="pt_availablity_weekday">金曜日</label>
                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="fri_start" id="fri_start" class="custom-control-input btn-availability">
                                    <label  for="fri_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
                                </div>

                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="fri_end" id="fri_end" class="custom-control-input btn-availability">
                                    <label  for="fri_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
                                </div>
                            </div>
                            <div class="d-flex align-v-center">
                                <label class="pt_availablity_weekday">土曜日</label>
                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="sat_start" id="sat_start" class="custom-control-input btn-availability">
                                    <label  for="sat_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
                                </div>

                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="sat_end" id="sat_end" class="custom-control-input btn-availability">
                                    <label  for="sat_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
                                </div>
                            </div>
                            <div class="d-flex align-v-center">
                                <label class="pt_availablity_weekday">日曜日</label>
                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="sun_start" id="sun_start" class="custom-control-input btn-availability">
                                    <label  for="sun_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
                                </div>

                                <div class="pt_availablity_time">
                                    <input type="checkbox" name="sun_end"  id="sun_end" class="custom-control-input btn-availability">
                                    <label  for="sun_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
                                </div>
                            </div>
                    </div>
                    <div class="row" >
                        <h5 style = "
                                font-family: Nunito Sans;
                                font-style: normal;
                                font-weight: bold;
                                font-size: 20px;
                                line-height: 27px;
                                color: #FFFFFF;
                            "><?= __tr('Gender'); ?></h5>
                    </div>

                    <div class="row">
                        <div class="custom-control custom-checkbox custom-control-inline" style="align-items:center;flex:1;">
                            <input type="checkbox" class="custom-control-input" id="filter_gender_any" name="filter_gender_any" value="true" checked="">
                            <label class="custom-control-label" for="filter_gender_any"> Any </label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline" style="align-items:center;flex:1;">
                            <input type="checkbox" class="custom-control-input" id="filter_gender_male" name="filter_gender_male" value="true" checked="">
                            <label class="custom-control-label" for="filter_gender_male"> Male </label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline" style="align-items:center;flex:1;">
                            <input type="checkbox" class="custom-control-input" id="filter_gender_female" name="filter_gender_female" value="true" checked="">
                            <label class="custom-control-label" for="filter_gender_female"> Female </label>
                        </div>
                    </div>
                    
                    <div class="row mb-3 pull-right" style = "margin-top:15px;">
                        <button type="button" class="btn btn-primary search_filter_btn" id="search_filter_btn" onclick="requestFilter()"><?= __tr('Search'); ?></button>
                    </div>

                    <div class="row mr-3 mb-3 pull-right" style = "margin-top:15px;">
                        <button type="button" style="background:transparent; border: 2px solid #FF3F3F; color : #FF3F3F;font-size: 16px; line-height: 19px; text-align: center; border-radius: 10px;" class="btn reset_search_filter_btn" id="reset_search_filter_btn" onclick="resetFilterForm()"><?= __tr('Reset'); ?></button>
                    </div>

                </form>
            </div>
    </div> 
</div>
@push('appScripts')
<script>
    function resetFilterForm() {

        $("#filter_address_check_container").html('');
        $('form#search_filter_form :input').val('');
        $("#search_filter_form")[0].reset();

        $(':input','#search_filter_form')
            .not(':button, :submit, :reset')
            .val('')
            .prop('checked', false)
            .prop('selected', false);

        var $select = $('#selectFilterExpertise').selectize();
        var control = $select[0].selectize;
        control.clear();
    }
</script>
@endpush