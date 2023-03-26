@if(!__isEmpty($filterData))
    @foreach($filterData as $filter)
    <div class="row row-cols-sm-1 row-cols-md-3 row-cols-lg-3" id="lwPendingFilterContainer" style="justify-content: center;">
        <div class="col mb-2 p-3" style="max-width: 30%;">
            <div class="card text-center lw-user-thumbnail-block
            <?= (isset($filter['isPremiumUser']) and $filter['isPremiumUser'] == true) ? 'lw-has-premium-badge' : '' ?>"
            style=" border-radius: 24px;min-height: 10vw;padding:0px;max-height:13.5rem; max-width:13.5rem;margin-left: auto; margin-right: auto;"
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
                        border-radius: 24px;
                        border: none;
                        min-height: 10vw;
                        border: 3px solid #C4C4C4;
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

                <label 
                style="
                    position: absolute;
                    left: 0;
                    top: 0;
                    padding: 3px 14px;
                    background: #C4C4C4;
                    color: #2B2B2C;
                    border-top-left-radius: 20px;
                    border-bottom-right-radius: 20px;
                    font-size: 0.8rem;
                    font-weight: bold;
                    font-size: 15px;
                    line-height: 20px;
                ">Pending</label>
                
                <!-- /show user online, idle or offline status -->
                <!-- <span class="pt_badge_feature">FEATURED</span> -->

                <!-- like button -->
                <a style="position:absolute;right: 22px;bottom: 15px;" href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $filter['id'], 'like' => 1]) ?>" data-method="post" data-callback="onLikeCallback" title="Like" class="lw-ajax-link-action">
                    <span  id="following-<?= $filter['id'] ?>" class=" filter_item_follow_status btn <?= (isset($filter['likeData']) and $filter['likeData'] == 1) ? 'pt_badge_tag' : 'follow_badge_tag'; ?>" >
                        <?= (isset($filter['likeData']) and $filter['likeData'] == 1) ? __tr('Following') : __tr('Follow'); ?>
                    </span>
                </a>
                <!-- /like button -->
            </div>
        </div>
        <?php 
            $userData = $filter;
            $isOwnProfile = false;
        ?>
        <div class="col mb-2 p-3" style="max-width: 36.33%;">
            <div class="">
                <div class="row">
                    <span class="pt_username"> <?= $filter['kanji_name'] ?> </span>
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
                        <i class="fas fa-map-marker-alt mr-2"></i><?= $filter['countryName'] ?>,<?= $filter['city'] ?>
                    </span>
                </div>
                <div class="mt-1 pt_description text-3-lines ">
                    <?= $filter['about_me'] ?>
                </div>

                <!-- User Gym Setting -->
                @if (!__isEmpty($filter["userGymsData"])) 
                <div class="d-flex row mb-4 pt_availablity_logo_div" style="justify-content: start;padding-left:15px;position: absolute;bottom:0px;width: 100%;"> 
                    @foreach($filter["userGymsData"] as $gym)	
                        <div class="" style="margin:3px;">
                            <img class="" style="width: 32px;height: 32px;border-radius:50%;" src="<?= $gym["userGymLogoUrl"]?>">       
                        </div>
                    @endforeach
                </div>
                @endif	

            </div>
        </div>
        <div class="col mb-2 p-3">

            <div class="row nav-item dropdown no-arrow">
                <!-- <span> 
                    <i class="fas fa-ellipsis-v" style="color:white;content: url(/dist/blackfit/images/svg/chat.svg);width: 24px;height: 24px;margin-top: 2px;"></i>
                </span> -->

                <a class="d-flex" style="margin-left:auto;" href="javascript:startChat(<?= $filter['id']?>)">
					<svg width="24" height="24" viewBox="0 0 34 31" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M32.0128 24.1413C33.8625 20.7717 33.8861 16.7296 32.076 13.3396C30.2658 9.94972 26.8552 7.64897 22.9619 7.19143C21.246 3.27883 17.465 0.5995 13.1165 0.214582C8.76799 -0.170337 4.55349 1.80125 2.14213 5.34851C-0.269224 8.89576 -0.48842 13.4464 1.57136 17.1982L0.653336 20.3298C0.445889 21.0369 0.648183 21.7981 1.1818 22.3182C1.71541 22.8383 2.49645 23.0355 3.22214 22.8335L6.43616 21.9387C7.73675 22.6171 9.15588 23.0529 10.6206 23.2237C11.9298 26.2082 14.4646 28.5201 17.607 29.5959C20.7495 30.6717 24.2111 30.4126 27.1481 28.8818L30.362 29.7767C31.0876 29.9787 31.8686 29.7814 32.4023 29.2614C32.9359 28.7413 33.1383 27.9803 32.9309 27.2731L32.0128 24.1413ZM29.7139 23.4024C29.5467 23.6764 29.5029 24.0054 29.5927 24.3119L30.5006 27.4083L27.3231 26.5236C27.0086 26.4361 26.6711 26.4789 26.39 26.6417C24.1946 27.9096 21.5682 28.2639 19.1018 27.625C16.6355 26.986 14.5364 25.4074 13.277 23.2445C16.5654 22.9129 19.5625 21.2589 21.5457 18.6814C23.5289 16.104 24.3183 12.8369 23.7234 9.66793C26.6659 10.3453 29.1021 12.3466 30.2848 15.0582C31.4675 17.7697 31.2555 20.8679 29.7139 23.4024Z" fill="white"/>
					</svg>
				</a>
                    
                <a class="nav-link dropdown-toggle d-flex pt-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="">
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
                            <a class="btn lwBlockUserBtn" title="<?= __tr('Block User'); ?>" href="#" onclick="blockUserConfirm('<?= $filter['id']?>')"><?= __tr('Block'); ?></a>
                        </div>
                        <div class="item_action_menu row lwRemoveFollowUserContainer" style="color:#FFFFFF;">
                            <a class=" lw-ajax-link-action btn <?= (isset($filter['likeData']) and $filter['likeData'] == 1) ? '' : 'disabled'; ?> lwRemoveFollowUserBtn" data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['id'], 'like' => 1]); ?>" data-method="post" data-callback="onLikeCallback" title="<?= __tr('Remove Follower'); ?>" ><?= __tr('Remove Follower'); ?></a>
                        </div>
                        <div class="item_action_menu row " style="color:#FFFFFF;">
                            <a class="btn lwCopyProfileUrlBtn" title="<?= __tr('Copy Profile URL'); ?>" href="#" onclick=" navigator.clipboard.writeText('<?= route('user.pt_profile_view', ['username' => $filter['username']]) ?>')"><?= __tr('Copy Profile URL'); ?></a>
                        </div>
                        <div class="item_action_menu row" style="color:#FFFFFF;">
                            <a href data-action="<?= route('user.write.hide_like_dislike', ['toUserUid' => $filter['id']]) ?>" data-method="post" data-callback="onHidePendingCallback" title="Like" class="lw-ajax-link-action btn">
                                <span  id="hiding-<?= $filter['id'] ?>" class="filter_item_follow_status1 btn1" >
                                    <?=  __tr('Hide'); ?>
                                </span>
                            </a>
                        </div>
                        <div class="d-none item_action_menu row" style="color:#FFFFFF;">
                            <a class="btn lwShareProfileBtn" title="<?= __tr('Share This Profile'); ?>" ><?= __tr('Share This Profile'); ?></a>
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
        <?= __tr('There are no Pending found.') ?>
    </div>
    <!-- / info message -->
@endif
@if($hasMorePages)
<div class="lw-load-more-container" id="lw-load-more-container-pending">
    <button type="button" class="btn btn-light btn-block lw-ajax-link-action lw-load-more-btn" id="lwLoadMoreButtonPending" data-action="<?= $nextPageUrl ?>" data-callback="loadPending"><?= __tr('Load More') ?></button>
</div>
@endif