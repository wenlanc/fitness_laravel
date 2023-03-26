@section('page-title', strip_tags($userData['userName']))
@section('head-title', strip_tags($userData['userName']))
@section('page-url', url()->current())

@if(isset($userData['aboutMe']))
@section('keywordName', strip_tags($userProfileData['aboutMe']))
@section('keyword', strip_tags($userProfileData['aboutMe']))
@section('description', strip_tags($userProfileData['aboutMe']))
@section('keywordDescription', strip_tags($userProfileData['aboutMe']))
@endif

@if(isset($userData['profilePicture']))
@section('page-image', $userData['profilePicture'])
@endif
@if(isset($userData['coverPicture']))
@section('twitter-card-image', $userData['coverPicture'])
@endif

@push('header')
<link rel="stylesheet" href="<?= __yesset('dist/css/vendorlibs-leaflet.css'); ?>" />
<link href="{{ asset('dist/smartwizard/smartwizard.css') }}" rel="stylesheet">
<link href="{{ asset('dist/flatpicker/flatpickr.css') }}" rel="stylesheet">
<link href="{{ asset('dist/cropper/cropper.css') }}" rel="stylesheet">
@endpush
@push('footer')
<script src="<?= __yesset('dist/js/vendorlibs-leaflet.js'); ?>"></script>
@endpush

<?php 
use Carbon\Carbon;
$latitude = (__ifIsset($userProfileData['latitude'], $userProfileData['latitude'], '21.120779'));
$longitude = (__ifIsset($userProfileData['longitude'], $userProfileData['longitude'], '79.0544606'));
?>

<!-- if user block then don't show profile page content -->
@if($isBlockUser)
<!-- info message -->
<div class="alert alert-info">
	<?= __tr('This user is unavailable.'); ?>
</div>
<!-- / info message -->
@elseif($blockByMeUser)
<!-- info message -->
<div class="alert alert-info">
	<?= __tr('You have blocked this user.'); ?>
