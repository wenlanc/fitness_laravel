@if(!__isEmpty($notificationData))
@foreach($notificationData as $notification)
	<div class="p-2 mt-2 " style="border-bottom:1px solid #282828;"> 
		<div class="chat-user-item d-flex position-relative"> 
			<div class="chat-user-avatar">
				<img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="<?=$notification["userImageUrl"]?>">
				<div class="chat-user-online-status-dot">
					<span class="d-none lw-dot lw-dot-danger" title="Offline"></span>
				</div>
			</div>
			<div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
				<div class="row" style="">
					<span class="chat-content"><a href="<?=$notification["action"]?>" style="color:white;"><?=$notification["message"]?></a></span>
					<span class="chat-time" style="margin-left:auto;"><?=$notification["created_at"]?></span>
				</div>
			</div>
		</div> 
	</div> 
@endforeach
@else
<!-- info message -->
<div class="col-sm-12 alert alert-info">
	<?= __tr('There are no feed found.') ?>
</div>
<!-- / info message -->
@endif



