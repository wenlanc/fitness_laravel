@if(!__isEmpty($filterData))
@foreach($filterData as $filter)
<div class="col mb-3">
	<div class="card text-center lw-user-thumbnail-block filter_item_pt_container <?= $filter['isFeaturedBadge']?"filter_item_container_feature":""?> 
	 <?= (isset($filter['isPremiumUser']) and $filter['isPremiumUser'] == true) ? 'lw-has-premium-badge' : '' ?>"
	 style="min-height: 7vw;padding: 0px;">
		<a href="<?= route('user.pt_profile_view', ['username' => $filter['username']]) ?>" class="filter_item_a">
			<img data-src="<?= imageOrNoImageAvailable($filter['profileImage']) ?>" class="@if($filter['isFeaturedBadge']) border-primary3 @else border-white3 @endif lw-user-thumbnail lw-lazy-img" style="min-height: 10vw;"/>
		</a>
		<label  class=" @if($filter['isFeaturedBadge']) filter_pt_badge_featured @else filter_pt_badge @endif">PT</label>
		@if($filter['isFeaturedBadge'])
			<span class="d-flex pt_badge_feature" style="background-color:#FC0000;">FEATURED</span>
		@endif
		<!-- show user online, idle or offline status -->
		@if($filter['userOnlineStatus'])
		<div class="pt-2" style="position:absolute; right: 1rem;">
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

		<div class="filter_item_feature_container">
			<div class="mb-1 d-flex position-relative" >
				<label class="mb-0 d-none btn filter_item_price_badge">&yen;10.00</label>
				<div class="lw-follow-box" style="position: absolute;right: -20px;bottom: -15px;">
					<!-- like button -->
					<a style="position:absolute;right: 22px;bottom: 15px;" href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $filter['id'], 'like' => 1]) ?>" data-method="post" data-show-message="false" data-callback="onLikeCallback" title="Like" class="lw-ajax-link-action" id="lwLikeBtn">
						<span  id="following-<?= $filter['id'] ?>" class=" filter_item_follow_status btn <?= (isset($filter['likeData']) and $filter['likeData'] == 1) ? 'pt_badge_tag' : 'follow_badge_tag'; ?>" >
							<?= (isset($filter['likeData']) and $filter['likeData'] == 1) ? __tr('Following') : __tr('Follow'); ?>
						</span>
					</a>
					<!-- /like button -->
				</div>

			</div>
			<div class="filter_item_feature_sub_container">
				<a class="" href="<?= route('user.profile_view', ['username' => $filter['username']]) ?>" style="width: 100%;flex: 1;display: flex;">
					<?= Str::limit($filter['kanji_name'],15) ?> <span style="margin-left:auto;"><?= $filter['userAge'] ?></span>
				</a>
				@if($filter['countryName'])
				<p style="min-height: 32px;align-items: center;display: flex;font-size:14px;">
					<i class="fa fa-map-marker"></i>

					<?= $filter['city'] ?>
					<span style="margin-left:auto;">
					@if (!__isEmpty($filter["userGymsData"])) 
                        @foreach($filter["userGymsData"] as $gym)	
						<img data-src="<?= $gym["userGymLogoUrl"]?>" class="lw-lazy-img" style="margin-left:2px;width: 32px;height: 32px;border-radius: 50%;" />
                        @endforeach
                    @endif
					<span>	
				</p>
				@endif
			</div>
		</div>
	</div>
</div>
@endforeach
@else
<!-- info message -->
<div class="col-sm-12 alert alert-info">
	<?= __tr('There are no PT found.') ?>
</div>
<!-- / info message -->
@endif

@if($hasMorePages)
<div class="lw-load-more-container-pt" id="lw-load-more-container-pt">
	<button type="button" class="btn btn-light btn-block lw-ajax-link-action lw-load-more-btn" id="lwLoadMoreButtonPT" data-action="<?= $nextPageUrl; ?>" data-callback="loadPT"><?= __tr('Load More'); ?></button>
</div>
@endif