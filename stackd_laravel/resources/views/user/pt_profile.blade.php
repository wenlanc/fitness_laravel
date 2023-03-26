@if(isset($userData))
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
@endif
@push('header')
<link rel="stylesheet" href="<?= __yesset('dist/css/vendorlibs-leaflet.css'); ?>" />
<style>
	#staticMapId {
		height: 300px;
	}

	.custom-control-input:checked~.custom-check {
		background: #ff4141;
	}
</style>
@endpush
@push('footer')
<script src="<?= __yesset('dist/js/vendorlibs-leaflet.js'); ?>"></script>
@endpush

<?php $latitude = (__ifIsset($userProfileData['latitude'], $userProfileData['latitude'], '21.120779'));
$longitude = (__ifIsset($userProfileData['longitude'], $userProfileData['longitude'], '79.0544606'));
$isBlockUser = false;
$blockByMeUser = false;
$isOwnProfile = false;
?>

<div class="row">
	<div class="col-sm-1 col-md-4">
		<!-- User Profile and Cover photo -->
		<div class="card mb-3 lw-profile-image-card-container">
			<div class="row nav-item dropdown no-arrow">
				<a class="" href="" role="button" style="">
					<i class="fas fa-arrow-left" style="color:white;font-size:22px;"></i>
				</a>
				<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left:auto;">
					<i class="fas fa-ellipsis-v" style="color:white;font-size:22px;"></i>
				</a>

				<!-- Dropdown - Messages -->
				<div class="dropdown-menu shadow " aria-labelledby="searchDropdown" style="background: #191919;border-radius: 20px;border: none;padding: 2rem;width:20vw;">
					<div class="row mb-2" style="border-bottom:none;">
						<button type="button" style="color:#FFFFFF;margin-left:auto;" class="close" data-dismiss="modal" aria-label="Close">
							<span style="padding: 5px 12px;background: #202020;border-radius: 12px;height: 40px;" aria-hidden="true">×</span>
						</button>
					</div>
					<div class="" style="margin-top:-20px;">
						<div class="item_action_menu row ">
							Report
						</div>
						<div class="item_action_menu row">
							Block
						</div>
						<div class="item_action_menu row" style="color:#FFFFFF;">
							Remove Follower
						</div>
						<div class="item_action_menu row " style="color:#FFFFFF;">
							Copy Profile URL
						</div>
						<div class="item_action_menu row" style="color:#FFFFFF;">
							Share This Profile
						</div>
					</div>
					

				</div>

			</div>
			<div class="row" id="lwProfileAndCoverStaticBlock">
				<div class="col-lg-12">
					<div class="card  lw-profile-image-card-container">
						<img style="width: 100%; min-height: 20vw; border: 4px solid white; border-radius: 10px; padding: 0px;object-fit: cover;" class="lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" id="lwProfilePictureStaticImage" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/profile/schermafbeelding-2021-10-31-om-064639-618d11e51866f.png">
						<label style="
								position: absolute;
								left: 0;
								top: 0;
								padding: 3px 24px;
								background: white;
								color: #ff4141;
								border-top-left-radius: 10px;
								border-bottom-right-radius: 10px;
								font-size: 0.8rem;
							">PT</label>
						<span class="pt_badge_tag">Following</span>
					</div>
				</div>
			</div>
		</div>
		<!-- /User Profile and Cover photo -->
		<div class="card mb-3">
			<div class="d-flex">
				<div style="width:100%;position:relative;padding-right:10px;">
					<span class="lw-inline-edit-text mr-2 profile_username" style="" data-model="userData.kanji_name">Admin</span>
					<span style="position:absolute;right:0px;margin-right: 10px;" class="profile_username" data-model="userData.userAge">18</span>
					<!-- /if user is premium then show badge -->
				</div>
				<span class="" style="margin-left:auto; margin-right:-15px;">
					<a class="" href="" role="button" data-toggle="modal" data-target="#lwBasicProfileDialog">
						<i class="far fa-comments " style="color:white;font-size:28px;"></i>
					</a>
				</span>
			</div>
			<div>
				<div class="d-flex justify-content-between mb-1" style="font-size: 15px;">
					<span>0 Follower </span>
					<span> 0 Following</span>
				</div>
				<div class="d-flex justify-content-between mb-1" style="font-weight: bold;font-size: 20px;line-height: 27px;">
					<span data-model="userData.userName">admin</span>
					<span class="pt_userrate_star" style="right: 0px;position: absolute;">
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>
				</div>

				<div class="d-flex mb-2" style="font-weight: bold;font-size: 17px;line-height: 21px;">
					<i class="fas fa-map-marker-alt"></i> &nbsp;
					Japan, Tokyo-To,Minato-Ku
				</div>
				<div class="d-flex mb-2" style="font-weight: bold;font-size: 17px;line-height: 21px;">
					<i class="fas fa-link"></i> &nbsp;
					lyfma-aise.com
				</div>
				<div class="d-flex mb-2" style="font-weight: bold;font-size: 15px;line-height: 23px;color: #929292;">
					Lorem ipsum dolor sit amet, consec
					tetur adipiscing elit. In sed feugiat
					purus. Pellentesque eu orci ullamco
					rper, feugiat magna ut, laoreet aug
					ue.
				</div>


			</div>

			<div class="d-flex mb-2 mt-2" style="font-weight: bold;font-size: 17px;line-height: 21px;">
				Qualified Since: 2021/04/25
			</div>
			<!-- user availability -->
			<div class="d-flex">
				<h5 style="
						font-family: Nunito Sans;
						font-style: normal;
						font-weight: bold;
						font-size: 20px;
						line-height: 27px;
						color: #FFFFFF;
					">Availability</h5>
			</div>
			<div class="mb-4" style="">
				<div class="d-flex align-v-center" style="align-items: center;">
					<label class="pt_availablity_weekday" style="flex: 1;">月曜日</label>
					<label class="pt_availablity_time" style="flex: 1;">
						<input type="checkbox" name="sun_start" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
					</label>
					<label class="pt_availablity_time" style="flex: 1;">
						<input type="checkbox" name="sun_end" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
					</label>
				</div>
				<div class="d-flex align-v-center">
					<label class="pt_availablity_weekday">火曜日</label>
					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_start" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
					</label>

					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_end" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
					</label>
				</div>
				<div class="d-flex align-v-center">
					<label class="pt_availablity_weekday">水曜日</label>
					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_start" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
					</label>

					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_end" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
					</label>
				</div>
				<div class="d-flex align-v-center">
					<label class="pt_availablity_weekday">木曜日</label>
					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_start" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
					</label>

					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_end" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
					</label>
				</div>
				<div class="d-flex align-v-center">
					<label class="pt_availablity_weekday">金曜日</label>
					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_start" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
					</label>

					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_end" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
					</label>
				</div>
				<div class="d-flex align-v-center">
					<label class="pt_availablity_weekday">土曜日</label>
					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_start" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
					</label>

					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_end" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
					</label>
				</div>
				<div class="d-flex align-v-center">
					<label class="pt_availablity_weekday">日曜日</label>
					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_start" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_daytime"><i class="fa fa-sun-o"></i></span>
					</label>

					<label class="pt_availablity_time">
						<input type="checkbox" name="sun_end" class="custom-control-input btn-availability" checked="">
						<span class="custom-check btn btn-secondary pl-4 pr-4 pt_availablity_weekday_nighttime"><i class="fa fa-moon-o"></i></span>
					</label>
				</div>
				
			</div>
			<!-- user availability -->

			<!-- reviews -->
			<div class="d-flex">
				<h5 style="
						font-family: Nunito Sans;
						font-style: normal;
						font-weight: bold;
						font-size: 20px;
						line-height: 27px;
						color: #FFFFFF;
					">Reviews (40)</h5>
				<div class="" style="margin-left: auto;">
					<button class="" id="postReviewBtn" role="button" data-toggle="modal" data-target="#lwPostReviewDialog" style="background: #616161;border-radius: 7px;border:none; height:30px;padding:4px 8px;font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 15px;line-height: 20px;color: #FFFFFF;"> Post Review</button>
				</div>
			</div>
			<div class="profile_reviews_container" style="max-height: 300px;overflow-y: scroll;padding-right: 5px;">
				<div class="profile_review_item mb-2">
					<div class="profile_review_header" style="display:flex;">
						<div class="review_image">
							<img class="lw-profile-thumbnail lw-lazy-img lw-lazy-img-loaded" style="width: 50px;height: 50px;border-radius: 10px;" data-src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/profile/schermafbeelding-2021-10-31-om-064639-618d11e51866f.png" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">
						</div>
						<div class="profile_review_name" style="padding-left: 5px;">
							<div class="profile_review_username">
								Samuel Jackson
							</div>
							<div class="profile_review_star_rate">
								<span class="pt_userrate_star" style="">
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
								</span>
							</div>
						</div>
						<div class="profile_review_type_badge">
							Partner
						</div>
					</div>
					<div class="profile_review_content">
						Lorem ipsum dolor sit amet, consectetur adipi
						scing elit. In sed feugiat purus. Lorem ipsum
						dolor sit amet, consectetur adipiscing elit. In s
						ed feugiat purus...
					</div>
				</div>
				<div class="profile_review_item mb-2">
					<div class="profile_review_header" style="display:flex;">
						<div class="review_image">
							<img class="lw-profile-thumbnail lw-lazy-img lw-lazy-img-loaded" style="width: 50px;height: 50px;border-radius: 10px;" data-src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/profile/schermafbeelding-2021-10-31-om-064639-618d11e51866f.png" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">
						</div>
						<div class="profile_review_name" style="padding-left: 5px;">
							<div class="profile_review_username">
								Samuel Jackson
							</div>
							<div class="profile_review_star_rate">
								<span class="pt_userrate_star" style="">
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
								</span>
							</div>
						</div>
						<div class="profile_review_type_badge">
							Partner
						</div>
					</div>
					<div class="profile_review_content">
						Lorem ipsum dolor sit amet, consectetur adipi
						scing elit. In sed feugiat purus. Lorem ipsum
						dolor sit amet, consectetur adipiscing elit. In s
						ed feugiat purus...
					</div>
				</div>
				<div class="profile_review_item mb-2">
					<div class="profile_review_header" style="display:flex;">
						<div class="review_image">
							<img class="lw-profile-thumbnail lw-lazy-img lw-lazy-img-loaded" style="width: 50px;height: 50px;border-radius: 10px;" data-src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/profile/schermafbeelding-2021-10-31-om-064639-618d11e51866f.png" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">
						</div>
						<div class="profile_review_name" style="padding-left: 5px;">
							<div class="profile_review_username">
								Samuel Jackson
							</div>
							<div class="profile_review_star_rate">
								<span class="pt_userrate_star" style="">
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
								</span>
							</div>
						</div>
						<div class="profile_review_type_badge">
							Partner
						</div>
					</div>
					<div class="profile_review_content">
						Lorem ipsum dolor sit amet, consectetur adipi
						scing elit. In sed feugiat purus. Lorem ipsum
						dolor sit amet, consectetur adipiscing elit. In s
						ed feugiat purus...
					</div>
				</div>
			</div>
			<!-- end of reviews-->
		</div>
	</div>
	<div class="col-sm-1 col-md-8">
		<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-3 mt-1 mb-1">
			<div class="col pl-4 pr-4">
				<div class="row">
					<span style="font-size:20px;"> Pricing </span>
				</div>
				<div class="row">
					<div class="pt_pricing_time"> 30 Minutes </div>
					<div class="pt_pricing_inquire_container">
						<span class="price"> $0,000 </span>
						<span class="inquire_span"><button class="inquire_btn" role="button" data-toggle="modal" data-target="#lwInquireDialog" > Inquire </button></span>
					</div>
				</div>
				<div class="row">
					<div class="pt_pricing_time"> 30 Minutes </div>
					<div class="pt_pricing_inquire_container">
						<span class="price"> $0,000 </span>
						<span class="inquire_span"><button class="inquire_btn" role="button" data-toggle="modal" data-target="#lwInquireDialog"> Inquire </button></span>
					</div>
				</div>
				<div class="row">
					<div class="pt_pricing_time"> 30 Minutes </div>
					<div class="pt_pricing_inquire_container">
						<span class="price"> $0,000 </span>
						<span class="inquire_span"><button class="inquire_btn" role="button" data-toggle="modal" data-target="#lwInquireDialog"> Inquire </button></span>
					</div>
				</div>
				<div class="row">
					<div class="pt_pricing_time"> 30 Minutes </div>
					<div class="pt_pricing_inquire_container">
						<span class="price"> $0,000 </span>
						<span class="inquire_span"><button class="inquire_btn" role="button" data-toggle="modal" data-target="#lwInquireDialog"> Inquire </button></span>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="row">
					<span style="font-size:20px;"> Gyms </span>
				</div>

				<div class="row mb-2" style="flex-wrap:nowrap;background: #1E1E1E;border-radius: 10px;">
					<div class="">
						<img style="width: 65px; height: 65px; border: none; border-radius: 10px; padding: 5px;object-fit: contain;background:white;" class="lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" id="lwProfilePictureStaticImage" src="http://127.0.0.1:8000/media-storage/pt/anytime_logo.png">
					</div>
					<div class="" style="padding-left: 1.2rem;justify-content: center;align-content: center;align-items: center;align-self: center;">
						<span style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 15px;line-height: 21px;" class="row"> Anytime Fitness </span>
						<span class="row" style="font-size: 11px;"> <i class="fas fa-map-marker-alt"></i> &nbsp;Minato-ku</span>
						<span class="row" style="font-size: 11px;"> <i class="fas fa-map-marker-alt"></i> &nbsp;Shibuya-ku</span>
					</div>
				</div>

				<div class="row mb-2" style="flex-wrap:nowrap;background: #1E1E1E;border-radius: 10px;">
					<div class="">
						<img style="width: 65px; height: 65px; border: none; border-radius: 10px; padding: 5px;object-fit: contain;background:white;" class="lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" id="lwProfilePictureStaticImage" src="http://127.0.0.1:8000/media-storage/pt/goldensgym.png">
					</div>
					<div class="" style="padding-left: 1.2rem;justify-content: center;align-content: center;align-items: center;align-self: center;">
						<span style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 15px;line-height: 21px;" class="row"> Anytime Fitness </span>
						<span class="row" style="font-size: 11px;"> <i class="fas fa-map-marker-alt"></i> &nbsp;Minato-ku</span>
						<span class="row" style="font-size: 11px;"> <i class="fas fa-map-marker-alt"></i> &nbsp;Shibuya-ku</span>
					</div>
				</div>

				<div class="row mb-2" style="flex-wrap:nowrap;background: #1E1E1E;border-radius: 10px;">
					<div class="" style="">
						<img style="width: 65px; height: 65px; border: none; border-radius: 10px; padding: 5px;object-fit: contain;background:white;" class="lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" id="lwProfilePictureStaticImage" src="http://127.0.0.1:8000/media-storage/pt/tipeness_logo.png">
					</div>
					<div class="" style="padding-left: 1.2rem;justify-content: center;align-content: center;align-items: center;align-self: center;">
						<span style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 15px;line-height: 21px;" class="row"> Anytime Fitness </span>
						<span class="row" style="font-size: 11px;"> <i class="fas fa-map-marker-alt"></i> &nbsp;Minato-ku</span>
						<span class="row" style="font-size: 11px;"> <i class="fas fa-map-marker-alt"></i> &nbsp;Shibuya-ku</span>
					</div>
				</div>


			</div>
			<div class="col pl-4 pr-4">
				<div class="row">
					<span style="font-size:20px;"> Expertise </span>
				</div>
				<div class="row" style="margin-top:10px;">
					<span class="pt_category_tag_item"> Power Lifting </span>
					<span class="pt_category_tag_item"> Recovery </span>
					<span class="pt_category_tag_item"> Weight Loss </span>
					<span class="pt_category_tag_item"> Yoga </span>
				</div>
			</div>
		</div>

		<div class="card mb-3 mt-3">
			<div class="card-header" style="padding:0;">
				<span class="float-right">
					<a class="lw-icon-btn" href="http://127.0.0.1:8000/@admin/photos" role="button">
						<i class="fas fa-cog"></i>
					</a>
				</span>
				<!-- Tab Heading -->
				<div class="d-sm-flex align-items-center justify-content-between">
					<nav class="nav">
						<a id="photos" data-toggle="tab" class="nav-link active" aria-current="page" href="#photos_tab">Photos</a>
						<a id="tagged" data-toggle="tab" class="nav-link" href="#tagged_tab">Tagged</a>
					</nav>
				</div>
			</div>
			<div class="tab-content">
				<div class="card-body tab-pane active in" id="photos_tab">
					<div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 text-center lw-horizontal-container pl-2">
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="0" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-91-at-1x-6176b2d53a0ed.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="1" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-97-at-2x-6176b30218522.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="2" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-102-at-2x-618102b08caff.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="3" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-116-at-1x-618102b27bc47.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="4" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-118-at-2x-618102b3dffaa.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="5" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-117-at-2x-618102b546781.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="6" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/main-2-1-at-2x-618102ce8d39f.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="7" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/main-45-1-at-2x-618102cfd1508.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="8" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/match-1-at-2x-618102d0d7dc6.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="9" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-72-at-2x-618103b3d1cf1.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="10" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-97-at-2x-618103b52f7a1.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="11" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-98-at-2x-618103b62b5d5.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="12" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-92-at-1x-618103b745c9d.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="13" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-78-at-2x-618103b899c43.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="14" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-72-1-at-2x-618103b9c0a6b.png">
						</div>
					</div>
				</div>
				<div class="card-body tab-pane fade" id="tagged_tab">
					<div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 text-center lw-horizontal-container pl-2">
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="0" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-91-at-1x-6176b2d53a0ed.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="1" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-97-at-2x-6176b30218522.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="2" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-102-at-2x-618102b08caff.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="3" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-116-at-1x-618102b27bc47.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="4" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-118-at-2x-618102b3dffaa.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="5" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-117-at-2x-618102b546781.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="6" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/main-2-1-at-2x-618102ce8d39f.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="7" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/main-45-1-at-2x-618102cfd1508.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="8" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/match-1-at-2x-618102d0d7dc6.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="9" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-72-at-2x-618103b3d1cf1.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="10" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-97-at-2x-618103b52f7a1.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="11" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-98-at-2x-618103b62b5d5.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="12" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-92-at-1x-618103b745c9d.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="13" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-78-at-2x-618103b899c43.png">
						</div>
						<div class="col" style="padding-top:5px;">
							<img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img lw-lazy-img-loaded" style="margin: 0px; border-radius: 10px;" data-img-index="14" src="http://127.0.0.1:8000/media-storage/users/50ee1967-7341-4c3a-b071-f2ea0722b179/photos/rectangle-72-1-at-2x-618103b9c0a6b.png">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- post review modal -->
