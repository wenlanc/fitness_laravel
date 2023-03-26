@section('page-title', __tr("Manage SupportRequest"))
@section('head-title', __tr("Manage SupportRequest"))
@section('keywordName', strip_tags(__tr("Manage SupportRequest")))
@section('keyword', strip_tags(__tr("Manage SupportRequest")))
@section('description', strip_tags(__tr("Manage SupportRequest")))
@section('keywordDescription', strip_tags(__tr("Manage SupportRequest")))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- SupportRequest Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Manage Support Request') ?></h1>
	<a class="btn btn-primary btn-sm" href="<?= route('manage.support.add.view') ?>" title="Add New Support Request"><?= __tr('Add New Support Request') ?></a>
</div>
<!-- Start of SupportRequest Wrapper -->
<div class="row">
	<div class="col-xl-12 mb-4">
		<div class="card mb-4">
			<div class="card-body">
				<table class="table table-hover" id="lwManageSupportRequestTable">
					<thead>
						<tr>
						    <th><?= __tr('Requester') ?></th>
							<th><?= __tr('Type') ?></th>
							<th><?= __tr('Description') ?></th>
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
<!-- End of SupportRequest Wrapper -->

<!-- User Soft delete Container -->
<div id="lwSupportRequestDeleteContainer" style="display: none;">
	<h3><?= __tr('Are You Sure!') ?></h3>
	<strong><?= __tr('You want to delete this support request.') ?></strong>
</div>
<!-- User Soft delete Container -->

<!-- SupportRequest Action Column -->
<script type="text/_template" id="supportRequestActionColumnTemplate">
	<div class="btn-group">
		<button type="button" class="btn btn-black dropdown-toggle lw-datatable-action-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-ellipsis-v"></i>
		</button>
		<div class="dropdown-menu dropdown-menu-right">
		    <!-- SupportRequest Edit Button -->
		    <a class="dropdown-item" href="<%= __Utils.apiURL("<?= route('manage.support.edit.view', ['supportUId' => 'supportUId']) ?>", {'supportUId': __tData._uid}) %>"><i class="far fa-edit"></i> <?= __tr('Edit') ?></a>
		    <!-- /SupportRequest Edit Button -->

		    <!-- SupportRequest Delete Button -->
		    <a data-callback="onSuccessAction" data-method="post" class="dropdown-item lw-ajax-link-action-via-confirm" data-confirm="#lwSupportRequestDeleteContainer" href data-action="<%= __Utils.apiURL("<?= route('manage.support.write.delete', ['supportUId' => 'supportUId']) ?>", {'supportUId': __tData._uid}) %>"><i class="fas fa-trash-alt"></i> <?= __tr('Delete') ?></a>
		    <!-- /SupportRequest Delete Button -->

		</div>
	</div>
</script>
<!-- SupportRequest Action Column -->

<script type="text/_template" id="supportRequestUserColumnTemplate">
	<div>
		<img class="img-profile rounded-circle" style="height: 2rem;width: 2rem;" src="<%=  __tData.userImageUrl %>">
		<%=  __tData.username %>
	</div>
</script>

@push('appScripts')
<script>
	var dtColumnsData = [
		    {
				"name": "userImageUrl",
				"template": '#supportRequestUserColumnTemplate',
			},
			{
				"name": "type",
				"orderable": true,
			},
			{
				"name": "description",
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
				"template": '#supportRequestActionColumnTemplate'
			}
		],
		dataTableInstance;

	dataTableInstance = dataTable('#lwManageSupportRequestTable', {
		url: "<?= route('manage.support.list') ?>",
		dtOptions: {
			"searching": true,
			"order": [
				[1, 'desc']
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