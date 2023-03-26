@section('page-title', __tr('Sponsored Ad'))
@section('head-title', __tr('Sponsored Ad'))
@section('keywordName', __tr('Sponsored Ad'))
@section('keyword', __tr('Sponsored Ad'))
@section('description', __tr('Sponsored Ad'))
@section('keywordDescription', __tr('Sponsored Ad'))
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
    $user_rate = getTotalRateUser(getUserID());
    if(__isEmpty($user_rate)){
        $user_rate = 0;
    }
?>

@if($promotionPlanData['isPromotionSponserUserStripe'] and !__isEmpty($promotionPlanData["userSubscriptionData"]))  
    <div class="row">
        @include('user.sponser_ad.sidemenu')
        <div class="col-lg-9 mt-4 p-4">
            <div class="" style="display:flex;">
                <span style="padding-left:5px;font-size:1.5rem;">Ad Campaign</span>
            </div>
            <div class="mt-4 ml-1 p-4" style="width:100%;font-family: Nunito Sans;font-style: normal;font-weight: normal; border: 1px solid #353535;box-sizing: border-box;border-radius: 10px;">
                
                <div class="" style="display:flex;">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.0007 2.3335C14.645 2.3335 15.1673 2.85583 15.1673 3.50016V4.73904C19.3892 5.26549 22.7353 8.61166 23.2618 12.8335H24.5007C25.145 12.8335 25.6673 13.3558 25.6673 14.0002C25.6673 14.6445 25.145 15.1668 24.5007 15.1668H23.2618C22.7353 19.3887 19.3892 22.7348 15.1673 23.2613V24.5002C15.1673 25.1445 14.645 25.6668 14.0007 25.6668C13.3563 25.6668 12.834 25.1445 12.834 24.5002V23.2613C8.61215 22.7348 5.26598 19.3887 4.73953 15.1668H3.50065C2.85632 15.1668 2.33398 14.6445 2.33398 14.0002C2.33398 13.3558 2.85632 12.8335 3.50065 12.8335H4.73953C5.26598 8.61166 8.61215 5.26549 12.834 4.73904V3.50016C12.834 2.85583 13.3563 2.3335 14.0007 2.3335ZM14.0007 21.0002C17.8666 21.0002 21.0007 17.8662 21.0007 14.0002C21.0007 10.1342 17.8666 7.00016 14.0007 7.00016C10.1347 7.00016 7.00065 10.1342 7.00065 14.0002C7.00065 17.8662 10.1347 21.0002 14.0007 21.0002Z" fill="#2499DB"/>
                    <path d="M17.5 14C17.5 15.933 15.933 17.5 14 17.5C12.067 17.5 10.5 15.933 10.5 14C10.5 12.067 12.067 10.5 14 10.5C15.933 10.5 17.5 12.067 17.5 14Z" fill="#2499DB"/>
                    </svg>
                    <span style="padding-left:5px;font-size:21px;">PROMOTION (ACTIVE)</span>
                </div>
                <div class="d-flex mt-4" style="width: 100%;">
                    <span class="" style="font-size: 13px;line-height: 24px;"> 
                        @if($promotionPlanData["userSubscriptionData"]["card_icon"] == 'visa')
                            <img src="/imgs/credit_cards/visa.svg" alt="Visa"/>
                        @else 
                            @if($promotionPlanData["userSubscriptionData"]["card_icon"] == 'amex')
                                <img src="/imgs/credit_cards/amex.svg" alt="American Express"/>
                            @else 
                                @if($promotionPlanData["userSubscriptionData"]["card_icon"] == 'jcb')
                                    <img src="/imgs/credit_cards/jcb.svg" alt="JCB"/>
                                @else
                                    <i class="fa fa-<?= $promotionPlanData["userSubscriptionData"]["card_icon"]?>" style="font-size:22px;"></i> 
                                @endif
                            @endif
                        @endif
                        &nbsp;&nbsp;&nbsp;
                        <?= $promotionPlanData["userSubscriptionData"]["card_type"] ?> - <?= $promotionPlanData["userSubscriptionData"]["card_last4"] ?> 
                    </span>
                    <span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">￥<?= $promotionPlanData["userSubscriptionData"]["planPrice"] ?> per <?= $promotionPlanData["userSubscriptionData"]["planTitle"] ?> </span>
                </div>
                <div class="d-flex mt-2" style="width: 100%;">
                    <span class="" style="font-size: 13px;line-height: 24px;"> Start Date </span>
                    <span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
                        <?= $promotionPlanData["userSubscriptionData"]["start_date"] ?>  
                    </span>
                </div>
                <div class="d-flex mt-2" style="width: 100%;">
                    <span class="" style="font-size: 13px;line-height: 24px;"> Auto Renews </span>
                    <span class="" style="margin-left:auto;font-size: 13px;line-height: 24px;font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 13px;">
                        <?= $promotionPlanData["userSubscriptionData"]["next_payment_date"] ?> 
                    </span>
                </div>


                <div class="row mt-2 ml-0 mr-4 pb-2" style="width:100%;"> 
                    <div class="col-lg-12 d-flex justify-content-center mt-2" style="">
                        <div style="display:flex;background: rgba(255, 255, 255, 0.04);border: 1px solid rgba(53, 53, 53, 0.66);box-sizing: border-box;backdrop-filter: blur(4px);border-radius: 10px;padding:1rem;">
                            <div class="">
                                <div class="position-relative">
                                    <img style="
                                    width:5rem;
                                    height:5rem;
                                    border:3px solid #FFFFFF!
                                    important;border-radius:10px;
                                    padding:0px;
                                    box-sizing: border-box;"
                                    class=" lw-lazy-img" id="lwProfilePictureStaticImage" src="<?= getUserAuthInfo('profile.profile_picture_url') ?>">
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
                                        line-height: 1.5rem;
                                        text-align: center;
                                    ">PT</label>
                                </div>
                            </div>
                            <div>
                                <div class="pl-2 d-flex" style="flex-direction:column;"> 
                                    

                                        <div class="d-flex">
                                            <div class="" style="font-size:1rem;line-height:1.5rem;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
                                                <?= Str::limit( getUserAuthInfo('profile.kanji_name') ,10) ?> 
                                            </div>
                                            <div class="sponser-session" style="margin-left:auto;">
                                                <svg width="18" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 20.9294C16.4183 20.9294 20 17.3477 20 12.9294C20 8.51117 16.4183 4.92944 12 4.92944C7.58172 4.92944 4 8.51117 4 12.9294C4 17.3477 7.58172 20.9294 12 20.9294ZM12.9933 9.81282C12.9355 9.31548 12.5128 8.92944 12 8.92944C11.4477 8.92944 11 9.37716 11 9.92944V13.6794L11.0072 13.7992C11.0498 14.1539 11.28 14.4628 11.6154 14.6025L14.6154 15.8525L14.7256 15.8912C15.2069 16.0291 15.7258 15.7874 15.9231 15.3141L15.9617 15.2038C16.0997 14.7225 15.858 14.2036 15.3846 14.0064L13 13.0124V9.92944L12.9933 9.81282Z" fill="white"/>
                                                </svg>
                                                <span class="preview_pricing_session"><?= isset($promotionPlanData["userSubscriptionData"]["pricing_session"])?$promotionPlanData["userSubscriptionData"]["pricing_session"]:"" ?></span>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            
                                            <div class="" style="color:#ff4141;font-size:1rem;line-height:1.5rem;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
                                                <?= Str::limit( getUserAuthInfo('profile.city') ,10) ?> 
                                            </div>
                                            <div class="preview_pricing_value" style="margin-left:auto;font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 16px;line-height: 24px;text-align: right;color: #AFAFAF;">
                                                ￥<?= isset($promotionPlanData["userSubscriptionData"]["pricing_value"])?floatval($promotionPlanData["userSubscriptionData"]["pricing_value"]):"" ?>
                                            </div>

                                        </div>

                                        <div class="d-flex" style="">
                                            <button type="button" role="button" class="lw-ajax-form-submit-action1 btn mr-2 btn-primary btn-user btn-block-on-mobile" style="border:none;display:flex;align-items:center;padding: 1rem 1.5rem;height: 24px;background: #FF3F3F;border-radius: 5px;">Inquire</button>
                                            <div class="" style="margin-left:auto;border:none;display:flex;align-items:center;padding: 1rem 1rem;height: 1.5rem;background: #858686;border-radius: 8px;">
                                                <div class="review-rating-1" data-rating="<?= $user_rate/5 ?>">
                                                </div>
                                                <span class="ml-1" style="top:2px;position: relative;"> <?= $user_rate ?> </span>
                                            </div>
                                        </div>

                                </div>	

                            </div>
                        </div>
                    </div>
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
                        <div class="d-none  col ml-1 pt-1 form-group mb-0">
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
            </div>
        </div>
    </div>