</div>
<!-- / info message -->
@else
<div style = "background: #1E1E1E;
								position: absolute;
								left: 0px;
								top: 0px;
								bottom:0px;
								right:0px;
								padding-right:0.75rem;
								padding-left: 2rem;">
	<div class="row" style="height:100%;">
		<div class="col-sm-1 col-md-3 p-3" style="background-color:#191919;border-radius:1.5rem;height:100%;">
			<div style="max-width: 18vw; margin:auto;">
				@if(!$isOwnProfile)
					<div class="row nav-item dropdown no-arrow" style="align-items: center;display: flex;">
						<a style="margin-left: 1rem;" href="javascript:history.back()" role="button">
							<i class="fas fa-arrow-left" style="color:white;font-size:22px;"></i>
						</a>
						<div style="margin-left:auto;">

							<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
								<svg width="6" height="26" viewBox="0 0 6 26" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M5.83366 3.08333C5.83366 4.64814 4.56513 5.91667 3.00033 5.91667C1.43552 5.91667 0.166992 4.64814 0.166992 3.08333C0.166992 1.51853 1.43552 0.25 3.00033 0.25C4.56513 0.25 5.83366 1.51853 5.83366 3.08333ZM5.83366 13C5.83366 14.5648 4.56513 15.8333 3.00033 15.8333C1.43552 15.8333 0.166992 14.5648 0.166992 13C0.166992 11.4352 1.43552 10.1667 3.00033 10.1667C4.56513 10.1667 5.83366 11.4352 5.83366 13ZM3.00033 25.75C4.56513 25.75 5.83366 24.4815 5.83366 22.9167C5.83366 21.3519 4.56513 20.0833 3.00033 20.0833C1.43552 20.0833 0.166992 21.3519 0.166992 22.9167C0.166992 24.4815 1.43552 25.75 3.00033 25.75Z" fill="white"/>
								</svg>
							</a>
							<!-- Dropdown - Messages -->
							<div class="dropdown-menu shadow profile_dropdown_menu" aria-labelledby="searchDropdown">
								<div class="row mb-2" style="border-bottom:none;">
									<button type="button" style="color:#FFFFFF;margin-left:auto;" class="close" data-dismiss="modal" aria-label="Close">
										<span style="padding: 5px 12px;background: #202020;border-radius: 12px;height: 40px;" aria-hidden="true">×</span>
									</button>
								</div>
								<div class="" style="margin-top:-20px;">
									<div class="item_action_menu row ">
										<a class="btn" title="<?= __tr('Report'); ?>" href="#" onclick="reportDialogShow('<?= $userData['userUId']?>', '<?= $userData['userName'] ?>')"><?= __tr('Report'); ?></a>
									</div>
									<div class="item_action_menu row">
										<a class="btn lwBlockUserBtn" title="<?= __tr('Block User'); ?>" href="#" onclick="blockUserConfirm('<?= $userData['userUId']?>')"><?= __tr('Block'); ?></a>
									</div>
									<div class="item_action_menu row lwRemoveFollowUserContainer" style="color:#FFFFFF;">
										<a class=" lw-ajax-link-action btn <?= (isset($userLikeData['like']) and $userLikeData['like'] == 1) ? '' : 'disabled'; ?> lwRemoveFollowUserBtn" data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['userUId'], 'like' => 1]); ?>" data-method="post" data-callback="onLikeCallback" title="<?= __tr('Remove Follower'); ?>" ><?= __tr('Remove Follower'); ?></a>
									</div>
									<div class="item_action_menu row " style="color:#FFFFFF;">
										<a class="btn lwCopyProfileUrlBtn" title="<?= __tr('Copy Profile URL'); ?>" ><?= __tr('Copy Profile URL'); ?></a>
									</div>
									<div class="d-none item_action_menu row" style="color:#FFFFFF;">
										<a class="btn lwShareProfileBtn" title="<?= __tr('Share This Profile'); ?>" ><?= __tr('Share This Profile'); ?></a>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				@endif	
				<!-- User Profile and Cover photo -->
				<div class="card mb-3 lw-profile-image-card-container" >
					<div class="">
						@if($isOwnProfile)
						<span class="lw-profile-edit-button-container" style="right: -13px;">

							<a class="lw-icon-btn profile_edit_icon" href role="button" id="lwEditProfileAndCoverPhoto" style="">
								<i class="fa fa-pencil-alt"></i>
							</a>
							<a class="lw-icon-btn" href role="button" id="lwCloseProfileAndCoverBlock" style="display: none;">
								<i class="fa fa-times"></i>
							</a>
							
							@if(0)
							<a class="lw-icon-btn profile_edit_icon" role="button" data-toggle="modal" data-target="#lwPostProfilePhotoDialog">
								<i class="fa fa-pencil-alt"></i>
							</a>
							@endif
						</span>
						@endif
						<div class="row" id="lwProfileAndCoverStaticBlock">
							<div class="col-lg-12">
								<div class="card  lw-profile-image-card-container">
									<img class="lw-lazy-img profile-img <?= ( $userData['userRoleId'] == 3 )? "white-border-profile-img": "" ?>" id="lwProfilePictureStaticImage" data-src="<?= imageOrNoImageAvailable($userData['profilePicture']); ?>">
									@if( $userData['userRoleId'] == 3 )
										<label class="user-role-badge">PT</label>
									@endif
								</div>
								<div style="
									position: absolute;
									left: 0;
									top: 6px;
									padding-left: 1rem;
									display:none;
								">
									@if(!$isOwnProfile)
									@if($userOnlineStatus == 1)
									<span class="lw-dot lw-dot-success float-none" title="<?= __tr('Online'); ?>"></span>
									@elseif($userOnlineStatus == 2)
									<span class="lw-dot lw-dot-warning float-none" title="<?= __tr('Idle'); ?>"></span>
									@elseif($userOnlineStatus == 3)
									<span class="lw-dot lw-dot-danger float-none" title="<?= __tr('Offline'); ?>"></span>
									@endif
									@endif
								</div>
								@if(!$isOwnProfile)
								<a style="position:absolute;right: 22px;bottom: 15px;" href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['userUId'], 'like' => 1]); ?>" data-method="post" data-callback="onLikeCallback" title="Like" class="lw-ajax-link-action" id="lwLikeBtn">
									<span class="btn <?= (isset($userLikeData['like']) and $userLikeData['like'] == 1) ? 'pt_badge_tag' : ''; ?>" style="padding: 0px 10px; font-size:0.8rem; background: #ff4141; color: white;" data-model="userLikeStatus"><?= (isset($userLikeData['like']) and $userLikeData['like'] == 1) ? __tr('Following') : __tr('Follow'); ?>
									</span>
								</a>
								@endif
							</div>
						</div>
						@if($isOwnProfile)
						<div class="row" id="lwProfileAndCoverEditBlock" style="display: none;">
							<div class="col">
								<input type="file" name="filepond" class="filepond" id="lwProfileImageUploader" >
							</div>
						</div>
						@endif
					</div>
				</div>
				<!-- /User Profile and Cover photo -->
				<div class="card mb-3">
					<div class="d-flex">
						<div style="width:100%;position:relative;padding-right:10px;display:flex;">
							<span class="lw-inline-edit-text mr-2 profile_username" style="margin-top: 0px" data-model="userData.kanji_name"><?= __ifIsset($userData['kanji_name'], Str::limit($userData['kanji_name'],24), '-'); ?></span>
							<div style="margin-left:auto;display: flex;">
								<span style="margin-left:auto;" class="profile_username" data-model="userData.userAge"><?= __tr($userData['userAge'] ?? ''); ?></span>
								@if(!$isOwnProfile)
								<a class="" href="javascript:startChat()" role="button" style="margin-left:10px;">
									<i class="fas fa-ellipsis-v" style="color:white;content: url(/dist/blackfit/images/svg/chat.svg);width: 32px;height: 32px;"></i>
								</a>
								@endif
							</div>
							
							@if(getFeatureSettings('premium_badge'))
							<i class="fas fa-star"></i>
							@endif
							<!-- /if user is premium then show badge -->
							@if(__ifIsset($userProfileData['isVerified']) and $userProfileData['isVerified'] == 1)
							<i class="d-none fas fa-user-check text-info"></i>
							@endif				
						</div>
						@if($isOwnProfile)
						<span class="" style="margin-left:auto; margin-right:-15px;">
							<a class="lw-icon-btn profile_edit_icon" href role="button" data-activetab="profile_modal_detail" data-toggle="modal" data-target="#lwBasicProfileDialog">
								<i class="fa fa-pencil-alt "></i>
							</a>
						</span>
						@endif
					</div>
					<div>
						@if($isOwnProfile)
						<div class="d-flex justify-content-between mb-1" style="font-size: 15px;">
							<a class="" style="color:white;" href="javascript:showModalFollow('follower')"> <span><?= $totalUserLike; ?> Follower </span></a>
							<a class="" style="color:white;" href="javascript:showModalFollow('following')"> <span> <?= $totalUserMakeLike; ?> Following </span> </a>
						</div>
						@endif
						<div class="d-flex justify-content-between mb-1" style="font-weight: bold;font-size: 20px;line-height: 27px;">
							<span>@<span data-model="userData.userName"><?= __ifIsset($userData['userName'], Str::limit($userData['userName'],12), '-'); ?></span></span>		
							@if($totalReviewRate > 0)
							<span class="pt_userrate_star review-rating" data-rating="<?= $totalReviewRate ?>" style="right: 0px;position: absolute;"> </span>
							@else
							<div class="" style="right: 0px;position: absolute; border: 2px solid #FF4141;border-radius: 8px;padding: 0.2rem 0.25rem;">
								<span class="pt_userrate_star review-rating-1" data-rating="<?= $totalReviewRate/5 ?>" > 
								</span> 
								<span style="top: 2px;position:relative;padding-right: 2px;"> <?= $totalReviewRate * 1 ?> </span>
							</div>
							@endif
						</div>
						@if((__ifIsset($userProfileData['city']) and __ifIsset($userProfileData['country_name'])))
							
						@endif

						<div class="d-flex mb-2" style="font-weight: bold;font-size: 17px;line-height: 21px;">
							<i class="fas fa-map-marker-alt"></i> &nbsp; 
							<span class="mr-3"><span data-model="profileData.city"><?= $userProfileData['city']; ?></span>, <span data-model="profileData.country_name"><?= $userProfileData['country_name']; ?></span></span>
						</div>

						<div class="d-flex mb-2" style="font-weight: bold;font-size: 15px;line-height: 23px;color: #929292;word-break: break-word;">
							<span data-model="profileData.aboutMe"><?= $userProfileData['aboutMe']; ?></span>
						</div>
						@if($isOwnProfile && 1 == 2)
						<div class="float-right">
							<!-- total user likes count -->
							<i class="fas fa-heart text-danger"></i> <span id="lwTotalUserLikes" class="mr-3">
								<?= __trn('__totalUserLike__ like', '__totalUserLike__ likes', $totalUserLike, [
									'__totalUserLike__' => $totalUserLike,
								]); ?></span>
							<!-- /total user likes count -->

							<!-- total user visitors count -->
							<i class="fas fa-eye text-warning"></i> <?= __trn('__totalVisitors__ view', '__totalVisitors__ views', $totalVisitors, [
																		'__totalVisitors__' => $totalVisitors,
																	]); ?>
							<!-- /total user visitors count -->
						</div>
						@endif
					</div>

					@if( $userData['userRoleId'] == 3 )
						@if( !__isEmpty($userProfileData['qualified_date']))
						<div class="d-flex mb-2 mt-2" style="font-weight: bold;font-size: 17px;line-height: 21px;">
							Qualified Since: <span style="margin-left: auto;" data-model="profileData.qualified_date"><?= $userProfileData["qualified_date"]?></span>
						</div>
						@endif
						@if( !__isEmpty($userProfileData['website']))
						<div class="d-flex mb-2" style="font-weight: bold;font-size: 17px;line-height: 21px; ">
							<i class="fas fa-link"></i> &nbsp;
							<span data-model="profileData.website"><?= $userProfileData['website']; ?></span>
						</div>
						@endif											
					@endif

					<!-- User Gym Setting -->
					<div class="d-flex mb-2 pt_availablity_logo_div" style="justify-content: start;padding-left:15px;"> 
					@if (!__isEmpty($userGymsData)) 
						@foreach($userGymsData as $gym)	
							<div class="" style="margin:3px;">
								<img class="" style="width: 32px;height: 32px;border-radius:50%;" src="<?= $gym["userGymLogoUrl"]?>">       
							</div>
						@endforeach
					@endif
					</div>
					<!-- /User Gym Setting -->

					<!-- user availability -->
					<div class="d-flex" >
						<h5 style="
								font-family: Nunito Sans;
								font-style: normal;
								font-weight: bold;
								font-size: 20px;
								line-height: 27px;
								color: #FFFFFF;
							">Availability</h5>
						@if($isOwnProfile)
						<span class="float-right" style="margin-left: auto;margin-right: -15px;">
							<a class="lw-icon-btn profile_edit_icon" href role="button" id="lwEditAvailability">
								<i class="fa fa-pencil-alt"></i>
							</a>
							<a class="lw-icon-btn" href role="button" id="lwCloseAvailability" style="display: none;">
								<i class="fa fa-times"></i>
							</a>
						</span>
						@endif
					</div>
					@if(0)
					<div class="mb-4" id="lwStaticAvailability">
						<div class="d-flex align-v-center" style="align-items: center;">
							<label class="pt_availablity_weekday" style="flex: 1;">月曜日</label>
							<label class="pt_availablity_time" style="flex: 1;">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['mon_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
							</label>
							<label class="pt_availablity_time" style="flex: 1;">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['mon_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
							</label>
						</div>
						<div class="d-flex align-v-center">
							<label class="pt_availablity_weekday">火曜日</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['tue_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
							</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['tue_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
							</label>
						</div>
						<div class="d-flex align-v-center">
							<label class="pt_availablity_weekday">水曜日</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['wed_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
							</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['wed_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
							</label>
						</div>
						<div class="d-flex align-v-center">
							<label class="pt_availablity_weekday">木曜日</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['thu_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
							</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['thu_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
							</label>
						</div>
						<div class="d-flex align-v-center">
							<label class="pt_availablity_weekday">金曜日</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['fri_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
							</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['fri_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
							</label>
						</div>
						<div class="d-flex align-v-center">
							<label class="pt_availablity_weekday">土曜日</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['sat_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
							</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['sat_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
							</label>
						</div>
						<div class="d-flex align-v-center">
							<label class="pt_availablity_weekday">日曜日</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['sun_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
							</label>
							<label class="pt_availablity_time">
								<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['sun_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
							</label>
						</div>
						
					</div>
					@else
					<div class="mb-4" id="lwAvailabilityForm">
						<form class="lw-ajax-form lw-form" lwSubmitOnChange method="post" data-show-message="true" action="<?= route('user.write.availability'); ?>" data-callback="getUserProfileData">
							<div class="d-flex align-v-center" style="align-items: center;">
								<label class="pt_availablity_weekday" style="flex: 1;">月曜日</label>
								<div class="pt_availablity_time">
									<input type="checkbox" name="mon_start" id="mon_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['mon_s']==1) checked @endif>
									<label  for="mon_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['mon_s']==1) checked @endif"><i class="fa fa-sun-o"></i></label>
								</div>
								<div class="pt_availablity_time">
									<input type="checkbox" name="mon_end" id="mon_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['mon_e']==1) checked @endif>
									<label  for="mon_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['mon_e']==1) checked @endif"><i class="fa fa-moon-o"></i></label>
								</div>
							</div>
							<div class="d-flex align-v-center">
								<label class="pt_availablity_weekday">火曜日</label>
								<div class="pt_availablity_time">
									<input type="checkbox" name="tue_start" id="tue_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['tue_s']==1) checked @endif>
									<label for="tue_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['tue_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
								</div>

								<div class="pt_availablity_time">
									<input type="checkbox" name="tue_end" id="tue_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['tue_e']==1) checked @endif>
									<label for="tue_end"  class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['tue_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
								</div>
							</div>
							<div class="d-flex align-v-center">
								<label class="pt_availablity_weekday">水曜日</label>
								<div class="pt_availablity_time">
									<input type="checkbox" name="wed_start" id="wed_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['wed_s']==1) checked @endif>
									<label  for="wed_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['wed_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
								</div>

								<div class="pt_availablity_time">
									<input type="checkbox" name="wed_end" id="wed_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['wed_e']==1) checked @endif>
									<label  for="wed_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['wed_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
								</div>
							</div>
							<div class="d-flex align-v-center">
								<label class="pt_availablity_weekday">木曜日</label>
								<div class="pt_availablity_time">
									<input type="checkbox" name="thu_start" id="thu_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['thu_s']==1) checked @endif>
									<label  for="thu_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['thu_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
								</div>

								<div class="pt_availablity_time">
									<input type="checkbox" name="thu_end" id="thu_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['thu_e']==1) checked @endif>
									<label  for="thu_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['thu_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
								</div>
							</div>
							<div class="d-flex align-v-center">
								<label class="pt_availablity_weekday">金曜日</label>
								<div class="pt_availablity_time">
									<input type="checkbox" name="fri_start" id="fri_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['fri_s']==1) checked @endif>
									<label  for="fri_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['fri_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
								</div>

								<div class="pt_availablity_time">
									<input type="checkbox" name="fri_end" id="fri_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['fri_e']==1) checked @endif>
									<label  for="fri_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['fri_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
								</div>
							</div>
							<div class="d-flex align-v-center">
								<label class="pt_availablity_weekday">土曜日</label>
								<div class="pt_availablity_time">
									<input type="checkbox" name="sat_start" id="sat_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['sat_s']==1) checked @endif>
									<label  for="sat_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['sat_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
								</div>

								<div class="pt_availablity_time">
									<input type="checkbox" name="sat_end" id="sat_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['sat_e']==1) checked @endif>
									<label  for="sat_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['sat_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
								</div>
							</div>
							<div class="d-flex align-v-center">
								<label class="pt_availablity_weekday">日曜日</label>
								<div class="pt_availablity_time">
									<input type="checkbox" name="sun_start" id="sun_start" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['sun_s']==1) checked @endif>
									<label  for="sun_start" class="custom-check pl-4 pr-4 pt_availablity_weekday_daytime @if($userAvailability && $userAvailability['sun_s']==1) checked @endif"><i class="fa fa-sun-o"></i></span>
								</div>

								<div class="pt_availablity_time">
									<input type="checkbox" name="sun_end"  id="sun_end" class="custom-control-input btn-availability" disabled @if($userAvailability && $userAvailability['sun_e']==1) checked @endif>
									<label  for="sun_end" class="custom-check pl-4 pr-4 pt_availablity_weekday_nighttime @if($userAvailability && $userAvailability['sun_e']==1) checked @endif"><i class="fa fa-moon-o"></i></span>
								</div>
							</div>
							
						</form>
					</div>
					@endif
					<!-- / user availability -->
					<!-- Interests -->
					@if ( $userData['userRoleId'] != 3 ) 
					
					@endif
					<!-- End of Interests -->
					<!-- reviews -->
					<div class="d-flex" >
						<h5 style="
								font-family: Nunito Sans;
								font-style: normal;
								font-weight: bold;
								font-size: 20px;
								line-height: 27px;
								color: #FFFFFF;
							">Reviews (<?= count($reviewUserData) ?>)</h5>
						@if(!$isOwnProfile)	
						<div class="" style="margin-left: auto;"> 
							<button class="postReviewBtn" id="postReviewBtn" role="button" data-toggle="modal" data-target="#lwPostReviewDialog"> 
								@if($isReviewedUser)
								Edit review
								@else
								Post a review
								@endif
							</button>
						</div>	
						@endif
					</div>
					@if(count($reviewUserData))
					<div class="profile_reviews_container" style="max-height: 300px;overflow-y: scroll;padding-right: 5px;">
						@foreach($reviewUserData as $review)											
							<div class="profile_review_item mb-2">
								<div class="profile_review_header" style="display:flex;">
									<?php
										$profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $review["userUId"]]);
										$profilePictureUrl = noThumbImageURL();
										if (!__isEmpty($review['profile_picture'])) {
											$profilePictureUrl = getMediaUrl($profilePictureFolderPath, $review['profile_picture']);
										}
									?>
									<div class="review_image">
										<img class="lw-profile-thumbnail lw-lazy-img" style="width: 50px;height: 50px;border-radius: 10px;" data-src="<?= imageOrNoImageAvailable($profilePictureUrl); ?>">								
									</div>
									<div class="profile_review_name"  style="padding-left: 5px;">
										<div class="profile_review_username">
											<?= $review["kanji_name"] ?>					
										</div>
										<div class="profile_review_star_rate">
											<div class="review-rating jq-stars" data-rating="<?= $review["rate_value"]?>">
											</div>
										</div>								
									</div>
									<div class="profile_review_type_badge">
										<?= $review["userRoleName"]?>								
									</div>
								</div>
								<div class="profile_review_content text-4-lines">
									<?= $review["review_comment"] ?>	
								</div>
							</div>
						@endforeach	
					</div>
					@endif
					<!-- end of reviews-->
				</div>

				<!-- mobile view premium block -->
				@if($isPremiumUser)
				<div class="mb-4 d-block d-md-none">
					<div class="card">
						<div class="card-body">
							<span class="lw-premium-badge" title="<?= __tr('Premium User'); ?>"></span>
						</div>
					</div>
				</div>
				@endif
				<!-- /mobile view premium block -->

				<!-- mobile view like dislike block -->
				@if(!$isOwnProfile && 1 == 2)
				<div class="mb-4 d-block d-md-none">
					<!-- profile related -->
					<div class="card">
						<div class="card-header">
							<?= __tr('Like Dislike'); ?>
						</div>
						<div class="card-body">
							<!-- Like and dislike buttons -->
							@if(!$isOwnProfile)
							<div class="lw-like-dislike-box">
								<!-- like button -->
								<a href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['userUId'], 'like' => 1]); ?>" data-method="post" data-callback="onLikeCallback" title="Like" class="lw-ajax-link-action lw-like-action-btn" id="lwLikeBtn">
									<span class="lw-animated-heart lw-animated-like-heart <?= (isset($userLikeData['like']) and $userLikeData['like'] == 1) ? 'lw-is-active' : ''; ?>"></span>
								</a>
								<span data-model="userLikeStatus"><?= (isset($userLikeData['like']) and $userLikeData['like'] == 1) ? __tr('Liked') : __tr('Like'); ?>
								</span>
								<!-- /like button -->
							</div>
							<div class="lw-like-dislike-box">
								<!-- dislike button -->
								<a href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['userUId'], 'like' => 0]); ?>" data-method="post" data-callback="onLikeCallback" title="Dislike" class="lw-ajax-link-action lw-dislike-action-btn" id="lwDislikeBtn">
									<span class="lw-animated-heart lw-animated-broken-heart <?= (isset($userLikeData['like']) and $userLikeData['like'] == 0) ? 'lw-is-active' : ''; ?>"></span>
								</a>
								<span data-model="userDislikeStatus"><?= (isset($userLikeData['like']) and $userLikeData['like'] == 0) ? __tr('Disliked') : __tr('Dislike'); ?>
								</span>
								<!-- /dislike button -->
							</div>
							@endif
						</div>
						<!-- / Like and dislike buttons -->
					</div>
					<div class="card mt-3">
						<div class="card-header">
							<?= __tr('Send Message or Gift'); ?>
						</div>
						<div class="card-body text-center">
							<!-- message button -->
							<a class="lwMessageChatButton mr-3 btn-link btn <?= (isset($userLikeData['mutual']) and $userLikeData['mutual'] == 1) ? '' : 'lw-disable-anchor-tag'; ?>" onclick="getChatMessenger('<?= route('user.read.individual_conversation', ['specificUserId' => $userData['userId']]); ?>')" href id="lwMessageChatButton" data-chat-loaded="false" data-toggle="modal" data-target="#messengerDialog"><i class="far fa-comments fa-3x"></i>
								<br> <?= __tr('Message'); ?></a>

							<!-- send gift button -->
							<a href title="<?= __tr('Send Gift'); ?>" data-toggle="modal" data-target="#lwSendGiftDialog" class="lwGiftButton btn-link btn <?= (isset($userLikeData['mutual']) and $userLikeData['mutual'] == 1) ? '' : 'lw-disable-anchor-tag'; ?>"" id=" lwGiftButton"><i class="fa fa-gift fa-3x" aria-hidden="true"></i>
								<br> <?= __tr('Gift'); ?>
							</a>
							<!-- /send gift button -->
						</div>
					</div>
				</div>
				@endif
				<!-- /mobile view like dislike block -->

				<!-- Content for like -->
				<li class="mt-4 d-none d-md-block" style="display:none;">
					@if(1==2)
					<!-- profile related -->
					<div class="card">
						<div class="card-header">
							@if($isOwnProfile)
							<?= $userData['kanji_name']; ?>
							@endif
							@if(!$isOwnProfile)
							<?= __tr('Like Dislike'); ?>
							@endif
						</div>
						<div class="card-body">
							@if($isPremiumUser)
							<span class="lw-premium-badge" title="<?= __tr('Premium User'); ?>"></span>
							@endif
							<!-- Like and dislike buttons -->
							@if(!$isOwnProfile)
							<div class="lw-like-dislike-box">
								<!-- like button -->
								<a href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['userUId'], 'like' => 1]); ?>" data-method="post" data-callback="onLikeCallback" title="Like" class="lw-ajax-link-action" id="lwLikeBtn">
									<span style="padding: 0px 10px; font-size:0.8rem; background: #ff4141; color: white;" class="btn" data-model="userLikeStatus"><?= (isset($userLikeData['like']) and $userLikeData['like'] == 1) ? __tr('Following') : __tr('Follow'); ?>
									</span>
								</a>
								<!-- /like button -->
							</div>
							<div class="lw-like-dislike-box">
								<!-- dislike button -->
								<a href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['userUId'], 'like' => 0]); ?>" data-method="post" data-callback="onLikeCallback" title="Dislike" class="lw-ajax-link-action" id="lwDislikeBtn">
									<span class="lw-animated-heart lw-animated-broken-heart <?= (isset($userLikeData['like']) and $userLikeData['like'] == 0) ? 'lw-is-active' : ''; ?>"></span>
								</a>
								<span data-model="userDislikeStatus"><?= (isset($userLikeData['like']) and $userLikeData['like'] == 0) ? __tr('Disliked') : __tr('Dislike'); ?>
								</span>
								<!-- /dislike button -->
							</div>
							@endif
						</div>
						<!-- / Like and dislike buttons -->
					</div>
					@endif
					@if(!$isOwnProfile)
					<div class="card mt-3" style="display:none;">
						<!-- <div class="card-header">
							<?= __tr('Send Message or Gift'); ?>
						</div> -->
						<div class="card-body text-center p-0">
							<!-- message button -->
							<a class="lwMessageChatButton mr-lg-3 btn-link btn <?= (isset($userLikeData['mutual']) and $userLikeData['mutual'] == 1) ? 'sss' : 'lw-disable-anchor-tag'; ?>" onclick="getChatMessenger('<?= route('user.read.individual_conversation', ['specificUserId' => $userData['userId']]); ?>')" id="lwMessageChatButton" href data-chat-loaded="false" data-toggle="modal" data-target="#messengerDialog"><i class="far fa-comments fa-3x"></i>
								<br> <?= __tr('Message'); ?></a>
							<!-- send gift button -->
							<a href title="<?= __tr('Send Gift'); ?>" data-toggle="modal" data-target="#lwSendGiftDialog" class="lwGiftButton btn-link btn <?= (isset($userLikeData['mutual']) and $userLikeData['mutual'] == 1) ? '' : 'lw-disable-anchor-tag'; ?>" id="lwGiftButton"><i class="fa fa-gift fa-3x" aria-hidden="true"></i>
								<br> <?= __tr('Gift'); ?>
							</a>
							<!-- /send gift button -->
						</div>
					</div>
					@endif
				</li>

				@if(isset($userProfileData['aboutMe']) and $userProfileData['aboutMe'])
				<div class="card mb-3" style="display:none;">
					<!-- <div class="card-header">
						<h5><i class="fas fa-user text-primary"></i> <?= __tr('About Me'); ?></h5>
					</div> -->
					<div class="card-body p-0">
						<!-- About Me -->
						<div class="form-group">
							<div class="lw-inline-edit-text" data-model="profileData.aboutMe">
								<?= __ifIsset($userProfileData['aboutMe'], $userProfileData['aboutMe'], '-'); ?>
							</div>
						</div>
						<!-- /About Me -->
					</div>
				</div>
				@endif
				<!-- user availability -->
				<div class="card" style="display:none;">
					<div class="card-header">
						@if($isOwnProfile)
						<!-- <span class="float-right">
							<a class="lw-icon-btn" href role="button" id="lwEditAvailability">
								<i class="fa fa-pencil-alt"></i>
							</a>
							<a class="lw-icon-btn" href role="button" id="lwCloseAvailability" style="display: none;">
								<i class="fa fa-times"></i>
							</a>
						</span> -->
						@endif
						<h5><i class="fas fa-info-circle text-info"></i> <?= __tr('Availability'); ?></h5>
					</div>
					<div class="card-body">
						@if(!$isOwnProfile)
						<div id="lwStaticAvailability">
							<div class="form-group preferences mon-pref">
								<label class="form-label">Monday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="mon_start" class="custom-control-input btn-availability" data-model="userAvailability.mon_s" @if($userAvailability && $userAvailability['mon_s']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="mon_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['mon_e']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>

									</div>
								</div>
							</div>

							<div class="form-group preferences tue-pref">
								<label class="form-label">Tuesday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="tue_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['tue_s']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="tue_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['tue_e']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>

									</div>

								</div>
							</div>

							<div class="form-group preferences wed-pref">
								<label class="form-label">Wednesday</label>
								<div class="d-flex monday justify-content-center">

									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="wed_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['wed_s']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="wed_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['wed_e']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>

									</div>

								</div>
							</div>

							<div class="form-group preferences thu-pref">
								<label class="form-label">Thursday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="thu_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['thu_s']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="thu_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['thu_e']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group preferences fri-pref">
								<label class="form-label">Friday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="fri_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['fri_s']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="fri_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['fri_s']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group preferences sat-pref">
								<label class="form-label">Saturday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="sat_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['sat_s']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="sat_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['sat_e']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group preferences sun-pref">
								<label class="form-label">Sunday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">

										<label class="custom-control">
											<input type="checkbox" name="sun_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['sun_s']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="sun_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['sun_e']==1) checked @endif disabled>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>
									</div>
								</div>
							</div>
						</div>
						@else
						<form class="lw-ajax-form lw-form" lwSubmitOnChange method="post" data-show-message="true" action="<?= route('user.write.availability'); ?>" data-callback="getUserProfileData" id="lwAvailabilityForm">
							<div class="form-group preferences mon-pref">
								<label class="form-label">Monday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="mon_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['mon_s']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="mon_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['mon_e']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>

									</div>
								</div>
							</div>

							<div class="form-group preferences tue-pref">
								<label class="form-label">Tuesday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="tue_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['tue_s']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="tue_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['tue_e']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>

									</div>

								</div>
							</div>

							<div class="form-group preferences wed-pref">
								<label class="form-label">Wednesday</label>
								<div class="d-flex monday justify-content-center">

									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="wed_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['wed_s']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="wed_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['wed_e']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>

									</div>

								</div>
							</div>

							<div class="form-group preferences thu-pref">
								<label class="form-label">Thursday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="thu_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['thu_s']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="thu_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['thu_e']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group preferences fri-pref">
								<label class="form-label">Friday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="fri_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['fri_s']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="fri_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['fri_s']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group preferences sat-pref">
								<label class="form-label">Saturday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">
										<label class="custom-control">
											<input type="checkbox" name="sat_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['sat_s']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="sat_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['sat_e']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group preferences sun-pref">
								<label class="form-label">Sunday</label>
								<div class="d-flex monday justify-content-center">
									<div class="d-flex">

										<label class="custom-control">
											<input type="checkbox" name="sun_start" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['sun_s']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-sun-o"></i></span>
										</label>

										<label class="custom-control">
											<input type="checkbox" name="sun_end" class="custom-control-input btn-availability" @if($userAvailability && $userAvailability['sun_e']==1) checked @endif>
											<span class="custom-check btn btn-secondary pl-4 pr-4"><i class="fa fa-moon-o"></i></span>
										</label>
									</div>
								</div>
							</div>
						</form>
						@endif
					</div>
				</div>
				<!-- user availability -->
				<!-- user gift data -->
				@if( 1 == 2 && (!__isEmpty($userGiftData) or $isOwnProfile))
				<div class="card mb-3">
					<!-- Gift Header -->
					<div class="card-header">
						<h5><i class="fa fa-gifts" aria-hidden="true"></i> <?= __tr('Gifts'); ?></h5>
					</div>
					<!-- /Gift Header -->
					<!-- Gift Card Body -->
					<div class="card-body" id="lwUserGift">
						@if(!__isEmpty($userGiftData))
						<div class="row">
							@foreach($userGiftData as $gift)
							<div class="col-sm-12 col-md-6 col-lg-3">
								<div class="lw-user-gift-container">
									<img data-src="<?= imageOrNoImageAvailable($gift['userGiftImgUrl']); ?>" class="lw-user-gift-img lw-lazy-img" />
									<small>
										<?= __tr('sent by'); ?> <br>
										<a href="<?= route('user.profile_view', ['username' => $gift['senderUserName']]); ?>"><?= $gift['fromUserName']; ?></a></small>
									@if($gift['status'] === 1)
									<i class="fas fa-mask" title="<?= __tr('This is a private gift you and only sender can see this.'); ?>"></i>
									@endif
								</div>
							</div>
							@endforeach
						</div>
						<!-- show more gift button -->
						<div class="mt-3">
							<button class="btn btn-dark btn-sm btn-block" id="showMoreGiftBtn"> <i class="fa fa-chevron-down"></i> <?= __tr('Show More'); ?></button>
						</div>
						<!-- /show more gift button -->

						<!-- show less gift button -->
						<div class="mt-3">
							<button class="btn btn-dark btn-sm btn-block" id="showLessGiftBtn"> <i class="fa fa-chevron-up"></i> <?= __tr('Show Less'); ?></button>
						</div>
						<!-- /show less gift button -->
						@else
						<!-- info message -->
						<div class="alert alert-info">
							<?= __tr('There are no gifts.'); ?>
						</div>
						<!-- / info message -->
						@endif
					</div>
					<!-- Gift Card Body -->
				</div>
				@endif
				<!-- /user gift data -->
				@if( 1 == 2)
				<!-- User Basic Information -->
				<div class="card mb-3">
					<!-- Basic information Header -->
					<div class="card-header">
						<!-- Check if its own profile -->
						@if($isOwnProfile)
						<span class="float-right">
							<a class="lw-icon-btn" href role="button" id="lwEditBasicInformation" data-toggle="modal" data-target="#lwBasicInformationDialog">
								<i class="fa fa-pencil-alt"></i>
							</a>
							<a class="lw-icon-btn" href role="button" id="lwCloseBasicInfoEditBlock" style="display: none;">
								<i class="fa fa-times"></i>
							</a>
						</span>
						@endif
						<!-- /Check if its own profile -->
						<h5><i class="fas fa-info-circle text-info"></i> <?= __tr('Basic Information'); ?></h5>
					</div>
					<!-- /Basic information Header -->
					<!-- Basic Information content -->
					<div class="card-body">
						<!-- Static basic information container -->
						<div id="lwStaticBasicInformation">
							@if($isOwnProfile)
							<div class="form-group row">
								<!-- First Name -->
								<div class="col-sm-6 mb-3 mb-sm-0">
									<label for="kanji_name"><strong><?= __tr('Display Name'); ?></strong></label>
									<div class="lw-inline-edit-text" data-model="userData.kanji_name"><?= __ifIsset($userData['kanji_name'], $userData['kanji_name'], '-'); ?></div>
								</div>
								<!-- /First Name -->
								<!-- Last Name -->
								<div class="col-sm-6">
									<label for="last_name"><strong><?= __tr('UserName'); ?></strong></label>
									<div class="lw-inline-edit-text" data-model="userData.last_name"><?= __ifIsset($userData['last_name'], $userData['last_name'], '-'); ?></div>
								</div>
								<!-- /Last Name -->
							</div>
							@endif
							<div class="form-group row">
								<!-- Gender -->
								<div class="col-sm-6 mb-3 mb-sm-0">
									<label for="select_gender"><strong><?= __tr('Gender'); ?></strong></label>
									<div class="lw-inline-edit-text" data-model="profileData.gender_text">
										<?= __ifIsset($userProfileData['gender_text'], $userProfileData['gender_text'], '-'); ?>
									</div>
								</div>
								<!-- /Gender -->
								<!-- Preferred Language -->
								<div class="col-sm-6">
									<label><strong><?= __tr('Preferred Language'); ?></strong></label>
									<div class="lw-inline-edit-text" data-model="profileData.formatted_preferred_language">
										<?= __ifIsset($userProfileData['formatted_preferred_language'], $userProfileData['formatted_preferred_language'], '-'); ?>
									</div>
								</div>
								<!-- /Preferred Language -->
							</div>
							<div class="form-group row">
								<!-- Relationship Status -->
								<div class="col-sm-6 mb-3 mb-sm-0">
									<label><strong><?= __tr('Relationship Status'); ?></strong></label>
									<div class="lw-inline-edit-text" data-model="profileData.formatted_relationship_status">
										<?= __ifIsset($userProfileData['formatted_relationship_status'], $userProfileData['formatted_relationship_status'], '-'); ?>
									</div>
								</div>
								<!-- /Relationship Status -->
								<!-- Work Status -->
								<div class="col-sm-6">
									<label for="work_status"><strong><?= __tr('Work Status'); ?></strong></label>
									<div class="lw-inline-edit-text" data-model="profileData.formatted_work_status">
										<?= __ifIsset($userProfileData['formatted_work_status'], $userProfileData['formatted_work_status'], '-'); ?>
									</div>
								</div>
								<!-- /Work Status -->
							</div>
							<div class="form-group row">
								<!-- Education -->
								<div class="col-sm-6 mb-3 mb-sm-0">
									<label for="education"><strong><?= __tr('Education'); ?></strong></label>
									<div class="lw-inline-edit-text" data-model="profileData.formatted_education">
										<?= __ifIsset($userProfileData['formatted_education'], $userProfileData['formatted_education'], '-'); ?>
									</div>
								</div>
								<!-- /Education -->
								<!-- Birthday -->
								<div class="col-sm-6">
									<label for="birthday"><strong><?= __tr('Birthday'); ?></strong></label>
									<div class="lw-inline-edit-text" data-model="profileData.birthday">
										<?= __ifIsset($userProfileData['birthday'], $userProfileData['birthday'], '-'); ?>
									</div>
								</div>
								<!-- /Birthday -->
							</div>
							@if(array_get($userProfileData, 'showMobileNumber'))
							<div class="form-group row">
								<!-- Mobile Number -->
								<div class="col-sm-6 mb-3 mb-sm-0">
									<label for="mobile_number"><strong><?= __tr('Mobile Number'); ?></strong></label>
									<div class="lw-inline-edit-text" data-model="profileData.mobile_number">
										<?= __ifIsset($userProfileData['mobile_number'], $userProfileData['mobile_number'], '-'); ?>
									</div>
								</div>
								<!-- /Mobile Number -->
							</div>
							@endif
						</div>
						<!-- /Static basic information container -->

						@if($isOwnProfile)
						<!-- User Basic Information Form -->
						<form class="lw-ajax-form lw-form" lwSubmitOnChange method="post" data-show-message="true" action="<?= route('user.write.basic_setting'); ?>" data-callback="getUserProfileData" style="display: none;" id="lwUserBasicInformationForm">
							<div class="form-group row">
								<!-- First Name -->
								<div class="col-sm-6 mb-3 mb-sm-0">
									<label for="kanji_name"><?= __tr('First Name'); ?></label>
									<input type="text" value="<?= $userData['first_name']; ?>" class="form-control" name="first_name" placeholder="<?= __tr('Display Name'); ?>">
								</div>
								<!-- /First Name -->
								<!-- Last Name -->
								<div class="col-sm-6">
									<label for="last_name"><?= __tr('Last Name'); ?></label>
									<input type="text" value="<?= $userData['last_name']; ?>" class="form-control" name="last_name" placeholder="<?= __tr('Last Name'); ?>">
								</div>
								<!-- /Last Name -->
							</div>
							<div class="form-group row">
								<!-- Gender -->
								<div class="col-sm-6 mb-3 mb-sm-0">
									<label for="select_gender"><?= __tr('Gender'); ?></label>
									<select name="gender" class="form-control" id="select_gender">
										<option value="" selected disabled><?= __tr('Choose your gender'); ?></option>
										@foreach($genders as $genderKey => $gender)
										<option value="<?= $genderKey; ?>" <?= (__ifIsset($userProfileData['gender']) and $genderKey == $userProfileData['gender']) ? 'selected' : ''; ?>><?= $gender; ?></option>
										@endforeach
									</select>
								</div>

								<!-- /Gender -->
								<!-- Birthday -->
								<div class="col-sm-6">
									<label for="select_preferred_language"><?= __tr('Preferred Language'); ?></label>
									<select name="preferred_language" class="form-control" id="select_preferred_language">
										<option value="" selected disabled><?= __tr('Choose your Preferred Language'); ?></option>
										@foreach($preferredLanguages as $languageKey => $language)
										<option value="<?= $languageKey; ?>" <?= (__ifIsset($userProfileData['preferred_language']) and $languageKey == $userProfileData['preferred_language']) ? 'selected' : ''; ?>><?= $language; ?></option>
										@endforeach
									</select>
								</div>
								<!-- /Preferred Language -->
							</div>
							<div class="form-group row">
								<!-- Relationship Status -->
								<div class="col-sm-6 mb-3 mb-sm-0">
									<label for="select_relationship_status"><?= __tr('Relationship Status'); ?></label>
									<select name="relationship_status" class="form-control" id="select_relationship_status">
										<option value="" selected disabled><?= __tr('Choose your Relationship Status'); ?></option>
										@foreach($relationshipStatuses as $relationshipStatusKey => $relationshipStatus)
										<option value="<?= $relationshipStatusKey; ?>" <?= (__ifIsset($userProfileData['relationship_status']) and $relationshipStatusKey == $userProfileData['relationship_status']) ? 'selected' : ''; ?>><?= $relationshipStatus; ?></option>
										@endforeach
									</select>
								</div>
								<!-- /Relationship Status -->
								<!-- Work status -->
								<div class="col-sm-6">
									<label for="select_work_status"><?= __tr('Work Status'); ?></label>
									<select name="work_status" class="form-control" id="select_work_status">
										<option value="" selected disabled><?= __tr('Choose your work status'); ?></option>
										@foreach($workStatuses as $workStatusKey => $workStatus)
										<option value="<?= $workStatusKey; ?>" <?= (__ifIsset($userProfileData['work_status']) and $workStatusKey == $userProfileData['work_status']) ? 'selected' : ''; ?>><?= $workStatus; ?></option>
										@endforeach
									</select>
								</div>
								<!-- /Work status -->
							</div>
							<div class="form-group row">
								<!-- Education -->
								<div class="col-sm-6 mb-3 mb-sm-0">
									<label for="select_education"><?= __tr('Education'); ?></label>
									<select name="education" class="form-control" id="select_education">
										<option value="" selected disabled><?= __tr('Choose your education'); ?></option>
										@foreach($educations as $educationKey => $educationValue)
										<option value="<?= $educationKey; ?>" <?= (__ifIsset($userProfileData['education']) and $educationKey == $userProfileData['education']) ? 'selected' : ''; ?>><?= $educationValue; ?></option>
										@endforeach
									</select>
								</div>
								<!-- /Education -->
								<!-- Birthday -->
								<div class="col-sm-6">
									<label for="birthday"><?= __tr('Birthday'); ?></label>
									<div class="flatpickr" style="position:relative;">
										<input type="text" name="birthday" min="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.maximum'))->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.minimum'))->format('Y-m-d') }}" class="form-control form-control-user required" required="true" placeholder="Select Date.." value="<?= __ifIsset($userProfileData['dob'], $userProfileData['dob']); ?>" data-input> <!-- input is mandatory -->
										<a class="d-none input-button" style="position: absolute; right: 10px;  top: 10px;" title="toggle" data-toggle>
											<i class="fa fa-calendar" style="color:#9596a0;font-size:18px;"></i>
										</a>
									</div>
								</div>
								<!-- /Birthday -->
							</div>
							@if($isOwnProfile)

							<div class="form-group row">
								<!-- Mobile Number -->
								<div class="col-sm-6">
									<label for="mobile_number"><?= __tr('Mobile Number'); ?></label>
									<input type="text" value="<?= $userData['mobile_number']; ?>" name="mobile_number" placeholder="<?= __tr('Mobile Number'); ?>" class="form-control" required maxlength="15">
								</div>
								<!-- /Mobile Number -->
							</div>
							<!-- About Me -->
							<div class="form-group">
								<label for="about_me"><?= __tr('About Me'); ?></label>
								<textarea class="form-control" name="about_me" id="about_me" rows="3" placeholder="<?= __tr('Say something about yourself.'); ?>"><?= __ifIsset($userProfileData['aboutMe'], $userProfileData['aboutMe'], ''); ?></textarea>
							</div>
							<!-- /About Me -->
							@endif
						</form>
						<!-- /User Basic Information Form -->
						@endif
					</div>
				</div>
				@endif
			</div>
		</div>
		<div class="col-sm-1 col-md-9" style="height:100%;">
			@if( $userData['userRoleId'] == 3 )						
				<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-3 mb-3">

					<div class="col pl-2 pr-2">
						<div class="profile-block p-4" style="height:100%;">
							@if($isOwnProfile)
								<span class="float-right"  style="">
									<a class="lw-icon-btn profile_edit_icon" href role="button" data-activetab="profile_modal_pricing" data-toggle="modal" data-target="#lwBasicProfileDialog">
										<i class="fa fa-pencil-alt"></i>
									</a>
									<a class="lw-icon-btn lwCloseLocationBlock" href role="button" style="display: none;">
										<i class="fa fa-times"></i>
									</a>
								</span>
							@endif	

							<div class="row">
								<span style="font-size:20px;"> Pricing </span>
							</div>
							<div class="pt_pricing_header_container" id="pt_pricing_header_container" style="
									padding-left:0.75rem;
									padding-right:0.75rem;
									max-height:225px;
									overflow-y:auto;">
								@if (!__isEmpty($userPricingData)) 
									@foreach($userPricingData as $session)
									<div class="row mb-1">
										<div class="pt_pricing_time"> <?= $session["session"]?> </div>
										<div class="pt_pricing_inquire_container">
											<span class="price"> ￥<?= floatval($session["price"])?> </span>
											@if(!$isOwnProfile)
											<span class="inquire_span"><button class="inquire_btn" role="button" onclick="showInquireModal('<?= $userData['profilePicture'] ?>', '<?= $userData['kanji_name']?>', '<?= $userProfileData['city']?>', '<?= $session['_id']?>', '<?= '￥'. floatval($session['price'])?>', '<?= $session['session']?>', '<?= $userData['userId'] ?>', '<?= getTotalRateUser($userData['userId']) ?>' )" > Inquire </button></span>
											@endif
										</div>
									</div>
									@endforeach	
								@else
								    <span style="color: #929292;"> No Pricing </span>
								@endif
							</div>
						</div>	
					</div>

					<div class="col">
						<div class="profile-block p-4" style="height:100%;">
							@if($isOwnProfile)
								<span class="float-right"  style="">
									<a class="lw-icon-btn profile_edit_icon" href role="button" data-activetab="profile_modal_detail" data-toggle="modal" data-target="#lwBasicProfileDialog">
										<i class="fa fa-pencil-alt"></i>
									</a>
									<a class="lw-icon-btn lwCloseLocationBlock" href role="button" style="display: none;">
										<i class="fa fa-times"></i>
									</a>
								</span>
							@endif
							<div class="row mb-2">
								<span style="font-size:20px;"> Gyms </span>
							</div>
							<div id="pt_user_gym_container" class="pt_user_gym_container" style="max-height:219px;overflow-y:auto;padding-left:1rem;padding-right:1.5rem;">			
							@if (!__isEmpty($userGymsData)) 
								@foreach($userGymsData as $gym)	
									<div class="row mb-2" style="flex-wrap:nowrap;background: #1E1E1E;border-radius: 10px;">
										<div class="">
											<img style="width: 65px; height: 65px; border: none; border-radius: 10px 0 0 10px;; padding: 5px;object-fit: contain;background:white;" class="lw-photoswipe-gallery-img lw-lazy-img" src="<?= $gym["userGymLogoUrl"]?>">
										</div>
										<div class="" style="padding-right: 1.2rem;padding-left: 1.2rem;justify-content: center;align-content: center;align-items: center;align-self: center;">
											<span style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 15px;line-height: 21px;" class="row"> <?= $gym["gymName"]?> </span>
											<span class="row d-none" style="font-size: 11px;"> <i class="fas fa-map-marker-alt"></i> &nbsp;Minato-ku</span>
											<span class="row d-none" style="font-size: 11px;"> <i class="fas fa-map-marker-alt"></i> &nbsp;Shibuya-ku</span>
										</div>
									</div>
								@endforeach
								<?php
									if( count($userGymsData) < 3){
										$addDummyCount = 3 - count($userGymsData);
										for( $i = 0 ; $i < $addDummyCount ; $i++) {
                                            ?>
										
										<div class="row mb-2" style="height: 65px;border: 2px dashed #858585;flex-wrap:nowrap;background: #1E1E1E;border-radius: 10px;">
											<span style="font-size: 1rem;line-height: 1.5rem;color: rgba(133, 133, 133, 0.7);margin: auto;">Add gym</span>
										</div>
								<?php
                                        }
									}								
								?>
								
							@else 
								<div class="row mb-2" style="height: 65px;border: 2px dashed #858585;flex-wrap:nowrap;background: #1E1E1E;border-radius: 10px;">
									<span style="font-size: 1rem;line-height: 1.5rem;color: rgba(133, 133, 133, 0.7);margin: auto;">Add gym</span>
								</div>
								<div class="row mb-2" style="height: 65px;border: 2px dashed #858585;flex-wrap:nowrap;background: #1E1E1E;border-radius: 10px;">
									<span style="font-size: 1rem;line-height: 1.5rem;color: rgba(133, 133, 133, 0.7);margin: auto;">Add gym</span>
								</div>
								<div class="row mb-2" style="height: 65px;border: 2px dashed #858585;flex-wrap:nowrap;background: #1E1E1E;border-radius: 10px;">
									<span style="font-size: 1rem;line-height: 1.5rem;color: rgba(133, 133, 133, 0.7);margin: auto;">Add gym</span>
								</div>
							@endif
							</div>
						</div>	
					</div>
					<div class="col pl-1 pr-1">
						<div class="profile-block p-4" style="height:100%;">
							@if($isOwnProfile)
								<span class="float-right"  style="">
									<a class="lw-icon-btn profile_edit_icon" href role="button" data-toggle="modal" data-activetab="profile_modal_expertise" data-target="#lwBasicProfileDialog">
										<i class="fa fa-pencil-alt"></i>
									</a>
									<a class="lw-icon-btn lwCloseLocationBlock" href role="button" style="display: none;">
										<i class="fa fa-times"></i>
									</a>
								</span>
							@endif
							<div class="row">
								<span style="font-size:20px;"> Expertise </span>
							</div>
							<div class="row expertise_items_container" style="margin-top:10px;max-height: 215px;overflow-y: auto;">
								@if(!__isEmpty($userExpertiseData))
									@foreach($userExpertiseData as $exp)	
										<span class="pt_category_tag_item"> <?= $exp["expertiseTitle"]?> </span>
									@endforeach
								@else
									<span style="color: #929292;"> No expertise </span>
								@endif
							</div>
						</div>	
					</div>

				</div>
			@endif	
			
			<div class="card mb-3 p-3 profile-block" style="margin-right: -0.5rem;">
				<div class="card-header" style="padding:0;border-bottom:none;">
					@if($isOwnProfile)
					<span class="float-right">
						@if(0)
						<a class="lw-icon-btn" href="<?= route('user.photos_setting', ['username' => getUserAuthInfo('profile.username')]); ?>" role="button">
							<i class="fas fa-cog"></i>
						</a>
						@endif
						<a class="lw-icon-btn" role="button" data-toggle="modal" id="btnShowModalPostPhoto" data-target="#lwPostPhotoDialog">
							<i class="fas fa-camera"></i>
						</a>				
					</span>
					@endif
					<!-- Tab Heading -->
					<div class="d-sm-flex align-items-center justify-content-between photos_tabs_container">
						<nav class="nav">
							<a id="photos" data-toggle="tab" class="nav-link active" aria-current="page" href="#photos_tab"><?= __tr('Photos'); ?></a>
							<a id="tagged" data-toggle="tab" class="nav-link" href="#tagged_tab"><?= __tr('Tagged'); ?></a>
							@if($isOwnProfile)
							<a id="favourite" data-toggle="tab" class="nav-link" href="#favourite_tab"><?= __tr('Favourites'); ?></a>
							@endif
						</nav>
					</div>
				</div>
				<div class="tab-content" style="
												margin-top: -1rem;
												margin-bottom: -1.5rem;">
					<div class="card-body tab-pane active in" id="photos_tab">
						<div style = "max-height: <?= $userData['userRoleId'] == 3?"250":"500"?>px;overflow-y: auto;overflow-x: hidden;" class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 text-center lw-horizontal-container photos_tab_container ">
							
						</div>
					</div>
					<div class="card-body tab-pane fade"  id="tagged_tab">
						<div style = "max-height:<?= $userData['userRoleId'] == 3?"250":"500"?>px;overflow-y: auto;overflow-x: hidden;" class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 text-center lw-horizontal-container photos_tagged_tab_container ">
							
						</div>
					</div>
					<div class="card-body tab-pane fade"  id="favourite_tab">
						<div style = "max-height: <?= $userData['userRoleId'] == 3?"250":"500"?>px;overflow-y: auto;overflow-x: hidden;" class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 text-center lw-horizontal-container photos_favourite_tab_container">
							
						</div>
					</div>
				</div>
			</div>
			
			@if( $userData['userRoleId'] == 3 )	
			<div class="card mb-3 p-3 profile-block" style="margin-right: -0.5rem;min-height: 463px;">
				<div class="card-header" style="padding:0;border-bottom:none;">
					@if($isOwnProfile)
					<span class="float-right">
						<a class="lw-icon-btn profile_edit_icon" href role="button" id="lwEditUserLocation">
							<i class="fa fa-pencil-alt"></i>
						</a>
						<a class="lw-icon-btn" href role="button" id="lwCloseLocationBlock" style="display: none;">
							<i class="fa fa-times"></i>
						</a>
					</span>
					@endif
					<h5><i class="fas fa-map-marker-alt"></i> <?= __tr('Location'); ?></h5>
				</div>
				<div class="card-body" style="margin-top:-1rem;margin-bottom:-1rem;">
					@if(getStoreSettings('allow_google_map') or getStoreSettings('use_static_city_data'))
					<div id="lwUserStaticLocation"  >
						@if(getStoreSettings('allow_google_map'))
						<div class="d-none gmap_canvas" style="filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px;"><iframe height="300" id="gmap_canvas" src="https://maps.google.com/maps/place?q=<?= $latitude; ?>,<?= $longitude; ?>&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
						</div>

						@else
						<div id="staticMapId"></div>
						@endif
					</div>
					<div id="lwUserEditableLocation" style="display:none;">
						@if(getStoreSettings('use_static_city_data'))
						<div class="form-group">
							<label for="selectLocationCity"><?= __tr('Location'); ?></label>
							<input type="text" id="selectLocationCity" class="form-control" placeholder="<?= __tr('Enter a location'); ?>">
						</div>
						@else
						<div class="form-group">
							<label class="d-none" for="address_address"><?= __tr('Location'); ?></label>
							<input type="text" id="address-input" name="address_address" class="form-control map-input" placeholder="<?= __tr('Enter a location'); ?>">

							<!-- show select location on map error -->
							<div class="alert alert-danger mt-2 alert-dismissible" style="display: none" id="lwShowLocationErrorMessage">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<span data-model="locationErrorMessage"></span>
							</div>
							<!-- /show select location on map error -->

							<input type="hidden" name="address_latitude" data-model="profileData.latitude" id="address-latitude" value="<?= $latitude; ?>" />
							<input type="hidden" name="address_longitude" data-model="profileData.longitude" id="address-longitude" value="<?= $longitude; ?>" />
						</div>
						@endif
					</div>

					<div id="address-map-container" style="width:100%;height:340px;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px; ">
						<div style="width: 100%; height: 100%;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px;" id="address-map"></div>
					</div>
					
					
					@else
					<!-- info message -->
					<div class="alert alert-info">
						<?= __tr('Something went wrong with Google Api Key, please contact to system administrator.'); ?>
					</div>
					<!-- / info message -->
					@endif
				</div>
			</div>
			@else
			<div class="row" style="">
				<div class="col-sm-1 col-md-8 p-3" >
					<div class="card mb-3 p-3 profile-block" style="margin-right: -0.5rem;min-height: 515px;">
						<div class="card-header" style="padding:0;border-bottom:none;">
							@if($isOwnProfile)
							<span class="float-right">
								<a class="lw-icon-btn profile_edit_icon" href role="button" id="lwEditUserLocation">
									<i class="fa fa-pencil-alt"></i>
								</a>
								<a class="lw-icon-btn" href role="button" id="lwCloseLocationBlock" style="display: none;">
									<i class="fa fa-times"></i>
								</a>
							</span>
							@endif
							<h5><i class="fas fa-map-marker-alt"></i> <?= __tr('Location'); ?></h5>
						</div>
						<div class="card-body" style="margin-top:-1rem;margin-bottom:-1rem;">
							@if(getStoreSettings('allow_google_map') or getStoreSettings('use_static_city_data'))
							<div id="lwUserStaticLocation"  >
								@if(getStoreSettings('allow_google_map'))
								<div class="d-none gmap_canvas" style="filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px;"><iframe height="300" id="gmap_canvas" src="https://maps.google.com/maps/place?q=<?= $latitude; ?>,<?= $longitude; ?>&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
								</div>

								@else
								<div id="staticMapId"></div>
								@endif
							</div>
							<div id="lwUserEditableLocation" style="display:none;">
								@if(getStoreSettings('use_static_city_data'))
								<div class="form-group">
									<label for="selectLocationCity"><?= __tr('Location'); ?></label>
									<input type="text" id="selectLocationCity" class="form-control" placeholder="<?= __tr('Enter a location'); ?>">
								</div>
								@else
								<div class="form-group">
									<label class="d-none" for="address_address"><?= __tr('Location'); ?></label>
									<input type="text" id="address-input" name="address_address" class="form-control map-input" placeholder="<?= __tr('Enter a location'); ?>">

									<!-- show select location on map error -->
									<div class="alert alert-danger mt-2 alert-dismissible" style="display: none" id="lwShowLocationErrorMessage">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<span data-model="locationErrorMessage"></span>
									</div>
									<!-- /show select location on map error -->

									<input type="hidden" name="address_latitude" data-model="profileData.latitude" id="address-latitude" value="<?= $latitude; ?>" />
									<input type="hidden" name="address_longitude" data-model="profileData.longitude" id="address-longitude" value="<?= $longitude; ?>" />
								</div>
								@endif
							</div>

							<div id="address-map-container" style="width:100%;height:380px;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px; ">
								<div style="width: 100%; height: 100%;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px;" id="address-map"></div>
							</div>
							
							
							@else
							<!-- info message -->
							<div class="alert alert-info">
								<?= __tr('Something went wrong with Google Api Key, please contact to system administrator.'); ?>
							</div>
							<!-- / info message -->
							@endif
						</div>
					</div>
				</div>
				<div class="col-sm-1 col-md-4 p-3" >

					<div class="card mb-3 p-3 profile-block" style="margin-right: -0.5rem;min-height: 515px;margin-left:-1.25rem">
						<div class="card-header" style="padding:0;border-bottom:none;">
							<div class="d-flex mb-1" >
								<h5 style="
										font-family: Nunito Sans;
										font-style: normal;
										font-weight: bold;
										font-size: 20px;
										line-height: 27px;
										color: #FFFFFF;
									">Interests</h5>
								@if($isOwnProfile)	
								<span class="" style="margin-left:auto; margin-right:-15px;">
									<a class="lw-icon-btn profile_edit_icon" href="" role="button" data-activetab="profile_modal_expertise" data-toggle="modal" data-target="#lwBasicProfileDialog">
										<i class="fa fa-pencil-alt "></i>
									</a>
								</span>
								@endif
							</div>
						</div>
						<div class="card-body" style="margin-top:-1rem;margin-bottom:-1rem;padding-left: 0.25rem;padding-right: 0.25rem;">
							<div class="mb-4">
								<div class="row expertise_items_container" style="margin: 0px;" id="expertise_items_container">
									@if(!__isEmpty($userExpertiseData))
										@foreach($userExpertiseData as $exp)	
											<span class="pt_category_tag_item"> <?= $exp["expertiseTitle"]?> </span>
										@endforeach
									@else
										<span style="color: #929292;"> No interest</span>	
									@endif
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>	
			@endif

			@if(!__isEmpty($userSpecificationData))
			@foreach($userSpecificationData as $specificationKey => $specifications)
			<div class="card mb-3" style="display:none;">
				<!-- User Specification Header -->
				<div class="card-header">
					<!-- Check if its own profile -->
					@if($isOwnProfile)
					<span class="float-right">
						<a class="lw-icon-btn profile_edit_icon" href role="button" id="lwEdit<?= $specificationKey; ?>" onclick="showHideSpecificationUser('<?= $specificationKey; ?>', event)">
							<i class="fa fa-pencil-alt"></i>
						</a>
						<a class="lw-icon-btn" href role="button" id="lwClose<?= $specificationKey; ?>Block" onclick="showHideSpecificationUser('<?= $specificationKey; ?>', event)" style="display: none;">
							<i class="fa fa-times"></i>
						</a>
					</span>
					@endif
					<!-- /Check if its own profile -->
					<h5><?= $specifications['icon']; ?> <?= $specifications['title']; ?></h5>
				</div>
				<!-- /User Specification Header -->
				<div class="card-body">
					<!-- User Specification static container -->
					<div id="lw<?= $specificationKey; ?>StaticContainer">
						@foreach(collect($specifications['items'])->chunk(2) as $specKey => $specification)
						<div class="form-group row">
							@foreach($specification as $itemKey => $item)
							<div class="col-sm-6 mb-3 mb-sm-0">
								<label><strong><?= $item['label']; ?></strong></label>
								<div class="lw-inline-edit-text" data-model="specificationData.<?= $item['name']; ?>">
									<?= $item['value']; ?>
								</div>
							</div>
							@endforeach
						</div>
						@endforeach
					</div>
					<!-- /User Specification static container -->
					@if($isOwnProfile)
					<!-- User Specification Form -->
					<form class="lw-ajax-form lw-form" method="post" lwSubmitOnChange action="<?= route('user.write.usersetting-account'); ?>" data-callback="getUserProfileData" id="lwUser<?= $specificationKey; ?>Form" style="display: none;">
						@foreach(collect($specifications['items'])->chunk(2) as $specification)
						<div class="form-group row">
							@foreach($specification as $itemKey => $item)
							<div class="col-sm-6 mb-3 mb-sm-0">
								@if($item['input_type'] == 'select')
								<label for="<?= $item['name']; ?>"><?= $item['label']; ?></label>
								<select name="<?= $item['name']; ?>" class="form-control">
									<option value="" selected disabled><?= __tr('Choose __label__', [
																			'__label__' => $item['label'],
																		]); ?></option>
									@foreach($item['options'] as $optionKey => $option)
									<option value="<?= $optionKey; ?>" <?= $item['selected_options'] == $optionKey ? 'selected' : ''; ?>>
										<?= $option; ?>
									</option>
									@endforeach
								</select>
								@elseif($item['input_type'] == 'textbox')
								<label for="<?= $item['name']; ?>"><?= $item['label']; ?></label>
								<input type="text" id="<?= $item['name']; ?>" name="<?= $item['name']; ?>" class="form-control" value="<?= $item['selected_options']; ?>">
								@endif
							</div>
							@endforeach
						</div>
						@endforeach
					</form>
					<!-- /User Specification Form -->
					@endif
				</div>
			</div>
			@endforeach
			@endif
			<!-- /User Specifications -->
			<!-- User Specifications -->
		</div>
	</div>
</div>
<!-- send gift Modal-->
<div class="modal fade" id="lwSendGiftDialog" tabindex="-1" role="dialog" aria-labelledby="sendGiftModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<?php $totalAvailableCredits = totalUserCredits(); ?>
				<h5 class="modal-title" id="sendGiftModalLabel"><?= __tr('Send Gift'); ?> <small class="text-muted"><?= __tr('(Credits Available:  __availableCredits__)', [
                                                                                                                        '__availableCredits__' => $totalAvailableCredits,
                                                                                                                    ]); ?></small></h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			@if(isset($giftListData) and !__isEmpty($giftListData))

			<!-- insufficient balance error message -->
			<div class="alert alert-info" id="lwGiftModalErrorText" style="display: none">
				<?= __tr('Your credit balance is too low, please'); ?>
				<a href="<?= route('user.credit_wallet.read.view'); ?>"><?= __tr('purchase credits'); ?></a>
			</div>
			<!-- / insufficient balance error message -->

			<form class="lw-ajax-form lw-form" id="lwSendGiftForm" method="post" data-callback="sendGiftCallback" action="<?= route('user.write.send_gift', ['sendUserUId' => $userData['userUId']]); ?>">
				<div class="modal-body">
					<div class="btn-group-toggle" data-toggle="buttons">
						@foreach($giftListData as $key => $gift)
						<span class="btn lw-group-radio-option-img" id="lwSendGiftRadioBtn_<?= $gift['_uid']; ?>">
							<input type="radio" value="<?= $gift['_uid']; ?>" name="selected_gift" />
							<span>
								<img class="lw-lazy-img" data-src="<?= imageOrNoImageAvailable($gift['gift_image_url']); ?>" /><br>
								<?= $gift['formattedPrice']; ?>
							</span>
						</span>
						@endforeach
					</div>

					<!-- select private / public -->
					<div class="custom-control custom-checkbox custom-control-inline mt-3">
						<input type="checkbox" class="custom-control-input" id="isPrivateCheck" name="isPrivateGift">
						<label class="custom-control-label" for="isPrivateCheck"><?= __tr('Private'); ?></label>
					</div>
					<!-- /select private / public -->
				</div>
				<!-- modal footer -->
				<div class="modal-footer mt-3">
					<button class="btn btn-light btn-sm" id="lwCloseSendGiftDialog"><?= __tr('Cancel'); ?></button>
					<button type="submit" class="btn btn-primary btn-sm lw-ajax-form-submit-action btn-user lw-btn-block-mobile"><?= __tr('Send'); ?></button>
				</div>
				<!-- modal footer -->
			</form>
			@else
			<!-- info message -->
			<div class="alert alert-info">
				<?= __tr('There are no gifts'); ?>
			</div>
			<!-- / info message -->
			@endif
		</div>
	</div>
</div>
<!-- /send gift Modal-->

<!-- basic info modal -->
<div class="modal fade" id="lwBasicInformationDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="lw-ajax-form lw-form" method="post" data-show-message="true" action="<?= route('user.write.basic_setting'); ?>" data-callback="getUserProfileData" id="lwUserBasicInformationForm">
					<div class="form-group row">
						<!-- First Name -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label for="kanji_name"><?= __tr('Display Name'); ?></label>
							<input type="text" value="<?= $userData['kanji_name']; ?>" class="form-control" name="kanji_name" placeholder="<?= __tr('Display Name'); ?>">
						</div>
						<!-- /First Name -->
						<!-- Last Name -->
						<div class="col-sm-6">
							<label for="userName"><?= __tr('Last Name'); ?></label>
							<input type="text" value="<?= $userData['last_name']; ?>" class="form-control" name="last_name" placeholder="<?= __tr('Last Name'); ?>">
						</div>
						<!-- /Last Name -->
					</div>
					<div class="form-group row">
						<!-- Gender -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label for="select_gender"><?= __tr('Gender'); ?></label>
							<select name="gender" class="form-control" id="select_gender">
								<option value="" selected disabled><?= __tr('Choose your gender'); ?></option>
								@foreach($genders as $genderKey => $gender)
								<option value="<?= $genderKey; ?>" <?= (__ifIsset($userProfileData['gender']) and $genderKey == $userProfileData['gender']) ? 'selected' : ''; ?>><?= $gender; ?></option>
								@endforeach
							</select>
						</div>

						<!-- /Gender -->
						<!-- Birthday -->
						<div class="col-sm-6">
							<label for="select_preferred_language"><?= __tr('Preferred Language'); ?></label>
							<select name="preferred_language" class="form-control" id="select_preferred_language">
								<option value="" selected disabled><?= __tr('Choose your Preferred Language'); ?></option>
								@foreach($preferredLanguages as $languageKey => $language)
								<option value="<?= $languageKey; ?>" <?= (__ifIsset($userProfileData['preferred_language']) and $languageKey == $userProfileData['preferred_language']) ? 'selected' : ''; ?>><?= $language; ?></option>
								@endforeach
							</select>
						</div>
						<!-- /Preferred Language -->
					</div>
					<div class="form-group row">
						<!-- Relationship Status -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label for="select_relationship_status"><?= __tr('Relationship Status'); ?></label>
							<select name="relationship_status" class="form-control" id="select_relationship_status">
								<option value="" selected disabled><?= __tr('Choose your Relationship Status'); ?></option>
								@foreach($relationshipStatuses as $relationshipStatusKey => $relationshipStatus)
								<option value="<?= $relationshipStatusKey; ?>" <?= (__ifIsset($userProfileData['relationship_status']) and $relationshipStatusKey == $userProfileData['relationship_status']) ? 'selected' : ''; ?>><?= $relationshipStatus; ?></option>
								@endforeach
							</select>
						</div>
						<!-- /Relationship Status -->
						<!-- Work status -->
						<div class="col-sm-6">
							<label for="select_work_status"><?= __tr('Work Status'); ?></label>
							<select name="work_status" class="form-control" id="select_work_status">
								<option value="" selected disabled><?= __tr('Choose your work status'); ?></option>
								@foreach($workStatuses as $workStatusKey => $workStatus)
								<option value="<?= $workStatusKey; ?>" <?= (__ifIsset($userProfileData['work_status']) and $workStatusKey == $userProfileData['work_status']) ? 'selected' : ''; ?>><?= $workStatus; ?></option>
								@endforeach
							</select>
						</div>
						<!-- /Work status -->
					</div>
					<div class="form-group row">
						<!-- Education -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label for="select_education"><?= __tr('Education'); ?></label>
							<select name="education" class="form-control" id="select_education">
								<option value="" selected disabled><?= __tr('Choose your education'); ?></option>
								@foreach($educations as $educationKey => $educationValue)
								<option value="<?= $educationKey; ?>" <?= (__ifIsset($userProfileData['education']) and $educationKey == $userProfileData['education']) ? 'selected' : ''; ?>><?= $educationValue; ?></option>
								@endforeach
							</select>
						</div>
						<!-- /Education -->
						<!-- Birthday -->
						<div class="col-sm-6">
							<label for="birthday"><?= __tr('Birthday'); ?></label>
							<div class="flatpickr" style="position:relative;">
								<input type="text" name="birthday" min="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.maximum'))->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.minimum'))->format('Y-m-d') }}" class="form-control form-control-user required" required="true" placeholder="Select Date.." value="<?= __ifIsset($userProfileData['dob'], $userProfileData['dob']); ?>" data-input> <!-- input is mandatory -->
								<a class="d-none input-button" style="position: absolute; right: 10px;  top: 10px;" title="toggle" data-toggle>
									<i class="fa fa-calendar" style="font-size:18px;"></i>
								</a>
							</div>
						</div>
						<!-- /Birthday -->
					</div>
					@if($isOwnProfile)

					<div class="form-group row">
						<!-- Mobile Number -->
						<div class="col-sm-6">
							<label for="mobile_number"><?= __tr('Mobile Number'); ?></label>
							<input type="text" value="<?= $userData['mobile_number']; ?>" name="mobile_number" placeholder="<?= __tr('Mobile Number'); ?>" class="form-control" required maxlength="15">
						</div>
						<!-- /Mobile Number -->
					</div>
					<!-- About Me -->
					<div class="form-group">
						<label for="about_me"><?= __tr('About Me'); ?></label>
						<textarea class="form-control" name="about_me" id="about_me" rows="3" placeholder="<?= __tr('Say something about yourself.'); ?>"><?= __ifIsset($userProfileData['aboutMe'], $userProfileData['aboutMe'], ''); ?></textarea>
					</div>
					<!-- /About Me -->
					@endif
					<div class="modal-footer mt-3">
						<button class="btn btn-light btn-sm" id="lwCloseUserBasicInformationDialog"><?= __tr('Cancel'); ?></button>
						<button type="submit" class="btn btn-primary btn-sm lw-ajax-form-submit-action btn-user lw-btn-block-mobile"><?= __tr('Report'); ?></button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>
<!-- basic info modal -->
<!-- basic info modal -->
<div class="modal fade" id="lwBasicProfileDialog" tabindex="-1" role="dialog" aria-labelledby="userProfileModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color: #191919;padding: 40px;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/border-radius: 24px; ">
			@if( $userData['userRoleId'] == 3 )
				<div class="modal-header" style="border-bottom:none;">
					<h5 class="modal-title" style="color:#FFFFFF;display:none;">Profile</h5>
					<div class="d-sm-flex align-items-center justify-content-between">
						<nav class="nav">
							<a id="profile_modal_detail" data-toggle="tab" class="nav-link active" aria-current="page" href="#profile_basic_tab"><?= __tr('Profile'); ?></a>
							<a id="profile_modal_pricing" data-toggle="tab" class="nav-link" href="#profile_pricing_tab"><?= __tr('Pricing'); ?></a>
							@if(0)																						
							<a id="profile_modal_gyms" data-toggle="tab" class="nav-link" href="#profile_gyms_tab"><?= __tr('Gyms'); ?></a>
							@endif																						
							<a id="profile_modal_expertise" data-toggle="tab" class="nav-link" href="#profile_expertise_tab"><?= __tr('Expertise'); ?></a>
						</nav>
					</div>
					<button type="button" style="color:#FFFFFF;margin-top: -40px; " class="close" data-dismiss="modal" aria-label="Close">
						<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body" style="color:#FFFFFF;">
					<div class="tab-content">
						<div id="profile_basic_tab" class="tab-pane active in">
							<form class="user lw-ajax-form lw-form" method="post" data-show-message="true" action="<?= route('user.write.usersetting-account'); ?>" data-callback="getUserProfileData" >
								<div class="d-flex">
									<div class="form-group" style="flex:1;margin-right: 3rem;">
										<label for="kanji_name">Display Name</label>
										<input type="text" class="form-control form-control-user" name="kanji_name" id="kanji_name" value="<?= $userData['kanji_name']; ?>">
									</div>
									<div class="form-group" style="flex:1;margin-right:3rem;">
										<label for="desciption">Username</label>
										<input type="text" class="form-control form-control-user" name="username" id="username" value="<?= $userData['userName']; ?>">
									</div>
								</div>
								<div class="d-flex">
									<div class="form-group" style="flex:1;margin-right:3rem;">
										<label for="desciption">Bio</label>
										<textarea class="form-control form-control-user" name="about_me" id="about_me" ><?= $userProfileData['aboutMe']; ?></textarea>
									</div>
								</div>
								<!-- Google Map setting Old -->
								@if(0)
								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<div id="newaddress-map-container" style="width:100%;height:250px;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px; ">
											<div style="width: 100%; height: 100%;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px;" id="newaddress-map"></div>
										</div>
									</div>
								</div>

								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<label for="newaddress-input"><?= __tr('Location'); ?></label>
										<input type="text" id="newaddress-input" name="newaddress_address" class="form-control form-control-user map-input" placeholder="<?= __tr('Enter a location'); ?>" style="padding-right:2rem;">
										<!-- show select location on map error -->
										<div class="alert alert-danger mt-2 alert-dismissible" style="display: none" id="lwShowLocationErrorMessage">
											<button type="button" class="close" data-dismiss="alert">&times;</button>
											<span data-model="locationErrorMessage"></span>
										</div>
										
										<input type="hidden" name="newaddress_latitude" data-model="profileData.latitude" id="newaddress-latitude" value="<?= $latitude; ?>" />
										<input type="hidden" name="newaddress_longitude" data-model="profileData.longitude" id="newaddress-longitude" value="<?= $longitude; ?>" />

										<!-- /show select location on map error -->
										<i class="fa fa-plus" style="position: absolute;right: -2rem;top: 48px;"></i>
										<i class="fas fa-map-marker-alt" style="position: absolute;right: 1rem;top: 48px;"></i>
									</div>
								</div>
								@endif

								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<label for="selectGym">Gyms</label>
										<select id="selectGym" name="selectGym" mutiple class="form-control form-control-user lw-user-gym-select-box" required="" style="width: 100%;border-color: white;">
                                        </select> 
									</div>
								</div>
								<input type="hidden" name="gym_selected_list" id="gym_selected_list" value="">

								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<label for="desciption">Qualified Since</label>
										<div class="flatpickr" style="position:relative;">
											<input type="text" name="do_qualify" min="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.maximum'))->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.minimum'))->format('Y-m-d') }}" class="form-control form-control-user required" required="true" placeholder="Select Date.." value="<?= $userProfileData["do_qualify"]?>" data-input> <!-- input is mandatory -->
											<a class="d-none input-button" style="position: absolute; right: 10px;  top: 10px;" title="toggle" data-toggle>
												<i class="fa fa-calendar" style="color:#9596a0;font-size:18px;"></i>
											</a>
										</div>
									</div>
								</div>

								<div class="d-flex">
									<div class=" d-none form-group position-relative" style="flex:1;margin-right:3rem;">
										<label for="desciption">Website</label>
										<input type="text" class="form-control form-control-user" name="website" value="<?= $userProfileData["website"]?>">
									</div>
								</div>
								
								<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="border-radius: 1rem;padding:13px 25px;">Save</button>
							</form>
						</div>

						<div id="profile_pricing_tab" class="tab-pane fade">
							<form class="user lw-ajax-form lw-form" method="post" data-show-message="true" action="<?= route('user.write.usersetting-account'); ?>" data-callback="getUserProfileData" >
								<div class="pt_pricing_container" id="pt_pricing_container">
									@foreach($userPricingData as $session)
									<div class="d-flex position-relative">
										<div class="form-group" style="flex:1;margin-right: 3rem;">
											<label for="session_type">Session</label>
											<input type="text" class="form-control form-control-user" name="session_type" value="<?= $session["session"]?>">
										</div>
										<div class="form-group" style="flex:1;margin-right:3rem;">
											<label for="pricing">Pricing</label>
											<input type="text" class="form-control form-control-user" name="pricing" value="<?= floatval($session["price"])?>">
										</div>
										<a class="removePricingItemBtn" href="javascript:removePricingItem('<?= $session["_uid"]?>');"><i class="fa fa-close" style="color:white;position: absolute;right: 0.25rem;top: 35px;padding: 0.75rem;background: #FF3F3F;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 10px;"></i></a>
									</div>
									@endforeach	
								</div>
								<div id="pt_pricing_adding_container" style="<?php if( count($userPricingData) == count(getPricingTypeList())) echo 'display:none!important;';?>">
									<div class="d-flex position-relative"  >
										<div class="form-group" style="flex:1;margin-right: 3rem;">
											<label for="pt_pricing_session">Session</label>
											<select class="form-control form-control-user" id="pt_pricing_session" name="pt_pricing_session">
												@foreach(getPricingTypeList() as $sessionKey => $sessionValue)
												<option value="<?= $sessionValue["title"] ?>" > <?= $sessionValue["title"] ?> </option>
												@endforeach																		
											</select>

										</div>
										<div class="form-group" style="flex:1;margin-right:3rem;">
											<label for="pt_pricing_price">Pricing</label>
											<input type="number" class="form-control form-control-user" min="0" value="0" step="any" name="pt_pricing_price" id="pt_pricing_price" value="">
										</div>
										<a style="position: absolute;right: 1rem;top: 40px; color:white;" href="#" id="addPricingItem">
											<i class="fa fa-plus"></i>
										</a>
									</div>
								</div>
								
								<button type="submit" class="d-none lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="border-radius: 1rem;padding:13px 25px;">Save</button>
							</form>
						</div>
						
						<!-- Gym&Branch setting old-->
						@if(0)
						<div id="profile_gyms_tab" class="tab-pane fade">
							<form class="user lw-ajax-form lw-form" method="post" data-show-message="true" action="<?= route('user.write.usersetting-account'); ?>" data-callback="getUserProfileData" >
								
								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<label for="desciption">Gyms</label>
										<input type="text" class="form-control form-control-user">
										<i class="fa fa-plus" style="position: absolute;right: -2rem;top: 48px;"></i>
									</div>
								</div>
								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<label for="desciption">Branch</label>
										<input type="text" class="form-control form-control-user">
										<i class="fa fa-plus" style="position: absolute;right: -2rem;top: 48px;"></i>
									</div>
								</div>
								
								<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="border-radius: 1rem;padding:13px 25px;">Save</button>
							</form>
						</div>
						@endif																							

						<div id="profile_expertise_tab" class="tab-pane fade">
							<form class="user lw-ajax-form lw-form" method="post" data-show-message="true" action="<?= route('user.write.expertise_data'); ?>" data-callback="getUserProfileData" >
								<!-- Testing dummy data-->		
								@if(0)																				
								<div class="row" style="margin:0px;">
									<span class="pt_category_tag_item"> Power Lifting </span>
									<span class="pt_category_tag_item"> Recovery </span>
									<span class="pt_category_tag_item"> Weight Loss </span>
									<span class="pt_category_tag_item"> Yoga </span>
								</div>
								<div class="row mb-1" style="margin:0px;">
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Yoga </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Power Lifting </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Weight Loss </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Recovery </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Yoga </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Power Lifting </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Weight Loss </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Recovery </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Yoga </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Power Lifting </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Weight Loss </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Recovery </span>
								</div>
								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<label for="desciption">Other</label>
										<input type="text" class="form-control form-control-user" value="test">
										<i class="fa fa-plus" style="position: absolute;right: -2rem;top: 48px;"></i>
									</div>
								</div>
								<div class="d-flex mb-4">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<input type="text" class="form-control form-control-user" value="test">
										<i class="fa fa-close" style="position: absolute;right: -2.5rem;top: 10px;padding: 0.75rem;background: #FF3F3F;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 10px;"></i>
									</div>
								</div>
								@endif
								
								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										@if($userData["userRoleId"] == 3)
											<label for="selectExpertise">Expertise</label>
										@else
											<label for="selectExpertise">Interests</label>
										@endif																		
										<select id="selectExpertise" name="selectExpertise" mutiple class="form-control form-control-user lw-user-gym-select-box" required="" style="width: 100%;border-color: white;">
										</select> 
									</div>
								</div>
								<input type="hidden" name="expertise_selected_list" id="expertise_selected_list" value="">

								<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="border-radius: 1rem;padding:13px 25px;">Save</button>
							</form>
						</div>
					</div>																									
				</div>
			@else 
				<div class="modal-header" style="border-bottom:none;">
					<h5 class="modal-title" style="color:#FFFFFF;display:none;">Profile</h5>
					<div class="d-sm-flex align-items-center justify-content-between">
						<nav class="nav">
							<a id="profile_modal_detail" data-toggle="tab" class="nav-link active" aria-current="page" href="#profile_basic_tab"><?= __tr('Profile'); ?></a>
							<a id="profile_modal_expertise" data-toggle="tab" class="nav-link" href="#profile_interests_tab"><?= __tr('Interests'); ?></a>
						</nav>
					</div>
					<button type="button" style="color:#FFFFFF;margin-top: -40px; " class="close" data-dismiss="modal" aria-label="Close">
						<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body" style="color:#FFFFFF;">
					<div class="tab-content">
						<div id="profile_basic_tab" class="tab-pane active in">
							<form class="user lw-ajax-form lw-form" method="post" data-show-message="true" action="<?= route('user.write.usersetting-account'); ?>" data-callback="getUserProfileData" >
								<div class="d-flex">
									<div class="form-group" style="flex:1;margin-right: 3rem;">
										<label for="kanji_name">Display Name</label>
										<input type="text" class="form-control form-control-user" name="kanji_name" id="kanji_name" value="<?= $userData['kanji_name']; ?>">
									</div>
									<div class="form-group" style="flex:1;margin-right:3rem;">
										<label for="desciption">Username</label>
										<input type="text" class="form-control form-control-user" name="username" id="username" value="<?= $userData['userName']; ?>">
									</div>
								</div>
								<div class="d-flex">
									<div class="form-group" style="flex:1;margin-right:3rem;">
										<label for="about_me">Bio</label>
										<textarea class="form-control form-control-user" name="about_me" id="about_me" ><?= $userProfileData['aboutMe']; ?></textarea>
									</div>
								</div>
								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<label for="selectGym">Gyms</label>
										<select id="selectGym" name="selectGym" mutiple class="form-control form-control-user lw-user-gym-select-box" required="" style="width: 100%;border-color: white;">
                                        </select> 
									</div>
								</div>
								<input type="hidden" name="gym_selected_list" id="gym_selected_list" value="">
								
								<!-- Google Map setting Old-->
								@if(0)
								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<div id="newaddress-map-container" style="width:100%;height:250px;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px; ">
											<div style="width: 100%; height: 100%;filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));border-radius: 20px;" id="newaddress-map"></div>
										</div>
									</div>
								</div>
								
								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<label for="newaddress-input"><?= __tr('Location'); ?></label>
										<input type="text" id="newaddress-input" name="newaddress_address" value="<?= $userProfileData["formatted_address"]?>" class="form-control form-control-user map-input" placeholder="<?= __tr('Enter a location'); ?>" style="padding-right:2rem;">
										<!-- show select location on map error -->
										<div class="alert alert-danger mt-2 alert-dismissible" style="display: none" id="lwShowLocationErrorMessage">
											<button type="button" class="close" data-dismiss="alert">&times;</button>
											<span data-model="locationErrorMessage"></span>
										</div>
										
										<input type="hidden" name="newaddress_latitude" data-model="profileData.latitude" id="newaddress-latitude" value="<?= $latitude; ?>" />
										<input type="hidden" name="newaddress_longitude" data-model="profileData.longitude" id="newaddress-longitude" value="<?= $longitude; ?>" />

										<!-- /show select location on map error -->
										<i class="fas fa-map-marker-alt" style="position: absolute;right: 1rem;top: 48px;"></i>
									</div>
								</div>
								@endif

								<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="border-radius: 1rem;padding:13px 25px;">Save</button>
							</form>
						</div>
						<div id="profile_interests_tab" class="tab-pane fade">
							<form class="user lw-ajax-form lw-form" method="post" data-show-message="true" action="<?= route('user.write.expertise_data'); ?>" data-callback="getUserProfileData" >
								<!-- Testing dummy data-->		
								@if(0)																				
								<div class="row" style="margin:0px;">
									<span class="pt_category_tag_item"> Power Lifting </span>
									<span class="pt_category_tag_item"> Recovery </span>
									<span class="pt_category_tag_item"> Weight Loss </span>
									<span class="pt_category_tag_item"> Yoga </span>
								</div>
								<div class="row mb-1" style="margin:0px;">
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Yoga </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Power Lifting </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Weight Loss </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Recovery </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Yoga </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Power Lifting </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Weight Loss </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Recovery </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Yoga </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Power Lifting </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Weight Loss </span>
									<span class="pt_category_tag_item" style="color: #FFFFFF;background: #FF3F3F;"> Recovery </span>
								</div>
								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<label for="desciption">Other</label>
										<input type="text" class="form-control form-control-user" value="test">
										<i class="fa fa-plus" style="position: absolute;right: -2rem;top: 48px;"></i>
									</div>
								</div>
								<div class="d-flex mb-4">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										<input type="text" class="form-control form-control-user" value="test">
										<i class="fa fa-close" style="position: absolute;right: -2.5rem;top: 10px;padding: 0.75rem;background: #FF3F3F;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 10px;"></i>
									</div>
								</div>
								@endif
								
								<div class="d-flex">
									<div class="form-group position-relative" style="flex:1;margin-right:3rem;">
										@if($userData["userRoleId"] == 3)
											<label for="selectExpertise">Expertise</label>
										@else
											<label for="selectExpertise">Interests</label>
										@endif																		
										<select id="selectExpertise" name="selectExpertise" mutiple class="form-control form-control-user lw-user-gym-select-box" required="" style="width: 100%;border-color: white;">
										</select> 
									</div>
								</div>
								<input type="hidden" name="expertise_selected_list" id="expertise_selected_list" value="">

								<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="border-radius: 1rem;padding:13px 25px;">Save</button>
							</form>
						</div>
					</div>																									
				</div>
			@endif
		</div>
	</div>
</div>
<!-- basic info modal -->
<!-- post review modal -->
<div class="modal fade" id="lwPostReviewDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color: #191919;padding: 20px;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/border-radius: 24px; ">
			<div class="modal-header" style="border-bottom:none;">
				<h5 class="modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 27px;line-height: 37px;color: #FFFFFF;">
					@if($isReviewedUser)
					Edit review
					@else
					Post a review
					@endif
				</h5>
				<button type="button" style="color:#FFFFFF;margin-top: -20px; " class="close" data-dismiss="modal" aria-label="Close">
					<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body" style="color:#FFFFFF;">
				<form class="lw-ajax-form lw-form" id="lwPostReviewForm" method="post" data-callback="sendPostReviewCallback" action="<?= route('user.write.post_review', ['sendUserUId' => $userData['userUId']]); ?>">
					<div class="d-flex">
						<div class="p-1">
							<div class="position-relative" >
								<img style="width:220px;height:220px;border:3px solid #FF3F3F!important;border-radius:10px;padding:0px;" class="lw-profile-thumbnail lw-photoswipe-gallery-img lw-lazy-img"  data-src="<?= imageOrNoImageAvailable($userData['profilePicture']); ?>">
								<!-- <label style="
									position: absolute;
									left: 0;
									top: 0;
									padding: 3px 14px;
									color: white;
									background: #ff4141;
									border-top-left-radius: 10px;
									border-bottom-right-radius: 10px;
									font-size: 0.8rem;
									font-family: Nunito Sans;
									font-style: normal;
									font-weight: bold;
									font-size: 15px;
									line-height: 20px;
									text-align: center;
									color: #FFFFFF;
								">Matched</label> -->
							</div>
						</div>
						<div class="p-1 ml-1" style="width:100%">
							<div class="profile_header" >
								<?= __ifIsset($userData['kanji_name'], $userData['kanji_name'], '-'); ?>
							</div>
							<div class="mt-1">
								<div class="postreview-rating jq-stars" >
								</div>
								<span class="live-rating" style="margin-left: 10px; color: #FF3F3F; top: -3px; position: relative;"></span>
								<input type="hidden" name="review_rate_value" id="review_rate_value" value="0">
							</div>
							<div class="d-flex mt-2">
								<div class="form-group" style="flex:1;">
									<label for="desciption">Bio</label>
									<textarea class="form-control form-control-user" style="height:100%;" name="review_comment"></textarea>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="border-radius: 1rem;padding:13px 25px;">Post</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /post review modal -->

<!-- post photo modal -->
<div class="modal fade" id="lwPostPhotoDialog" tabindex="-1" role="dialog" aria-labelledby="userPhotoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color: #191919;padding: 20px;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/border-radius: 24px; ">
			<div class="modal-header" style="border-bottom:none;">
				<h5 class="modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 27px;line-height: 37px;color: #FFFFFF;">Post a photo</h5>
				<button type="button" style="color:#FFFFFF;margin-top: -20px; " class="close" data-dismiss="modal" aria-label="Close">
					<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body" style="color:#FFFFFF;">
				<form class="lw-ajax-form lw-form" data-show-message="true" id="lwPostPhotoForm" method="post" data-callback="sendPostPhotoCallback" action="<?= route('user.write.post_photo', ['sendUserUId' => $userData['userUId']]); ?>">
					<div class="d-flex row">

						<div class="profile-btn-container col-md-4 ">
							<input type="file" class="" id="postPhotoUploader" name="filepond" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
						</div>

						<div class="p-1 col-md-8" style="width:100%">
							<div class="d-flex">
								<div class="form-group" style="flex:1;">
									<label for="desciption">Description</label>
									<textarea class="form-control form-control-user" style="height:100%;" id="photo_comment" name="photo_comment" placeholder="Add a short description for the post..."></textarea>
								</div>
							</div>

							<div class="d-flex mt-3 pt-3">
								<div class="form-group" style="flex:1;">
									<label for="post_photo_user_tag">Tag</label>
									<select class="post_photo_user_tag selectize-item" style="width:100%;color:white;" id="post_photo_user_tag" ></select>
								</div>
							</div>
						</div>
						<input type ="hidden" name="post_tagged_users" id="post_tagged_users">																							
						<input type ="hidden" name="post_photo_blob" id="post_photo_blob">		

					</div>
					<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="border-radius: 1rem;padding:13px 25px;">Post</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
			</div>
			<div class="modal-body">

				<div class="cropper-example-container">
					<img id="cropper-example-image" alt="Picture">
				</div>
				<input type="hidden" name="upload_type" value="" id="upload_type">										
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="set_profile_image">Save</button>
			</div>
		</div>
	</div>
</div>

<!-- /post photo modal -->


<!-- view detail of photo modal -->
<div class="modal fade" id="lwViewDetailPhotoDialog" tabindex="-1" role="dialog" aria-labelledby="userPhotoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" style="background-color: #191919;padding: 20px;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/border-radius: 24px; ">
			<div class="modal-header" style="border-bottom:none;">
				<h5 class="d-none modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 27px;line-height: 37px;color: #FFFFFF;">Post a photo</h5>
				<button type="button" style="color:#FFFFFF;margin-top: -40px; margin-right:-40px; " class="close" data-dismiss="modal" aria-label="Close">
					<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body" style="color:#FFFFFF;margin-top:-10px;">
				<form class="lw-ajax-form lw-form" data-show-message="true" id="lwPostPhotoForm" method="post" data-callback="sendPostPhotoCallback" action="">
					<div class="d-flex row">

						<div class="p-2 mt-1" style="width:100%;">
							<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" style="position:relative;">
								<h5 style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 22px;line-height: 30px;/* identical to box height */color: #FF0000;"> 
									
								</h5>
							</div>

							<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" style="position:relative;">
								<div class="col d-flex photo_container">
									<div >
										<img class="lw-lazy-img photoowner_img" style="border-radius: 10px;width: 70px;height: 70px;" data-src="<?= imageOrNoImageAvailable($userData['profilePicture']); ?>">
									</div>
									<div class="p-2">
										<div class="photoowner_kanjiname" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 25px;line-height: 34px;text-align: center;color: #FFFFFF;"><?= __ifIsset($userData['kanji_name'], $userData['kanji_name'], '-'); ?></div>
										<div class="photo_ownerName" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 20px;line-height: 27px;color: #FFFFFF;">@<?= $userData['userName']?></div>
									</div>
									<div class="p-2" style="margin-left: auto;">
										<div class="d-none"><span class="match_following_badge_tag"> Following   </span></div>
										<div><span class="photo_created_date" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 15px;line-height: 20px;text-align: right;color: rgba(255, 255, 255, 0.7);"></span></div>
									</div>
								</div>
							</div>

							<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" style="position:relative;">
								<div class="col d-flex">
									<img class="photo_image" style="border-radius: 30px;width: 100%;height: 100%;" >
								</div>
							</div>
							<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" >
								<div class="col d-flex mt-2 p-1">
									<a class="lw-ajax-link-action likePhotoBtn" data-show-message="true" data-callback="onLikedFeedCallback" data-method="post" href="<?= route('user.feed.write.like', ['photoUid' => '0']) ?>"><i id="like_icon" class="ml-2 far fa-heart" style="font-size:32px;color:white;"></i></a> 
									<a class="ml-2 commentPhotoBtn" >
										<!-- <i id="comment_icon" class="ml-2 far fa-comment" style="font-size:32px;color:white;"></i> -->
										<svg width="32" height="32" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M19.0413 0.750056H19.9997L20.6171 0.788369C29.6238 1.53759 36.7461 8.8205 37.2499 18.0003L37.2499 18.9539C37.257 21.7855 36.5954 24.5788 35.3225 27.0988C32.2398 33.2668 25.9375 37.1643 19.0463 37.167C16.6867 37.1731 14.3536 36.7147 12.1787 35.823L11.6622 35.5992L8.6443 36.6987C5.76685 37.7463 2.59583 36.3534 1.39887 33.5769L1.27411 33.2628C0.805573 31.9759 0.811753 30.564 1.29154 29.2813L2.39509 26.3263L2.17704 25.8213C1.37444 23.864 0.922875 21.779 0.845069 19.6639L0.833008 18.9579C0.835676 12.0625 4.73317 5.76017 10.8939 2.68117C13.4212 1.40461 16.2145 0.742975 19.0413 0.750056ZM19.9166 4.58177L19.0365 4.58341C16.8084 4.57783 14.6107 5.09842 12.6149 6.10648C7.74542 8.54015 4.66845 13.5157 4.66633 18.9637C4.66053 21.1915 5.18104 23.3893 6.18549 25.3779C6.42674 25.8555 6.45734 26.4123 6.26988 26.9135L4.88194 30.6242C4.72202 31.0518 4.71996 31.5225 4.87613 31.9514C5.23828 32.9461 6.33819 33.4589 7.33286 33.0967L11.1023 31.7243C11.5996 31.5433 12.1497 31.5759 12.6221 31.8145C14.6107 32.819 16.8085 33.3395 19.0406 33.3337C24.4843 33.3316 29.4599 30.2546 31.8972 25.3779C32.9016 23.3894 33.4222 21.1916 33.4166 18.9587L33.4195 18.106C33.0172 10.817 27.2026 4.99532 19.9166 4.58177ZM19.9166 4.58177L19.9192 4.58176L19.894 4.5805L19.9166 4.58177ZM10.4163 15.1671C10.4163 14.6148 10.8641 14.1671 11.4163 14.1671H26.6663C27.2186 14.1671 27.6663 14.6148 27.6663 15.1671V17.0004C27.6663 17.5527 27.2186 18.0004 26.6663 18.0004H11.4163C10.8641 18.0004 10.4163 17.5527 10.4163 17.0004V15.1671ZM15.2497 21.8338C14.6974 21.8338 14.2497 22.2815 14.2497 22.8338V24.6671C14.2497 25.2194 14.6974 25.6671 15.2497 25.6671H22.833C23.3853 25.6671 23.833 25.2194 23.833 24.6671V22.8338C23.833 22.2815 23.3853 21.8338 22.833 21.8338H15.2497Z" fill="white"/>
										</svg>
									</a> 

									<i class="d-none ml-2 far fa-comments" style="font-size:32px;color:white;"></i> 
									<a class="lw-ajax-link-action taggedPhotoBtn" id="tagged_icon" style="margin-left:auto;" data-show-message="true" data-callback="onTaggedFeedCallback" data-method="post" href="<?= route('user.feed.write.tagged', ['photoUid' => '0']) ?>"><i id="" class="ml-2 fa fa-thumbtack" style="font-size:32px;color:white;"></i></a> 
								</div>

								<div class="col d-flex mt-2 p-1">
									<span class="photo_ownerName" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 20px;line-height: 27px;color: #FFFFFF;">@<?= $userData["userName"] ?></span>
									<span class="ml-3 user_photo_comment" style="word-break: break-all;font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 20px;line-height: 27px;color: #FFFFFF;"></span>
									<!-- <div class="d-flex mb-2 pt_availablity_logo_div" style="justify-content: start;padding-left:15px;margin-left:auto;height:30px;padding:15px;"> 
										<div class="" style="margin:3px;">
											<img class="" style="width: 55px;height: 22px;" src="/media-storage/pt/anytime_logo.png">       
										</div>
									</div> -->
								</div>
								<div class="col d-flex p-1">
									<div class="" id="accordion" style="width:100%;">
										<div class="" id="headingAllComments" style="border:none;display:none;">
											<h6 class="mb-0">
												<a class="btn comment_view_btn" style="padding:0;" data-toggle="collapse" onclick="toggleViewComments(this)" href="#collapseAllComments" aria-expanded="false" aria-controls="collapseAllComments" data-toggle="collapse" data-target="#collapseAllComments" aria-expanded="false" aria-controls="collapseAllComments">
													<span style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 17px;line-height: 23px;color: #FFFFFF;margin-right:1rem;">View all comments</span>
													<i class="fas fa-chevron-right"></i>
												</a>
											</h6>
										</div>
										<div id="collapseAllComments" class="collapse" aria-labelledby="headingAllComments" data-parent="#accordion">
											<div class="photo_comments_container" style="max-height:5vw;overflow-y:auto;">

											</div>
										</div>
									</div>
									
								</div>
							</div>

						</div>

					</div>
					<button type="submit" class="d-none lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="border-radius: 1rem;padding:13px 25px;">Post</button>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="lwFeedCommentDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color: #191919;padding: 20px;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/border-radius: 24px; ">
			
			<div class="modal-header" style="border-bottom:none;display:none;">
				<h5 class="modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 27px;line-height: 37px;color: #FFFFFF;">
					Comment
				</h5>
				<button type="button" style="color:#FFFFFF;margin-top: -20px; " class="close" data-dismiss="modal" aria-label="Close">
					<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body" style="color:#FFFFFF;">
                <form class="user lw-ajax-form lw-form" data-show-message="true" method="post" action="<?= route("user.feed.write.comment") ?>" data-callback="onCommentFeedCallback">
                    <div class="d-flex">
                        <div class="p-1">
                            <div class="position-relative">
                                <img style="width:10rem;height:10rem;border:3px solid #FFFFFF!important;border-radius:10px;padding:0px;box-sizing: border-box;" class="lw-profile-thumbnail lw-photoswipe-gallery-img lw-lazy-img" id="lwPhotoStaticImage" src="">
                            </div>
                        </div>
                        <input type="hidden" name="post_photo_uid" id="post_photo_uid" value="">
                        <div class="p-1 ml-1" style="width:100%">
                            <div class="d-flex mt-2">
                                <div class="form-group" style="flex:1;">
                                    <label for="post_photo_comment">Your Comment for this photo</label>
                                    <textarea class="form-control form-control-user" name="comment" id="post_photo_comment" style="height:100%;" placeholder="Add a short message..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;">Post</button>
                </form>
            </div>
		</div>
	</div>
</div>
@include('modals.chat_unavailable')
@include('modals.follow_remind')
@include('modals.report')

@endif
<!-- /if user block then don't show profile page content -->

@push('appScripts')
<script src="{{ asset('dist/flatpicker/flatpickr.js') }}"></script>
<script src="{{ asset('dist/cropper/cropper.js') }}"></script>
@if(getStoreSettings('allow_google_map'))
<script src="https://maps.googleapis.com/maps/api/js?key=<?= getStoreSettings('google_map_key'); ?>&libraries=places&callback=initialize&language=en" async defer></script>
@endif
<script>
	// Post review with star rating
	$(".postreview-rating").starRating({
		initialRating: 0,
		strokeColor: '#FF3F3F',
		strokeWidth: 10,
		starSize: 24,
		disableAfterRate: false,
		onHover: function(currentIndex, currentRating, $el){
			console.log('index: ', currentIndex, 'currentRating: ', currentRating, ' DOM element ', $el);
			$('.live-rating').text(currentIndex);
		},
		onLeave: function(currentIndex, currentRating, $el){
			console.log('index: ', currentIndex, 'currentRating: ', currentRating, ' DOM element ', $el);
			$('.live-rating').text(currentRating);
		},
		//starShape: 'rounded',
		useFullStars: true,
		totalStars: 5,
		emptyColor: 'white',
		hoverColor: '#FF3F3F',
		activeColor: '#FF3F3F',
		useGradient: false,
		// minRating: 2,
		callback: function(currentRating, $el){
			//alert('rated ' +  currentRating);
			console.log('DOM Element ', $el);
			$("#review_rate_value").val(currentRating);
		},
	});

	$(".review-rating").starRating({
		strokeColor: '#FF3F3F',
		strokeWidth: 0,
		readOnly:true,
		starSize: 16,
		disableAfterRate: false,
		useFullStars: true,
		totalStars: 5,
		emptyColor: 'white',
		hoverColor: '#FF3F3F',
		activeColor: '#FF3F3F',
		useGradient: false,
	});

	$(".review-rating-1").starRating({
		strokeColor: '#FF3F3F',
		strokeWidth: 0,
		readOnly:true,
		starSize: 16,
		disableAfterRate: false,
		useFullStars: true,
		totalStars: 1,
		emptyColor: 'white',
		hoverColor: '#FF3F3F',
		activeColor: '#FF3F3F',
		useGradient: false,
	});

	//start show more gift item if user gift length is greater then 10
	var userGiftLength = $("#lwUserGift, .lw-user-gift-container").length;

	$("#showMoreGiftBtn").hide();
	$("#showLessGiftBtn").hide();
	//check gift length is greater than 10
	if (userGiftLength > 8) {
		$("#showMoreGiftBtn").show();
		$('.lw-user-gift-container').hide();
		$('.lw-user-gift-container:lt(8)').show();

		//on click show more gift show all remaining gifts
		$("#showMoreGiftBtn").on('click', function() {
			$('.lw-user-gift-container:lt(' + userGiftLength + ')').show();
			$("#showMoreGiftBtn").hide();
			$("#showLessGiftBtn").show();
		});

		//on click show less gift show only 10 gifts
		$("#showLessGiftBtn").on('click', function() {
			$('.lw-user-gift-container').hide();
			$('.lw-user-gift-container:lt(8)').show();
			$("#showMoreGiftBtn").show();
			$("#showLessGiftBtn").hide();
		});
	}
	//end show more gift item if user gift length is greater then 10


	// Get user profile data
	function getUserProfileData(response) {
		$('#lwBasicProfileDialog').modal('hide');
		// If successfully stored data
		if (response.reaction == 1) {
			__DataRequest.get("<?= route('user.get_profile_data'); ?>", {}, function(responseData) {
				var requestData = responseData.data;
				var specificationUpdateData = [];
				_.forEach(requestData.userSpecificationData, function(specification) {
					_.forEach(specification['items'], function(item) {
						specificationUpdateData[item.name] = item.value;
					});
				});
				__DataRequest.updateModels('userData', requestData.userData);
				__DataRequest.updateModels('profileData', requestData.userProfileData);
				__DataRequest.updateModels('specificationData', specificationUpdateData);
				__DataRequest.updateModels('userAvailability', requestData.userAvailability);


				$('.pt_availablity_logo_div').html('');
				$(".pt_user_gym_container").html('');
				_.forEach(requestData.userGymsData, function(gym) {
					$('.pt_availablity_logo_div').append(`
						<div class="" style="margin:3px;">
							<img class="" style="width: 32px;height: 32px;border-radius:50%;" src="` + gym.userGymLogoUrl + `">       
						</div>
					`);
					$(".pt_user_gym_container").append(`
						<div class="row mb-2" style="flex-wrap:nowrap;background: #1E1E1E;border-radius: 10px;">
							<div class="">
								<img style="width: 65px; height: 65px; border: none; border-radius: 10px; padding: 5px;object-fit: contain;background:white;" class="lw-photoswipe-gallery-img lw-lazy-img" src="`+ gym.userGymLogoUrl+`">
							</div>
							<div class="" style="padding-left: 1.2rem;justify-content: center;align-content: center;align-items: center;align-self: center;">
								<span style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 15px;line-height: 21px;" class="row"> ` + gym.gymName + ` </span>
								<span class="row d-none" style="font-size: 11px;"> <i class="fas fa-map-marker-alt"></i> &nbsp;Minato-ku</span>
								<span class="row d-none" style="font-size: 11px;"> <i class="fas fa-map-marker-alt"></i> &nbsp;Shibuya-ku</span>
							</div>
						</div>
					`);
				});

				$('.expertise_items_container').html('');
				_.forEach(requestData.userExpertiseData, function(exp) {
					$('.expertise_items_container').append(`
						<span class="pt_category_tag_item"> `+ exp.expertiseTitle +` </span>
					`);
				});

				refineShowExpertise();
			});
		}
	}

	/**************** User Like Dislike Fetch and Callback Block Start ******************/
	//add disabled anchor tag class on click
	$(".lw-like-action-btn, .lw-dislike-action-btn").on('click', function() {
		$('.lw-like-dislike-box').addClass("lw-disable-anchor-tag");
	});
	//on like Callback function
	function onLikeCallback(response) {
		var requestData = response.data;
		// enable or disable message & gift button
		var mutual = requestData.mutual;
		console.log(mutual, 'mutual');
		if (mutual == 1) {
			$('.lwMessageChatButton').removeClass('lw-disable-anchor-tag');
			$('.lwGiftButton').removeClass('lw-disable-anchor-tag');
			console.log('remove class');
		} else {
			$('.lwMessageChatButton').addClass('lw-disable-anchor-tag');
			$('.lwGiftButton').addClass('lw-disable-anchor-tag');
			console.log('add class');
		}
		//check reaction code is 1 and status created or updated and like status is 1
		if (response.reaction == 1 && requestData.likeStatus == 1 && (requestData.status == "created" || requestData.status == 'updated')) {
			__DataRequest.updateModels({
				'userLikeStatus': '<?= __tr('Following'); ?>', //user liked status
				'userDislikeStatus': '<?= __tr('Dislike'); ?>', //user dislike status
			});
			//add class
			$(".lw-animated-like-heart").toggleClass("lw-is-active");
			//check if updated then remove class in dislike heart
			if (requestData.status == 'updated') {
				$(".lw-animated-broken-heart").toggleClass("lw-is-active");
			}
			$(".lwRemoveFollowUserBtn").removeClass("disabled");
			$(".lwRemoveFollowUserContainer").show();

		}
		//check reaction code is 1 and status created or updated and like status is 2
		if (response.reaction == 1 && requestData.likeStatus == 2 && (requestData.status == "created" || requestData.status == 'updaetd')) {
			__DataRequest.updateModels({
				'userLikeStatus': '<?= __tr('Follow'); ?>', //user like status
				'userDislikeStatus': '<?= __tr('Disliked'); ?>', //user disliked status
			});
			//add class
			$(".lw-animated-broken-heart").toggleClass("lw-is-active");
			//check if updated then remove class in like heart
			if (requestData.status == 'updated') {
				$(".lw-animated-like-heart").toggleClass("lw-is-active");
			}
			$(".lwRemoveFollowUserBtn").addClass("disabled");
			$(".lwRemoveFollowUserContainer").hide();
		}
		//check reaction code is 1 and status deleted and like status is 1
		if (response.reaction == 1 && requestData.likeStatus == 1 && requestData.status == "deleted") {
			__DataRequest.updateModels({
				'userLikeStatus': '<?= __tr('Follow'); ?>', //user like status
			});
			$(".lw-animated-like-heart").toggleClass("lw-is-active");
			$(".lwRemoveFollowUserBtn").addClass("disabled");
			$(".lwRemoveFollowUserContainer").hide();
		}
		//check reaction code is 1 and status deleted and like status is 2
		if (response.reaction == 1 && requestData.likeStatus == 2 && requestData.status == "deleted") {
			__DataRequest.updateModels({
				'userDislikeStatus': '<?= __tr('Dislike'); ?>', //user like status
			});
			$(".lw-animated-broken-heart").toggleClass("lw-is-active");
			$(".lwRemoveFollowUserBtn").addClass("disabled");
			$(".lwRemoveFollowUserContainer").hide();
		}
		//remove disabled anchor tag class
		_.delay(function() {
			$('.lw-like-dislike-box').removeClass("lw-disable-anchor-tag");
		}, 1000);

	}
	/**************** User Like Dislike Fetch and Callback Block End ******************/

	$(".profile_edit_icon").on('click', function() {
		let selected_tab = $(this).data("activetab");
		//$("#lwBasicProfileDialog .tab-content>.tab-pane").removeClass("active").removeClass("show");
		//$("#"+selected_tab).addClass("active").addClass('show');
		$("#"+selected_tab).trigger('click');
	});

	function onDeletePhotoCallback(responseData) {
        if (responseData.reaction == 1) {
            //remove value from array
			
			$(".photo_posting_item_" + responseData.data.photoUid).remove();
			_.delay(function() {
				//__Utils.viewReload();
				getPhotosAllData();
			}, 1000)

        }
    }
	
	//send gift callback
	function sendGiftCallback(response) {
		//check success reaction is 1
		if (response.reaction == 1) {
			var requestData = response.data;
			//form reset after success
			$("#lwSendGiftForm").trigger("reset");
			//remove active class after success on select gift radio option
			$("#lwSendGiftRadioBtn_" + requestData.giftUid).removeClass('active');
			//close dialog after success
			$('#lwSendGiftDialog').modal('hide');
			//reload view after 2 seconds on success reaction
			_.delay(function() {
				__Utils.viewReload();
			}, 1000)
			//if error type is insufficient balance then show error message
		} else if (response.data['errorType'] == 'insufficient_balance') {
			//show error div
			$("#lwGiftModalErrorText").show();
		} else {
			//hide error div
			$("#lwGiftModalErrorText").hide();
		}
	}

	//close Send Gift Dialog
	$("#lwCloseSendGiftDialog").on('click', function(e) {
		e.preventDefault();
		//form reset after success
		$("#lwSendGiftForm").trigger("reset");
		//close dialog after success
		$('#lwSendGiftDialog').modal('hide');
	});


	function sendPostReviewCallback(responseData) {  
		if(responseData.reaction == 1){
		// 	$(".profile_reviews_container").append(
		// 		`<div class="profile_review_item mb-2">
		// 			<div class="profile_review_header" style="display:flex;">
		// 				<div class="review_image">
		// 					<img class="lw-profile-thumbnail lw-lazy-img" style="width: 50px;height: 50px;border-radius: 10px;" data-src="<?= imageOrNoImageAvailable(getUserAuthInfo('profile.profile_picture_url')); ?>" src="<?= imageOrNoImageAvailable(getUserAuthInfo('profile.profile_picture_url')); ?>">								
		// 				</div>
		// 				<div class="profile_review_name"  style="padding-left: 5px;">
		// 					<div class="profile_review_username">
		// 						<? getUserAuthInfo('profile.username') ?>					
		// 					</div>
		// 					<div class="profile_review_star_rate">
		// 						<div class="review-rating jq-stars" data-rating="`+responseData.data.rate_value+`">
		// 						</div>
		// 					</div>								
		// 				</div>
		// 				<div class="profile_review_type_badge">
		// 					<? getUserAuthInfo('profile.role')?>								
		// 				</div>
		// 			</div>
		// 			<div class="profile_review_content">
		// 				`+responseData.data.review_comment+`	
		// 			</div>
		// 		</div>	`
		// 	);
		// }
		
		// $(".review-rating").starRating({
		// 	strokeColor: '#FF3F3F',
		// 	strokeWidth: 0,
		// 	readOnly:true,
		// 	starSize: 16,
		// 	disableAfterRate: false,
		// 	useFullStars: true,
		// 	totalStars: 5,
		// 	emptyColor: 'white',
		// 	hoverColor: '#FF3F3F',
		// 	activeColor: '#FF3F3F',
		// 	useGradient: false,
		// });

		// $('#lwPostReviewDialog').modal('hide');

		__Utils.viewReload();
		}
	}

	// close basic information modal
	$('#lwCloseUserBasicInformationDialog').on('click', function(e) {
		e.preventDefault();
		$('#lwBasicInformationDialog').modal('hide');
	});

	// Click on edit / close button 
	$('#lwEditAvailability, #lwCloseAvailability').click(function(e) {
		e.preventDefault();
		showHideAvailabilityContainer();
	});

	function showHideAvailabilityContainer() {
		$('#lwCloseAvailability').toggle();
		$('#lwEditAvailability').toggle();
		$('#lwStaticAvailability').toggle();
		
		//$('#lwAvailabilityForm').toggle();
		$('#lwAvailabilityForm input').each(function() {
			$(this).prop('disabled', function (_, val) { return ! val; });
		});

	}
	// Click on edit / close button 
	$('#lwEditBasicInformation, #lwCloseBasicInfoEditBlock').click(function(e) {
		e.preventDefault();
		showHideBasicInfoContainer();
	});
	// Show / Hide basic information container
	function showHideBasicInfoContainer() {
		$('#lwUserBasicInformationForm').toggle();
		$('#lwStaticBasicInformation').toggle();
		$('#lwCloseBasicInfoEditBlock').toggle();
		$('#lwEditBasicInformation').toggle();
	}
	// Show hide specification user settings
	function showHideSpecificationUser(formId, event) {
		event.preventDefault();
		$('#lwEdit' + formId).toggle();
		$('#lw' + formId + 'StaticContainer').toggle();
		$('#lwUser' + formId + 'Form').toggle();
		$('#lwClose' + formId + 'Block').toggle();
	}
	// Click on profile and cover container edit / close button 
	$('#lwEditProfileAndCoverPhoto, #lwCloseProfileAndCoverBlock').click(function(e) {
		e.preventDefault();
		// original style
		showHideProfileAndCoverPhotoContainer();

	});
	// Hide / show profile and cover photo container
	function showHideProfileAndCoverPhotoContainer() {
		$('#lwProfileAndCoverStaticBlock').toggle();
		$('#lwProfileAndCoverEditBlock').toggle();
		$('#lwEditProfileAndCoverPhoto').toggle();
		$('#lwCloseProfileAndCoverBlock').toggle();
	}
	// After successfully upload profile picture
	function afterUploadedProfilePicture(responseData) {
		$('#lwProfilePictureStaticImage, .lw-profile-thumbnail').attr('src', responseData.data.image_url);
	}
	// After successfully upload Cover photo
	function afterUploadedCoverPhoto(responseData) {
		$('#lwCoverPhotoStaticImage').attr('src', responseData.data.image_url);
	}

	var maxItemCount = 1;
	@if($userData["userRoleId"] == 3)
		maxItemCount  = 3;
	@endif

	var gymListData = JSON.parse(`<?= json_encode($gymListData)?>`);
    var gymUserdata = JSON.parse(`<?= json_encode($userGymsData)?>`);

	var selected_items = [];
	$.each(gymUserdata, function( i, obj) {
		selected_items.push(obj.gymId);
	});

	$(document).ready(function(){
		var $selectGym = $('#selectGym').selectize({
			plugins: ['restore_on_backspace', 'remove_button'],
			valueField: '_id',
			labelField: 'name',
			searchField: [
				'name'
			],
			items: selected_items,
			options: gymListData,
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
			},

			onInitialize: function(){
				var selectize = this;
				// $.get("/api/selected_cities.php", function( data ) {
				// 	selectize.addOption(data); // This is will add to option
				// 	var selected_items = [];
				// 	$.each(data, function( i, obj) {
				// 		selected_items.push(obj.id);
				// 	});
				// 	selectize.setValue(selected_items); //this will set option values as default
				// });
			}

		});

		// var selectize = $selectGym[0].selectize;
		// selectize.addOption([{text: "puja", value: "puja"}, {text: "raxit", value: "raxit"},]);
		// selectize.setValue(['puja','raxit']);
		// selectize.setValue(gymUserdata);
		// selectize.refreshOptions();

		var expertiseListData = JSON.parse(`<?= json_encode($expertiseListData)?>`);
		var expertiseUserdata = JSON.parse(`<?= json_encode($userExpertiseData)?>`);

		selected_items = [];
		$.each(expertiseUserdata, function( i, obj) {
			selected_items.push(obj.expertiseId);
		});

		var $selectExpertise = $('#selectExpertise').selectize({
			plugins: ['restore_on_backspace', 'remove_button'],
			valueField: '_id',
			labelField: 'title',
			searchField: [
				'title'
			],
			items: selected_items,
			options: expertiseListData,
			create: false,
			// loadThrottle: 2000,
			maxItems: null,
			render: {
				option: function(item, escape) {
					return '<div><span class="title"><span class="name">' + escape(item.title) + '</span></span></div>';
				}
			},
			load: function(query, callback) {
				if (!query.length || (query.length < 2)) {
					return callback([]);
				} else {
					__DataRequest.post("<?= route('user.read.search_static_expertise'); ?>", {
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
				$("#expertise_selected_list").val(value);
			},

			onInitialize: function(){
				var selectize = this;
				// $.get("/api/selected_cities.php", function( data ) {
				// 	selectize.addOption(data); // This is will add to option
				// 	var selected_items = [];
				// 	$.each(data, function( i, obj) {
				// 		selected_items.push(obj.id);
				// 	});
				// 	selectize.setValue(selected_items); //this will set option values as default
				// });
			}

		});

	});
   
	$('#addPricingItem').click(function(){
		var sessionType = $("#pt_pricing_session").val();
		var price = $("#pt_pricing_price").val();

		if( !sessionType || !price) {
			return;
		}

		__DataRequest.post("<?= route('user.write.store_session_data'); ?>", {
			'session_type': sessionType,
			'price'    : price
		}, function(responseData) {
			if (responseData.reaction == 1) {
				$("#pt_pricing_price").val('');
				//$("#pt_pricing_session").val('');

				$(".pt_pricing_container").html("");
				$(".pt_pricing_header_container").html("");
				_.forEach(responseData.data.stored_session_list, function(item) {
					$(".pt_pricing_container").append(
						`<div class="d-flex position-relative">
							<div class="form-group" style="flex:1;margin-right: 3rem;">
								<label for="session_type">Session</label>
								<input type="text" class="form-control form-control-user" name="session_type" value="`+item.session+`">
							</div>
							<div class="form-group" style="flex:1;margin-right:3rem;">
								<label for="pricing">Pricing</label>
								<input type="text" class="form-control form-control-user" name="pricing" value="`+Math.floor(item.price)+`">
							</div>
							<a class="removePricingItemBtn" href="javascript:removePricingItem('`+item._uid+`');"><i class="fa fa-close" style="color:white;position: absolute;right: 0.25rem;top: 35px;padding: 0.75rem;background: #FF3F3F;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 10px;"></i></a>
						</div>
					`);

					$(".pt_pricing_header_container").append(
						`
						<div class="row">
							<div class="pt_pricing_time"> `+item.session+` </div>
							<div class="pt_pricing_inquire_container">
								<span class="price"> ￥`+parseFloat(item.price)+` </span>
								<span class="d-none inquire_span"><button class="inquire_btn" role="button" onclick="showInquireModal('<?= $userData['profilePicture'] ?>', '<?= $userData['kanji_name']?>', '<?= $userProfileData['city']?>', '`+item._id+`', '`+item.price+`', '`+item.session+`', '<?= $userData['userId'] ?>', '<?= getTotalRateUser($userData['userId']) ?>' )" > Inquire </button></span>
							</div>
						</div>
					`);

				});

				if( responseData.data.stored_session_list.length == <?= count(getPricingTypeList())?>) {
					$("#pt_pricing_adding_container").hide();
				}
			}
		});
	});

	function removePricingItem( item_uid ){
		__DataRequest.post("<?= route('user.write.delete_session_data'); ?>", { // delete_session_data
			'item_uid'    : item_uid
		}, function(responseData) {
			if (responseData.reaction == 1) {
				$(".pt_pricing_container").html("");
				_.forEach(responseData.data.stored_session_list, function(item) {
					$(".pt_pricing_container").append(
						`<div class="d-flex position-relative">
							<div class="form-group" style="flex:1;margin-right: 3rem;">
								<label for="session_type">Session</label>
								<input type="text" class="form-control form-control-user" name="session_type" value="`+item.session+`">
							</div>
							<div class="form-group" style="flex:1;margin-right:3rem;">
								<label for="pricing">Pricing</label>
								<input type="text" class="form-control form-control-user" name="pricing" value="`+Math.floor(item.price)+`">
							</div>
							<a class="removePricingItemBtn" href="javascript:removePricingItem('`+item._uid+`');"><i class="fa fa-close" style="color:white;position: absolute;right: 0.25rem;top: 35px;padding: 0.75rem;background: #FF3F3F;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 10px;"></i></a>
						</div>
					`);
				});

				$(".pt_pricing_header_container").html("");
				_.forEach(responseData.data.stored_session_list, function(item) {
					$(".pt_pricing_header_container").append(
						`
						<div class="row">
							<div class="pt_pricing_time"> `+item.session+` </div>
							<div class="pt_pricing_inquire_container">
								<span class="price"> ￥`+parseFloat(item.price)+` </span>
								<span class="d-none inquire_span"><button class="inquire_btn" role="button" onclick="showInquireModal('<?= $userData['profilePicture'] ?>', '<?= $userData['kanji_name']?>', '<?= $userProfileData['city']?>', '`+item._id+`', '`+item.price+`', '`+item.session+`', '<?= $userData['userId'] ?>', '<?= getTotalRateUser($userData['userId']) ?>' )" > Inquire </button></span>
							</div>
						</div>
					`);
				});
				$("#pt_pricing_adding_container").show();
			}
		});
	}
	


</script>
<script>
	// Click on edit / close button 
	$('#lwEditUserLocation, #lwCloseLocationBlock').click(function(e) {
		e.preventDefault();
		showHideLocationContainer();
	});
	// Show hide location container
	function showHideLocationContainer() {
		$('#lwUserStaticLocation').toggle();
		$('#lwUserEditableLocation').toggle();
		$('#lwEditUserLocation').toggle();
		$('#lwCloseLocationBlock').toggle();
	}

	function initialize() {
		@if(getStoreSettings('allow_google_map'))
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
		@endif
	}

	function setLocationCoordinates(key, lat, lng, placeData) { 
		__DataRequest.post("<?= route('user.write.location_data'); ?>", {
			'latitude': lat,
			'longitude': lng,
			'placeData': placeData.address_components,
			'formatted_address' : placeData.formatted_address,
		}, function(responseData) {
			var requestData = responseData.data;
			//check reaction code is not 1
			if (responseData.reaction != 1) {
				$("#lwShowLocationErrorMessage").show();
				__DataRequest.updateModels({
					'locationErrorMessage': requestData.message
				});
				return false;
			}
			//check reaction code is 1
			if (responseData.reaction == 1) {
				$("#lwShowLocationErrorMessage").hide();
				showHideLocationContainer();
				__DataRequest.updateModels('profileData', {
					city: requestData.city,
					country_name: requestData.country_name,
					latitude: lat,
					longitude: lng
				});
			}

			var mapSrc = "https://maps.google.com/maps/place?q=" + lat + "," + lng + "&output=embed";
			$('#gmap_canvas').attr('src', mapSrc)
		});
	};
	@if(!getStoreSettings('allow_google_map') and getStoreSettings('use_static_city_data'))
	var $selectLocationCity = $('#selectLocationCity').selectize({
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
			if (!value.length) {
				return;
			};
			__DataRequest.post("<?= route('user.write.store_city'); ?>", {
				'selected_city_id': value
			}, function(responseData) {
				if (responseData.reaction == 1) {
					__Utils.viewReload();
				}
			});
		}
	});

	var selectLocationCityControl = $selectLocationCity[0].selectize;
	selectLocationCityControl.clear(true);
	selectLocationCityControl.clearOptions(true);

	// leaflet map
	var leafletMap = L.map('staticMapId').setView(["<?= $latitude; ?>", "<?= $longitude; ?>"], 13);
	L.tileLayer(
		'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, '
		}
	).addTo(leafletMap);
	// add marker
	L.marker(["<?= $latitude; ?>", "<?= $longitude; ?>"]).addTo(leafletMap);
	@endif
</script>
<script>
	@if(!$isOwnProfile)
		$(".lwCopyProfileUrlBtn").click(function(){
			navigator.clipboard.writeText("<?= route('user.profile_view', ['username' => $userData['userName']]) ?>");
		});
	@endif
</script>
<script>
	
		// croper js 
		var cropped_image = '';
		var URL = window.URL || window.webkitURL;
		var $image = $('#cropper-example-image');
		var options = {
			aspectRatio: 16 / 16,
			preview: '.cropper-example-preview',
			viewMode: 2, //  0 ~ 3
			dragMode: 'move',
			autoCropArea: 1.0,
			center:true,
			left: 0,
        	top: 0,

			zoom: 0.2,
			autoCrop: true, 
			background: false,
			modal: true,
			zoomable: true,
			responsive: false, 
			//aspectRatio: 1 / 1,
			strict: true,
			guides: false,
			movable: true,
			highlight: true,
			dragCrop: false,
			cropBoxResizable: true,
			data: { width: 160, height: 160 },
			autoCropArea: 0,
			minWidth: 160,
			minHeight: 160,
			maxWidth: 320,
			maxHeight: 320,

			minCanvasWidth:320,
			minCanvasHeight:320,
			minCropBoxWidth:160,
			minCropBoxHeight:160,
			
			ready: function (event) {

				$(this).cropper('setData', { 
				width:  160,
				height: 160
				});

			},
			//guides: false,
			//cropBoxResizable: false,
			//cropBoxMovable: false,
			//viewMode: 3,
			//width: canvasSize.width,
			//height: canvasSize.height,
			//aspectRatio: 1,
			toggleDragModeOnDblclick: false,
			zoomOnTouch: true,
			zoomOnWheel: true,
			
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

		
FilePond.registerPlugin(
//  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
 // FilePondPluginImageCrop,
 // FilePondPluginImageResize,
 // FilePondPluginImageTransform,
 // FilePondPluginImageEdit
);

	var photoPond =	FilePond.create( document.querySelector('#postPhotoUploader'), {
                    allowDrop: true,
                    allowImagePreview: true,
                    allowRevert: true,

					allowMultiple: false,
        			allowProcess: false,

					labelIdle: `<div class="row" style="flex-direction: column;">
							<div class="d-flex" style="align-self: center;">
								<img src="imgs/dummy_img.png" style="width:3vw;">
							</div>	
							<div class="d-flex" style="align-self: center;">
								<label style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 14px;line-height: 24px;color: #888888;"> Drag and drop your image </label>
							</div>																												
						</div>`,
					//imagePreviewHeight: 170,
					imageCropAspectRatio: '1:1',
					imageResizeTargetWidth: 200,
					imageResizeTargetHeight: 200,
					stylePanelLayout: 'compact',  // Can be either 'integrated', 'compact', and/or 'circle'
					stylePanelAspectRatio : "1:1",
					styleLoadIndicatorPosition: 'center bottom',
					styleProgressIndicatorPosition: 'right bottom',
					styleButtonRemoveItemPosition: 'left bottom',
					styleButtonProcessItemPosition: 'right bottom',
					
					removeMedia:false,
					instantUpload:false,
					styleProcessItemPosition : "right bottom",

                    server: {
                        process: {
                            url: '<?= route('user.upload_profile_image'); ?>',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': appConfig.csrf_token
                            },
                            withCredentials: false,
                            onload: function (response) {
                                var responseData = JSON.parse(response);
                                var requestData = responseData.data;
                                var storedData = requestData.storedData;

                                if (responseData.reaction == 1) {
									
                                } else {

                                    showErrorMessage(requestData.message);
                                }
                            },
                            ondata: function (formData) {
                                formData.append('type', 2);
                                formData.append('unique_id', '');
                                return formData;
                            }
                        }
                    },
                    onaddfilestart: function (file) {


                    },
                    onprocessfile: function (error, file) {
                        pond.removeFile(file.id);
                    },
					oninitfile : function(fileobj) {
							console.log(fileobj)
							

					},
					onupdatefiles : function(files) {
						console.log(files);

						if(!files.length) return;

						var file = files[0].file;

						if (URL) {
								
								if (!$image.data('cropper')) {
									return;
								}
								if (/^image\/\w+$/.test(file.type)) {
									if (uploadedImageURL) {
										URL.revokeObjectURL(uploadedImageURL);
									}
									uploadedImageURL = URL.createObjectURL(file);
									$image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
									$('#photoModal').modal('show');
									$("#upload_type").val('');
								} else {
									window.alert('Please choose an image file.');
								}
								
						} else {
							$inputImage.prop('disabled', true).parent().addClass('disabled');
						}

					}
                });

	

</script>
<script>

	var pondProfile = FilePond.create( document.querySelector('#lwProfileImageUploader'), {
                    allowDrop: true,
                    allowImagePreview: true,
                    allowRevert: false,

					allowMultiple: false,
        			allowProcess: false,

					labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
					imagePreviewHeight: 170,
					imageCropAspectRatio: '1:1',
					imageResizeTargetWidth: 200,
					imageResizeTargetHeight: 200,
					stylePanelLayout: 'compact circle',
					styleLoadIndicatorPosition: 'center bottom',
					styleProgressIndicatorPosition: 'right bottom',
					styleButtonRemoveItemPosition: 'left bottom',
					styleButtonProcessItemPosition: 'right bottom',
					
					removeMedia:true,
					instantUpload:false,
					styleProcessItemPosition : "right bottom",
					callback : "afterUploadedProfilePicture",

                    server: {
                        process: {
                            url: '<?= route('user.upload_profile_image'); ?>',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': appConfig.csrf_token
                            },
                            withCredentials: false,
                            onload: function (response) {
                                var responseData = JSON.parse(response);
                                var requestData = responseData.data;
                                var storedData = requestData.storedData;

                                if (responseData.reaction == 1) {
									
                                } else {

                                    showErrorMessage(requestData.message);
                                }
                            },
                            ondata: function (formData) {
                                formData.append('type', 2);
                                formData.append('unique_id', '');
                                return formData;
                            }
                        }
                    },
                    onaddfilestart: function (file) {


                    },
                    onprocessfile: function (error, file) {
                        pond.removeFile(file.id);
                    },
					oninitfile : function(fileobj) {
							console.log(fileobj)
							

					},
					onupdatefiles : function(files) {
						console.log(files);

						if(!files.length) return;

						var file = files[0].file;

						if (URL) {
								
								if (!$image.data('cropper')) {
									return;
								}
								if (/^image\/\w+$/.test(file.type)) {
									if (uploadedImageURL) {
										URL.revokeObjectURL(uploadedImageURL);
									}
									uploadedImageURL = URL.createObjectURL(file);
									$image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
									$('#photoModal').modal('show');
									$("#upload_type").val('profile');
								} else {
									window.alert('Please choose an image file.');
								}
								
								
						} else {
							$inputImage.prop('disabled', true).parent().addClass('disabled');
						}

					}
                });

	// Methods
	$('#set_profile_image').on('click', function() {
		let result = $image.cropper('getCroppedCanvas', 
			{
				'width': 500,
				'height': 500,
				//minWidth: 128,
				//minHeight: 128,
				//maxWidth: 4096,
				//maxHeight: 4096,
				//fillColor: '#fff',
				//imageSmoothingEnabled: true,
				//imageSmoothingQuality: 'high',
			});

		cropped_image = result.toDataURL('image/jpeg', 1);  //image/png, ("image/jpeg", 0.7);  // last=quality

		result.toBlob(function(blob){
            var url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function(){
                var base64data = reader.result;
				//   .... 
			}
		}, 'image/jpeg', 0.8)	


		$('#photoModal').modal('hide');
		if($("#upload_type").val() == 'profile') {
			var requestUrl = '<?= route('user.upload_profile_imageblob'); ?>',
				formData = {
					'profile_image': cropped_image,
				};
			// post ajax request
			__DataRequest.post(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					afterUploadedProfilePicture(response);
					showHideProfileAndCoverPhotoContainer();
					$("#upload_type").val('');
					showSuccessMessage(response.data.message);
				}
			});
		} else {
			$('#profile_image').attr('src', cropped_image);
			$('#profile_image').addClass('add-profile-btn');

			$('#post_photo_blob').val(cropped_image);

			$('.filepond--image-bitmap canvas').attr('id','photo_canvas_preview');
			var canvas = document.getElementById('photo_canvas_preview');
			var img = new Image;
			var ctx = canvas.getContext('2d');
			
  			canvas.height = canvas.width;
			//ctx.clear()
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			img.onload = function () {
				ctx.drawImage(img,0,0,canvas.width,canvas.height);
			}
			img.src = cropped_image;

			// Clear canvas, and resize image
			//ctx.clearRect(0, 0, max_width, max_height);
			//ctx.drawImage(img,
			//	0, 0, img.width, img.height, // size of image
			//	0, 0, max_width, max_height // size of canvas
			//);

		}	
	});


	var tagUserSelectize;
	var requestUrl = '<?= route('user.read.get_follows'); ?>';
	__DataRequest.get(requestUrl, {}, function(response) {
		if (response.reaction_code == 1) {
			tagUserSelectize = $('.post_photo_user_tag').selectize({
				valueField: 'user_id',
				labelField: 'user_kanji_name',
				searchField: ['user_kanji_name'],
				persist: true,
				allowEmptyOption: false,
				createOnBlur: true,
				create: false,
				closeAfterSelect: true,
				hideSelected    : true,
				openOnFocus     : true,
				maxOptions      : 10,
				maxItems: null,
				//placeholder     : "Neighborhood, Street, School, Zip, MLS",
				//plugins         : ['remove_button'],
				options         : response.data,
				render          : {
					option: function (item, escape) {
						console.log(item);
						var template = `<div class="p-2 chat-user-item d-flex position-relative " > 
											<div class="chat-user-avatar">
												<img src="`+item.profile_picture+`">
											</div>
											<div class="chat-item-username" style="padding-left: 1.25rem;align-items:center;display: flex;"> 
											`+ item.user_kanji_name+`
											</div>
										</div> `;
						return template;
					}
				},
				//load            : searchHandler,
				//onKeydown       : keyHandler,
				//onDelete        : deleteHandler,
				//onFocus         : textHandler('focus'),
				onChange       : function(value) {
					$("#post_tagged_users").val(value);
				}
			});
		}
	});

	function initPostPhotoForm () {
		var selectize = tagUserSelectize[0].selectize;
		selectize.setValue([]);
		selectize.refreshOptions();
		$("#photo_comment").val('');
		photoPond.removeFiles();
	}

	function sendPostPhotoCallback(responseData) {
		console.log(responseData);
		if(responseData.reaction == 1) {
			var photo_data = JSON.stringify(responseData.data.stored_photo).replace(/'/g, "&apos;");
			$("#lwPostPhotoDialog").modal('hide');
			$(".photos_tab_container").prepend(`
				<div  class="col photo_posting_item_`+responseData.data.stored_photo.photoUId+`" style="padding:0.75rem;">
					<a href='javascript:showDetailViewPhoto(`+photo_data+`)'>
						<img class="lw-user-photo lw-lazy-img" style="margin:0px;border-radius: 10px;width:100%;height:auto;min-height:130px;flex: 1 1 auto;" src="`+responseData.data.stored_photo.image_url+`">
						<a href="`+responseData.data.stored_photo.removePhotoUrl+`" data-callback="onDeletePhotoCallback" data-method="post" class="btn btn-danger btn-sm lw-remove-photo-btn remove-photo-btn lw-ajax-link-action" style="position: absolute;top: 0px;right: 0px;"><i class="far fa-trash-alt"></i></a>
					</a>
				</div>
			`);
			$("span.no_image_found").remove();
			initPostPhotoForm();
		}
	}

	function showDetailViewPhoto(photo){
		console.log(photo)

		let user_comment = (photo.user_comment == null)?"":photo.user_comment;

		$('.photo_image').attr('src', photo.image_url);
		$('.photo_created_date').html( photo.created_at);
		$('.user_photo_comment').html(user_comment.replace(/\u0027/g, "'").replace(/\u0022/g, '"'));

		$('.taggedPhotoBtn').attr('href',   __Utils.apiURL("<?= route('user.feed.write.tagged', ['photoUid' => 'photoUid']) ?>", {
					'photoUid': photo.photoUId
				}))
		$('.likePhotoBtn').attr('href',   __Utils.apiURL("<?= route('user.feed.write.like', ['photoUid' => 'photoUid']) ?>", {
			'photoUid': photo.photoUId
		}))		
		$('.commentPhotoBtn').attr('href', 'javascript:commentFeedModalShow( '+JSON.stringify(photo)+')' )

		var requestUrl = __Utils.apiURL("<?= route('user.read.photo_info', ['photoUId' => 'photoUId']) ?>", {
					'photoUId': photo.photoUId
				})
				formData = {
					'photo_user_id' : photo.photo_user_id
				};
			// post ajax request
			__DataRequest.get(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					console.log(response)

					if(response.data.is_like){
						$("#like_icon").removeClass("far").addClass("fas");
					} else {
						$("#like_icon").removeClass("fas").addClass("far");
					}

					$("#tagged_icon").html('');
					if(response.data.is_tagged){
						$("#tagged_icon").append(`
							<i class="ml-2 fa fa-thumbtack" style="font-size:32px;color:white;"></i>
						`);
					} else {
						$("#tagged_icon").append(`
							<svg width="32" height="32" viewBox="0 0 24 39" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M17.9161 0.833984C20.1654 0.833984 21.9889 2.65746 21.9889 4.90684C21.9889 5.63185 21.7954 6.34373 21.4283 6.96895L19.6298 10.0323C18.5249 11.9141 18.5805 14.2592 19.7734 16.0866L22.5797 20.3856C24.001 22.563 23.3882 25.4803 21.2108 26.9017C20.4454 27.4013 19.5512 27.6673 18.6372 27.6673H13.9164V36.484C13.9164 37.5425 13.0583 38.4006 11.9997 38.4006C11.0168 38.4006 10.2067 37.6607 10.096 36.7075L10.0831 36.484V27.6673H5.39281C2.80007 27.6673 0.698242 25.5655 0.698242 22.9728C0.698242 22.0529 0.968504 21.1532 1.47546 20.3856L4.38884 15.9743C5.55616 14.2068 5.65718 11.9406 4.65177 10.0762L2.97609 6.96895C1.8855 4.94662 2.64083 2.42309 4.66316 1.3325C5.26992 1.00529 5.94848 0.833984 6.63785 0.833984H17.9161ZM11.9997 23.834H18.6372C18.807 23.834 18.9732 23.7846 19.1154 23.6917C19.4694 23.4606 19.6008 23.0167 19.4512 22.6384L19.3697 22.481L16.5634 18.182C14.6618 15.2688 14.4943 11.5661 16.0948 8.50475L16.3241 8.09141L18.1226 5.02811C18.1442 4.99134 18.1556 4.94947 18.1556 4.90684C18.1556 4.80101 18.0869 4.71121 17.9918 4.67953L17.9161 4.66732H6.63785C6.58368 4.66732 6.53035 4.68078 6.48267 4.70649C6.35553 4.77506 6.29211 4.91569 6.31571 5.05057L6.35009 5.14944L8.02577 8.25673C9.62528 11.2228 9.54457 14.799 7.84182 17.6801L7.58754 18.0868L4.67416 22.4981C4.58116 22.639 4.53158 22.804 4.53158 22.9728C4.53158 23.3955 4.83624 23.7472 5.238 23.8201L5.39281 23.834H11.9997Z" fill="white"/>
							</svg>
						`);
					}

					$(".photoowner_img").attr('src', response.data.profilePictureUrl);
					$(".photo_ownerName").html(response.data.userName);
					$(".photoowner_kanjiname").html(response.data.kanji_name);

					$("#collapseAllComments>div.photo_comments_container").html('');
					if(response.data.feedCommentData.length){
						_.forEach(response.data.feedCommentData, function (value, key) {
							$("#collapseAllComments>div.photo_comments_container").append(
								`<div class=""> 
								<div class="chat-user-item d-flex position-relative"> 
									<div class="chat-user-avatar">
										<img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+value.feeduserImageUrl+`">
									</div>
									<div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
										<div class="row" style="flex-direction:column;padding-top: 0.5rem;">
											<span class="chat-time" style="">`+value.comment_date+`</span>
											<span class="chat-content" style="word-break: break-all;">`+value.comment+`</span>
											
										</div>
									</div>
								</div> 
							</div>`
							);
						});
						$(".no_comment").hide();
						$("#headingAllComments").show();
					} else {
						$("#headingAllComments").hide();
						$("#collapseAllComments>div.photo_comments_container").html('<span class="no_comment">No comment</span>');
						$(".no_comment").hide();
					}
					
				}
			});

		$('#lwViewDetailPhotoDialog').modal('show');
		
	}


	function onLikedFeedCallback(responseData){ 
        if (responseData.reaction == 1) {
			if(responseData.data.is_like){
				$("#like_icon").addClass("fas");
				$("#like_icon").removeClass("far");
			} else {
				$("#like_icon").addClass("far");
				$("#like_icon").removeClass("fas");
			}
        }
    }
	function onTaggedFeedCallback(responseData){ 
        if (responseData.reaction == 1) {
			$("#tagged_icon").html('');
			if(responseData.data.is_tagged){
				$("#tagged_icon").append(`
					<i class="ml-2 fa fa-thumbtack" style="font-size:32px;color:white;"></i>
				`);
			} else {
				$("#tagged_icon").append(`
					<svg width="32" height="32" viewBox="0 0 24 39" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M17.9161 0.833984C20.1654 0.833984 21.9889 2.65746 21.9889 4.90684C21.9889 5.63185 21.7954 6.34373 21.4283 6.96895L19.6298 10.0323C18.5249 11.9141 18.5805 14.2592 19.7734 16.0866L22.5797 20.3856C24.001 22.563 23.3882 25.4803 21.2108 26.9017C20.4454 27.4013 19.5512 27.6673 18.6372 27.6673H13.9164V36.484C13.9164 37.5425 13.0583 38.4006 11.9997 38.4006C11.0168 38.4006 10.2067 37.6607 10.096 36.7075L10.0831 36.484V27.6673H5.39281C2.80007 27.6673 0.698242 25.5655 0.698242 22.9728C0.698242 22.0529 0.968504 21.1532 1.47546 20.3856L4.38884 15.9743C5.55616 14.2068 5.65718 11.9406 4.65177 10.0762L2.97609 6.96895C1.8855 4.94662 2.64083 2.42309 4.66316 1.3325C5.26992 1.00529 5.94848 0.833984 6.63785 0.833984H17.9161ZM11.9997 23.834H18.6372C18.807 23.834 18.9732 23.7846 19.1154 23.6917C19.4694 23.4606 19.6008 23.0167 19.4512 22.6384L19.3697 22.481L16.5634 18.182C14.6618 15.2688 14.4943 11.5661 16.0948 8.50475L16.3241 8.09141L18.1226 5.02811C18.1442 4.99134 18.1556 4.94947 18.1556 4.90684C18.1556 4.80101 18.0869 4.71121 17.9918 4.67953L17.9161 4.66732H6.63785C6.58368 4.66732 6.53035 4.68078 6.48267 4.70649C6.35553 4.77506 6.29211 4.91569 6.31571 5.05057L6.35009 5.14944L8.02577 8.25673C9.62528 11.2228 9.54457 14.799 7.84182 17.6801L7.58754 18.0868L4.67416 22.4981C4.58116 22.639 4.53158 22.804 4.53158 22.9728C4.53158 23.3955 4.83624 23.7472 5.238 23.8201L5.39281 23.834H11.9997Z" fill="white"/>
					</svg>
				`);
			}

			_.delay(function() {
				//__Utils.viewReload();
				getPhotosAllData();
			}, 1000)
        }
    }
	function commentFeedModalShow( item_data ) {
		 // JSON.parse(item);
		$("#lwPhotoStaticImage").attr('src', item_data.image_url);
        $("#post_photo_uid").val(item_data.photoUId);
        //$("#post_photo_comment").val(item_data.feed_comment);
		//$("#post_photo_comment").val($("#comment_icon_"+item_data.photo_uid).attr("data-comment"));
		$("#post_photo_comment").val('');

        $("#lwFeedCommentDialog").modal('show');
	}
	function onCommentFeedCallback(responseData){ 
        if (responseData.reaction == 1) {
			
			//$("#comment_icon").addClass("fas");
			//$("#comment_icon").removeClass("far");
			//$("#comment_icon").attr("data-comment", responseData.data.comment);

			$("#lwFeedCommentDialog").modal('hide');
			$("#collapseAllComments>div.photo_comments_container").append(
				`<div class=""> 
				<div class="chat-user-item d-flex position-relative"> 
					<div class="chat-user-avatar">
						<img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+responseData.data.profilePictureUrl+`">
					</div>
					<div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
						<div class="row" style="flex-direction:column;padding-top: 0.5rem;">
							<span class="chat-time" style="">`+responseData.data.create_at+`</span>
							<span class="chat-content" style="word-break: break-all;">`+responseData.data.comment+`</span>
							
						</div>
					</div>
				</div> 
			</div>`
			);
			$(".no_comment").hide();
			$("#headingAllComments").show();
        }
    }
	function toggleViewComments(target){ 
        $child=$(target).children('i');
        $child.toggleClass("fa-chevron-right").toggleClass("fa-chevron-down");
    }

</script>
<script>
var minImageCount = 6	
@if($userData["userRoleId"] == 3)
	minImageCount  = 3;
@endif
function loadPhoto(responseData) {
	$(function() {
		applyLazyImages();
	});
	var requestData = responseData.data,
		appendData = responseData.response_action.content;
	$('.photos_tab_container').html('');
	$('.photos_tab_container').append(appendData);

	if( $('.photos_tab_container>.photo_posting_item').length > 8) {
		$("#btnShowModalPostPhoto").hide();
	} else {
		$("#btnShowModalPostPhoto").show();
	}

	if( $('.photos_tab_container>.photo_posting_item').length < minImageCount) {
		$("span.no_image_found").hide();
		var dummyCount = minImageCount - $('.photos_tab_container>.photo_posting_item').length;
		for( var i = 0 ; i < dummyCount ; i++) {
			$('.photos_tab_container').append(`
				<div class="col photo_posting_item" style="padding:0.75rem;">
					<div class="" style="display:flex;aspect-ratio: 1;background: #1E1E1E;border: 1px dashed #858585;border-radius: 10px;margin:0px;border-radius: 10px;width:100%;height:auto;min-height:130px;flex: 1 1 auto;" >
						<span style="color: rgba(133, 133, 133, 0.7);margin:auto;">No Image</span>
					</div>
				</div>
			`);
		}
	} 
}

var requestUrl = '<?= route('user.read.photos_data', ['username' => $userData['userName']]) ?>',
	formData = {
	};
// post ajax request
__DataRequest.get(requestUrl, formData, function(response) {
	if (response.reaction == 1) {
		loadPhoto(response);
	}
});

function loadTaggedPhoto(responseData) {
	$(function() {
		applyLazyImages();
	});
	var requestData = responseData.data,
		appendData = responseData.response_action.content;
	$('.photos_tagged_tab_container').html('');
	$('.photos_tagged_tab_container').append(appendData);

	if( $('.photos_tagged_tab_container>div').length < minImageCount) {
		$("span.no_image_found").hide();
		var dummyCount = minImageCount - $('.photos_tagged_tab_container>div').length;
		for( var i = 0 ; i < dummyCount ; i++) {
			$('.photos_tagged_tab_container').append(`
				<div class="col photo_posting_item" style="padding:0.75rem;">
					<div class="" style="display:flex;aspect-ratio: 1;background: #1E1E1E;border: 1px dashed #858585;border-radius: 10px;margin:0px;border-radius: 10px;width:100%;height:auto;min-height:130px;flex: 1 1 auto;" >
						<span style="color: rgba(133, 133, 133, 0.7);margin:auto;">No Image</span>
					</div>
				</div>
			`);
		}
	} 

}

function loadFavouritePhoto(responseData) {
	$(function() {
		applyLazyImages();
	});
	var requestData = responseData.data,
		appendData = responseData.response_action.content;
	$('.photos_favourite_tab_container').html('');
	$('.photos_favourite_tab_container').append(appendData);

	if( $('.photos_favourite_tab_container>div').length < minImageCount) {
		$("span.no_image_found").hide();
		var dummyCount = minImageCount - $('.photos_favourite_tab_container>div').length;
		for( var i = 0 ; i < dummyCount ; i++) {
			$('.photos_favourite_tab_container').append(`
				<div class="col photo_posting_item" style="padding:0.75rem;">
					<div class="" style="display:flex;aspect-ratio: 1;background: #1E1E1E;border: 1px dashed #858585;border-radius: 10px;margin:0px;border-radius: 10px;width:100%;height:auto;min-height:130px;flex: 1 1 auto;" >
						<span style="color: rgba(133, 133, 133, 0.7);margin:auto;">No Image</span>
					</div>
				</div>
			`);
		}
	} 

}

$('.nav-link').click(function(event) {
        let id = event.target.getAttribute('id');
        if (id == 'photos') {
            // load pt data
			var requestUrl = '<?= route('user.read.photos_data', ['username' => $userData['userName']]) ?>',
				formData = {
				};
			// post ajax request
			__DataRequest.get(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					loadPhoto(response);
				}
			});
            
        } else if ( id == "tagged") {
			var requestUrl = '<?= route('user.read.photos_tagged_data', ['username' => $userData['userName']]) ?>',
				formData = {
				};
			// post ajax request
			__DataRequest.get(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					loadTaggedPhoto(response);
				}
			});
            
        } else if ( id == "favourite") {
			var requestUrl = '<?= route('user.read.photos_favourite_data', ['username' => $userData['userName']]) ?>',
				formData = {
				};
			// post ajax request
			__DataRequest.get(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					loadFavouritePhoto(response);
				}
			});
        }
    });
