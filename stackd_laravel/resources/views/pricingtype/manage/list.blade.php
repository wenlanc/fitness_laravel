@section('page-title', __tr("Manage PricingType"))
@section('head-title', __tr("Manage PricingType"))
@section('keywordName', strip_tags(__tr("Manage PricingType")))
@section('keyword', strip_tags(__tr("Manage PricingType")))
@section('description', strip_tags(__tr("Manage PricingType")))
@section('keywordDescription', strip_tags(__tr("Manage PricingType")))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- PricingType Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Manage PricingType') ?></h1>
	<a class="btn btn-primary btn-sm" href="<?= route('manage.pricingtype.add.view') ?>" title="Add New PricingType"><?= __tr('Add New PricingType') ?></a>
</div>
<!-- Start of PricingType Wrapper -->
<div class="row">
	<div class="col-xl-12 mb-4">
		<div class="card mb-4">
			<div class="card-body">
				<table class="table table-hover" id="lwManagePricingTypeTable">
					<thead>
						<tr>
							<th><?= __tr('Title') ?></th>
							<th><?= __tr('Created') ?></th>
							<th><?= __tr('Updated') ?></th>
							<th><?= __tr('Status') ?></th>
							<th><?= __tr('Action') ?></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- End of PricingType Wrapper -->

<!-- User Soft delete Container -->
<div id="lwPricingTypeDeleteContainer" style="display: none;">
	<h3><?= __tr('Are You Sure!') ?></h3>
	<strong><?= __tr('You want to delete this PricingType.') ?></strong>
</div>
<!-- User Soft delete Container -->

<!-- PricingType Action Column -->
<script type="text/_template" id="PricingTypeActionColumnTemplate">
	<div class="btn-group">
		<button type="button" class="btn btn-black dropdown-toggle lw-datatable-action-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-ellipsis-v"></i>
		</button>
		<div class="dropdown-menu dropdown-menu-right">
		    <!-- PricingType Edit Button -->
		    <a class="dropdown-item" href="<%= __Utils.apiURL("<?= route('manage.pricingtype.edit.view', ['pricingtypeUId' => 'pricingtypeUId']) ?>", {'pricingtypeUId': __tData._uid}) %>"><i class="far fa-edit"></i> <?= __tr('Edit') ?></a>
		    <!-- /PricingType Edit Button -->

		    <!-- PricingType Delete Button -->
		    <a data-callback="onSuccessAction" data-method="post" class="dropdown-item lw-ajax-link-action-via-confirm" data-confirm="#lwPricingTypeDeleteContainer" href data-action="<%= __Utils.apiURL("<?= route('manage.pricingtype.write.delete', ['pricingtypeUId' => 'pricingtypeUId']) ?>", {'pricingtypeUId': __tData._uid}) %>"><i class="fas fa-trash-alt"></i> <?= __tr('Delete') ?></a>
		    <!-- /PricingType Delete Button -->

		</div>
	</div>
</script>
<!-- PricingType Action Column -->

@push('appScripts')
<script>
	var dtColumnsData = [{
				"name": "title",
				"orderable": true,
			},
			{
				"name": "created_at",
				"orderable": true,
			},
			{
				"name": "updated_at",
				"orderable": true,
			},
			{
				"name": 'status'
			},
			{
				"name": 'action',
				"template": '#PricingTypeActionColumnTemplate'
			}
		],
		dataTableInstance;

	dataTableInstance = dataTable('#lwManagePricingTypeTable', {
		url: "<?= route('manage.pricingtype.list') ?>",
		dtOptions: {
			"searching": true,
			"order": [
				[0, 'desc']
			],
			"pageLength": 25
		},
		columnsData: dtColumnsData,
		scope: this
	});

	// Perform actions after delete / restore / block
	onSuccessAction = function(response) {
		reloadDT(dataTableInstance);
	}
</script>
@endpush