<div class="modal fade" id="lwInquireDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color: #191919;padding: 20px;box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);border-radius: 24px; ">
			
			<div class="modal-header" style="border-bottom:none;display:none;">
				<h5 class="modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 27px;line-height: 37px;color: #FFFFFF;">
					Inquire
				</h5>
				<button type="button" style="color:#FFFFFF;margin-top: -20px; " class="close" data-dismiss="modal" aria-label="Close">
					<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body" style="color:#FFFFFF;">
				<div class="d-flex">
					<div class="p-1">
						<div class="position-relative">
							<img style="width:220px;height:220px;border:3px solid #FFFFFF!important;border-radius:10px;padding:0px;box-sizing: border-box;" class="lw-profile-thumbnail lw-photoswipe-gallery-img lw-lazy-img" id="lwProfilePictureStaticImage" data-src="">
							<label style="
								position: absolute;
								left: 0;
								top: 0;
								padding: 3px 14px;
								color: #ff4141;
								background: white;
								border-top-left-radius: 10px;
								border-bottom-right-radius: 10px;
								font-size: 0.8rem;
								font-family: Nunito Sans;
								font-style: normal;
								font-weight: bold;
								font-size: 15px;
								line-height: 20px;
								text-align: center;
							">PT</label>
							<span class="match_follow_badge_tag">Follow</span>
						</div>
					</div>

					<div class="p-1 ml-1" style="width:100%">
						<div class="d-flex" style="position:relative;"> 
							
							<div class="" style="width:100%;">
								<div class="d-flex">
									<div class="" style="font-size:16px;line-height:24px;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
										Zyzz Bruh
									</div>
									<div class="" style="margin-left:3rem;color:#ff4141;font-size:16px;line-height:24px;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
										Minato-Ku
									</div>
								</div>	
								<div class="d-flex">
									<div class="" style="font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 14px;line-height: 19px;color: #91929E;">
										1 hour session
									</div>
									<div class="" style="margin-left:3rem;font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 16px;line-height: 24px;text-align: right;color: #AFAFAF;">
										￥5,000
									</div>
								</div>
							</div>
							
							<div class="" style="right:0px;position:absolute;">
								<span class="pt_userrate_star" style="">
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star"></span>
									<span class="fa fa-star"></span>
								</span>
							</div>
						</div>			

						<div class="d-flex mt-2">
							<div class="form-group" style="flex:1;">
								<label for="desciption">Message</label>
								<textarea class="form-control form-control-user" style="height:100%;" placeholder="Add a short message..."></textarea>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;">Send</button>
			</div>
		</div>
	</div>
