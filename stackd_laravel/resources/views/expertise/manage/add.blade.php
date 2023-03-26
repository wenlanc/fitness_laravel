@section('page-title', __tr("Add Expertise"))
@section('head-title', __tr("Add Expertise"))
@section('keywordName', strip_tags(__tr("Add Expertise")))
@section('keyword', strip_tags(__tr("Add Expertise")))
@section('description', strip_tags(__tr("Add Expertise")))
@section('keywordDescription', strip_tags(__tr("Add Expertise")))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Expertise Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Add Expertise')  ?></h1>
	<!-- back button -->
	<a class="btn btn-light btn-sm" href="<?= route('manage.expertise.view') ?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= __tr('Back to Expertises') ?>
	</a>
	<!-- /back button -->
</div>
<!-- Start of Expertise Wrapper -->
<div class="row">
	<div class="col-xl-12 mb-4">
		<div class="card mb-4">
			<div class="card-body">
				<!-- Expertise add form -->
				<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.expertise.write.add') ?>">
					<!-- title input field -->
					<div class="form-group">
						<label for="lwTitle"><?= __tr('Title') ?></label>
						<input type="text" class="form-control" name="title" id="lwTitle" required minlength="3">
					</div>
					<!-- / title input field -->

					<!-- description field -->
					<div class="form-group">
						<label for="lwDescription"><?= __tr('Description') ?></label>
						<textarea rows="4" cols="50" class="form-control" id="lwDescription" name="description" required></textarea>
					</div>
					<!-- / description field -->

					<!-- status field -->
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="activeCheck" name="status">
						<label class="custom-control-label" for="activeCheck"><?= __tr('Active')  ?></label>
					</div>
					<!-- / status field -->
					<br><br>
					<!-- add button -->
					<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile"><?= __tr('Add')  ?></button>
					<!-- / add button -->
				</form>
				<!-- / Expertise add form -->
			</div>
		</div>
	</div>
</div>
<!-- End of Expertise Wrapper -->