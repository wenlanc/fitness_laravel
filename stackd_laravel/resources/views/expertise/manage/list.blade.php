@section('page-title', __tr("Manage Expertise"))
@section('head-title', __tr("Manage Expertise"))
@section('keywordName', strip_tags(__tr("Manage Expertise")))
@section('keyword', strip_tags(__tr("Manage Expertise")))
@section('description', strip_tags(__tr("Manage Expertise")))
@section('keywordDescription', strip_tags(__tr("Manage Expertise")))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Expertise Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Manage Expertise') ?></h1>
	<a class="btn btn-primary btn-sm" href="<?= route('manage.expertise.add.view') ?>" title="Add New Expertise"><?= __tr('Add New Expertise') ?></a>
</div>
<!-- Start of Expertise Wrapper -->
<div class="row">
	<div class="col-xl-12 mb-4">
		<div class="card mb-4">
			<div class="card-body">
				<table class="table table-hover" id="lwManageExpertiseTable">
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
<!-- End of Expertise Wrapper -->

<!-- User Soft delete Container -->
<div id="lwExpertiseDeleteContainer" style="display: none;">
	<h3><?= __tr('Are You Sure!') ?></h3>
	<strong><?= __tr('You want to delete this Expertise.') ?></strong>
</div>
<!-- User Soft delete Container -->

<!-- Expertise Action Column -->
<script type="text/_template" id="ExpertiseActionColumnTemplate">
	<div class="btn-group">
		<button type="button" class="btn btn-black dropdown-toggle lw-datatable-action-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-ellipsis-v"></i>
		</button>
		<div class="dropdown-menu dropdown-menu-right">
		    <!-- Expertise Edit Button -->
		    <a class="dropdown-item" href="<%= __Utils.apiURL("<?= route('manage.expertise.edit.view', ['expertiseUId' => 'expertiseUId']) ?>", {'expertiseUId': __tData._uid}) %>"><i class="far fa-edit"></i> <?= __tr('Edit') ?></a>
		    <!-- /Expertise Edit Button -->

		    <!-- Expertise Delete Button -->
		    <a data-callback="onSuccessAction" data-method="post" class="dropdown-item lw-ajax-link-action-via-confirm" data-confirm="#lwExpertiseDeleteContainer" href data-action="<%= __Utils.apiURL("<?= route('manage.expertise.write.delete', ['expertiseUId' => 'expertiseUId']) ?>", {'expertiseUId': __tData._uid}) %>"><i class="fas fa-trash-alt"></i> <?= __tr('Delete') ?></a>
		    <!-- /Expertise Delete Button -->

		</div>
	</div>
</script>
<!-- Expertise Action Column -->

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
				"template": '#ExpertiseActionColumnTemplate'
			}
		],
		dataTableInstance;

	dataTableInstance = dataTable('#lwManageExpertiseTable', {
		url: "<?= route('manage.expertise.list') ?>",
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