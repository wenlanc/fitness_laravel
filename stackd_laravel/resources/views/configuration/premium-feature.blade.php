<!-- Page Heading -->
<h3><?= __tr('Feature Settings') ?></h3>
<!-- /Page Heading -->
<hr>
<!-- pusher Setting Form -->
<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.configuration.write', ['pageType' => request()->pageType]) ?>">
	<!-- premium plan container -->
	@foreach($configurationData['feature_plans'] as $plan_key => $plan_data)
		<div class="form-group mt-2">
			<fieldset class="lw-fieldset mb-3">
				<legend class="lw-fieldset-legend text-uppercase">
					<?= $plan_key?>
				</legend>

				<div class="row">
					@foreach($configurationData['feature_plans'][$plan_key] as $key => $feature)
					@if(isset($feature['enable']) and $feature['enable'])
					@if($loop->last)
					<div class="col-sm-12 mb-3">
					@else
					<div class="col-sm-6 mb-3">
					@endif
						<!-- Feature Title -->
						<span><?= $feature['title'] ?></span>
						<!-- /Feature Title -->

						<div id="lwFeatureSelectUser_<?= $plan_key.'_'.$key ?>">
							@foreach($feature['options'] as $optionKey => $option)
							<!-- select premium feature user input hidden field -->
							<input type="hidden" name="feature_plans[<?= $plan_key ?>][<?= $key ?>][select_user]" value="1" />
							<!-- select premium feature user input hidden field -->

							<!-- select user -->
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="lwSelectUser_<?= $plan_key.'_'.$key . '_' . $optionKey ?>" value="<?= $option['value'] ?>" name="feature_plans[<?= $plan_key ?>][<?= $key ?>][select_user]" class="custom-control-input" value="2" <?= $feature['select_user'] == $option['value'] ? 'checked' : '' ?> />
								<label class="custom-control-label" for="lwSelectUser_<?= $plan_key.'_'.$key . '_' . $optionKey ?>"><?= $option['title'] ?></label>
							</div>
							<!-- /select user -->
							@endforeach
							<!-- Show Encounter User count -->
							@if($key== 'user_encounter')
							<div class="mb-3 mt-3" id="lwEncounterUserCountField_<?= $plan_key.'_'.$key ?>" style="display:none">
								<strong><?= __tr('Daily Encounter limit for Normal Users') ?></strong>
								<input type="number" class="form-control form-control-user" name="feature_plans[<?= $plan_key ?>][<?= $key ?>][encounter_all_user_count]" placeholder="<?= __tr('Daily Encounter User') ?>" value="<?= $feature['encounter_all_user_count'] ?>">
							</div>
							@endif()
							<!-- /Show Encounter User count -->
						</div>
						<!-- / select -->
					</div>
					@endif
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
		var premiumFeature = JSON.parse('<?= str_replace("\u0022", "\\\\\"", json_encode($configurationData['feature_plans'], JSON_HEX_QUOT)) ?>'),
			enableUserEncounter = premiumFeature['common']['user_encounter']['enable'];

		//premium plan array on change bind value and disable input price filed start
		_.forEach(premiumFeature, function(m_featureValue, m_featureKey) {
			_.forEach(premiumFeature.m_featureKey, function(featureValue, featureKey) {
				var enableFeature = featureValue.enable,
					featureOption = featureValue.options;

				//check premium feature are enable or disable
				if (!enableFeature) {
					$("#lwFeatureSelectUser_" + m_featureKey + "_" + featureKey).addClass('lw-disabled-block-content');
				} else {
					$("#lwFeatureSelectUser_" + m_featureKey + "_" + featureKey).removeClass('lw-disabled-block-content');
				}

				//feature option array start
				_.forEach(featureOption, function(optionValue, optionKey) {
					var isCheckedEncounterAllUser = $("#lwSelectUser_common_user_encounter_0").is(':checked');

					//check select feature is encounter and select user is 'All user (1)'
					if (enableUserEncounter && isCheckedEncounterAllUser) {
						$("#lwEncounterUserCountField_" + m_featureKey + "_" + featureKey).show();
					}

					//enable plan on change event
					$("#lwSelectUser_" + m_featureKey + "_" + featureKey + '_' + optionKey).on('change', function(e) {
						isCheckedEncounterAllUser = $("#lwSelectUser_common_user_encounter_0").is(':checked');

						//check select feature is encounter and select user is 'All user (1)'
						if (enableUserEncounter && isCheckedEncounterAllUser) {
							$("#lwEncounterUserCountField_"  + m_featureKey + "_" + featureKey).show();
						} else {
							$("#lwEncounterUserCountField_"  + m_featureKey + "_" + featureKey).hide();
						}
					});
				})
				//feature option array end
			});
			//premium plan array on change bind value and disable input price filed end
		});
	});
</script>
@endpush