@section('page-title', __tr('Notification Settings'))
@section('head-title', __tr('Notification Settings'))
@section('keywordName', __tr('Notification Settings'))
@section('keyword', __tr('Notification Settings'))
@section('description', __tr('Notification Settings'))
@section('keywordDescription', __tr('Notification Settings'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Page Heading -->

<!-- Notification Setting Form -->
<form class="lw-ajax-form lw-form" lwSubmitOnChange method="post" data-show-message="true" data-callback="" action="<?= route('user.write.setting', ['pageType' => request()->pageType]) ?>">
	
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<div class="custom-control custom-switch">
			<input type="hidden" name="allow_notifications" value="false">
			<input type="checkbox" class="custom-control-input" id="lwAllowNotifications" name="allow_notifications" <?= $userSettingData['allow_notifications'] == true ? 'checked' : '' ?> value="true">
			<label class="custom-control-label" for="lwAllowNotifications">Allow Notifications</label>
		</div>
	</div>
	<div class="card-body table-responsive" style="padding:0px;">
		<table class="table table-hover">
			<thead>
				<tr>
					<th  style="width:320px;"><span>Your STACKD</span></th>
					<th>Push</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<p style="font-size:17px;margin-bottom: 0px;">Matches</p>
						<span style="font-size:13px;">Any new matches you receive</span>
					</td>
					<td>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="hidden" name="notification_match_push" id="notification_match_push" value="false">
							<input type="checkbox" class="custom-control-input" id="lwNotifyMatchPush" name="notification_match_push" value="true" <?= $userSettingData['notification_match_push'] == true ? 'checked' : '' ?> >
							<label class="custom-control-label" for="lwNotifyMatchPush"> </label>
						</div>
					</td>
					<td>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="hidden" name="notification_match_email" value="false">
							<input type="checkbox" class="custom-control-input" id="lwNotifyMatchEmail" name="notification_match_email" value="true" <?= $userSettingData['notification_match_email'] == true ? 'checked' : '' ?>>
							<label class="custom-control-label" for="lwNotifyMatchEmail"> </label>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<p style="font-size:17px;margin-bottom: 0px;">Followers</p>
						<span style="font-size:13px;">Any new followers you got</span>
					</td>
					<td>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="hidden" name="notification_follower_push" id="notification_follower_push" value="false">
							<input type="checkbox" class="custom-control-input" id="lwNotifyFollowerPush" name="notification_follower_push" value="true" <?= $userSettingData['notification_follower_push'] == true ? 'checked' : '' ?>>
							<label class="custom-control-label" for="lwNotifyFollowerPush"> </label>
						</div>
					</td>
					<td>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="hidden" name="notification_follower_email" id="notification_follower_email" value="false">
							<input type="checkbox" class="custom-control-input" id="lwNotifyFollowerEmail" name="notification_follower_email" value="true" <?= $userSettingData['notification_follower_email'] == true ? 'checked' : '' ?>>
							<label class="custom-control-label" for="lwNotifyFollowerEmail"> </label>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<p style="font-size:17px;margin-bottom: 0px;">Messages</p>
						<span style="font-size:13px;">Any new messages you got</span>
					</td>
					<td>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="hidden" name="show_message_notification_push" id="show_message_notification_push" value="false">
							<input type="checkbox" class="custom-control-input" id="lwShowMessageNotifyPush" name="show_message_notification_push" value="true" <?= $userSettingData['show_message_notification_push'] == true ? 'checked' : '' ?>>
							<label class="custom-control-label" for="lwShowMessageNotifyPush"> </label>
						</div>
					</td>
					<td>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="hidden" name="show_message_notification_email" id="show_message_notification_email" value="false">
							<input type="checkbox" class="custom-control-input" id="lwShowMessageNotifyEmail" name="show_message_notification_email" value="true" <?= $userSettingData['show_message_notification_email'] == true ? 'checked' : '' ?>>
							<label class="custom-control-label" for="lwShowMessageNotifyEmail"> </label>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-hover">
			<thead>
				<tr>
					<th style="width:320px;"><span>STACKD Updates</span></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<p style="font-size:17px;margin-bottom: 0px;">STACKD News & Offers</p>
						<span style="font-size:13px;">All the latest news and offers from STACKD</span>
					</td>
					<td>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="hidden" name="show_news_notification_push" id="show_news_notification_push" value="false">
							<input type="checkbox" class="custom-control-input" id="lwShowNewsNotifyPush" name="show_news_notification_push" value="true" <?= $userSettingData['show_news_notification_push'] == true ? 'checked' : '' ?>>
							<label class="custom-control-label" for="lwShowNewsNotifyPush"> </label>
						</div>
					</td>
					<td>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="hidden" name="show_news_notification_email" id="show_news_notification_email" value="false">
							<input type="checkbox" class="custom-control-input" id="lwShowNewsNotifyEmail" name="show_news_notification_email" value="true" <?= $userSettingData['show_news_notification_email'] == true ? 'checked' : '' ?>>
							<label class="custom-control-label" for="lwShowNewsNotifyEmail"> </label>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<p style="font-size:17px;margin-bottom: 0px;">Product News</p>
						<span style="font-size:13px;">Be the first to know about new releases</span>
					</td>
					<td>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="hidden" name="show_product_notification_push" id="show_product_notification_push" value="false">
							<input type="checkbox" class="custom-control-input" id="lwShowProductNotifyPush" name="show_product_notification_push" value="true" <?= $userSettingData['show_product_notification_push'] == true ? 'checked' : '' ?>>
							<label class="custom-control-label" for="lwShowProductNotifyPush"> </label>
						</div>
					</td>
					<td>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="hidden" name="show_product_notification_email" id="show_product_notification_email" value="false">
							<input type="checkbox" class="custom-control-input" id="lwShowProductNotifyEmail" name="show_product_notification_email" value="true" <?= $userSettingData['show_product_notification_email'] == true ? 'checked' : '' ?>>
							<label class="custom-control-label" for="lwShowProductNotifyEmail"> </label>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	@if(0)
	<div class="row">
		<div class="col-sm-6 mb-2">
			<!-- Show Visitor Notification field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_visitor_notification" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowVisitorNotify" name="show_visitor_notification" value="true" <?= $userSettingData['show_visitor_notification'] == true ? 'checked' : '' ?>>
				<label class="custom-control-label" for="lwShowVisitorNotify"><?= __tr('Show Visitors Notification')  ?></label>
			</div>
			<!-- / Show Visitor Notification field -->
		</div>
		<div class="col-sm-6">
			<!-- Show Profile Like Notification field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_like_notification" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowLikeNotify" name="show_like_notification" value="true" <?= $userSettingData['show_like_notification'] == true ? 'checked' : '' ?> <?= getFeatureSettings('show_like') == true ? '' : 'disabled' ?>>
				<label class="custom-control-label" for="lwShowLikeNotify">
					<?= __tr('Show Likes Notification')  ?>
					@if(getFeatureSettings('show_like', 'select_user') == '2')
					<span class="lw-premium-feature-badge"></span>
					@endif
				</label>
			</div>
			<!-- / Show Profile Like Notification field -->
		</div>
		<div class="col-sm-6">
			<!-- Show Gifts Notification field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_gift_notification" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowGiftNotify" name="show_gift_notification" value="true" <?= $userSettingData['show_gift_notification'] == true ? 'checked' : '' ?>>
				<label class="custom-control-label" for="lwShowGiftNotify"><?= __tr('Show Gifts Notification')  ?></label>
			</div>
			<!-- / Show Gifts Notification field -->
		</div>
		<div class="col-sm-6">
			<!-- Show Messages Notification field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_message_notification" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowMessageNotify" name="show_message_notification" value="true" <?= $userSettingData['show_message_notification'] == true ? 'checked' : '' ?>>
				<label class="custom-control-label" for="lwShowMessageNotify"><?= __tr('Show Messages Notification')  ?></label>
			</div>
			<!-- / Show Messages Notification field -->
		</div>
		<div class="col-sm-6 mt-2">
			<!-- Show User LoggedIn field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_user_login_notification" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowLoginNotify" name="show_user_login_notification" value="true" <?= $userSettingData['show_user_login_notification'] == true ? 'checked' : '' ?>>
				<label class="custom-control-label" for="lwShowLoginNotify"><?= __tr('Show Login Notification For Your Liked Users')  ?></label>
			</div>
			<!-- / Show User LoggedIn field -->
		</div>

		<!-- Display Mobile Number And check admin can set on User Choice Display mobile number selection -->
		@if(getStoreSettings('display_mobile_number') == 2)
		<div class="col-sm-12 mt-4 mb-3">
			<label for="lwDisplayMobileNumber"><?= __tr('Display Mobile Number') ?></label>
			<select id="lwDisplayMobileNumber" class="form-control form-control-user" name="display_user_mobile_number" required>
				@foreach($userSettingData['user_choice_display_mobile_number'] as $key => $userChoice)
				<option value="<?= $key ?>" <?= ($userSettingData['display_user_mobile_number'] == $key) ? 'selected' : '' ?>><?= $userChoice ?></option>
				@endforeach
			</select>
		</div>
		@endif
		<!-- /Display Mobile Number And check admin can set on User Choice Display mobile number selection -->
	</div>
	@endif

	<!-- Update Button -->
	<a href class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile mt-3 btn-sm">
		<?= __tr('Update') ?>
	</a>
	<!-- /Update Button -->
</form>
<!-- Notification Setting Form -->