@section('page-title', __tr('Notifications'))
@section('head-title', __tr('Notifications'))
@section('keywordName', __tr('Notifications'))
@section('keyword', __tr('Notifications'))
@section('description', __tr('Notifications'))
@section('keywordDescription', __tr('Notifications'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-1">
	<h5 class="h5 mb-0 text-gray-200">
		<span class=""><i class="far fa-bell"></i></span> <?= __tr('Notifications') ?></h5>
</div>

<!-- Start of Notification Wrapper -->
<div class="card mb-4">
	<div class="card-body">
		<div class="chat-users-list"> 
			<div class="dropdown-message-list notification-list-container" style=""> 
			</div> 
			<div class="lw-load-more-container" id="lw-load-more-container" style="display:none;">
				<button type="button" class="btn btn-light btn-block lw-ajax-link-action lw-load-more-btn" id="lwLoadMoreButton" data-action="" data-callback="loadCallback"><?= __tr('Load More'); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- End of Notification Wrapper -->

@push('appScripts')
<script>
	
	let hasMorePages = true;

	function loadCallback(responseData) {
		$(function() {
			applyLazyImages();
		});
		var requestData = responseData.data;
		var appendData = responseData.response_action.content;
		hasMorePages = requestData.hasMorePages;
		$('.notification-list-container').append(appendData);
		$('#lwLoadMoreButton').data('action', requestData.nextPageUrl);
		if (!hasMorePages) {
			$('#lw-load-more-container').hide();
		} else {
			$('#lw-load-more-container').show();
		}
	}


	function loadNotificationData() {
		if (hasMorePages) {
			var requestUrl = '<?= route('user.notification.read.view') ?>',
				formData = {

				};
			// post ajax request
			__DataRequest.get(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					loadCallback(response);
				}
			});
		}
	}

	loadNotificationData();

</script>
<!-- For Datatable -->
<script>
	var dtColumnsData = [{
				"name": "message",
				"orderable": true,
				"template": '#notificationMsgActionTemplate'
			},
			{
				"name": "created_at",
				"orderable": true,
				"template": '#notificationTimeActionTemplate'
			}
		],
		notificationTableInstance;

	notificationTableInstance = dataTable('#lwNotificationTable', {
		url: "<?= route('user.notification.read.list') ?>",
		dtOptions: {
			"searching": false,
			"order": [
				[0, 'desc']
			],
			"pageLength": 10
		},
		columnsData: dtColumnsData,
		scope: this
	});

	//notification read callback
	function notificationReadCallback(response) {
		if (response.reaction == 1) {
			//reload data-table instance
			reloadDT(notificationTableInstance);
			//get notification list
			var requestData = response.data.getNotificationList,
				getNotificationList = requestData.notificationData,
				getNotificationCount = requestData.notificationCount,
				notification = '';
			//empty text
			$("#lwNotificationList").text('');
			if (!_.isEmpty(getNotificationList)) {
				_.forEach(getNotificationList, function(value, key) {
					notification = '<a class="dropdown-item d-flex align-items-center"><div><div class="small text-gray-500">' + value.created_at + '</div><span class="font-weight-bold">' + value.message + '</span></div></a>';
					$("#lwNotificationList").append(notification);
				});
			} else {
				//hide show all notification link in top header
				$("#lwShowAllNotifyLink").hide();
				notification = '<a class="dropdown-item text-center small text-gray-500"><?= __tr('There are no notification.') ?></a>'
			}
			$("#lwNotificationCount").text(getNotificationCount);
		}
	}
</script>
@endpush