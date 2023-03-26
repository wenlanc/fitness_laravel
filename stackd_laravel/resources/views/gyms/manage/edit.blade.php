 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
 	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Edit Gym')  ?></h1>
 	<!-- back button -->
 	<a class="btn btn-light btn-sm" href="<?= route('manage.gyms.view') ?>">
 		<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= __tr('Back to Gyms') ?>
 	</a>
 	<!-- /back button -->
 </div>
 <!-- Start of Page Wrapper -->
 <div class="row">
 	<div class="col-xl-12 mb-4">
 		<div class="card mb-4">
 			<div class="card-body">
 				<!-- page add form -->
 				<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.gyms.write.edit', ['gymsUId' => $gymEditData['_uid']]) ?>">

 					<div class="row">
 						<div class="col-lg-6">
 							<input type="file" class="lw-file-uploader" data-instant-upload="true" data-action="<?= route('media.gyms.upload_temp_media') ?>" data-remove-media="true" data-callback="afterUploadedFile" data-allow-image-preview="false" data-allowed-media='<?= getMediaRestriction('gyms') ?>'>
 							<input type="hidden" name="gym_image" class="lw-uploaded-file" value="">
 						</div>
 						<div class="col-lg-6" id="lwGymsImagePreview">
 							<img class="lw-gyms-preview-image lw-uploaded-preview-img" src="<?= $gymEditData['gyms_image_url'] ?>">
 						</div>
 					</div>

 					<!-- title input field -->
 					<div class="form-group">
 						<label for="gymName"><?= __tr('Name') ?></label>
 						<input type="text" value="<?= $gymEditData['name'] ?>" id="gymName" class="form-control" name="name" placeholder="<?= __tr('Name')  ?>" required minlength="3">
 					</div>
 					<!-- / title input field -->
 					<div class="form-group row">
 					</div>

 					<!-- status field -->
 					<div class="custom-control custom-checkbox custom-control-inline">
 						<input type="checkbox" class="custom-control-input" id="statusCheck" name="status" <?= $gymEditData['status'] == 1 ? 'checked' : '' ?>>
 						<label class="custom-control-label" for="statusCheck"><?= __tr('Active')  ?></label>
 					</div>
 					<!-- / status field -->
 					<br><br>
 					<!-- Update button -->
 					<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile"><?= __tr('Update')  ?></button>
 					<!-- / Update button -->
 				</form>
 				<!-- / page add form -->
 			</div>
 		</div>
 	</div>
 </div>
 <!-- End of Page Wrapper -->
 @push('appScripts')
 <script>
 	function afterUploadedFile(responseData) {
 		if (responseData.reaction == 1) {
 			$('.lw-gyms-preview-image').attr('src', responseData.data.path);
 		}
 	}
 </script>
 @endpush