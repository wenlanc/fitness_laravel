<?php 
$current_route = Route::getCurrentRoute()->getName();
?>

<style>
.sponser-ad-sidebar li.active svg path {
    fill: none!important; 
    color: #ff4141!important;
}
</style>

<div class="col-lg-3 sponser-ad-sidebar" style="border-right: 1px solid #393939;padding:0px;">
	<!-- Sidebar of settings -->
	<ul class="navbar-nav sidebar-dark accordion" id="accordionSettingSidebar">

		<li class="mt-2 nav-item pr-2 <?= $current_route=="user.read.sponser-ad"?"active":"" ?>">
			<a class="nav-link pl-3" href="<?= route('user.read.sponser-ad') ?>">
				@if($current_route=="user.read.sponser-ad")
				<svg width="21" height="22" viewBox="0 0 21 22" fill="none!important" xmlns="http://www.w3.org/2000/svg">
<path d="M5.24414 13.781L8.23728 9.89088L11.6515 12.5728L14.5805 8.79248" stroke="#FF3F3F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<circle cx="17.9945" cy="3.20003" r="1.9222" stroke="#FF3F3F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12.9238 2.12012H5.65606C2.64462 2.12012 0.777344 4.25284 0.777344 7.26428V15.3467C0.777344 18.3581 2.60801 20.4817 5.65606 20.4817H14.2602C17.2716 20.4817 19.1389 18.3581 19.1389 15.3467V8.30776" stroke="#FF3F3F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

				@else
				<svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5.24414 13.781L8.23728 9.89088L11.6515 12.5728L14.5805 8.79248" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<circle cx="17.9945" cy="3.20003" r="1.9222" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12.9238 2.12012H5.65606C2.64462 2.12012 0.777344 4.25284 0.777344 7.26428V15.3467C0.777344 18.3581 2.60801 20.4817 5.65606 20.4817H14.2602C17.2716 20.4817 19.1389 18.3581 19.1389 15.3467V8.30776" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

				@endif
				<span style="margin-left: 0.25rem;"><?= __tr('Ad Campaign') ?></span>
			</a>
		</li>
		<li class="mt-2 nav-item pr-2">
			<a class="nav-link pl-3" href="#">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M21.419 15.732C21.419 19.31 19.31 21.419 15.732 21.419H7.95C4.363 21.419 2.25 19.31 2.25 15.732V7.932C2.25 4.359 3.564 2.25 7.143 2.25H9.143C9.861 2.251 10.537 2.588 10.967 3.163L11.88 4.377C12.312 4.951 12.988 5.289 13.706 5.29H16.536C20.123 5.29 21.447 7.116 21.447 10.767L21.419 15.732Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M7.48047 14.4629H16.2155" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span  style="margin-left: 0.25rem;"><?= __tr('History') ?></span>
			</a>
		</li>
	</ul>
	<!-- End of Sidebar of settings -->
</div>
			