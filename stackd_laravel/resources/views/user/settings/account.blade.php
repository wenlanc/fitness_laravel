@section('page-title', __tr('Notification Settings'))
@section('head-title', __tr('Notification Settings'))
@section('keywordName', __tr('Notification Settings'))
@section('keyword', __tr('Notification Settings'))
@section('description', __tr('Notification Settings'))
@section('keywordDescription', __tr('Notification Settings'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Account Setting Form -->
<form class="lw-ajax-form lw-form" data-show-message="true" method="post" action="<?= route('user.write.setting-account') ?>" data-callback="updateSettingAccountCallback" id="lwUserSettingAccountForm" >
	<div class="form-group row">
		<div class="col-sm-12 mb-3 mb-sm-0">
			<label for="music_genre">Full Name (Japanese)</label>
			<input type="text" id="fullname_kanji" name="fullname_kanji" placeholder="Full Name" class="form-control" value="<?= $userData["kanji_name"]?>">
		</div>
	</div>
	<div class="form-group row">	
		<div class="col-sm-12 mb-3 mb-sm-0">
			<label for="music_genre">Display name (English)</label>
			<input type="text" id="fullname_katagana" name="fullname_katagana" placeholder="Full Name" class="form-control" value="<?= $userData["kata_name"]?>">
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-12 mb-3 mb-sm-0">
			<label for="music_genre">Username</label>
			<input type="text" id="username" name="username" placeholder="Username" class="form-control" value="<?= $userData["username"]?>">
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-12 mb-3 mb-sm-0">
			<label for="music_genre">Birthday Date</label>
			<div class="flatpickr" style="position:relative;">
				<input type="text" name="birthday" id="birthday" min="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.maximum'))->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->subYears(configItem('age_restriction.minimum'))->format('Y-m-d') }}" class="form-control form-control-user required" required="true" placeholder="Select Date.." value="<?= $userData["dob"]?>" data-input> <!-- input is mandatory -->
				<a class="d-none input-button" style="position: absolute; right: 10px;  top: 10px;" title="toggle" data-toggle>
					<i class="fa fa-calendar" style="color:#9596a0;font-size:18px;"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-12 mb-3 mb-sm-0">
			<label for="music_genre">Email Address</label>
			<input type="email" class="form-control form-control-user" id="email_address" name="email_address" placeholder="Email Address" value="<?= $userData["email"]?>">
		</div>
	</div>

	<a href="" class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile mt-3 btn-sm">
		Update	</a>

</form>
<!-- Account Setting Form -->


@if(!isAdmin())
<!-- card start -->
<div class="card mt-3">
	<!-- card body -->
	<div class="card-body">
		<!-- Delete Account Form -->
		<form class="user lw-ajax-form lw-form" method="post" action="<?= route('user.write.delete_account') ?>">
			<!-- card-header -->
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h3 mb-0 text-gray-200"><?= __tr('Delete Account') ?></h1>
			</div>
			<!-- /card-header -->

			<!-- user delete account note -->
			<span>
				<?= __tr('All content including photos and other data will be permanently removed!') ?>
			</span>
			<!-- /user delete account note -->

			<!-- user delete account button -->
			<div class="mt-3">
				<a class="btn btn-danger btn-sm" title="<?= __tr('Delete Account') ?>" href="#" data-toggle="modal" data-target="#lwDeleteAccountModel"><?= __tr('Delete Account') ?>?</a>
			</div>
			<!-- user delete account button -->
		</form>
		<!-- /Delete Account Form -->
	</div>
	<!-- /card body -->
</div>
<!-- /card end -->

<!-- Delete Account Container -->
<div class="modal fade" id="lwDeleteAccountModel" tabindex="-1" role="dialog" aria-labelledby="messengerModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?= __tr('Delete account?') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
			</div>
			<div class="modal-body">
				<!-- Delete Account Form -->
				<form class="user lw-ajax-form lw-form" method="post" action="<?= route('user.write.delete_account') ?>">
					<!-- Delete Message -->
					<?= __tr('Are you sure you want to delete your account? All content including photos and other data will be permanently removed!') ?>
					<!-- /Delete Message -->
					<hr />
					<!-- password input field -->
					<div class="form-group">
						<label for="password"><?= __tr('Enter your password') ?></label>
						<input type="password" class="form-control" name="password" id="password" placeholder="<?= __tr('Password') ?>" required minlength="6">
					</div>
					<!-- password input field -->

					<!-- Delete Account -->
					<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile"><?= __tr('Delete Account')  ?></button>
					<!-- / Delete Account -->
				</form>
				<!-- /Delete Account Form -->
			</div>
		</div>
	</div>
</div>
<!-- /Delete Account Container -->
@endif

<script>
	function updateSettingAccountCallback(responseData){
		$("#fullname_kanji").val(responseData.data.userData.kanji_name);
		$("#fullname_katagana").val(responseData.data.userData.kata_name);
		$("#birthday").val(responseData.data.userData.dob);
		$("#username").val(responseData.data.userData.username);
		$("#email_address").val(responseData.data.userData.email);
	}
	
</script>