
<div class="modal fade" id="lwInquireDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content" style="background-color: #191919;padding: 20px;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/border-radius: 24px; ">
			
			<div class="modal-header" style="border-bottom:none;display:none;">
				<h5 class="modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 27px;line-height: 37px;color: #FFFFFF;">
					Inquire
				</h5>
				<button type="button" style="color:#FFFFFF;margin-top: -20px; " class="close" data-dismiss="modal" aria-label="Close">
					<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body" style="color:#FFFFFF;">
				<form class="lwRequestInquireForm" id="lwRequestInquireForm">
					<div class="d-flex">
						<div class="p-1">
							<div class="position-relative">
								<img style="width:220px;height:220px;border:3px solid #FFFFFF!important;border-radius:10px;padding:0px;box-sizing: border-box;" class="lwInquireProfileImage lw-lazy-img" id="lwInquireProfileImage" src="<?= getUserAuthInfo('profile.profile_picture_url') ?>">
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
								<span class="d-none match_follow_badge_tag">Follow</span>
							</div>
						</div>

						<div class="p-1 ml-1" style="width:100%">
							<div class="d-flex" style="position:relative;"> 
								
								<div class="" style="width:100%;">
									<div class="d-flex">
										<div class="inquireSelectedUsername" style="font-size:16px;line-height:24px;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
											Zyzz Bruh
										</div>
										<div class="inquireSelectedCity" style="margin-left:3rem;color:#ff4141;font-size:16px;line-height:24px;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
											Minato-Ku
										</div>
									</div>	
									<div class="d-flex">
										<div class="inquireSelectedSession" style="font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 14px;line-height: 19px;color: #91929E;">
											1 hour session
										</div>
										<div class="inquireSelectedPrice" style="margin-left:3rem;font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 16px;line-height: 24px;text-align: right;color: #AFAFAF;">
											￥5,000
										</div>
									</div>
								</div>
								
								<div class="" style="right:0px;position:absolute;">
									<div class="" style="margin-left:auto;border:none;display:flex;align-items:center;padding: 1rem 1rem;height: 24px;background: #858686;border-radius: 8px;">
										<div class="sponser-review-rating jq-stars" data-rating="0">
										</div>
										<span class="inquireSelectedUserRate ml-1" style="top:2px;position: relative;"> 5 </span>
									</div>
								</div>
							</div>	

							<input type="hidden" name="selected_user_id" value="" id="inquireSelectedUserId">
							<input type="hidden" name="selected_user_pricing_id" value="" id="inquireSelectedUserPricingId">
							<input type="hidden" name="selected_price" value="" id="inquireSelectedPrice">
							<input type="hidden" name="selected_session" value="" id="inquireSelectedSession">
							<input type="hidden" name="type" value="1" >

							<div class="d-flex mt-2">
								<div class="form-group" style="flex:1;">
									<label for="desciption">Message</label>
									<textarea class="form-control inquireMessage form-control-user" id="inquireMessage" name="inquire_message" style="height:100%;min-height: 100px;" placeholder="Add a short message..."></textarea>
								</div>
							</div>
						</div>
					</div>
					<button type="button" id="btnSendInquireMessage" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile pull-right" style="padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;">Send</button>
				</form>
			</div>
		</div>
	</div>
</div>
@push('appScripts')

<script>
	function showInquireModal(image, username, city, pricing_id, price, session, user_id,rate) {

		rate = rate?rate:0; 
		$('.lwInquireProfileImage').attr('src', image);
		$('.inquireSelectedUsername').text(username);
		$('.inquireSelectedCity').text(city);
		$('.inquireSelectedSession').text(session);
		$('.inquireSelectedPrice').text(price);
		$('#inquireSelectedSession').val(session);
		$('#inquireSelectedPrice').val(price);
		$('.inquireSelectedUserRate').text(rate);
		if(rate){
			$(".sponser-review-rating").prop('data-rating',rate/5).attr('data-rating',rate/5);
		} else {
			$(".sponser-review-rating").prop('data-rating',0).attr('data-rating',0);
		}
		
		$('#inquireSelectedUserId').val(user_id);
		$('#inquireSelectedUserPricingId').val(pricing_id);

		$(".review-rating").starRating({
            strokeColor: '#FF3F3F',
            strokeWidth: 0,
            readOnly:true,
            starSize: 16,
            disableAfterRate: false,
            useFullStars: false,
            totalStars: 1,
            emptyColor: 'white',
            hoverColor: '#FF3F3F',
            activeColor: '#FF3F3F',
            useGradient: false,
        });

		$(".sponser-review-rating").starRating({
            strokeColor: '#FF3F3F',
            strokeWidth: 0,
            readOnly:true,
            starSize: 16,
            disableAfterRate: false,
            useFullStars: false,
            totalStars: 1,
            emptyColor: 'white',
            hoverColor: '#FF3F3F',
            activeColor: '#FF3F3F',
            useGradient: false,
			
        });

		$("#lwInquireDialog").modal();

	}

	$(document).ready(function(){
		$('#btnSendInquireMessage').click(function(){

			var requestUrl = "<?= route('user.write.send_inquire_message') ?>",
								formData = $("#lwRequestInquireForm").serialize();  
			// post ajax request
			__DataRequest.post(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					$("#lwInquireDialog").modal('hide');
				//	var url ='<?= route('user.read.messenger')."?selected=" ?>'+response.data.user_id;
				//	window.open(url, '_blank');
				} else {
					$('#lwChatUnavailableDialog').modal('show');
				}
			});


		});
	});

</script>
@endpush