@section('SupportRequest-title', __tr("Edit SupportRequest"))
@section('head-title', __tr("Edit SupportRequest"))
@section('keywordName', strip_tags(__tr("Edit SupportRequest")))
@section('keyword', strip_tags(__tr("Edit SupportRequest")))
@section('description', strip_tags(__tr("Edit SupportRequest")))
@section('keywordDescription', strip_tags(__tr("Edit SupportRequest")))
@section('SupportRequest-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('SupportRequest-url', url()->current())

<!-- SupportRequest Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Edit SupportRequest') ?></h1>
	<!-- back button -->
	<a class="btn btn-light btn-sm" href="<?= route('manage.support.view') ?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= __tr('Back to SupportRequests') ?>
	</a>
	<!-- /back button -->
</div>
<!-- Start of SupportRequest Wrapper -->
<div class="row">
	<div class="col-xl-12 mb-4">
		<div class="card mb-4">
			<div class="card-body">
				

				<!-- SupportRequest edit form -->
				<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.support.write.edit', ['supportUId' => $supportEditData['_uid']]) ?>">
					<!-- hidden _uid input field -->
					<input type="hidden" value="<?= $supportEditData['_uid'] ?>" class="form-control" name="supportUId">
					<!-- / hidden _uid input field -->

					<!-- title input field -->
					<div class="form-group">
						<label for="lwType"><?= __tr('Type') ?></label>
						<select name="support_type"  style="background-color:#222222;border-radius: 1rem !important;color:#FFFFFF"  class="form-control" id="lwType" required>
							<option value="" selected disabled><?= __tr('Choose a type of your issue.') ?></option>
							@foreach(configItem("support.support_types") as $key => $val)
								<option value="<?= $val ?>" @if( $val == $supportEditData['type']) selected @endif> <?= $val ?> </option>
							@endforeach		
						</select>
					</div>
					<!-- / title input field -->

					<!-- description field -->
					<div class="form-group">
						<label for="lwDescription"><?= __tr('Description') ?></label>
						<textarea rows="4" cols="50" class="form-control" name="description" id="lwDescription" required><?= $supportEditData['description'] ?></textarea>
					</div>
					<!-- / description field -->

					<!-- status field -->
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="activeCheck" name="status" <?= $supportEditData['status'] == 1 ? 'checked' : '' ?>>
						<label class="custom-control-label" for="activeCheck"><?= __tr('Active') ?></label>
					</div>
					<!-- / status field -->

					<br><br>
					<!-- update button -->
					<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile"><?= __tr('Update') ?></button>
					<!-- / update button -->
				</form>
				<!-- / SupportRequest edit form -->
			</div>
		</div>
	</div>
</div>
<!-- End of SupportRequest Wrapper -->