@section('page-title', __tr("Manage User Subscriptions"))
@section('head-title', __tr("Manage User Subscriptions"))
@section('keywordName', strip_tags(__tr("Manage User Subscriptions")))
@section('keyword', strip_tags(__tr("Manage User Subscriptions")))
@section('description', strip_tags(__tr("Manage User Subscriptions")))
@section('keywordDescription', strip_tags(__tr("Manage User Subscriptions")))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr("Manage User Subscriptions") ?></h1>
</div>
<!-- /Page Heading -->

<div class="row">
	<div class="col-xl-12">
		<!-- card -->
		<div class="card mb-4">
			<!-- card body -->
			<div class="card-body">
				<!-- table start -->
				<table class="table table-hover" id="lwManageUserSubscriptionTable">
					<!-- table headings -->
					<thead>
						<tr>
							<th class="lw-dt-nosort"><?= __tr('Image') ?></th>
							<th><?= __tr('Full Name') ?></th>
							<th><?= __tr('Price') ?></th>
							<th><?= __tr('Plan Interval') ?></th>
							<th><?= __tr('Plan Interval Count') ?></th>
							<th><?= __tr('Status') ?></th>
							<th><?= __tr('Created On') ?></th>
							<th><?= __tr('Action') ?></th>
						</tr>
					</thead>
					<!-- /table headings -->
					<tbody class="lw-datatable-photoswipe-gallery"></tbody>
				</table>
				<!-- table end -->
			</div>
			<!-- /card body -->
		</div>
		<!-- /card -->
	</div>
</div>
<!-- User Soft delete Container -->
<div id="lwSubscriptionDeleteContainer" style="display: none;">
	<h3><?= __tr('Are You Sure!') ?></h3>
	<strong><?= __tr('You want to delete this Subscription') ?></strong>
</div>
<!-- User Soft delete Container -->

<script type="text/_template" id="usersProfilePictureTemplate">
		<img class="lw-datatable-profile-picture lw-dt-thumbnail lw-photoswipe-gallery-img lw-lazy-img" src="<?= noThumbImageURL() ?>" data-src="<%= __tData.profile_image %>">
</script>

<!-- Pages Action Column -->
<script type="text/_template" id="actionColumnTemplate">
	<a class="btn btn-danger btn-sm  lw-ajax-link-action-via-confirm" data-confirm="#lwSubscriptionDeleteContainer" data-method="post" data-action="<%= __tData.deleteUrl %>" data-callback="onSuccessAction" href data-method="post"><i class="fas fa-trash-alt"></i> <?= __tr('Delete') ?></a>
</script>
<!-- Pages Action Column -->

<!-- Title Column -->
<script type="text/_template" id="titleTemplate">
	<a target="_blank" href="<%= __tData.profile_url %>"><%= __tData.full_name %></a> 
</script>
<!-- Title Column -->

@push('appScripts')
<script>
	var dtColumnsData = [{
				"name": "_uid",
				"template": '#usersProfilePictureTemplate',
				"searchable": false,
				"orderable": false
			},
			{
				"name": "first_name",
				"orderable": true,
				"searchable": true,
				"template": '#titleTemplate',
			},
			{
				"name": "plan_amount",
				"orderable": false,
				"searchable": false
			},
			{
				"name": "plan_interval",
				"orderable": false,
				"searchable": false
			},
			{
				"name": "plan_interval_count",
				"orderable": false,
				"searchable": false
			},
			{
				"name": "created",
				"orderable": true,
				"searchable": false
			},
			{
				"name": "action",
				"orderable": false,
				"searchable": false,
				"template": '#actionColumnTemplate'
			}
		],
		dataTableInstance;

	// Perform actions after delete / restore / block
	onSuccessAction = function(response) {
		reloadDT(dataTableInstance);
	};

	//for users list
	fetchUserSubscription = function() {
		dataTableInstance = dataTable('#lwManageUserSubscriptionTable', {
			url: "<?= route('manage.user.read.subscriptions_list') ?>",
			dtOptions: {
				"searching": true,
				"order": [
					[3, 'desc']
				],
				"pageLength": 25,
				"drawCallback": function() {
					applyLazyImages();
				}
			},
			columnsData: dtColumnsData,
			scope: this
		});
	};
	fetchUserSubscription();
</script>
@endpush