function getPhotosAllData() {
	// load pt data
	var requestUrl = '<?= route('user.read.photos_data', ['username' => $userData['userName']]) ?>',
		formData = {
		};
	// post ajax request
	__DataRequest.get(requestUrl, formData, function(response) {
		if (response.reaction == 1) {
			loadPhoto(response);
		}
	});
	
	requestUrl = '<?= route('user.read.photos_tagged_data', ['username' => $userData['userName']]) ?>';
	// post ajax request
	__DataRequest.get(requestUrl, formData, function(response) {
		if (response.reaction == 1) {
			loadTaggedPhoto(response);
		}
	});
	
	requestUrl = '<?= route('user.read.photos_favourite_data', ['username' => $userData['userName']]) ?>';
	// post ajax request
	__DataRequest.get(requestUrl, formData, function(response) {
		if (response.reaction == 1) {
			loadFavouritePhoto(response);
		}
	});
}

$(".flatpickr").flatpickr({
	wrap: true,
	allowInput: true,
	minDate: '<?= Carbon::today()->subYears(getUserSettings('max_age'))->endOfDay()->toDateString()?>',
	maxDate: '<?= Carbon::today()->subYears(getUserSettings('min_age'))->toDateString()?>'
});

function startChat() {

	var requestUrl = '<?= route('user.write.send_invite_message'); ?>',
                            formData = {
                                'user_id' : <?= $userData['userId'] ?>,
                                'type' : 1,
                                'message' : '' 
                            };  
	// post ajax request
	__DataRequest.post(requestUrl, formData, function(response) {
		if (response.reaction == 1) {
			var url ='<?= route('user.read.messenger')."?selected=".$userData['userId'] ?>';
			window.open(url, '_blank');
		} else {
			$('#lwChatUnavailableDialog').modal('show');
		}
	});
}

