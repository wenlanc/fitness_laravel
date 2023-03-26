@if(!__isEmpty($feedData))
@foreach($feedData as $feed)
	<div class="p-2 mt-1">
		<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" style="position:relative;">
			<h5 style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 22px;line-height: 30px;/* identical to box height */color: #FF0000;"> 
				 
			</h5>
		</div>

		<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" style="position:relative;">
			<div class="col d-flex feed_container">
				<div >
					<img class="" style="border-radius: 10px;width: 70px;height: 70px;" src="<?= $feed["userImageUrl"]?>">
				</div>
				<div class="p-2">
					<div style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 25px;line-height: 34px;text-align: center;color: #FFFFFF;"><?= $feed["kanji_name"]?></div>
					<div style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 20px;line-height: 27px;color: #FFFFFF;">@<?= $feed["username"]?></div>
				</div>
				<div class="p-2" style="margin-left: auto;">
					<div><span class="d-none match_following_badge_tag">Following</span></div>
					<div><span style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 15px;line-height: 20px;text-align: right;color: rgba(255, 255, 255, 0.7);"><?= $feed["photoUpdatedAt"]?></span></div>
				</div>
			</div>
		</div>

		<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" style="position:relative;">
			<div class="col d-flex" style="max-width:600px; margin:auto;">
				<img class="" style="border-radius: 30px;width: 100%;height: 100%;" src="<?= $feed["photoImageUrl"]?>">
			</div>
		</div>
		<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" >
			<div class="col d-flex mt-2 p-1">
				<a class="lw-ajax-link-action" data-show-message="true" data-callback="onLikedFeedCallback" data-method="post" href="<?= route('user.feed.write.like', ['photoUid' => $feed["photo_uid"]]) ?>"><i id="like_icon_<?= $feed["photo_uid"] ?>" class="ml-2 <?= ( isset($feed["is_like"]) and $feed["is_like"])?"fas":"far" ?> fa-heart" style="font-size:32px;color:white;"></i></a> 
				<a href='javascript:commentFeedModalShow( <?= json_encode($feed, JSON_HEX_APOS ) ?>)' class="ml-2">
					<i id="comment_icon_<?= $feed["photo_uid"] ?>" data-comment="" class="d-none ml-2 <?= ( isset($feed["feed_comment"]) and !is_null($feed["feed_comment"]))?"fas":"far" ?> fa-comment" style="font-size:32px;color:white;"></i>

					<svg width="32" height="32" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M19.0413 0.750056H19.9997L20.6171 0.788369C29.6238 1.53759 36.7461 8.8205 37.2499 18.0003L37.2499 18.9539C37.257 21.7855 36.5954 24.5788 35.3225 27.0988C32.2398 33.2668 25.9375 37.1643 19.0463 37.167C16.6867 37.1731 14.3536 36.7147 12.1787 35.823L11.6622 35.5992L8.6443 36.6987C5.76685 37.7463 2.59583 36.3534 1.39887 33.5769L1.27411 33.2628C0.805573 31.9759 0.811753 30.564 1.29154 29.2813L2.39509 26.3263L2.17704 25.8213C1.37444 23.864 0.922875 21.779 0.845069 19.6639L0.833008 18.9579C0.835676 12.0625 4.73317 5.76017 10.8939 2.68117C13.4212 1.40461 16.2145 0.742975 19.0413 0.750056ZM19.9166 4.58177L19.0365 4.58341C16.8084 4.57783 14.6107 5.09842 12.6149 6.10648C7.74542 8.54015 4.66845 13.5157 4.66633 18.9637C4.66053 21.1915 5.18104 23.3893 6.18549 25.3779C6.42674 25.8555 6.45734 26.4123 6.26988 26.9135L4.88194 30.6242C4.72202 31.0518 4.71996 31.5225 4.87613 31.9514C5.23828 32.9461 6.33819 33.4589 7.33286 33.0967L11.1023 31.7243C11.5996 31.5433 12.1497 31.5759 12.6221 31.8145C14.6107 32.819 16.8085 33.3395 19.0406 33.3337C24.4843 33.3316 29.4599 30.2546 31.8972 25.3779C32.9016 23.3894 33.4222 21.1916 33.4166 18.9587L33.4195 18.106C33.0172 10.817 27.2026 4.99532 19.9166 4.58177ZM19.9166 4.58177L19.9192 4.58176L19.894 4.5805L19.9166 4.58177ZM10.4163 15.1671C10.4163 14.6148 10.8641 14.1671 11.4163 14.1671H26.6663C27.2186 14.1671 27.6663 14.6148 27.6663 15.1671V17.0004C27.6663 17.5527 27.2186 18.0004 26.6663 18.0004H11.4163C10.8641 18.0004 10.4163 17.5527 10.4163 17.0004V15.1671ZM15.2497 21.8338C14.6974 21.8338 14.2497 22.2815 14.2497 22.8338V24.6671C14.2497 25.2194 14.6974 25.6671 15.2497 25.6671H22.833C23.3853 25.6671 23.833 25.2194 23.833 24.6671V22.8338C23.833 22.2815 23.3853 21.8338 22.833 21.8338H15.2497Z" fill="white"/>
					</svg>
				</a> 
				
				@if($feed["user_id"] != getUserId())
				<a class="ml-2" href="<?= route('user.read.messenger')."?selected=".$feed["user_id"] ?>" target="_new">
					<svg width="34" height="31" viewBox="0 0 34 31" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M32.0128 24.1413C33.8625 20.7717 33.8861 16.7296 32.076 13.3396C30.2658 9.94972 26.8552 7.64897 22.9619 7.19143C21.246 3.27883 17.465 0.5995 13.1165 0.214582C8.76799 -0.170337 4.55349 1.80125 2.14213 5.34851C-0.269224 8.89576 -0.48842 13.4464 1.57136 17.1982L0.653336 20.3298C0.445889 21.0369 0.648183 21.7981 1.1818 22.3182C1.71541 22.8383 2.49645 23.0355 3.22214 22.8335L6.43616 21.9387C7.73675 22.6171 9.15588 23.0529 10.6206 23.2237C11.9298 26.2082 14.4646 28.5201 17.607 29.5959C20.7495 30.6717 24.2111 30.4126 27.1481 28.8818L30.362 29.7767C31.0876 29.9787 31.8686 29.7814 32.4023 29.2614C32.9359 28.7413 33.1383 27.9803 32.9309 27.2731L32.0128 24.1413ZM29.7139 23.4024C29.5467 23.6764 29.5029 24.0054 29.5927 24.3119L30.5006 27.4083L27.3231 26.5236C27.0086 26.4361 26.6711 26.4789 26.39 26.6417C24.1946 27.9096 21.5682 28.2639 19.1018 27.625C16.6355 26.986 14.5364 25.4074 13.277 23.2445C16.5654 22.9129 19.5625 21.2589 21.5457 18.6814C23.5289 16.104 24.3183 12.8369 23.7234 9.66793C26.6659 10.3453 29.1021 12.3466 30.2848 15.0582C31.4675 17.7697 31.2555 20.8679 29.7139 23.4024Z" fill="white"/>
					</svg>
				</a>
				@endif

				<a class="lw-ajax-link-action" id="tagged_icon_<?= $feed["photo_uid"] ?>" style="margin-left:auto;" data-show-message="true" data-callback="onTaggedFeedCallback" data-method="post" href="<?= route('user.feed.write.tagged', ['photoUid' => $feed["photo_uid"]]) ?>">
					@if( isset($feed["is_tagged"]) and $feed["is_tagged"])
					    <i class="ml-2 fa fa-thumbtack" style="font-size:32px;color:white;"></i>
					@else
						<svg width="32" height="32" viewBox="0 0 24 39" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M17.9161 0.833984C20.1654 0.833984 21.9889 2.65746 21.9889 4.90684C21.9889 5.63185 21.7954 6.34373 21.4283 6.96895L19.6298 10.0323C18.5249 11.9141 18.5805 14.2592 19.7734 16.0866L22.5797 20.3856C24.001 22.563 23.3882 25.4803 21.2108 26.9017C20.4454 27.4013 19.5512 27.6673 18.6372 27.6673H13.9164V36.484C13.9164 37.5425 13.0583 38.4006 11.9997 38.4006C11.0168 38.4006 10.2067 37.6607 10.096 36.7075L10.0831 36.484V27.6673H5.39281C2.80007 27.6673 0.698242 25.5655 0.698242 22.9728C0.698242 22.0529 0.968504 21.1532 1.47546 20.3856L4.38884 15.9743C5.55616 14.2068 5.65718 11.9406 4.65177 10.0762L2.97609 6.96895C1.8855 4.94662 2.64083 2.42309 4.66316 1.3325C5.26992 1.00529 5.94848 0.833984 6.63785 0.833984H17.9161ZM11.9997 23.834H18.6372C18.807 23.834 18.9732 23.7846 19.1154 23.6917C19.4694 23.4606 19.6008 23.0167 19.4512 22.6384L19.3697 22.481L16.5634 18.182C14.6618 15.2688 14.4943 11.5661 16.0948 8.50475L16.3241 8.09141L18.1226 5.02811C18.1442 4.99134 18.1556 4.94947 18.1556 4.90684C18.1556 4.80101 18.0869 4.71121 17.9918 4.67953L17.9161 4.66732H6.63785C6.58368 4.66732 6.53035 4.68078 6.48267 4.70649C6.35553 4.77506 6.29211 4.91569 6.31571 5.05057L6.35009 5.14944L8.02577 8.25673C9.62528 11.2228 9.54457 14.799 7.84182 17.6801L7.58754 18.0868L4.67416 22.4981C4.58116 22.639 4.53158 22.804 4.53158 22.9728C4.53158 23.3955 4.83624 23.7472 5.238 23.8201L5.39281 23.834H11.9997Z" fill="white"/>
						</svg>
					@endif
				</a> 
			</div>

			<div class="col d-flex mt-2 p-1">
				<span style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 20px;line-height: 27px;color: #FFFFFF;">@<?= $feed["username"] ?></span>
				<span class="ml-3" style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 20px;line-height: 27px;color: #FFFFFF;"><?= $feed["user_comment"]?></span>
				<!-- <div class="d-flex mb-2 pt_availablity_logo_div" style="justify-content: start;padding-left:15px;margin-left:auto;height:30px;padding:15px;"> 
					<div class="" style="margin:3px;">
						<img class="" style="width: 55px;height: 22px;" src="/media-storage/pt/anytime_logo.png">       
					</div>
				</div> -->
			</div>
			<div class="col d-flex p-1">
				@if(0)
				<span style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 17px;line-height: 23px;color: #FFFFFF;">View all comments</span>
				@endif

				<div class="" id="accordion_<?= $feed["photo_uid"] ?>" style="width:100%;">
					<div class="" id="headingAllComments_<?= $feed["photo_uid"] ?>" style="border:none;<?= __isEmpty($feed["feedCommentData"])?'display:none;':'' ?>">
						<h6 class="mb-0">
							<a class="btn comment_view_btn" style="padding:0;" data-toggle="collapse" onclick="toggleViewComments(this)" href="#collapseAllComments_<?= $feed["photo_uid"] ?>" aria-expanded="false" aria-controls="collapseAllComments_<?= $feed["photo_uid"] ?>" data-toggle="collapse" data-target="#collapseAllComments_<?= $feed["photo_uid"] ?>" aria-expanded="false" aria-controls="collapseAllComments_<?= $feed["photo_uid"] ?>">
								<span style="font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 17px;line-height: 23px;color: #FFFFFF;margin-right:1rem;">View all comments</span>
								<i class="fas fa-chevron-right"></i>
							</a>
						</h6>
					</div>
					<div id="collapseAllComments_<?= $feed["photo_uid"] ?>" class="collapse" aria-labelledby="headingAllComments_<?= $feed["photo_uid"] ?>" data-parent="#accordion_<?= $feed["photo_uid"] ?>">
						<div class="photo_comments_container">

							@if(!__isEmpty($feed["feedCommentData"]))
							@foreach($feed["feedCommentData"] as $itemfeed)

								<div class=""> 
									<div class="chat-user-item d-flex position-relative"> 
										<div class="chat-user-avatar">
											<img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="<?= $itemfeed["feeduserImageUrl"]?>">
										</div>
										<div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
											<div class="row" style="flex-direction:column;padding-top: 0.5rem;">
												<span class="chat-time" style=""><?= $itemfeed["comment_date"]?></span>
												<span class="chat-content" style="word-break: break-all;"><?= $itemfeed["comment"]?></span>
												
											</div>
										</div>
									</div> 
								</div>
							@endforeach
							@else 
								<span class="no_comment">No comment</span>
							@endif
						</div>
					</div>
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

