@section('page-title', __tr('Notification Settings'))
@section('head-title', __tr('Notification Settings'))
@section('keywordName', __tr('Notification Settings'))
@section('keyword', __tr('Notification Settings'))
@section('description', __tr('Notification Settings'))
@section('keywordDescription', __tr('Notification Settings'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Notification Setting Form -->
<form class="lw-ajax-form lw-form" data-show-message="true" method="post" action="<?= route('user.write.setting-privacy') ?>">
	<div class="lw-ad-block-h90">
		Password                  
	</div>
	<div class="form-group">
		<lable class="form-label">Change Password</lable>
		<div class="position-relative">
			<input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Password" required="" minlength="6">
			<i class="fa fa-eye col-1 my-auto input-icon" style="position: absolute;right: 0rem;top: 0.75rem;font-size: 1.2rem;" id="togglePassword" ></i>
		</div>
	</div>
	<div class="form-group">
		<lable class="form-label">Confirm Password</lable>
		<div class="position-relative">
			<input type="password" class="form-control form-control-user" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required="" minlength="6">
			<i class="fa fa-eye col-1 my-auto input-icon" style="position: absolute;right: 0rem;top: 0.75rem;font-size: 1.2rem;" id="toggleConfirm" ></i>
		</div>
	</div>

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<div class="d-none custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="private_account" name="private_account" value="1">
			<label class="custom-control-label" for="private_account">Private Account</label>
		</div>
	</div>

	@if(0)
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" id="lwAllowNotifications" name="allow_notifications" value="1">
			<label class="custom-control-label" for="lwAllowNotifications">Comments
				<p style="font-size:13px;">
				Allow comments from everyone or only allow those that are following
				</p>
			</label>
		</div>
	</div>
	@endif

	<div id="accordion">
		<div class="card">
			<div class="card-header" id="headingOne">
				<h6 class="mb-0">
					Blocked Accounts
					<a class="btn" style="position: absolute;right: 0px;top: 5px;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					<i class="fas fa-chevron-right"></i>
					</a>
				</h6>
			</div>
			<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
				<div class="card-body">
					Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="headingTwo">
				<h6 class="mb-0">
					Terms and Conditions
					<a class="btn" style="position: absolute;right: 0px;top: 5px;" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<i class="fas fa-chevron-right"></i>
					</a>
				</h6>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
				<div class="card-body">
					Anim pariatur cliche reprehenderit. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="headingPrivacyPolicy">
				<h6 class="mb-0">
					Privacy Policy
					<a class="btn" data-toggle="collapse" style="position: absolute;right: 0px;top: 5px;" data-target="#collapsePrivacyPolicy" aria-expanded="false" aria-controls="collapsePrivacyPolicy">
					<i class="fas fa-chevron-right"></i>
					</a>
				</h6>
			</div>
			<div id="collapsePrivacyPolicy" class="collapse" aria-labelledby="headingPrivacyPolicy" data-parent="#accordion">
				<div class="card-body">
					Anim pariatur cliche reprehenderit. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
				</div>
			</div>
		</div>
	</div>
	
	<!-- Update Button -->
	<a href class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile mt-3 btn-sm">
		<?= __tr('Update') ?>
	</a>
	<!-- /Update Button -->
</form>
<!-- Notification Setting Form -->
