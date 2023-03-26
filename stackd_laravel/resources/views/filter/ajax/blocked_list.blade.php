@if(!__isEmpty($filterData))
@foreach($filterData as $filter)

<div class="row row-cols-sm-1 row-cols-md-3 row-cols-lg-3" style="justify-content: center;">
    <div class="col p-3" style="max-width:30%;">
        <div class="card text-center lw-user-thumbnail-block
        <?= (isset($filter['isPremiumUser']) and $filter['isPremiumUser'] == true) ? 'lw-has-premium-badge' : '' ?>"
        style="border-radius: 15px;padding:0px; min-height:10vw;max-height:13.5rem; max-width:13.5rem;margin-left: auto; margin-right: auto;"
        >
            <a href="<?= route('user.pt_profile_view', ['username' => $filter['username']]) ?>" style="
                /* position: absolute; */
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            ">
                <img data-src="<?= imageOrNoImageAvailable($filter['profileImage']) ?>" class="lw-user-thumbnail lw-lazy-img" style="
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    border-radius: 15px;
                    border: none;
                    min-height:10vw;
                    border: 3px solid white; 
                " />
            </a>
            <!-- show user online, idle or offline status -->
            @if($filter['userOnlineStatus'])
            <div class="pt-2" style="position:absolute; right: 1rem; display:none;">
                @if($filter['userOnlineStatus'] == 1)
                <span class="lw-dot lw-dot-success" title="Online"></span>
                @elseif($filter['userOnlineStatus'] == 2)
                <span class="lw-dot lw-dot-warning" title="Idle"></span>
                @elseif($filter['userOnlineStatus'] == 3)
                <span class="lw-dot lw-dot-danger" title="Offline"></span>
                @endif
            </div>
            @endif
            <!-- /show user online, idle or offline status -->
            <!-- <span class="pt_badge_feature">FEATURED</span> -->
            <span class="match_following_badge_tag">Blocked</span>
        </div>
    </div>
    <?php 
        $userData = $filter;
        $isOwnProfile = false;
    ?>
    <div class="col p-3" style="max-width:36.33%;">
        <div class="">
            <div class="row">
                <span class="pt_username"> <?= Str::limit($filter['kanji_name'],15) ?> </span>
                <span class="pt_username" style="right: 0px;position: absolute;"> <?= $filter["userAge"] ?> </span>
            </div>
            <div class="row">
                <span class="pt_usernickname"> @<?= $filter['username'] ?> </span>

                <?php
                    $rate_val = __isEmpty($filter["totalReviewRate"])?0:$filter["totalReviewRate"];
                ?>
                <div class="" style="right: 0px;position: absolute; border: 2px solid #FF4141;border-radius: 8px;padding: 0.2rem 0.25rem;">
                    <span class="pt_userrate_star review-rating" data-rating="<?= $rate_val/5 ?>" > 
                    </span> 
                    <span style="top: 2px;position:relative;padding-right: 2px;"> <?= $rate_val ?> </span>
                </div>
                
            </div>
            <div class="row mt-2">
                <span class="pt_usernickname" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 17px;line-height: 21px;"> 
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <?= $filter['countryName'] ?>,<?= $filter['city'] ?>
                </span>
            </div>
            <div class="mt-1 pt_description text-3-lines">
                <?= $filter['about_me'] ?>
            </div>

            <!-- User Gym Setting -->
            @if (!__isEmpty($filter["userGymsData"])) 
                <div class="d-flex mb-4 pt_availablity_logo_div" style="justify-content: start;padding-left:15px;margin-left:-1rem;position: absolute;bottom:0px;width: 100%;"> 
                    @foreach($filter["userGymsData"] as $gym)	
                        <div class="" style="margin:3px;">
                            <img class="" style="width: 32px;height: 32px;border-radius:50%;" src="<?= $gym["userGymLogoUrl"]?>">       
                        </div>
                    @endforeach
                </div>
            @endif	

        </div>
    </div>
    <div class="col p-3">

        <div class="row nav-item dropdown no-arrow">
            <span style="min-height:32px;"> <i style="font-size: 24px;" class="d-none far fa-comments"></i> </span>
                
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="right: 0px;top: -5px;position: absolute;">
            <i class="fas fa-ellipsis-v" style="color:white;content: url(/dist/blackfit/images/svg/three_dot.svg);width: 24px;height: 24px;margin-top: 2px;"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu shadow profile_dropdown_menu dropdown-menu-right" aria-labelledby="searchDropdown">
                <div class="row mb-2" style="border-bottom:none;">
                    <button type="button" style="color:#FFFFFF;margin-left:auto;" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="padding: 5px 12px;background: #202020;border-radius: 12px;height: 40px;" aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="" style="margin-top:-20px;">
                    <div class="item_action_menu row ">
                        <a class="btn" title="<?= __tr('Report'); ?>" href="javascript:reportDialogShow('<?= $filter['id']?>','<?= $filter['fullName']?>')"><?= __tr('Report'); ?></a>
                    </div>
                    <div class="item_action_menu row">
                        <a class="btn lwBlockUserBtn" href="javascript:unblockUser('<?= $filter['id']?>','<?= $filter['fullName']?>')" title="<?= __tr('Unblock User'); ?>" ><?= __tr('Unblock'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- user availability -->
        <div class="" style="padding:5px;margin-top:-15px;">
            <div class="row" style="padding-left: 1rem;">
                <h5 style = "
                        font-family: Nunito Sans;
                        font-style: normal;
                        font-weight: bold;
                        font-size: 20px;
                        line-height: 27px;
                        color: #FFFFFF;
                    "><?= __tr('Availability') ?></h5>
            </div>
            <div >
                    <?php $userAvailability = $filter["userAvailability"];?>
                    <div class="d-flex align-v-center row" style="align-items: center;">
                        <label class="pt_availablity_weekday col-lg-4" style="flex: 1;">月曜日</label>
                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="mon_start" id="mon_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['mon_s']==1) checked @endif>
                            <label  for="mon_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['mon_s']==1) checked @endif"><i class="fa fa-sun-o"></i></label>
                        </div>
                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="mon_end" id="mon_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['mon_e']==1) checked @endif>
                            <label  for="mon_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['mon_e']==1) checked @endif"><i class="fa fa-moon-o"></i></label>
                        </div>
                    </div>
                    <div class="d-flex align-v-center row">
                        <label class="pt_availablity_weekday col-lg-4">火曜日</label>
                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="tue_start" id="tue_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['tue_s']==1) checked @endif>
                            <label for="tue_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['tue_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                        </div>

                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="tue_end" id="tue_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['tue_e']==1) checked @endif>
                            <label for="tue_end"  class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['tue_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-v-center row">
                        <label class="pt_availablity_weekday col-lg-4">水曜日</label>
                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="wed_start" id="wed_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['wed_s']==1) checked @endif>
                            <label  for="wed_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['wed_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                        </div>

                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="wed_end" id="wed_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['wed_e']==1) checked @endif>
                            <label  for="wed_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['wed_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-v-center row">
                        <label class="pt_availablity_weekday col-lg-4">木曜日</label>
                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="thu_start" id="thu_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['thu_s']==1) checked @endif>
                            <label  for="thu_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['thu_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                        </div>

                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="thu_end" id="thu_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['thu_e']==1) checked @endif>
                            <label  for="thu_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['thu_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-v-center row">
                        <label class="pt_availablity_weekday col-lg-4">金曜日</label>
                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="fri_start" id="fri_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['fri_s']==1) checked @endif>
                            <label  for="fri_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['fri_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                        </div>

                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="fri_end" id="fri_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['fri_e']==1) checked @endif>
                            <label  for="fri_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['fri_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-v-center row">
                        <label class="pt_availablity_weekday col-lg-4">土曜日</label>
                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="sat_start" id="sat_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['sat_s']==1) checked @endif>
                            <label  for="sat_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['sat_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                        </div>

                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="sat_end" id="sat_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['sat_e']==1) checked @endif>
                            <label  for="sat_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['sat_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-v-center row">
                        <label class="pt_availablity_weekday col-lg-4">日曜日</label>
                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="sun_start" id="sun_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['sun_s']==1) checked @endif>
                            <label  for="sun_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['sun_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
                        </div>

                        <div class="pt_availablity_time col-lg-4">
                            <input type="checkbox" name="sun_end"  id="sun_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['sun_e']==1) checked @endif>
                            <label  for="sun_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['sun_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
                        </div>
                    </div>
                    
                </div>
        </div>
        <!-- user availability -->
    </div>
</div>

@endforeach
@else
<!-- info message -->
<div class="col-sm-12 alert alert-info">
    <?= __tr('There are no Blocked found.') ?>
</div>
<!-- / info message -->
@endif
@if($hasMorePages)
<div class="lw-load-more-container" id="lw-load-more-container">
    <button type="button" class="btn btn-light btn-block lw-ajax-link-action lw-load-more-btn" id="lwLoadMoreButton" data-action="<?= $nextPageUrl ?>" data-callback="loadMoreUsers"><?= __tr('Load More') ?></button>
</div>
@endif