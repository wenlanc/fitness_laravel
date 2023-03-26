@section('PricingType-title', __tr("Edit PricingType"))
@section('head-title', __tr("Edit PricingType"))
@section('keywordName', strip_tags(__tr("Edit PricingType")))
@section('keyword', strip_tags(__tr("Edit PricingType")))
@section('description', strip_tags(__tr("Edit PricingType")))
@section('keywordDescription', strip_tags(__tr("Edit PricingType")))
@section('PricingType-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('PricingType-url', url()->current())

<!-- PricingType Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Edit PricingType') ?></h1>
	<!-- back button -->
	<a class="btn btn-light btn-sm" href="<?= route('manage.pricingtype.view') ?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= __tr('Back to PricingTypes') ?>
	</a>
	<!-- /back button -->
</div>
<!-- Start of PricingType Wrapper -->
<div class="row">
	<div class="col-xl-12 mb-4">
		<div class="card mb-4">
			<div class="card-body">
				

				<!-- PricingType edit form -->
				<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.pricingtype.write.edit', ['pricingtypeUId' => $pricingtypeEditData['_uid']]) ?>">
					<!-- hidden _uid input field -->
					<input type="hidden" value="<?= $pricingtypeEditData['_uid'] ?>" class="form-control" name="pricingtypeUid">
					<!-- / hidden _uid input field -->

					<!-- title input field -->
					<div class="form-group">
						<label for="lwTitle"><?= __tr('Title') ?></label>
						<input type="text" value="<?= $pricingtypeEditData['title'] ?>" id="lwTitle" class="form-control" name="title" required minlength="3">
					</div>
					<!-- / title input field -->

					<!-- description field -->
					<div class="form-group">
						<label for="lwDescription"><?= __tr('Description') ?></label>
						<textarea rows="4" cols="50" class="form-control" name="description" id="lwDescription" required><?= $pricingtypeEditData['description'] ?></textarea>
					</div>
					<!-- / description field -->

					<!-- status field -->
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="activeCheck" name="status" <?= $pricingtypeEditData['status'] == 1 ? 'checked' : '' ?>>
						<label class="custom-control-label" for="activeCheck"><?= __tr('Active') ?></label>
					</div>
					<!-- / status field -->

					<br><br>
					<!-- update button -->
					<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile"><?= __tr('Update') ?></button>
					<!-- / update button -->
				</form>
				<!-- / PricingType edit form -->
			</div>
		</div>
	</div>
</div>
<!-- End of PricingType Wrapper -->