</div>
<!-- post review modal -->

<!-- /if user block then don't show profile page content -->

@push('appScripts')
@if(getStoreSettings('allow_google_map'))
<script src="https://maps.googleapis.com/maps/api/js?key=<?= getStoreSettings('google_map_key'); ?>&libraries=places&callback=initialize&language=en" async defer></script>
@endif
<script>
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
		$('#lwBasicInformationDialog').modal('hide');
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

		}
		//check reaction code is 1 and status created or updated and like status is 2
		if (response.reaction == 1 && requestData.likeStatus == 2 && (requestData.status == "created" || requestData.status == 'updated')) {
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
		}
		//check reaction code is 1 and status deleted and like status is 1
		if (response.reaction == 1 && requestData.likeStatus == 1 && requestData.status == "deleted") {
			__DataRequest.updateModels({
				'userLikeStatus': '<?= __tr('Follow'); ?>', //user like status
			});
			$(".lw-animated-like-heart").toggleClass("lw-is-active");
		}
		//check reaction code is 1 and status deleted and like status is 2
		if (response.reaction == 1 && requestData.likeStatus == 2 && requestData.status == "deleted") {
			__DataRequest.updateModels({
				'userDislikeStatus': '<?= __tr('Dislike'); ?>', //user like status
			});
			$(".lw-animated-broken-heart").toggleClass("lw-is-active");
		}
		//remove disabled anchor tag class
		_.delay(function() {
			$('.lw-like-dislike-box').removeClass("lw-disable-anchor-tag");
		}, 1000);
	}
	/**************** User Like Dislike Fetch and Callback Block End ******************/


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

	//user report callback
	function userReportCallback(response) {
		//check success reaction is 1
		if (response.reaction == 1) {
			var requestData = response.data;
			//form reset after success
			$("#lwReportUserForm").trigger("reset");
			//close dialog after success
			$('#lwReportUserDialog').modal('hide');
			//reload view after 2 seconds on success reaction
			_.delay(function() {
				__Utils.viewReload();
			}, 1000)
		}
	}

	//close User Report Dialog
	$("#lwCloseUserReportDialog").on('click', function(e) {
		e.preventDefault();
		//form reset after success
		$("#lwReportUserForm").trigger("reset");
		//close dialog after success
		$('#lwReportUserDialog').modal('hide');
	});

	// close basic information modal
	$('#lwCloseUserBasicInformationDialog').on('click', function(e) {
		e.preventDefault();
		$('#lwBasicInformationDialog').modal('hide');
	});
	//block user confirmation
	$("#lwBlockUserBtn").on('click', function(e) {
		var confirmText = $('#lwBlockUserConfirmationText');
		//show confirmation 
		showConfirmation(confirmText, function() {
			var requestUrl = '<?= route('user.write.block_user'); ?>',
				formData = {
					'block_user_id': '',
				};
			// post ajax request
			__DataRequest.post(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					__Utils.viewReload();
				}
			});
		});
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
		$('#lwAvailabilityForm').toggle();
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

			const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
			const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

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
			'placeData': placeData.address_components
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
@endpush