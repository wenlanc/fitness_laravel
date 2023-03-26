@push('header')
<link href="{{ asset('dist/flatpicker/flatpickr.css') }}" rel="stylesheet">
@endpush
<?php 
use Carbon\Carbon;
$pageType = request()->pageType; 
?>
<!-- card start -->
<!-- Page Heading -->
<div class="d-sm-flex1 align-items-center justify-content-between mb-1 d-none">
	<h5 class="h5 mb-0 text-gray-200">
		<span class=""></span> <?= __tr('Settings') ?></h5>
</div>
<div class="card">
	<!-- card body -->
	<div class="card-body1">
		<div class="row">
			<div class="col-lg-3 pb-4">
				<!-- Sidebar of settings -->
				<ul class="navbar-nav sidebar-dark accordion" id="accordionSettingSidebar">
			
					<li class="mt-2 nav-item pr-2 <?= $pageType=="account"?"active":"" ?>">
						<a class="nav-link pl-3" href="<?= route('user.read.setting', [ "pageType" => "account"]) ?>">
							
							<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M9 0C6.23858 0 4 2.23858 4 5C4 7.76142 6.23858 10 9 10C11.7614 10 14 7.76142 14 5C14 2.23858 11.7614 0 9 0ZM9 2C10.6569 2 12 3.34315 12 5C12 6.65685 10.6569 8 9 8C7.34315 8 6 6.65685 6 5C6 3.34315 7.34315 2 9 2ZM17.9954 16.7831C17.8818 14.1223 15.6888 12 13 12H5L4.78311 12.0046C2.12231 12.1182 0 14.3112 0 17V19L0.00672773 19.1166C0.0644928 19.614 0.487164 20 1 20C1.55228 20 2 19.5523 2 19V17L2.00509 16.8237C2.09634 15.2489 3.40232 14 5 14H13L13.1763 14.0051C14.7511 14.0963 16 15.4023 16 17V19L16.0067 19.1166C16.0645 19.614 16.4872 20 17 20C17.5523 20 18 19.5523 18 19V17L17.9954 16.7831Z" fill="white"/>
							</svg>

							<span style="margin-left: 0.25rem;"><?= __tr('Account') ?></span>
						</a>
					</li>
					<li class="mt-2 nav-item pr-2 <?= $pageType=="notification"?"active":"" ?>">
						<a class="nav-link pl-3" href="<?= route('user.read.setting', ["pageType" => "notification"]) ?>">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M11.557 17.103C12.3277 17.103 12.8087 17.9381 12.422 18.6047C11.9211 19.4684 10.9983 20 10 20C9.00166 20 8.07886 19.4684 7.57796 18.6047C7.21064 17.9714 7.62639 17.1861 8.32964 17.1092L8.443 17.103H11.557ZM10 0C13.9511 0 17.169 3.13941 17.2961 7.06012L17.3 7.30112V11.8019C17.3 12.6917 17.9831 13.4218 18.8533 13.4962L19.1332 13.5094C20.2445 13.6286 20.2872 15.2401 19.2614 15.4741L19.1332 15.4954L19 15.5024H1L0.866825 15.4954C-0.288942 15.3714 -0.288942 13.6334 0.866825 13.5094L1.14668 13.4962C1.96851 13.4259 2.62352 12.7708 2.69376 11.9486L2.7 11.8019V7.30112C2.7 3.26886 5.96828 0 10 0ZM10 2C7.14611 2 4.81899 4.25617 4.70442 7.0826L4.7 7.30112V11.8019C4.7 12.3105 4.59742 12.7951 4.41182 13.2362L4.3122 13.453L4.285 13.502H15.714L15.6878 13.453C15.504 13.0848 15.3797 12.6817 15.3276 12.2563L15.3051 11.9984L15.3 11.8019V7.30112C15.3 4.37335 12.9271 2 10 2Z" fill="white"/>
						</svg>

							<span  style="margin-left: 0.25rem;"><?= __tr('Notification') ?></span>
						</a>
					</li>
					<li class="mt-2 nav-item pr-2 <?= $pageType=="privacy_security"?"active":"" ?>">
						<a class="nav-link pl-3" href="<?= route('user.read.setting', ["pageType" => "privacy_security"]) ?>">
							<svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M15.9956 5.23375C15.8736 2.29884 13.2127 0 10 0C6.71081 0 4 2.40961 4 5.44444V8C1.79086 8 0 9.79086 0 12V17C0 19.2091 1.79086 21 4 21H16C18.2091 21 20 19.2091 20 17V12C20 9.79086 18.2091 8 16 8V5.44444L15.9956 5.23375ZM14 8V5.44444C14 3.57008 12.2337 2 10 2C7.8384 2 6.11444 3.47042 6.00547 5.26405L6 5.44444V8H14ZM5 10H4C2.89543 10 2 10.8954 2 12V17C2 18.1046 2.89543 19 4 19H16C17.1046 19 18 18.1046 18 17V12C18 10.8954 17.1046 10 16 10H15H5Z" fill="white"/>
							</svg>

							<span  style="margin-left: 0.25rem;"><?= __tr('Privacy&Security') ?></span>
						</a>
					</li>
					<li class="mt-2 nav-item pr-2 <?= $pageType=="billing"?"active":"" ?>">
						<a class="nav-link pl-3" href="<?= route('user.read.setting', ["pageType" => "billing"]) ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M2 7C2 5.34315 3.34315 4 5 4H19C20.6569 4 22 5.34315 22 7V17C22 18.6569 20.6569 20 19 20H5C3.34315 20 2 18.6569 2 17V7ZM5 6H19C19.5523 6 20 6.44771 20 7V8H4V7C4 6.44772 4.44772 6 5 6ZM4 10V17C4 17.5523 4.44772 18 5 18H19C19.5523 18 20 17.5523 20 17V10H4Z" fill="white"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M6 15C6 14.4477 6.44772 14 7 14H13C13.5523 14 14 14.4477 14 15C14 15.5523 13.5523 16 13 16H7C6.44772 16 6 15.5523 6 15Z" fill="white"/>
							</svg>
							<span  style="margin-left: 0.25rem;"><?= __tr('Billing') ?></span>
						</a>
					</li>
					<li class="mt-2 nav-item pr-2 <?= $pageType=="help"?"active":"" ?>">
						<a class="nav-link pl-3" href="<?= route('user.read.setting', ["pageType" => "help"]) ?>">
							<svg width="24" height="16" viewBox="0 0 24 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M20.6482 2.12599C19.2 0.329316 16.8796 -0.416854 14.7141 0.22945C14.1849 0.387401 13.8839 0.944461 14.0419 1.47368C14.1998 2.00289 14.7569 2.30386 15.2861 2.14591C16.6658 1.73414 18.1476 2.21066 19.091 3.3811C20.0522 4.57361 20.2727 6.26269 19.6496 7.69447C19.035 9.10667 17.7178 9.99994 16.2806 10.0001C16.2572 10.0001 16.2341 10.0009 16.2111 10.0025C16.1406 10.0009 16.07 10.0001 15.9993 10.0001C15.447 10.0006 14.9997 10.4486 15.0001 11.0009C15.0006 11.5532 15.4486 12.0006 16.0009 12.0001C18.4386 11.9982 20.7363 13.3112 22.1571 15.538C22.4542 16.0036 23.0724 16.1402 23.538 15.8431C24.0036 15.5461 24.1402 14.9278 23.8431 14.4622C22.7951 12.8196 21.3504 11.5645 19.7001 10.8099C20.457 10.2179 21.0763 9.42793 21.4834 8.49257C22.4023 6.38117 22.0786 3.9006 20.6482 2.12599ZM8.00012 0.000119527C4.68642 0.000119527 2.00012 2.68641 2.00012 6.00012C2.00012 7.95039 2.93062 9.68333 4.37188 10.7792C2.69233 11.5301 1.2213 12.7968 0.157467 14.4617C-0.139911 14.9271 -0.00371301 15.5454 0.461674 15.8428C0.92706 16.1402 1.5454 16.004 1.84278 15.5386C3.26488 13.313 5.56225 12.0002 8.00003 12.0001C10.4378 12 12.7353 13.3126 14.1575 15.538C14.4549 16.0034 15.0733 16.1396 15.5386 15.8421C16.004 15.5447 16.1402 14.9264 15.8427 14.461C14.7789 12.7964 13.3079 11.5298 11.6285 10.7791C13.0697 9.68322 14.0001 7.95033 14.0001 6.00012C14.0001 2.68641 11.3138 0.000119527 8.00012 0.000119527ZM4.00012 6.00012C4.00012 8.20922 5.79092 10 8 10.0001H8.00012C10.2093 10.0001 12.0001 8.20926 12.0001 6.00012C12.0001 3.79098 10.2093 2.00012 8.00012 2.00012C5.79099 2.00012 4.00012 3.79098 4.00012 6.00012Z" fill="white"/>
							</svg>

							<span  style="margin-left: 0.25rem;"><?= __tr('Help') ?></span>
						</a>
					</li>
					<li class="mt-2 nav-item pr-2 <?= $pageType=="about"?"active":"" ?>">
						<a class="nav-link pl-3" href="<?= route('user.read.setting', ["pageType" => "about"]) ?>">
							<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M0 11C0 4.92487 4.92487 0 11 0C17.0751 0 22 4.92487 22 11C22 17.0751 17.0751 22 11 22C4.92487 22 0 17.0751 0 11ZM20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20C15.9706 20 20 15.9706 20 11ZM11 10C11.5128 10 11.9355 10.386 11.9933 10.8834L12 11V15C12 15.5523 11.5523 16 11 16C10.4872 16 10.0645 15.614 10.0067 15.1166L10 15V11C10 10.4477 10.4477 10 11 10ZM12.01 7C12.01 6.44772 11.5623 6 11.01 6L10.8834 6.00673C10.386 6.06449 10 6.48716 10 7C10 7.55228 10.4477 8 11 8L11.1266 7.99327C11.624 7.93551 12.01 7.51284 12.01 7Z" fill="white"/>
							</svg>

							<span  style="margin-left: 0.25rem;"><?= __tr('About') ?></span>
						</a>
					</li>

				</ul>
				<!-- End of Sidebar of settings -->
			</div>
			<div class="col-lg-9">
				<!-- card start -->
				<div class="card">
					<!-- card body -->
					<div class="card-body" id="setting_page_content">
						<!-- include related view -->
						@include('user.settings.'. $pageType)
						<!-- /include related view -->
					</div>
					<!-- /card body -->
				</div>
				<!-- card start -->
			</div>
		</div>
	</div>
	<!-- /card body -->
