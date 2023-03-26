<div class="sponsers_container lw-page-content" style="width:25vw;min-height:calc( 22vw + 860px );overflow-y: auto;">
	<div class="d-flex">
		<h5 style="
				font-family: Nunito Sans;
				font-style: normal;
				font-weight: bold;
				font-size: 22px;
				line-height: 27px;
				color: #FFFFFF;
			">Sponsored</h5>
	</div>

	<div class="" style="color:#FFFFFF;">
		@foreach( getSponseredList()['sponserData'] as $key => $sponser)
		<div class="d-flex mt-2">
			<div class="">
				<div class="position-relative">
					<a href="<?= route('user.pt_profile_view', ['username' => $sponser['username']]) ?>" >
						<img style="width:5rem;height:5rem;border:3px solid #FFFFFF!important;border-radius:10px;padding:0px;box-sizing: border-box;" class=" lw-lazy-img" id="lwProfilePictureStaticImage" src="<?= $sponser["userImageUrl"] ?>">
					</a>
					<label style="
						position: absolute;
						left: 0;
						top: 0;
						padding: 0rem 0.75rem;
						color: #ff4141;
						background: white;
						border-top-left-radius: 10px;
						border-bottom-right-radius: 10px;
						font-size: 0.75rem;
						font-family: Nunito Sans;
						font-style: normal;
						font-weight: bold;
						line-height: 24px;
						text-align: center;
					">PT</label>
				</div>
			</div>

			<div class="pl-2" style="width:100%">
				<div class="d-flex" style="position:relative;"> 
					
					<div class="" style="width:100%;">
						<div class="d-flex">
							<div class="" style="font-size:0.75rem;line-height:1.5rem;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
								<a href="<?= route('user.pt_profile_view', ['username' => $sponser['username']]) ?>" >	
								<?= Str::limit($sponser['kanji_name'],10) ?>
								</a>
							</div>
							<div class="sponser-session" style="">
								<svg width="18" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M12 20.9294C16.4183 20.9294 20 17.3477 20 12.9294C20 8.51117 16.4183 4.92944 12 4.92944C7.58172 4.92944 4 8.51117 4 12.9294C4 17.3477 7.58172 20.9294 12 20.9294ZM12.9933 9.81282C12.9355 9.31548 12.5128 8.92944 12 8.92944C11.4477 8.92944 11 9.37716 11 9.92944V13.6794L11.0072 13.7992C11.0498 14.1539 11.28 14.4628 11.6154 14.6025L14.6154 15.8525L14.7256 15.8912C15.2069 16.0291 15.7258 15.7874 15.9231 15.3141L15.9617 15.2038C16.0997 14.7225 15.858 14.2036 15.3846 14.0064L13 13.0124V9.92944L12.9933 9.81282Z" fill="white"/>
								</svg>
								<?= $sponser['session'] ?>
							</div>
						</div>	
						<div class="d-flex">
							
							<div class="" style="color:#ff4141;font-size:0.75rem;line-height:1.4rem;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
								<?= Str::limit($sponser['city'],10) ?>
							</div>
							<div class="" style="margin-left:auto;font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 0.85rem;line-height: 1.4rem;text-align: right;color: #AFAFAF;">
								￥<?= floatval($sponser['price']) ?>
							</div>
						</div>
					</div>
				</div>			

				<div class="d-flex">
					<button type="button" onclick="showInquireModal('<?= $sponser['userImageUrl'] ?>', '<?= $sponser['kanji_name']?>', '<?= $sponser['city']?>', '<?= $sponser['user_pricing_id'] ?>', '<?= '￥'.floatval($sponser['price']) ?>', '<?= $sponser['session'] ?>', '<?= $sponser['users__id'] ?>', '<?= getTotalRateUser($sponser['users__id']) ?>' )" role="button"  class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile btnSponserInquire" style="border: none;
						display: flex;
						align-items: center;
						padding: 0.75rem 1rem;
						height: 2rem;
						margin-right:0.25rem;
						background: #FF3F3F;
						border-radius: 0.5rem;">Inquire</button>
					<div class="" style="margin-left: auto;
							border: none;
							display: flex;
							align-items: center;
							padding: 0.75rem;
							height: 2rem;
							background: #858686;
							border-radius: 0.5rem;">
						<div class="sponser-review-rating jq-stars" data-rating="1">
						</div>
						<span class="ml-1" style="top:2px;position: relative;"> <?= __isEmpty(getTotalRateUser($sponser['users__id']))?"0":getTotalRateUser($sponser['users__id']) ?> </span>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@include('modals.inquire_modal')
@push('appScripts')

<script>
$(".sponser-review-rating").starRating({
		strokeColor: 'white',
		strokeWidth: 0,
		readOnly:true,
		starSize: 16,
		disableAfterRate: false,
		useFullStars: true,
		totalStars: 1,
		emptyColor: 'white',
		hoverColor: 'white',
		activeColor: 'white',
		useGradient: false,
	});

</script>
@endpush