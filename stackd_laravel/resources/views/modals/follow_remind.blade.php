
<div class="modal fade" id="lwRemindFollowDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered" role="document">
		<div class="modal-content" style="background-color: #191919;padding: 20px;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/border-radius: 24px; ">
			
			<div class="modal-header" style="border-bottom:none;">
				<h5 class="modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;color: #FFFFFF;">
					
				</h5>
				<button type="button" style="color:#FFFFFF;margin-top: -20px;margin-right:-30px;z-index:10000; " class="close" data-dismiss="modal" aria-label="Close">
					<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body" style="color:#FFFFFF;margin-top:-40px;padding:0px;">
                <div class="d-flex" style="width:100%;">
					
					<div id="follow_remider_tabs" style="width:100%;">

						<!-- Tab Heading -->
						<div class="d-sm-flex align-items-center justify-content-between mb-1 position-relative">
							<nav class="nav">
								<a id="remider_tab_follower" data-toggle="tab" class="nav-link nav-link-follow active" aria-current="page" href="#follow_tab1"><?= __tr('Followers'); ?></a>
								<a id="remider_tab_following" data-toggle="tab" class="nav-link nav-link-follow" href="#follow_tab2"><?= __tr('Following'); ?></a>
							</nav>
						</div>

						<i class="fa fa-search" style="top: 65px;left: 20px;position: absolute; z-index: 100;"></i>

						<div class="tab-content" style="padding: 5px 20px;">
							
							<div id="follow_tab1" class="tab-pane active in position-relative">
								<div class="row" style="max-height: 500px; overflow-y: auto;padding-right:10px;" id="lwRemindFollowerContainer">
									
									<div class="form-group follow_content" style="flex:1;height:420px;">
										<select class="follower_user_tag selectize-item" style="padding-left:20px;width:100%;color:white;" id="follower_user_tag" ></select>
									</div>
								
									@if(0)
									<div class="position-relative" style="padding-left:10px;">
										<input type="text" style="" class="form-control form-control-user search-text filter_text" id="follow_filter_text" name="follow_filter_text" placeholder="Search">
										<i onclick="requestSearchText()" class="fa fa-search" style="top: 10px;right: 7px;position: absolute;"></i>
									</div>

									<div class="d-flex mt-2" style="width:100%;">
										<div class="">
											<div class="position-relative">
												<img style="width:85px;height:85px;border:3px solid #FFFFFF!important;border-radius:10px;padding:0px;box-sizing: border-box;" class=" lw-lazy-img" id="lwProfilePictureStaticImage" src="<?= getUserAuthInfo('profile.profile_picture_url') ?>">
												<label style="
													position: absolute;
													left: 0;
													top: 0;
													padding: 0rem 0.75rem;
													color: #ff4141;
													background: white;
													border-top-left-radius: 10px;
													border-bottom-right-radius: 10px;
													font-size: 0.75rem;
													font-family: Nunito Sans;
													font-style: normal;
													font-weight: bold;
													line-height: 24px;
													text-align: center;
												">PT</label>
											</div>
										</div>

										<div class="pl-2 d-flex align-items-center" style="width:100%">
											<div class="d-flex align-items-center justify-content-between" style="position:relative;width:100%"> 
												
												<div class="" style="width:100%;">
													<div class="d-flex">
														<div class="" style="font-size: 22px;line-height: 34px;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
															Zyzz Bruh
														</div>
													</div>	
													<div class="d-flex">
														<div class="" style="font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 18px;line-height: 19px;color: #91929E;">
															@shawnstoney
														</div>
													</div>
												</div>
												<div class="">
													<button type="button" role="button" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile" style="border:1px solid #FFFFFF;display:flex;align-items:center;padding: 1rem 1.5rem;height: 24px;background: #191919;border-radius: 7px;">Remove</button>
												</div>
											</div>														
										</div>
									</div>
									@endif

								</div>
							</div>
							<div id="follow_tab2" class="tab-pane fade">
								<div class="row" id="lwRemindFollowingContainer" style="max-height: 500px; overflow-y: auto;padding-right:10px;">

									<div class="form-group follow_content" style="flex:1;height:420px;">
										<select class="following_user_tag selectize-item" style="width:100%;color:white;" id="following_user_tag" ></select>
									</div>

								</div>
							</div>
						</div>
					</div>

                </div>
            </div>
		</div>
	</div>
</div>