// Follow Modal 

$(document).ready(function(){

	_.delay(function() {
		makeFollowerSelectize();						
	}, 1000);
	_.delay(function() {
		makeFollowingSelectize();			
	}, 1000);
	
});


$('.nav-link-follow').click(function(event) {

	let id = event.target.getAttribute('id');

	if ( id == "remider_tab_follower") {
		makeFollowerSelectize()
	} else if ( id == "remider_tab_following") {
		makeFollowingSelectize()
	}

});

function makeFollowerSelectize() {
	var followerSelectize;
	var requestUrl = '<?= route('user.read.get_followers'); ?>';
	__DataRequest.get(requestUrl, {}, function(response) {
		if (response.reaction_code == 1) {
			followerSelectize = $('.follower_user_tag').selectize({
				valueField: 'user_id',
				labelField: 'user_kanji_name',
				searchField: ['user_kanji_name'],
				persist: true,
				allowEmptyOption: false,
				createOnBlur: true,
				create: false,
				closeAfterSelect: false,
				hideSelected    : false,
				openOnFocus     : true,
				maxOptions      : null,
				maxItems: null,
				//placeholder     : "Neighborhood, Street, School, Zip, MLS",
				//plugins         : ['remove_button'],
				options         : response.data,
				disabledField: 'user_id',
				render          : {
					option: function (item, escape) {
						console.log(item);
						if(item.isMutualLike){ 
							badge = `<label style="
													position: absolute;
													left: 0;
													top: 0;
													padding: 0rem 0.75rem;
													color: #fff;
													background: #ff3f3f;
													border-top-left-radius: 10px;
													border-bottom-right-radius: 10px;
													font-size: 0.75rem;
													font-family: Nunito Sans;
													font-style: normal;
													font-weight: bold;
													line-height: 24px;
													text-align: center;
												">Matched</label>`;
						} else {
							badge = `<label style="
													position: absolute;
													left: 0;
													top: 0;
													padding: 0rem 0.75rem;
													color: #fff;
													background: #979797;
													border-top-left-radius: 10px;
													border-bottom-right-radius: 10px;
													font-size: 0.75rem;
													font-family: Nunito Sans;
													font-style: normal;
													font-weight: bold;
													line-height: 24px;
													text-align: center;
												">Pending</label>`;
						}
						var template =`<div class="d-flex mt-2 follow-item" style="width:100%;">
										<div class="">
											<div class="position-relative">
												<img style="width:85px;height:85px;border:3px solid #`+ (item.isMutualLike?`FF3F3F`:`979797`) +`!important;border-radius:10px;padding:0px;box-sizing: border-box;" class=" lw-lazy-img" id="lwProfilePictureStaticImage" src="`+item.profile_picture+`">
												`+badge+`
											</div>
										</div>

										<div class="pl-2 d-flex align-items-center" style="width:100%">
											<div class="d-flex align-items-center justify-content-between" style="position:relative;width:100%"> 
												
												<div class="" style="width:100%;">
													<div class="d-flex">
														<div class="" style="font-size: 22px;line-height: 34px;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
														`+ item.user_kanji_name+`
														</div>
													</div>	
													<div class="d-flex">
														<div class="" style="font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 18px;line-height: 19px;color: #91929E;">
															@`+item.username+`
														</div>
													</div>
												</div>
												<div class="" style="z-index:100000!important;">
													<button type="button" role="button" onMouseDown="removefollowuser(`+item.user_id+`)" data-userid="`+item.user_id+`" class="lw-ajax-form-submit-action1 btn-removefollowuser btn btn-primary btn-user btn-block-on-mobile" style="border:1px solid #FFFFFF;display:flex;align-items:center;padding: 1rem 1.5rem;height: 24px;background: #191919;border-radius: 7px;">Remove</button>
												</div>
											</div>														
										</div>
									</div>`;
						return template;
					}
				},
				//load            : searchHandler,
				//onKeydown       : keyHandler,
				//onDelete        : deleteHandler,
				//onFocus         : textHandler('focus'),
				onChange       : function(value) {
					//$("#post_tagged_users").val(value);
				},

				onDropdownOpen: function() {
						$('.selectize-dropdown-content').on('mousedown', 'div.follow-item', function(event) {
						event.preventDefault();
						event.stopPropagation();
						});
					}
			});
			followerSelectize[0].selectize.open();
			$('.active .selectize-input input').focus();
		}
	});
}

