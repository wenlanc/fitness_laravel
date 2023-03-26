@section('page-title', __tr('Settings'))
@section('head-title', __tr('Settings'))
@section('keywordName', __tr('Settings'))
@section('keyword', __tr('Settings'))
@section('description', __tr('Settings'))
@section('keywordDescription', __tr('Settings'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())
@push('header')
<style>
	#cardNumber iframe {
		height: 48px!important;
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

</style>
@endpush
<?php 
use Carbon\Carbon;
$user_role_id = getUserAuthInfo()["profile"]["role_id"];
$membership = '';
$card_icon = '';
if($premiumPlanData["isPremiumUser"]) {
	$membership = $premiumPlanData["userSubscriptionData"]["membership"];
	$card_icon = $premiumPlanData["userSubscriptionData"]["card_icon"];
}

?>
<div class="d-flex" style="justify-content: center;">
	@if( $user_role_id == 2 )
		@if(!$premiumPlanData["isPremiumUser"])
		<div class="mt-3 p-3" style="max-width:400px;width:90%;font-family: Nunito Sans;font-style: normal;font-weight: normal; border: 1px solid #353535;box-sizing: border-box;border-radius: 10px;">
			<h6 class="" style="font-size: 21px;line-height: 24px;">
				STACKD Free
			</h6>
			<span class="mt-3" style="font-size: 13px;line-height: 24px;"> Free Forever </span>

			<div class="d-flex mt-4" style="width: 100%;">
				<button type="submit" role="button" data-toggle="modal" data-target="#lwBillingProDialog" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile" style="width:100%;text-align:center;border:none;padding:0.5rem;background: #FF4141;border-radius: 10px;"><i class="fa fa-star" style="color:#FDC748;"></i>&nbsp;&nbsp;&nbsp;Try PRO Now</button>
			</div>
		</div>
		@else
		<div class="mt-4 p-4" style="max-width:400px;width:90%;font-family: Nunito Sans;font-style: normal;font-weight: normal; border: 1px solid #353535;box-sizing: border-box;border-radius: 10px;">
			<h6 class="" style="font-size: 21px;line-height: 24px;">
				<i class="fa fa-star" style="color:#FDC748;"></i>&nbsp;&nbsp;&nbsp;STACKD PRO

				@if( $premiumPlanData["userSubscriptionData"]["status"]  == 2 )
				<span style="color:#FF3f3f;">(CANCELLED)</span>
				@else 
				<span>(CURRENT)</span>
				@endif
			</h6>
			<div class="d-flex mt-4" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> 
					@if($premiumPlanData["userSubscriptionData"]["card_icon"] == 'visa')
						<img src="/imgs/credit_cards/visa.svg" alt="Visa"/>
					@else 
						@if($premiumPlanData["userSubscriptionData"]["card_icon"] == 'amex')
							<img src="/imgs/credit_cards/amex.svg" alt="American Express"/>
						@else 
							@if($premiumPlanData["userSubscriptionData"]["card_icon"] == 'jcb')
								<img src="/imgs/credit_cards/jcb.svg" alt="JCB"/>
							@else
								<i class="fa fa-<?= $premiumPlanData["userSubscriptionData"]["card_icon"]?>" style="font-size:22px;"></i> 
							@endif
						@endif
					@endif
					&nbsp;&nbsp;&nbsp;
					<?= $premiumPlanData["userSubscriptionData"]["card_type"] ?> - <?= $premiumPlanData["userSubscriptionData"]["card_last4"] ?> 
				</span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">￥<?= $premiumPlanData["userSubscriptionData"]["planPrice"] ?> per <?= $premiumPlanData["userSubscriptionData"]["planTitle"] ?> </span>
			</div>
			<div class="d-flex mt-2" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> Start Date </span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
					<?= $premiumPlanData["userSubscriptionData"]["start_date"] ?>  
				</span>
			</div>

			@if( $premiumPlanData["userSubscriptionData"]["status"]  == 2 )
			<div class="d-flex mt-2" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> Subscription Ends </span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
					<?= $premiumPlanData["userSubscriptionData"]["plan_period_end"] ?> 
				</span>
			</div>
			@else
			<div class="d-flex mt-2" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> Next Payment Due </span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
					<?= $premiumPlanData["userSubscriptionData"]["next_payment_date"] ?> 
				</span>
			</div>

			<div class="d-flex row justify-content-center p-2" id="containerBtn">
				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button"  class="btn btn-primary btn-user btn-block-on-mobile" id="btnUpdateCardProSubscription" style="width:100%;text-align:center;border:none;padding:0.5rem;background: #FF3F3F;border-radius: 10px;">
						Update Card
					</button>
				</div>
				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button" data-toggle="modal" data-target="#lwSubscriptionCancelDialog" id="cancelProSubscriptionBtn" class="btn btn-block-on-mobile" style="width:100%;text-align:center;border:1px solid #FF3F3F;color:#FF3F3F;padding:0.5rem;background: transparent;border-radius: 10px;">Cancel</button>
				</div>
			</div>

			<div class="d-none row justify-content-center p-2" id="containerUpdateDetail">
				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button"  class="btn btn-user btn-block-on-mobile" style="width:100%;text-align:center;border:1px solid #FF3F3F;padding:0.5rem;background:transparent;color:#FF3F3F;border-radius: 10px;">
						Update Card
					</button>
				</div>
				<form id="formUpdateCardSubscription" >
				<div class="p-4 row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" style="font-family: Nunito Sans;font-style: normal;color:white;">
					<div class="col ml-1 d-flex pt-2" style="font-weight: bold;font-size: 11px;"> 
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M3 10C2.44772 10 2 10.4477 2 11V17C2 18.6569 3.34315 20 5 20H19C20.6569 20 22 18.6569 22 17V11C22 10.4477 21.5523 10 21 10H3ZM5 14C4.44772 14 4 14.4477 4 15C4 15.5523 4.44772 16 5 16H11C11.5523 16 12 15.5523 12 15C12 14.4477 11.5523 14 11 14H5Z" fill="white"/>
						<path d="M2 7C2 5.34315 3.34315 4 5 4H19C20.6569 4 22 5.34315 22 7C22 7.55228 21.5523 8 21 8H3C2.44772 8 2 7.55228 2 7Z" fill="white"/>
						</svg> 
						&nbsp;&nbsp;
						<span class="pt-1"> Credit or Debit Card </span> 
					</div>
					<div class="col ml-1 pt-2 form-group mb-0">
						<div id="paymentResponse"></div>
						<!--  success messages  -->
						<div class="alert alert-success alert-dismissible fade show lwSuccessMessage" style="display:none;"></div>
						<!--  /success messages  -->
						<!--  error messages  -->
						<div class="alert alert-danger alert-dismissible fade show lwErrorMessage" style="display:none;"></div>
						<!--  /error messages  -->
					</div>

					<div class="col ml-1 pt-2 form-group mb-0">
						<label class="mb-0" for="name">Name</label>
						<input type="text" name="custName" class="form-control " style="color:white;"> 
					</div>
					<div class="d-none col ml-1 pt-1 form-group mb-0">
						<label class="mb-0" for="email">Email</label>
						<input type="email" name="custEmail" class="form-control" style="color:white;"> 
					</div>
					<div class="col ml-1 pt-1 form-group mb-0">
						<label class="mb-0">Card Number</label>
						<div id="cardNumber" class=""> </div>
					</div>

					<div class="col ml-1 pt-1">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="mb-0">CVC</label>
									<div id="cardCVC" class=""> </div>
								</div>
							</div> <div class="col-md-1"></div>
							<div class="col-md-7">
								<div class="form-group">
									<label class="mb-0">Expiration (MM/YYYY)</label>
									<div id="cardExp" class=""> </div>
								</div>
							</div>
						</div>	
					</div>
					<div class="pt-2 mr-4 pr-4 col d-flex"> 
						<button type="button" id="btnCardUpdate" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;">
							Save
						</button>
					</div>
					<div class=" col d-flex1 pt-2" style="font-weight: bold;font-size: 13px; text-align:center;"> 
						<button type="button" class="btn" id="btnCancelUpdateSubscription" style="text-decoration: underline;"> Back </button>
					</div>
				</div>
				</form>
			</div>
			@endif
		</div>
		@endif
	@endif 
	
	@if( $user_role_id == 3 && $premiumPlanData["isPremiumUser"] )	
		@if( $membership == "standard")
		<div class="p-4" style="max-width:500px;width:90%;font-family: Nunito Sans;font-style: normal;font-weight: normal; border: 1px solid #353535;box-sizing: border-box;border-radius: 10px;">
			<h6 class="" style="font-size: 21px;line-height: 24px;">
				<i class="fa fa-star" style="color:#2499DB;"></i>&nbsp;&nbsp;&nbsp;
				STACKD PT Basic 
				@if( $premiumPlanData["userSubscriptionData"]["status"]  == 2 )
				<span style="color:#FF3f3f;">(CANCELLED)</span>
				@else 
				<span>(CURRENT)</span>
				@endif
			</h6>
			<div class="d-flex mt-4" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> 
					@if( $card_icon == 'visa')
						<img src="/imgs/credit_cards/visa.svg" alt="Visa"/>
					@else 
						@if( $card_icon == 'amex')
							<img src="/imgs/credit_cards/amex.svg" alt="American Express"/>
						@else 
							@if($card_icon == 'jcb')
								<img src="/imgs/credit_cards/jcb.svg" alt="JCB"/>
							@else
								<i class="fa fa-<?= $card_icon ?>" style="font-size:22px;"></i> 
							@endif
						@endif
					@endif
					&nbsp;&nbsp;&nbsp;
					<?= $premiumPlanData["userSubscriptionData"]["card_type"] ?> - <?= $premiumPlanData["userSubscriptionData"]["card_last4"] ?> 
				</span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">￥<?= $premiumPlanData["userSubscriptionData"]["planPrice"] ?> per <?= $premiumPlanData["userSubscriptionData"]["planTitle"] ?> </span>
			</div>
			<div class="d-flex mt-2" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> Start Date </span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
					<?= $premiumPlanData["userSubscriptionData"]["start_date"] ?>  
				</span>
			</div>

			@if( $premiumPlanData["userSubscriptionData"]["status"]  == 2 )
			<div class="d-flex mt-2" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> Subscription Ends </span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
					<?= $premiumPlanData["userSubscriptionData"]["plan_period_end"] ?> 
				</span>
			</div>
			@else
			<div class="d-flex mt-2" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> Next Payment Due </span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
					<?= $premiumPlanData["userSubscriptionData"]["next_payment_date"] ?> 
				</span>
			</div>

			<div class="d-flex row justify-content-center p-2" id="containerBtn">
				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button"  class="btn btn-primary btn-user btn-block-on-mobile" id="btnUpdateCardProSubscription" style="width:100%;text-align:center;border:none;padding:0.5rem;background: #FF3F3F;border-radius: 10px;">
						Update Card
					</button>
				</div>
				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button" data-toggle="modal" data-target="#lwSubscriptionCancelDialog" id="cancelProSubscriptionBtn" class="btn btn-block-on-mobile" style="width:100%;text-align:center;border:1px solid #FF3F3F;color:#FF3F3F;padding:0.5rem;background: transparent;border-radius: 10px;">Cancel</button>
				</div>

				<div class="d-flex row justify-content-start mt-3 p-2" style="width: 100%;">
					<h6 class="" style="font-size: 20px;line-height: 24px;width: 100%; display: flex;">
						<i class="fa fa-star" style="color:#FDC748;"></i>&nbsp;&nbsp;&nbsp;STACKD PT Pro
						<span style="font-size:13px;line-height:24px;margin-left:auto;"> ￥
							<?php
								$selected_plan = $premiumPlanData["userSubscriptionData"]["planTitle"];
								echo $premiumPlanData["premiumPlans"]["premium"][$selected_plan]["price"];
							?> per <?php echo $selected_plan;?>
						<?php //print_r($premiumPlanData) ?>
					  </span>
					</h6>
				</div>

				<div class="d-flex row" style="width: 100%;">
					<table class="table table-hover table-pricing" style="color:white;">
						<thead>
							<tr>
								<th></th>
								<th style="text-align:center;border-right:1px solid #515151;font-size: 11px;"><span>PT Basic</span></th>
								<th style="text-align:center;font-size: 11px;"><span>PT Pro</span></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<span style="font-size:11px;">Unlimited messaging</span>
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
									<span style="font-size:11px;">Business in one spot</span>
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
									<span style="font-size:11px;">See who views your page</span>
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
									<span style="font-size:11px;">Upload pricing</span>
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
									<span style="font-size:11px;">Access to customers worldwide</span>
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
									<span style="font-size:11px;">Priority features in search results</span>
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
									<span style="font-size:11px;">Unlimited follows everyday</span>
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
							
						</tbody>
					</table>
				</div>


				<div class="d-flex mt-4" style="width: 100%;">
					<span class="" style="font-size: 13px;line-height: 24px;"> 
						@if( $card_icon == 'visa')
							<img src="/imgs/credit_cards/visa.svg" alt="Visa"/>
						@else 
							@if( $card_icon == 'amex')
								<img src="/imgs/credit_cards/amex.svg" alt="American Express"/>
							@else 
								@if($card_icon == 'jcb')
									<img src="/imgs/credit_cards/jcb.svg" alt="JCB"/>
								@else
									<i class="fa fa-<?= $card_icon ?>" style="font-size:22px;"></i> 
								@endif
							@endif
						@endif
						&nbsp;&nbsp;&nbsp;
						<?= $premiumPlanData["userSubscriptionData"]["card_type"] ?> - <?= $premiumPlanData["userSubscriptionData"]["card_last4"] ?> 
					</span>
					
					<span style="font-size:13px;line-height:24px;margin-left:auto;"> ￥
						<?php
							$selected_plan = $premiumPlanData["userSubscriptionData"]["planTitle"];
							echo $premiumPlanData["premiumPlans"]["premium"][$selected_plan]["price"];
						?> per <?php echo $selected_plan;?>
					</span>
				</div>
				<div class="d-flex mt-2" style="width: 100%;">
					<span class="" style="font-size: 13px;line-height: 24px;"> Start Date </span>
					<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
						NOW
					</span>
				</div>
				
				<div class="d-flex mt-2" style="width: 100%;">
					<span class="" style="font-size: 13px;line-height: 24px;"> Next Payment Due </span>
					<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
						<?php echo Carbon::now()->addMonthsNoOverflow(1)->format('j F Y');?>
					</span>
				</div>
				
				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button" id="upgradeSubscriptionBtn" class="btn btn-block-on-mobile" style="width:100%;text-align:center;border:1px solid #FDC748;color:#FDC748;padding:0.5rem;background: transparent;border-radius: 10px;">Upgrade to STAKD PT Pro</button>
				</div>

			</div>

			<div class="d-none row justify-content-center p-2" id="containerUpdateDetail">
				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button"  class="btn btn-user btn-block-on-mobile" style="width:100%;text-align:center;border:1px solid #FF3F3F;padding:0.5rem;background:transparent;color:#FF3F3F;border-radius: 10px;">
						Update Card
					</button>
				</div>
				<form id="formUpdateCardSubscription" >
				<div class="p-4 row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" style="font-family: Nunito Sans;font-style: normal;color:white;">
					<div class="col ml-1 d-flex pt-2" style="font-weight: bold;font-size: 11px;"> 
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M3 10C2.44772 10 2 10.4477 2 11V17C2 18.6569 3.34315 20 5 20H19C20.6569 20 22 18.6569 22 17V11C22 10.4477 21.5523 10 21 10H3ZM5 14C4.44772 14 4 14.4477 4 15C4 15.5523 4.44772 16 5 16H11C11.5523 16 12 15.5523 12 15C12 14.4477 11.5523 14 11 14H5Z" fill="white"/>
						<path d="M2 7C2 5.34315 3.34315 4 5 4H19C20.6569 4 22 5.34315 22 7C22 7.55228 21.5523 8 21 8H3C2.44772 8 2 7.55228 2 7Z" fill="white"/>
						</svg> 
						&nbsp;&nbsp;
						<span class="pt-1"> Credit or Debit Card </span> 
					</div>
					<div class="col ml-1 pt-2 form-group mb-0">
						<div id="paymentResponse"></div>
						<!--  success messages  -->
						<div class="alert alert-success alert-dismissible fade show lwSuccessMessage" style="display:none;"></div>
						<!--  /success messages  -->
						<!--  error messages  -->
						<div class="alert alert-danger alert-dismissible fade show lwErrorMessage" style="display:none;"></div>
						<!--  /error messages  -->
					</div>

					<div class="col ml-1 pt-2 form-group mb-0">
						<label for="name" class="mb-0">Name</label>
						<input type="text" name="custName" class="form-control " style="color:white;"> 
					</div>
					<div class="d-none col ml-1 pt-1 form-group mb-0">
						<label for="email" class="mb-0">Email</label>
						<input type="email" name="custEmail" class="form-control" style="color:white;"> 
					</div>
					<div class="col ml-1 pt-1 form-group mb-0">
						<label class="mb-0">Card Number</label>
						<div id="cardNumber" class=""> </div>
					</div>

					<div class="col ml-1 pt-1">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="mb-0">CVC</label>
									<div id="cardCVC" class=""> </div>
								</div>
							</div> <div class="col-md-1"></div>
							<div class="col-md-7">
								<div class="form-group">
									<label class="mb-0">Expiration (MM/YYYY)</label>
									<div id="cardExp" class=""> </div>
								</div>
							</div>
						</div>	
					</div>
					<div class="pt-2 mr-4 pr-4 col d-flex"> 
						<button type="button" id="btnCardUpdate" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;">
							Save
						</button>
					</div>
					<div class=" col d-flex1 pt-2" style="font-weight: bold;font-size: 13px; text-align:center;"> 
						<button type="button" class="btn" id="btnCancelUpdateSubscription" style="text-decoration: underline;"> Back </button>
					</div>
				</div>
				</form>
			</div>
			@endif
		</div>
		@else
		<div class="p-4" style="max-width:500px;width:90%;font-family: Nunito Sans;font-style: normal;font-weight: normal; border: 1px solid #353535;box-sizing: border-box;border-radius: 10px;">
			<h6 class="" style="font-size: 21px;line-height: 24px;">
				<i class="fa fa-star" style="color:#FDC748;"></i>&nbsp;&nbsp;&nbsp;

				STACKD PT Pro 
				@if( $premiumPlanData["userSubscriptionData"]["status"]  == 2 )
				<span style="color:#FF3f3f;">(CANCELLED)</span>
				@else 
				<span>(CURRENT)</span>
				@endif
			</h6>
			<div class="d-flex mt-4" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> 
					@if($card_icon == 'visa')
						<img src="/imgs/credit_cards/visa.svg" alt="Visa"/>
					@else 
						@if($card_icon == 'amex')
							<img src="/imgs/credit_cards/amex.svg" alt="American Express"/>
						@else 
							@if($card_icon == 'jcb')
								<img src="/imgs/credit_cards/jcb.svg" alt="JCB"/>
							@else
								<i class="fa fa-<?= $card_icon?>" style="font-size:22px;"></i> 
							@endif
						@endif
					@endif
					&nbsp;&nbsp;&nbsp;
					<?= $premiumPlanData["userSubscriptionData"]["card_type"] ?> - <?= $premiumPlanData["userSubscriptionData"]["card_last4"] ?> 
				</span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">￥<?= $premiumPlanData["userSubscriptionData"]["planPrice"] ?> per <?= $premiumPlanData["userSubscriptionData"]["planTitle"] ?> </span>
			</div>
			<div class="d-flex mt-2" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> Start Date </span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
					<?= $premiumPlanData["userSubscriptionData"]["start_date"] ?>  
				</span>
			</div>

			@if( $premiumPlanData["userSubscriptionData"]["status"]  == 2 )
			<div class="d-flex mt-2" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> Subscription Ends </span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
					<?= $premiumPlanData["userSubscriptionData"]["plan_period_end"] ?> 
				</span>
			</div>
			@else
			<div class="d-flex mt-2" style="width: 100%;">
				<span class="" style="font-size: 13px;line-height: 24px;"> Next Payment Due </span>
				<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
					<?= $premiumPlanData["userSubscriptionData"]["next_payment_date"] ?> 
				</span>
			</div>

			<div class="d-flex row justify-content-center p-2" id="containerBtn">
				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button"  class="btn btn-primary btn-user btn-block-on-mobile" id="btnUpdateCardProSubscription" style="width:100%;text-align:center;border:none;padding:0.5rem;background: #FF3F3F;border-radius: 10px;">
						Update Card
					</button>
				</div>
				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button" data-toggle="modal" data-target="#lwSubscriptionCancelDialog" id="cancelProSubscriptionBtn" class="btn btn-block-on-mobile" style="width:100%;text-align:center;border:1px solid #FF3F3F;color:#FF3F3F;padding:0.5rem;background: transparent;border-radius: 10px;">Cancel</button>
				</div>


				<div class="d-flex row justify-content-start mt-3 p-2" style="width: 100%;">
					<h6 class="" style="font-size: 20px;line-height: 24px;width: 100%; display: flex;">
						<i class="fa fa-star" style="color:#2499DB;"></i>&nbsp;&nbsp;&nbsp;STACKD PT Basic
						<span style="font-size:13px;line-height:24px;margin-left:auto;"> ￥
							<?php
								$selected_plan = $premiumPlanData["userSubscriptionData"]["planTitle"];
								echo $premiumPlanData["premiumPlans"]["standard"][$selected_plan]["price"];
							?> per <?php echo $selected_plan;?>
						<?php //print_r($premiumPlanData) ?>
					  </span>
					</h6>
				</div>

				<div class="d-flex row" style="width: 100%;">
					<table class="table table-hover table-pricing" style="color:white;">
						<thead>
							<tr>
								<th></th>
								<th style="text-align:center;border-right:1px solid #515151;font-size: 11px;"><span>PT Basic</span></th>
								<th style="text-align:center;font-size: 11px;"><span>PT Pro</span></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<span style="font-size:11px;">Unlimited messaging</span>
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
									<span style="font-size:11px;">Business in one spot</span>
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
									<span style="font-size:11px;">See who views your page</span>
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
									<span style="font-size:11px;">Upload pricing</span>
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
									<span style="font-size:11px;">Access to customers worldwide</span>
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
									<span style="font-size:11px;">Priority features in search results</span>
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
									<span style="font-size:11px;">Unlimited follows everyday</span>
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
							
						</tbody>
					</table>
				</div>

				
				<div class="d-flex mt-4" style="width: 100%;">
					<span class="" style="font-size: 13px;line-height: 24px;"> 
						@if( $card_icon == 'visa')
							<img src="/imgs/credit_cards/visa.svg" alt="Visa"/>
						@else 
							@if( $card_icon == 'amex')
								<img src="/imgs/credit_cards/amex.svg" alt="American Express"/>
							@else 
								@if($card_icon == 'jcb')
									<img src="/imgs/credit_cards/jcb.svg" alt="JCB"/>
								@else
									<i class="fa fa-<?= $card_icon ?>" style="font-size:22px;"></i> 
								@endif
							@endif
						@endif
						&nbsp;&nbsp;&nbsp;
						<?= $premiumPlanData["userSubscriptionData"]["card_type"] ?> - <?= $premiumPlanData["userSubscriptionData"]["card_last4"] ?> 
					</span>
					
					<span style="font-size:13px;line-height:24px;margin-left:auto;"> ￥
						<?php
							$selected_plan = $premiumPlanData["userSubscriptionData"]["planTitle"];
							echo $premiumPlanData["premiumPlans"]["standard"][$selected_plan]["price"];
						?> per <?php echo $selected_plan;?>
					</span>
				</div>
				<div class="d-flex mt-2" style="width: 100%;">
					<span class="" style="font-size: 13px;line-height: 24px;"> Start Date </span>
					<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
						<?= $premiumPlanData["userSubscriptionData"]["next_payment_date"] ?> 
					</span>
				</div>
				
				<div class="d-flex mt-2" style="width: 100%;">
					<span class="" style="font-size: 13px;line-height: 24px;"> Next Payment Due </span>
					<span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
						<?= $premiumPlanData["userSubscriptionData"]["next_payment_date"] ?> 
					</span>
				</div>
				

				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button" id="downgradeSubscriptionBtn" class="btn btn-block-on-mobile" style="width:100%;text-align:center;border:1px solid #2499DB;color:#2499DB;padding:0.5rem;background: transparent;border-radius: 10px;">Downgrade to STAKD PT Basic</button>
				</div>

			</div>

			<div class="d-none row justify-content-center p-2" id="containerUpdateDetail">
				<div class="d-flex mt-2" style="width: 100%;">
					<button type="button" role="button"  class="btn btn-user btn-block-on-mobile" style="width:100%;text-align:center;border:1px solid #FF3F3F;padding:0.5rem;background:transparent;color:#FF3F3F;border-radius: 10px;">
						Update Card
					</button>
				</div>
				<form id="formUpdateCardSubscription" >
				<div class="p-4 row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" style="font-family: Nunito Sans;font-style: normal;color:white;">
					<div class="col ml-1 d-flex pt-2" style="font-weight: bold;font-size: 11px;"> 
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M3 10C2.44772 10 2 10.4477 2 11V17C2 18.6569 3.34315 20 5 20H19C20.6569 20 22 18.6569 22 17V11C22 10.4477 21.5523 10 21 10H3ZM5 14C4.44772 14 4 14.4477 4 15C4 15.5523 4.44772 16 5 16H11C11.5523 16 12 15.5523 12 15C12 14.4477 11.5523 14 11 14H5Z" fill="white"/>
						<path d="M2 7C2 5.34315 3.34315 4 5 4H19C20.6569 4 22 5.34315 22 7C22 7.55228 21.5523 8 21 8H3C2.44772 8 2 7.55228 2 7Z" fill="white"/>
						</svg> 
						&nbsp;&nbsp;
						<span class="pt-1"> Credit or Debit Card </span> 
					</div>
					<div class="col ml-1 pt-2 form-group mb-0">
						<div id="paymentResponse"></div>
						<!--  success messages  -->
						<div class="alert alert-success alert-dismissible fade show lwSuccessMessage" style="display:none;"></div>
						<!--  /success messages  -->
						<!--  error messages  -->
						<div class="alert alert-danger alert-dismissible fade show lwErrorMessage" style="display:none;"></div>
						<!--  /error messages  -->
					</div>

					<div class="col ml-1 pt-2 form-group mb-0">
						<label for="name">Name</label>
						<input type="text" name="custName" class="form-control " style="color:white;"> 
					</div>
					<div class="d-none col ml-1 pt-1 form-group mb-0">
						<label for="email">Email</label>
						<input type="email" name="custEmail" class="form-control" style="color:white;"> 
					</div>
					<div class="col ml-1 pt-1 form-group mb-0">
						<label class="mb-0">Card Number</label>
						<div id="cardNumber" class=""> </div>
					</div>

					<div class="col ml-1 pt-1">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="mb-0">CVC</label>
									<div id="cardCVC" class=""> </div>
								</div>
							</div> <div class="col-md-1"></div>
							<div class="col-md-7">
								<div class="form-group">
									<label class="mb-0">Expiration (MM/YYYY)</label>
									<div id="cardExp" class=""> </div>
								</div>
							</div>
						</div>	
					</div>
					<div class="pt-2 mr-4 pr-4 col d-flex"> 
						<button type="button" id="btnCardUpdate" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;">
							Save
						</button>
					</div>
					<div class=" col d-flex1 pt-2" style="font-weight: bold;font-size: 13px; text-align:center;"> 
						<button type="button" class="btn" id="btnCancelUpdateSubscription" style="text-decoration: underline;"> Back </button>
					</div>
				</div>
				</form>
			</div>
			@endif
		</div>
		@endif
	@endif
</div>

@if($user_role_id == 2 )

	<?php 
		$userSubscription = getUserSubscriptionStripe();
		$subscriptionStatus = !is_null($userSubscription)?$userSubscription["status"]:0;  // 2 - canceled , 3 - billing failed
	?>
	@if(!$premiumPlanData["isPremiumUser"])

	<div class="modal fade" id="lwBillingProDialog" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="userReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content" style="background-color: #191919;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/ border-radius: 24px; ">
                
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
								@if( $subscriptionStatus  > 1 )
                                <div class="col-lg-12 d-flex pt-4 mt-3" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> It appears that your subscription has expired. </div>
                                <div class="col-lg-12 d-flex pt-3" style="font-weight: normal;font-size: 1rem;line-height: 24px;"> Your fitness hub unlocked to its full potential. </div>
                                @else 
								<div class="col-lg-12 d-flex pt-4 mt-3" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Do more with STACKD Pro. </div>
                                <div class="col-lg-12 d-flex pt-3" style="font-weight: normal;font-size: 1rem;line-height: 24px;"> Your fitness hub unlocked to its full potential. </div>
								@endif
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
							<button type="button" style="color:#FFFFFF;margin-top: -20px; " class="close" data-dismiss="modal" aria-label="Close">
								<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
							</button>
                            <form id="payment-form" class="lw-ajax-form1 lw-form1" method="post" data-show-message="true" action="<?= route('user.write.setting-subscription') ?>" data-callback="onSubscriptionStripeCallback" >
                            <div id="payment_type_container" class="p-4 row" style="font-family: Nunito Sans;font-style: normal;color:white;">

								@if( $subscriptionStatus  > 1 )
                                <div class="col-lg-12 d-flex pt-2 pb-2" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Try STACKD PRO </div>
                                <div class="col-lg-12 d-flex pt-2 pb-2" style="padding-left:20px;font-weight: bold;font-size: 0.75rem;line-height: 24px;"> </div>
                                @else 
								<div class="col-lg-12 d-flex pt-2 pb-2" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Try STACKD PRO for free </div>
                                <div class="col-lg-12 d-flex pt-2 pb-2" style="padding-left:20px;font-weight: bold;font-size: 0.75rem;line-height: 24px;"> Free 30 day trial, cancel any time</div>
								@endif

								@foreach( $premiumPlanData["premiumPlans"]['pro'] as $plan_key=>$plan_val)
									@if( $plan_val["enable"])
									<div class="col-lg-12" >
										<div class="col-lg-12 d-flex pt-2 mt-3 pl-5 pr-2 custom-control custom-radio custom-control-inline">
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
											<span>( ￥<?= round($plan_val["price"]/12,2) ?> / month ) </span> 
											@endif
										</div>
									</div>	
									@endif
								@endforeach


                                <!-- <div class="ml-3 col-lg-12 d-flex pt-4" style="font-weight: bold;font-size: 11px;"> Due January 22, 2022 <span style="margin-left: auto;"> ￥4,800 </span></div>
                                <div class="ml-3 col-lg-12 d-flex pt-1" style="font-weight: bold;font-size: 11px;"> Due today <span style="margin-left: auto;"> ￥0 </span></div> -->
        
                                <div class="pt-4 ml-4 pl-4 mr-4 pr-4 col-lg-12 d-flex"> 
                                    <button type="button" id="paymentSubscribeBtn" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;border: none;">
										@if( $subscriptionStatus  < 2 )
											Try for free for 30 days
										@else
											Join today
										@endif	
									</button>
                                </div>
                                <div class="ml-4 pl-4 col-lg-12 d-flex1 pt-2" style="font-weight: bold;font-size: 13px; text-align:center;"> Cancel any time </div>
                            
                            </div>	
                            
                            <div id="payment_card_container" class="p-4 row" style="display:none;font-family: Nunito Sans;font-style: normal;color:white;">
                                
								@if( $subscriptionStatus  < 2 )
								<div class="col-lg-12 d-flex pt-2" style="font-weight: bold;font-size: 1.25rem;line-height: 24px;"> Try STACKD PRO </div>
								<div class="col-lg-12 d-flex pt-2 pl-4" style="font-weight: bold;font-size: 0.75rem;line-height: 24px;"> Free 30 day trial, cancel any time </div>                              
								@else
								<div class="col-lg-12 d-flex pt-2" style="font-weight: bold;font-size: 1.25rem;line-height: 24px;">Subscribe to STACKD PRO </div>
								@endif
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
								@if( $subscriptionStatus  < 2 )
                                <div class="ml-2 col-lg-12 d-flex pt-2" style="font-weight: bold;font-size: 11px;"> First payment due <?= \Carbon\Carbon::now()->addDays(30)->format('F d, Y')?> <span id="dueSelectedPrice" class="dueSelectedPrice" style="margin-left: auto;"> </span></div>
                                <div class="ml-2 col-lg-12 d-flex pt-1" style="font-weight: bold;font-size: 11px;padding-bottom:5px;border-bottom:1px solid #515151;"> Due today <span style="margin-left: auto;"> ￥0 </span></div>
								@else
								<div class="ml-2 col-lg-12 d-flex pt-2" style="font-weight: bold;font-size: 11px;"> <span id="dueSelectedDate"> First payment due <?= \Carbon\Carbon::now()->addDays(30)->format('F d, Y')?></span> <span id="dueSelectedPrice" class="dueSelectedPrice" style="margin-left: auto;"> </span></div>
                                <div class="ml-2 col-lg-12 d-flex pt-1" style="font-weight: bold;font-size: 11px;padding-bottom:5px;border-bottom:1px solid #515151;"> Due today <span class="dueSelectedPrice" style="margin-left: auto;"> ￥0 </span></div>
								@endif
								<div class="col-lg-12 ml-1 d-flex pt-2" style="font-weight: bold;font-size: 11px;"> 
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 10C2.44772 10 2 10.4477 2 11V17C2 18.6569 3.34315 20 5 20H19C20.6569 20 22 18.6569 22 17V11C22 10.4477 21.5523 10 21 10H3ZM5 14C4.44772 14 4 14.4477 4 15C4 15.5523 4.44772 16 5 16H11C11.5523 16 12 15.5523 12 15C12 14.4477 11.5523 14 11 14H5Z" fill="white"/>
                                    <path d="M2 7C2 5.34315 3.34315 4 5 4H19C20.6569 4 22 5.34315 22 7C22 7.55228 21.5523 8 21 8H3C2.44772 8 2 7.55228 2 7Z" fill="white"/>
                                    </svg> 
                                    &nbsp;&nbsp;
                                    <span style="align-self: center;"> Credit or Debit Card </span> 
                                </div>

                                <div class="col-lg-12 ml-1 pt-2 form-group mb-0">
                                    <label for="name" class="mb-0">Name</label>
                                    <input type="text" name="custName" class="form-control" style="color:white;background: #2C2C2D;border: 1px solid #FFFFFF;box-sizing: border-box;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 14px;height:48px;padding-left:5px;"> 
                                </div>
                                <div class="d-none col-lg-12 ml-1 pt-1 form-group mb-0">
                                    <label class="mb-0" for="email">Email</label>
                                    <input type="email" name="custEmail" class="form-control" style="color:white;background: #2C2C2D;border: 1px solid #FFFFFF;box-sizing: border-box;box-shadow: 0px 1px 2px rgba(184, 200, 224, 0.222055);border-radius: 14px;height:48px;padding-left:5px;"> 
                                </div>
                                <div class="col-lg-12 ml-1 pt-0 form-group mb-0">
                                    <label class="mb-0">Card Number</label>
                                    <div id="cardNumber" class=""> </div>
                                    <!-- <input type="text" name="cardNumber" size="20" autocomplete="off" id="cardNumber" class="form-control"  style="color:white;"/> -->
                                </div>

                                <div class="col-lg-12 ml-1 pt-0">
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
										
										@if( $subscriptionStatus  < 2 )
										Get your free trial
										@else
										Subscribe now
										@endif
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

	@else

	
	@endif
@endif
<!-- user cancel subscription -->
<div class="modal fade" id="lwSubscriptionCancelDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content" style="background: #191919;border-radius: 20px;">
			<div class="modal-body">
				<button type="button" style="color:#FFFFFF;margin-top: 10px; " class="close" data-dismiss="modal" aria-label="Close">
					<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
				</button>
				<div class="form-group">
					<label style="
							font-family: Nunito Sans;
							font-style: normal;
							font-weight: bold;
							font-size: 21px;
							line-height: 29px;
							text-align: center;
							color: #FF3F3F;">
						Are you sure you want to cancel?
					</label> 
				</div>
				<div class="form-group">
					<label style="
								font-family: Nunito Sans;
								font-size: 16px;
								line-height: 22px;
								text-align: center;
								color: #FFFFFF;
								"> 
					We are sorry to hear that you wish to cancel. <br>
					@if( $user_role_id == 3 )
					If you cancel you will lose access to your account. 
					@else
					Are you sure you want to cancel?
					@endif
					</label> 
				</div>
			</div>

			<!-- modal footer -->
			<div class="modal-footer" style="border-top:none;text-align:center;align-self: center;">
				<button class="lw-ajax-form-submit-action1 btn btn-user btn-block-on-mobile" style="background:transparent;color:white;" id="btnCancelConfirmProSubscription"><?= __tr('Confirm'); ?></button>
				<button type="submit" class="lw-ajax-form-submit-action1  btn-primary btn btn-user btn-block-on-mobile" data-dismiss="modal" aria-label="Close" style="border-radius: 14px;padding:0.25rem 2rem;"  id="btnStayProSubscription"><?= __tr('Stay'); ?></button>
			</div>
			<!-- modal footer -->

		</div>
	</div>
</div>
<!-- /user cancel subscription -->