@else

    <div style="z-index: 99;position: absolute;left:0px;top:-1rem;bottom:-1rem;height:110%;min-height:calc( 22vw + 860px ); overflow:hidden;background: #1e1e1e;">
        <div style="padding:1rem;">
            <div class="d-flex position-rlative" style="padding:1.5rem;color:#FFFFFF;border-radius: 1.5rem;background-image: url('/imgs/pro_background.png');background-repeat: no-repeat;background-size: 50% 100%;min-height: 850px;background-color:#121117;">

                <div class="p-1" style="flex:1;">
                    <div class="mt-3 row" style="font-family: Nunito Sans;font-style: normal;color:white;">
                        <div class="col-lg-12 d-flex mt-2 pt-2" style="font-weight: bold;font-size: 1.5rem;line-height: 1.5rem;"> STACKD </div>
                        <div class="col-lg-12 d-flex pt-4 mt-3" style="font-weight: bold;font-size: 1.5rem;line-height: 1.5rem;"> Promote through STACKD </div>
                        <div class="col-lg-12 d-flex pt-3" style="font-weight: normal;font-size: 1rem;line-height: 1.5rem;"> Your fitness hub providing the perfect niche </div>

                        <div class="col-lg-12 justify-content-center d-flex pt-3" style="font-weight: normal;font-size: 1.25rem;line-height: 24px;"> Preview </div>

                        <div class="row  justify-content-center" style="width:100%;padding-bottom:10px;"> 
                            <span class="d-none row"> Preview </span>
                            <div class="row ml-4 mr-2 pb-2" style="width:100%;/*border: 1px solid rgba(53, 53, 53, 0.66);*/"> 
                                <div class="col-lg-12 d-flex justify-content-center mt-2">
                                    <div class="d-flex p-3" style="box-sizing: border-box;backdrop-filter: blur(4px);border-radius: 10px;background: rgba(255, 255, 255, 0.04);">
                                        <div class="">
                                            <div class="position-relative">
                                                <img style="
                                                width:5rem;
                                                height:5rem;
                                                border:3px solid #FFFFFF!
                                                important;border-radius:10px;
                                                padding:0px;
                                                box-sizing: border-box;"
                                                class=" lw-lazy-img" id="lwProfilePictureStaticImage" src="<?= getUserAuthInfo('profile.profile_picture_url') ?>">
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
                                                    line-height: 1.5rem;
                                                    text-align: center;
                                                ">PT</label>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="pl-2 d-flex" style="flex-direction:column;"> 
                                                

                                                    <div class="d-flex">
                                                        <div class="" style="font-size:1rem;line-height:1.5rem;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
                                                            <?= Str::limit( getUserAuthInfo('profile.kanji_name') ,10) ?> 
                                                        </div>
                                                        <div class="sponser-session" style="margin-left:auto;">
                                                            <svg width="18" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 20.9294C16.4183 20.9294 20 17.3477 20 12.9294C20 8.51117 16.4183 4.92944 12 4.92944C7.58172 4.92944 4 8.51117 4 12.9294C4 17.3477 7.58172 20.9294 12 20.9294ZM12.9933 9.81282C12.9355 9.31548 12.5128 8.92944 12 8.92944C11.4477 8.92944 11 9.37716 11 9.92944V13.6794L11.0072 13.7992C11.0498 14.1539 11.28 14.4628 11.6154 14.6025L14.6154 15.8525L14.7256 15.8912C15.2069 16.0291 15.7258 15.7874 15.9231 15.3141L15.9617 15.2038C16.0997 14.7225 15.858 14.2036 15.3846 14.0064L13 13.0124V9.92944L12.9933 9.81282Z" fill="white"/>
                                                            </svg>
                                                            <span class="preview_pricing_session"><?= isset($promotionPlanData["userSubscriptionData"]["pricing_session"])?$promotionPlanData["userSubscriptionData"]["pricing_session"]:"" ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex">
                                                        
                                                        <div class="" style="color:#ff4141;font-size:1rem;line-height:1.5rem;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
                                                            <?= Str::limit( getUserAuthInfo('profile.city') ,10) ?> 
                                                        </div>
                                                        <div class="preview_pricing_value" style="margin-left:auto;font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 16px;line-height: 24px;text-align: right;color: #AFAFAF;">
                                                            ￥<?= isset($promotionPlanData["userSubscriptionData"]["pricing_value"])?floatval($promotionPlanData["userSubscriptionData"]["pricing_value"]):"" ?>
                                                        </div>

                                                    </div>

                                                    <div class="d-flex" style="">
                                                        <button type="button" role="button" class="lw-ajax-form-submit-action1 btn mr-2 btn-primary btn-user btn-block-on-mobile" style="border:none;display:flex;align-items:center;padding: 1rem 1.5rem;height: 24px;background: #FF3F3F;border-radius: 5px;">Inquire</button>
                                                        <div class="" style="margin-left:auto;border:none;display:flex;align-items:center;padding: 1rem 1rem;height: 1.5rem;background: #858686;border-radius: 8px;">
                                                            <div class="review-rating-1" data-rating="<?= $user_rate/5 ?>">
                                                            </div>
                                                            <span class="ml-1" style="top:2px;position: relative;"> <?= $user_rate ?> </span>
                                                        </div>
                                                    </div>

                                            </div>	
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 d-flex pt-4 mt-3" style="font-weight: bold;font-size: 1.25rem;line-height: 1.5rem;"> What you get: </div>
                        <div class="col-lg-12 d-flex">
                            <table class="table table-hover table-pricing" style="color:white;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align:center;">
                                            <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                            </svg>
                                        </td>
                                        <td>
                                            <span style="font-size:13px;">Fitness/Gym/Health Niche audience</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">
                                            <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                            </svg>
                                        </td>
                                        <td>
                                            <span style="font-size:13px;">1 Featured Feed of your profile once a day</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">
                                            <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 0.292893C17.0976 0.683417 17.0976 1.31658 16.7071 1.70711L8.12132 10.2929C6.94975 11.4645 5.05026 11.4645 3.87868 10.2929L0.292893 6.70711C-0.0976311 6.31658 -0.0976311 5.68342 0.292893 5.29289C0.683417 4.90237 1.31658 4.90237 1.70711 5.29289L5.29289 8.87868C5.68342 9.2692 6.31658 9.26921 6.70711 8.87868L15.2929 0.292893C15.6834 -0.0976311 16.3166 -0.0976311 16.7071 0.292893Z" fill="#FF3F3F"/>
                                            </svg>
                                        </td>
                                        <td>
                                            <span style="font-size:13px;">Advertisement space on all users Chats, and Feed pages and more.</span>
                                        </td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="p-4" style="flex:1;">

                    <div class="col-lg-12 d-flex pb-2" style="font-weight: bold;font-size: 1.75rem;line-height: 24px;"> Sponserd Ad </div>
                    
                        <form id="payment-form" class="lw-ajax-form1 lw-form1" method="post" data-show-message="true" action="<?= route('user.write.setting-subscription') ?>" data-callback="onSubscriptionStripeCallback" >
                            <div id="payment_type_container" class="row" style="font-family: Nunito Sans;font-style: normal;color:white;">
                                    @foreach( $promotionPlanData["promotionPlans"]['sponser'] as $plan_key=>$plan_val)
                                        @if( $plan_val["enable"])
                                        <div class="col-lg-12" >
                                            <div class="col-lg-12 d-flex pt-2 mt-3 pl-5 pr-2 promotion_plan_select custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="lwSelectMembership_<?= $plan_key ?>" value="<?= $plan_key ?>" data-amount="<?= $plan_val["price"]?>" name="plan_id" class="custom-control-input">
                                                <label id="containerMembershipTitle_<?= $plan_key ?>" class="custom-control-label" for="lwSelectMembership_<?= $plan_key ?>" style="font-weight: bold;font-size: 13px;line-height: 24px;">
                                                    <?= $plan_val["title"] ?>
                                                    @if ($plan_key == 'half_year')
                                                    &nbsp;&nbsp;&nbsp;<span class="pl-3 pr-3 pt-1 pb-1" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 9px;line-height: 24px;text-align: center;letter-spacing: 1px;color: #FFFFFF;background: #FF4141;border-radius: 10px;">  BEST DEAL ￥<?= $promotionPlanData["promotionPlans"]['sponser']["one_month"]["price"] * 6 - $plan_val["price"] ?> OFF </span>
                                                    @endif
                                                </label>
                                            </div>
                                            <div class="ml-4 pl-4 col d-flex pt-1" id="containerMembershipPrice_<?= $plan_key ?>" style="font-weight: bold;font-size: 11px;"> ￥<?= $plan_val["price"]?> 
                                                @if ($plan_key != 'one_month')
                                                <span> ( ￥<?= round($plan_val["price"]/$plan_val["interval"] , 2) ?> / month ) </span> 
                                                @endif
                                            </div>
                                        </div>	
                                        @endif
                                    @endforeach
                                <div class="ml-3 col-lg-12 d-flex pt-4" style="font-weight: bold;font-size: 11px;"> Due today <span class="due_amount" style="margin-left: auto;"> ￥0 </span></div>

                                <div class="pt-4 ml-4 pl-4 mr-4 pr-4 col-lg-12 d-flex"> 
                                    <button type="button" id="promoteBtn" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;border: none;">
                                        Promote Now
                                    </button>
                                </div>
                            </div>	

                            <div id="payment_card_container" class="pl-4 row" style="display:none;font-family: Nunito Sans;font-style: normal;color:white;">
                                <div class="row ml-2 pl-4" style="border: 1px solid #353535;box-sizing: border-box;border-radius: 10px;">
                                    
                                    <div class="col-lg-12 pt-2 form-group mb-0" style="padding-left:0px;" id="selectedMembershipContainer">
                                        <div class="col-lg-12 d-flex custom-control custom-radio custom-control-inline">
                                            <input type="radio" checked="" id="lwSelectMembership_selected" value="" name="selected_plan_id" class="custom-control-input">
                                            <label id="containerMembershipTitleSelected" class="custom-control-label" for="lwSelectMembership_selected" style="font-weight: bold;font-size: 13px;line-height: 24px;">
                                            </label>			
                                        </div>
                                        <div class="pl-3 col-lg-12 d-flex pt-1" id="lwSelectMembership_selected_text" style="font-weight: bold;font-size: 11px;">  </div>
                                    </div>
                                
                                    <div class="row pt-2 justify-content-center" style="width:100%;padding-bottom:10px;"> 
                                        <span class="row"> Pricing </span>
                                        <div class="row" style="width:100%;"> 
                                            @foreach(getUserPricingData() as $session)
                                                <div class="col-lg-6" >
                                                    <div class="col-lg-12 pt-1 d-flex custom-control promotion_pricing_select custom-radio custom-control-inline" style="margin:0px;">
                                                        <input type="radio" id="lwSelectPricing_<?= $session["_id"]?>" value="<?= $session["_id"]?>" data-price="￥<?= floatval($session["price"])?>" data-session="<?= $session["session"]?>" name="pricing_id" class="custom-control-input">
                                                        <label id="containerPricingTitle" class="custom-control-label" for="lwSelectPricing_<?= $session["_id"]?>" style="width:100%;font-weight: bold;font-size: 13px;line-height: 24px;">
                                                            <span class="d-flex" style="flex-direction:column;">
                                                                <span class="d-flex align-items-center"><?= $session["session"]?></span>
                                                                <span class="pt_pricing_inquire_container" style="display:inline; min-width:80px; margin-left: -0.5rem; margin-top: auto; margin-bottom: auto; padding: 5px;">
                                                                    <span class="price" style="padding:1px;display:flex;margin:0px;"> ￥<?= floatval($session["price"])?> </span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>	
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 ml-1 pt-2 form-group mb-0">
                                    <div id="paymentResponse"></div>
                                    <!--  success messages  -->
                                    <div class="alert alert-success alert-dismissible fade show" id="lwSuccessMessage" style="display:none;"></div>
                                    <!--  /success messages  -->
                                    <!--  error messages  -->
                                    <div class="alert alert-danger alert-dismissible fade show" id="lwErrorMessage" style="display:none;"></div>
                                    <!--  /error messages -->
                                </div>
                                
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
                                </div>
                                <div class="col-lg-12 ml-1 pt-0">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="mb-0">CVC</label>
                                                <div id="cardCVC" class=""> </div>
                                            </div>
                                        </div> <div class="col-md-1"></div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="mb-0">Expiration (MM/YY)</label>
                                                <div id="cardExp" class=""> </div>
                                            </div>
                                        </div>
                                    </div>	
                                </div>

                                
                                <div class="ml-2 col-lg-12 d-flex pt-1" style="font-weight: bold;font-size: 11px;padding-bottom:5px;border-bottom:1px solid #515151;">
                                    Due today 
                                    <span class="due_amount" style="margin-left: auto;">
                                        ￥0 
                                    </span>
                                </div>

                            
                                <input type="hidden" name="membership" value="pro">
                                <div class="pt-2 ml-3 pl-2 mr-4 pr-4 col-lg-12 d-flex"> 
                                    <button type="button" id="paymentCardRequestBtn" class="lw-ajax-form-submit-action1 btn btn-primary btn-user btn-block-on-mobile" style="font-weight: bold;font-size: 15px;line-height: 24px; width:100%; padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;border: none;">
                                        Confirm
                                    </button>
                                </div>
                                <div class="ml-3 pl-2 col-lg-12 d-flex1 pt-2" style="font-weight: bold;font-size: 13px; text-align:center;"> 
                                    <button class="btn" id="backToPaymentTypeBtn" style="text-decoration: underline;background: transparent;color: white;"> Back </button>
                                </div>
                            </div>	
                        </form>
                </div>

            </div>
        </div>
    </div>
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
							color: #FF3F3F;
                            width:100%;">
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
                                width:100%;
								"> 
					We are sorry to hear that you wish to cancel. 
					Are you sure you want to cancel? 
					</label> 
				</div>
			</div>

			<!-- modal footer -->
			<div class="modal-footer mt-3" style="border-top:none;text-align:center;align-self: center;">
				<button class="lw-ajax-form-submit-action1 btn btn-user btn-block-on-mobile" style="background:transparent;color:white;" id="btnCancelConfirmProSubscription"><?= __tr('Confirm'); ?></button>
				<button type="submit" class="lw-ajax-form-submit-action1  btn-primary btn btn-user btn-block-on-mobile" data-dismiss="modal" aria-label="Close" style="border-radius: 14px;padding:0.25rem 2rem;"  id="btnStayProSubscription"><?= __tr('Stay'); ?></button>
			</div>
			<!-- modal footer -->

		</div>
	</div>