function makeFollowingSelectize() {
	var followingSelectize;
	var requestUrl = '<?= route('user.read.get_followings'); ?>';
	__DataRequest.get(requestUrl, {}, function(response) {
		if (response.reaction_code == 1) {

			followingSelectize = $('.following_user_tag').selectize({
				valueField: 'user_id',
				labelField: 'user_kanji_name',
				searchField: ['user_kanji_name'],
				persist: true,
				allowEmptyOption: false,
				createOnBlur: true,
				create: false,
				closeAfterSelect: true,
				hideSelected    : true,
				openOnFocus     : true,
				maxOptions      : null,
				maxItems: null,
				//placeholder     : "Neighborhood, Street, School, Zip, MLS",
				//plugins         : ['remove_button'],
				options         : response.data,
				disabledField: 'user_id',
				render          : {
					option: function (item, escape) {
						console.log(item);
						
						var badge = "";
						if(item.isMutualLike){ 
							badge = `<label style="
													position: absolute;
													left: 0;
													top: 0;
													padding: 0rem 0.75rem;
													color: #fff;
													background: #ff3f3f;
													border-top-left-radius: 10px;
													border-bottom-right-radius: 10px;
													font-size: 0.75rem;
													font-family: Nunito Sans;
													font-style: normal;
													font-weight: bold;
													line-height: 24px;
													text-align: center;
												">Matched</label>`;
						} else {
							badge = `<label style="
													position: absolute;
													left: 0;
													top: 0;
													padding: 0rem 0.75rem;
													color: #fff;
													background: #979797;
													border-top-left-radius: 10px;
													border-bottom-right-radius: 10px;
													font-size: 0.75rem;
													font-family: Nunito Sans;
													font-style: normal;
													font-weight: bold;
													line-height: 24px;
													text-align: center;
												">Pending</label>`;
						}
						var template =`<div class="d-flex mt-2 follow-item" style="width:100%;">
										<div class="">
											<div class="position-relative">
												<img style="width:85px;height:85px;border:3px solid #`+ (item.isMutualLike?`FF3F3F`:`979797`) +`!important;border-radius:10px;padding:0px;box-sizing: border-box;" class=" lw-lazy-img" id="lwProfilePictureStaticImage" src="`+item.profile_picture+`">
												`+badge+`
											</div>
										</div>

										<div class="pl-2 d-flex align-items-center" style="width:100%">
											<div class="d-flex align-items-center justify-content-between" style="position:relative;width:100%"> 
												
												<div class="" style="width:100%;">
													<div class="d-flex">
														<div class="" style="font-size: 22px;line-height: 34px;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
														`+ item.user_kanji_name+`
														</div>
													</div>	
													<div class="d-flex">
														<div class="" style="font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 18px;line-height: 19px;color: #91929E;">
															@`+item.username+`
														</div>
													</div>
												</div>
												<div class="">
													<button type="button" role="button" onMouseDown="unfollowuser(`+item.user_id+`)" data-userid="`+item.user_id+`" class="lw-ajax-form-submit-action1 btn-unfollowuser btn btn-primary1 btn-user1 btn-block-on-mobile" style="border:1px solid #FF3F3F;color:#FF3F3F;display:flex;align-items:center;padding: 1rem 1.5rem;height: 24px;background: transparent;border-radius: 7px;">Following</button>
												</div>
											</div>														
										</div>
									</div>`;
						return template;
					}
				},
				//load            : searchHandler,
				//onKeydown       : keyHandler,
				//onDelete        : deleteHandler,
				//onFocus         : textHandler('focus'),
				onChange       : function(value) {
					//$("#post_tagged_users").val(value);
				},

				onDropdownOpen: function() {
						$('.selectize-dropdown-content').on('mousedown', 'div.follow-item', function(event) {
						event.preventDefault();
						event.stopPropagation();
						});
					}
			});

			followingSelectize[0].selectize.open();
			$('.active .selectize-input input').focus();
		}
	});
}

