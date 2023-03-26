@section('page-title', __tr("Add SupportRequest"))
@section('head-title', __tr("Add SupportRequest"))
@section('keywordName', strip_tags(__tr("Add SupportRequest")))
@section('keyword', strip_tags(__tr("Add SupportRequest")))
@section('description', strip_tags(__tr("Add SupportRequest")))
@section('keywordDescription', strip_tags(__tr("Add SupportRequest")))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- SupportRequest Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Add SupportRequest')  ?></h1>
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
				<!-- SupportRequest add form -->
				<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.support.write.add') ?>">
					<!-- title input field -->
					<div class="form-group">
						<label for="lwType"><?= __tr('Support Type') ?></label>
						<select name="support_type"  style="background-color:#222222;border-radius: 1rem !important;color:#FFFFFF"  class="form-control" id="lwType" required>
							<option value="" selected disabled><?= __tr('Choose a type of your issue.') ?></option>
							@foreach(configItem("support.support_types") as $key => $val)
								<option value="<?= $val ?>" > <?= $val ?> </option>
							@endforeach		
						</select>
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
				<!-- / SupportRequest add form -->
			</div>
		</div>
	</div>
</div>
<!-- End of SupportRequest Wrapper -->