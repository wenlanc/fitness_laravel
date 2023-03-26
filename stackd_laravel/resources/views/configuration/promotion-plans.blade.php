<!-- Page Heading -->
<h3><?= __tr('Promotion Plan Settings') ?></h3>
<!-- /Page Heading -->
<hr>
<!-- pusher Setting Form -->
<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.configuration.write', ['pageType' => request()->pageType]) ?>">
	<!-- premium plan container -->
		@foreach($configurationData['promotion_plan_duration'] as $plan_key => $plan_data)
			<div class="form-group mt-2">
				<fieldset class="lw-fieldset mb-3">
					<legend class="lw-fieldset-legend text-uppercase">
						<?= $plan_key?>
					</legend>
					<div class="row">
						@foreach($configurationData['promotion_plan_duration'][$plan_key] as $key => $plan)
						<div class="col-sm-6">
							<div class="custom-control custom-checkbox">
								<!-- enable premium plans input hidden field -->
								<input type="hidden" name="promotion_plan_duration[<?= $plan_key ?>][<?= $key ?>][enable]" id="lwEnablePlan_<?= $plan_key.'_'.$key ?>" value="false" />
								<!-- /enable premium plans input hidden field -->
								<input type="checkbox" class="custom-control-input" id="lwEnable_<?= $plan_key.'_'.$key ?>" name="promotion_plan_duration[<?= $plan_key ?>][<?= $key ?>][enable]" value="true" <?= $plan['enable'] == 'true' ? 'checked' : '' ?>>
								<label class="custom-control-label" for="lwEnable_<?= $plan_key.'_'.$key ?>"><?= $plan['title'] ?></label>
							</div>
							<!-- Plan Price -->
							<div class="mb-3" id="lwPlanPriceInputField_<?= $plan_key.'_'.$key ?>">
								<label for="lwPrice_<?= $plan_key.'_'.$key ?>"><?= __tr('Price') ?></label>
								<input type="number" class="form-control form-control-user" value="<?= $plan['price'] ?>" name="promotion_plan_duration[<?= $plan_key ?>][<?= $key ?>][price]" placeholder="<?= __tr('Price') ?>" id="lwPrice_<?= $plan_key.'_'.$key ?>">
							</div>
							<!-- / Plan Price -->
						</div>
						@endforeach
					</div>	
				</fieldset>
			</div>	
		@endforeach
	<!-- premium plan container -->
	<hr>
	<!-- Update Button -->
	<a href class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile">
		<?= __tr('Update') ?>
	</a>
	<!-- /Update Button -->
</form>

@push('appScripts')
<script>
	$(document).ready(function() {
		var premiumPlan = JSON.parse('<?= json_encode($configurationData['promotion_plan_duration']) ?>');

		//premium plan array on change bind value and disable input price filed start
		_.forEach(premiumPlan, function(m_value, m_key) {
			_.forEach(premiumPlan.m_key, function(value, key) {
				var enablePlan = value.enable;
				//check is false then disabled input price field
				if (!enablePlan) {
					$("#lwPlanPriceInputField_" + key).addClass('lw-disabled-block-content');
				}

				//enable plan on change event
				$("#lwEnable_" + key).on('change', function(e) {
					var enablePlan = $(this).is(':checked');
					if (enablePlan) {
						$("#lwPlanPriceInputField_" + key).removeClass('lw-disabled-block-content');
					} else {
						$("#lwPlanPriceInputField_" + key).addClass('lw-disabled-block-content');
					}
				})
			});	
		});
		//premium plan array on change bind value and disable input price filed end
	});
</script>
@endpush