function showModalFollow( type ) {

	$('#lwRemindFollowDialog').modal('show');
	if(type=="follower") {
		$("#remider_tab_follower").trigger('click');
	}
	else {
		$("#remider_tab_following").trigger('click');
	}	
}

$(".btn-removefollowuser").click(function(e){
	e.preventDefault();
	removefollowuser($(this).data('userid'));
});

$(".btn-unfollowuser").click(function(e){
	e.preventDefault();
	unfollowuser($(this).data('userid'));
});

$("#lwRemindFollowDialog .selectize-dropdown>div").click(function(e){
    e.preventDefault();
});

$('#lwRemindFollowDialog .modal-content').click(function(event){
	event.preventDefault();
	//if (event.target.className != "form-group follow_content")
		//event.preventDefault();
		
	$('.active .selectize-input input').focus();
});

function removefollowuser(user_id) {
	var requestUrl = __Utils.apiURL("<?= route('user.write.remove_like_dislike', ['toUserUid' => 'toUserUid']) ?>", {
					'toUserUid': user_id
				}),
	formData = {
	};
	// post ajax request
	__DataRequest.post(requestUrl, formData, function(response) {
        if (response.reaction == 1) {
			makeFollowerSelectize();
        }
    });

}

function unfollowuser(user_id) {
	var requestUrl = __Utils.apiURL("<?= route('user.write.like_dislike', ['toUserUid' => 'toUserUid', 'like' => 'like']) ?>", {
					'toUserUid': user_id,
					'like'   : 1
				}),
	formData = {
	};
	// post ajax request
	__DataRequest.post(requestUrl, formData, function(response) {
        if (response.reaction == 1) {
			makeFollowingSelectize();
        }
    });

}

function refineShowExpertise() {
	var maxLength = 0, width = 0;
	var tags = $("span.pt_category_tag_item");
	for(var i = 0 ; i < tags.length ; i++) {
        // element == this
		width = $(tags[i]).width();
        if ( width  > maxLength ) {
            maxLength = width;
        }
    }

	$("span.pt_category_tag_item").width(maxLength);
}

_.delay(function() {
	refineShowExpertise();						
}, 1000);



</script>
@endpush