</div>
<!-- /user cancel subscription -->

@push('appScripts')
<script>
    $(document).ready(function(){

        $('.promotion_plan_select .custom-control-input').change( function(){
            $('.due_amount').text( '￥' + $(this).data('amount'));
        } );
        $('.promotion_plan_select .custom-control-input:first').prop( "checked", true );
        $('.due_amount').text( '￥' + $('.promotion_plan_select .custom-control-input:first').data('amount'));
        
        $('.promotion_pricing_select .custom-control-input:first').prop( "checked", true );
        $('.promotion_pricing_select .custom-control-input').change( function(){
            $('.preview_pricing_session').text($(this).data('session'));
            $('.preview_pricing_value').text($(this).data('price'));
        } );
        $('.preview_pricing_session').text($('.promotion_pricing_select .custom-control-input:first').data('session'));
        $('.preview_pricing_value').text($('.promotion_pricing_select .custom-control-input:first').data('price'));

        $("#promoteBtn").on('click', function(e) {
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

        $("#backToPaymentTypeBtn").on('click', function(e) {
            e.preventDefault();
            $("#payment_type_container").show();
            $("#payment_card_container").hide();
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
	console.log(typeof Stripe);
	if( typeof Stripe !== "undefined" ){
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
	}
	
	// Create a token when the form is submitted.
	$("#paymentCardRequestBtn").click(function(e) {
		//e.preventDefault();
		createToken();
	});

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
		
		__DataRequest.post("<?= route('user.write.setting-subscription-sponser') ?>", 
				$("#payment-form").serialize()
		  , function(responseData) {
				console.log(responseData)
				showSuccessMessage(responseData.data.message);
				if(responseData.data.isUpdated)
				{
					__Utils.viewReload();
				}
		  });
	}

	function onSubscriptionStripeCallback(responseData) {
		console.log(responseData)
		if (responseData.reaction == 1) {
            
        }
	}

	$("#cancelSubscriptionBtn").click(function(){
		__DataRequest.post("<?= route('user.write.setting-subscription-sponser-cancel') ?>", 
				{}
		  , function(responseData) {
				console.log(responseData)
				showSuccessMessage(responseData.data.message);
				if(responseData.data.isUpdated)
				{
					__Utils.viewReload();
				}
		  });
	});

	$("#btnCancelConfirmProSubscription").click(function(){
		__DataRequest.post("<?= route('user.write.setting-subscription-sponser-cancel') ?>", 
				{}
		  , function(responseData) {
				console.log(responseData)
				showSuccessMessage(responseData.data.message);
				if(responseData.data.isUpdated)
				{
					__Utils.viewReload();
				}
		  });
	});

	$("#btnUpdateCardProSubscription").click(function(){

		$("#containerUpdateDetail").removeClass("d-none").addClass("d-flex");
		$("#containerBtn").removeClass("d-flex").addClass("d-none");

	});

	$("#btnCancelUpdateSubscription").click(function(){

		$("#containerUpdateDetail").removeClass("d-flex").addClass("d-none");
		$("#containerBtn").removeClass("d-none").addClass("d-flex");

	});

	$("#btnCardUpdate").click(function(){

		stripe.createToken(cardElement).then(function(result) {
			if (result.error) {
				// Inform the user if there was an error
				resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
			} else {

				var hiddenInput = document.createElement('input');
				hiddenInput.setAttribute('type', 'hidden');
				hiddenInput.setAttribute('name', 'stripeToken');
				hiddenInput.setAttribute('value', result.token.id);
				$("#formUpdateCardSubscription").append(hiddenInput);

				__DataRequest.post("<?= route('user.write.setting-subscription-sponser-updatecard') ?>", 
						$("#formUpdateCardSubscription").serialize()
				, function(responseData) {
						console.log(responseData)
						showSuccessMessage(responseData.data.message);
						if(responseData.data.isUpdated)
						{
							__Utils.viewReload();
						}
				});
			}
		});
	});
</script>
@endpush