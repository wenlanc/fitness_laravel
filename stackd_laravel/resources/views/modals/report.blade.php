<!-- user report Modal-->
<div class="modal fade" id="lwReportUserDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header" style="border:none;">
				<h5 class="modal-title" id="userReportModalLabel">Abuse Report to <span id = "report_modal_username"> ... </span></h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form class="lw-ajax-form lw-form" id="lwReportUserForm" method="post" data-callback="userReportCallback" action="<?= route('user.write.report_user'); ?>">
				<div class="modal-body">
					<!-- reason input field -->
					<div class="form-group">
						<label for="lwUserReportReason"><?= __tr('Reason'); ?></label>
						<textarea class="form-control" rows="5" style="height:auto; " id="lwUserReportReason" name="report_reason" required></textarea>
					</div>
					<!-- / reason input field -->
				</div>
                <input type="hidden" name="sendUserUId" id="report_sendUserUId" value="">
				<!-- modal footer -->
				<div class="modal-footer" style="border:none;">
					<button class="btn btn-light btn-sm" id="lwCloseUserReportDialog"><?= __tr('Cancel'); ?></button>
					<button type="submit" class="btn btn-primary btn-sm lw-ajax-form-submit-action btn-user lw-btn-block-mobile"><?= __tr('Report'); ?></button>
				</div>
			</form>
			<!-- modal footer -->
		</div>
	</div>
</div>
<!-- /user report Modal-->

<!-- User block Confirmation text html -->
<div id="lwBlockUserConfirmationText" style="display: none;">
	<h3><?= __tr('Are You Sure!'); ?></h3>
	<strong><?= __tr('You want to block this user.'); ?></strong>
</div>
<!-- /User block Confirmation text html -->

@push('appScripts')
<script>
    function reportDialogShow(userUId, username){
        $("span#report_modal_username").html(username);
		$("#report_sendUserUId").val(userUId);
        $("#lwReportUserDialog").modal('show');
    }

    //user report callback
	function userReportCallback(response) {
		//check success reaction is 1
		if (response.reaction == 1) {
			var requestData = response.data;
			//form reset after success
			$("#lwReportUserForm").trigger("reset");
			//close dialog after success
			$('#lwReportUserDialog').modal('hide');
			//reload view after 2 seconds on success reaction
			_.delay(function() {
				__Utils.viewReload();
			}, 1000)
		}
	}

	//close User Report Dialog
	$("#lwCloseUserReportDialog").on('click', function(e) {
		e.preventDefault();
		//form reset after success
		$("#lwReportUserForm").trigger("reset");
		//close dialog after success
		$('#lwReportUserDialog').modal('hide');
	});

    //block user confirmation
	function blockUserConfirm(userUId) {
		var confirmText = $('#lwBlockUserConfirmationText');
		//show confirmation 
		showConfirmation(confirmText, function() {
			var requestUrl = '<?= route('user.write.block_user'); ?>',
				formData = {
					'block_user_id': userUId,
				};
			// post ajax request
			__DataRequest.post(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					__Utils.viewReload();
				}
			});
		});
	}


</script>
@endpush