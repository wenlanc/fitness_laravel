@section('page-title', __tr('Notification Settings'))
@section('head-title', __tr('Notification Settings'))
@section('keywordName', __tr('Notification Settings'))
@section('keyword', __tr('Notification Settings'))
@section('description', __tr('Notification Settings'))
@section('keywordDescription', __tr('Notification Settings'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- About Setting Form -->
<form class="lw-ajax-form lw-form" method="post" action="<?= route('user.write.setting', ['pageType' => request()->pageType]) ?>">
	<div id="accordion">
		<div class="card">
			<div class="card-header" id="headingOne">
			<h6 class="mb-0">
				Data Policy
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
				Terms of Use
				<a class="btn" style="position: absolute;right: 0px;top: 5px;" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
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
		
	</div>

	<!-- Update Button -->
	<a href class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile mt-3 btn-sm">
		<?= __tr('Update') ?>
	</a>
	<!-- /Update Button -->
</form>
<!-- About Setting Form -->