</div>
<!-- card start -->
@push('appScripts')
<script src="{{ asset('dist/flatpicker/flatpickr.js') }}"></script>
<script>
	$('#togglePassword').on('click', function(e) {
        e.preventDefault();
        let x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
            $('#togglePassword').removeClass('fa-eye');
            $('#togglePassword').addClass('fa-eye-slash');
        } else {
            x.type = "password";
            $('#togglePassword').removeClass('fa-eye-slash');
            $('#togglePassword').addClass('fa-eye');
        }
    });
    $('#toggleConfirm').on('click', function(e) {
        e.preventDefault();
        let x = document.getElementById("confirm_password");
        if (x.type === "password") {
            x.type = "text";
            $('#toggleConfirm').removeClass('fa-eye');
            $('#toggleConfirm').addClass('fa-eye-slash');
        } else {
            x.type = "password";
            $('#toggleConfirm').removeClass('fa-eye-slash');
            $('#toggleConfirm').addClass('fa-eye');
        }
    });

	$("#paymentSubscribeBtn").on('click', function(e) {
		e.preventDefault();
		$("#payment_type_container").hide();
		$("#payment_card_container").show();

		console.log($("input[name='plan_id']:checked").val());
		var selectedMembershipvalue = $("input[name='plan_id']:checked").val();
		$("#lwSelectMembership_selected").val(selectedMembershipvalue);
		$("#containerMembershipTitleSelected").html($("#containerMembershipTitle_"+selectedMembershipvalue).html());
		$("#lwSelectMembership_selected_text").html($("#containerMembershipPrice_"+selectedMembershipvalue).html());

		$(".dueSelectedPrice").html($("#containerMembershipPrice_"+selectedMembershipvalue).clone().children().remove().end().text());
		$("#dueSelectedPrice").html($("#containerMembershipPrice_"+selectedMembershipvalue).clone().children().remove().end().text());
		
		if($("#dueSelectedDate")) {
			if(selectedMembershipvalue == 'year'){
				$("#dueSelectedDate").html('Renews <?= \Carbon\Carbon::now()->addYears(1)->format('F d, Y')?>');
			} else if(selectedMembershipvalue == 'one_month') {
				$("#dueSelectedDate").html('Renews <?= \Carbon\Carbon::now()->addDays(30)->format('F d, Y')?>');
			}
		}
		
	});

	$("#backToPaymentTypeBtn").on('click', function(e) {
		e.preventDefault();
		$("#payment_type_container").show();
		$("#payment_card_container").hide();
	});

	$(".flatpickr").flatpickr({
        wrap: true,
        allowInput: true,
		minDate: '<?= Carbon::today()->subYears(getUserSettings('max_age'))->endOfDay()->toDateString()?>',
        maxDate:'<?= Carbon::today()->subYears(getUserSettings('min_age'))->toDateString()?>',
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
		
		__DataRequest.post("<?= route('user.write.setting-subscription') ?>", 
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
		__DataRequest.post("<?= route('user.write.setting-subscription-cancel') ?>", 
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
		__DataRequest.post("<?= route('user.write.setting-subscription-cancel') ?>", 
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

				__DataRequest.post("<?= route('user.write.setting-subscription-updatecard') ?>", 
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

	$("#downgradeSubscriptionBtn").click(function(){
		__DataRequest.post("<?= route('user.write.setting-subscription-downgrade') ?>", 
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

	$("#upgradeSubscriptionBtn").click(function(){
		__DataRequest.post("<?= route('user.write.setting-subscription-upgrade') ?>", 
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

</script>

@endpush