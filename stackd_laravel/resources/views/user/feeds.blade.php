@section('page-title', __tr('Feeds'))
@section('head-title', __tr('Feeds'))
@section('keywordName', __tr('Feeds'))
@section('keyword', __tr('Feeds'))
@section('description', __tr('Feeds'))
@section('keywordDescription', __tr('Feeds'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<div class="user-feed-container p-2" style="overflow-x: auto;overflow-y: auto;overflow-x: hidden;">
</div>

<div class="lw-load-more-container" id="lw-load-more-container" style="display:none;">
	<button type="button" class="btn btn-light btn-block lw-ajax-link-action lw-load-more-btn" id="lwLoadMoreButton" data-action="" data-callback="loadCallback"><?= __tr('Load More'); ?></button>
</div>

<div class="modal fade" id="lwFeedCommentDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color: #191919;padding: 20px;/*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504);*/border-radius: 24px; ">
			
			<div class="modal-header" style="border-bottom:none;display:none;">
				<h5 class="modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 27px;line-height: 37px;color: #FFFFFF;">
					Comment
				</h5>
				<button type="button" style="color:#FFFFFF;margin-top: -20px; " class="close" data-dismiss="modal" aria-label="Close">
					<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body" style="color:#FFFFFF;">
                <form class="user lw-ajax-form lw-form" data-show-message="true" method="post" action="<?= route("user.feed.write.comment") ?>" data-callback="onCommentFeedCallback">
                    <div class="d-flex">
                        <div class="p-1">
                            <div class="position-relative">
                                <img style="width:10rem;height:10rem;border:3px solid #FFFFFF!important;border-radius:10px;padding:0px;box-sizing: border-box;" class="lw-profile-thumbnail lw-photoswipe-gallery-img lw-lazy-img" id="lwPhotoStaticImage" src="">
                            </div>
                        </div>
                        <input type="hidden" name="post_photo_uid" id="post_photo_uid" value="">
                        <div class="p-1 ml-1" style="width:100%">
                            <div class="d-flex mt-2">
                                <div class="form-group" style="flex:1;">
                                    <label for="post_photo_comment">Your Comment for this photo</label>
                                    <textarea class="form-control form-control-user" name="comment" id="post_photo_comment" style="height:100%;" placeholder="Add a short message..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;">Post</button>
                </form>
            </div>
		</div>
	</div>
</div>

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
		$('.user-feed-container').append(appendData);
		$('#lwLoadMoreButton').data('action', requestData.nextPageUrl);
		if (!hasMorePages) {
			$('#lw-load-more-container').hide();
		} else {
			$('#lw-load-more-container').show();
		}
	}


	function loadFeedData() {
		if (hasMorePages) {
			var requestUrl = '<?= route('user.read.list_feed', ['username' => getUserAuthInfo('profile.username')]) ?>',
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

	loadFeedData();

	function onLikedFeedCallback(responseData){ 
        if (responseData.reaction == 1) {
			if(responseData.data.is_like){
				$("#like_icon_"+responseData.data.photoUid).addClass("fas");
				$("#like_icon_"+responseData.data.photoUid).removeClass("far");
			} else {
				$("#like_icon_"+responseData.data.photoUid).addClass("far");
				$("#like_icon_"+responseData.data.photoUid).removeClass("fas");
			}
        }
    }
	function onTaggedFeedCallback(responseData){ 
        if (responseData.reaction == 1) {
			$("#tagged_icon_"+responseData.data.photoUid).html('');
			if(responseData.data.is_tagged){
				$("#tagged_icon_"+responseData.data.photoUid).append(`
					<i class="ml-2 fa fa-thumbtack" style="font-size:32px;color:white;"></i>
				`);
			} else {
				$("#tagged_icon_"+responseData.data.photoUid).append(`
					<svg width="32" height="32" viewBox="0 0 24 39" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M17.9161 0.833984C20.1654 0.833984 21.9889 2.65746 21.9889 4.90684C21.9889 5.63185 21.7954 6.34373 21.4283 6.96895L19.6298 10.0323C18.5249 11.9141 18.5805 14.2592 19.7734 16.0866L22.5797 20.3856C24.001 22.563 23.3882 25.4803 21.2108 26.9017C20.4454 27.4013 19.5512 27.6673 18.6372 27.6673H13.9164V36.484C13.9164 37.5425 13.0583 38.4006 11.9997 38.4006C11.0168 38.4006 10.2067 37.6607 10.096 36.7075L10.0831 36.484V27.6673H5.39281C2.80007 27.6673 0.698242 25.5655 0.698242 22.9728C0.698242 22.0529 0.968504 21.1532 1.47546 20.3856L4.38884 15.9743C5.55616 14.2068 5.65718 11.9406 4.65177 10.0762L2.97609 6.96895C1.8855 4.94662 2.64083 2.42309 4.66316 1.3325C5.26992 1.00529 5.94848 0.833984 6.63785 0.833984H17.9161ZM11.9997 23.834H18.6372C18.807 23.834 18.9732 23.7846 19.1154 23.6917C19.4694 23.4606 19.6008 23.0167 19.4512 22.6384L19.3697 22.481L16.5634 18.182C14.6618 15.2688 14.4943 11.5661 16.0948 8.50475L16.3241 8.09141L18.1226 5.02811C18.1442 4.99134 18.1556 4.94947 18.1556 4.90684C18.1556 4.80101 18.0869 4.71121 17.9918 4.67953L17.9161 4.66732H6.63785C6.58368 4.66732 6.53035 4.68078 6.48267 4.70649C6.35553 4.77506 6.29211 4.91569 6.31571 5.05057L6.35009 5.14944L8.02577 8.25673C9.62528 11.2228 9.54457 14.799 7.84182 17.6801L7.58754 18.0868L4.67416 22.4981C4.58116 22.639 4.53158 22.804 4.53158 22.9728C4.53158 23.3955 4.83624 23.7472 5.238 23.8201L5.39281 23.834H11.9997Z" fill="white"/>
					</svg>
				`);
			}
        }
    }
	function commentFeedModalShow( item_data ) {
		 // JSON.parse(item);
		$("#lwPhotoStaticImage").attr('src', item_data.photoImageUrl);
        $("#post_photo_uid").val(item_data.photo_uid);
        //$("#post_photo_comment").val(item_data.feed_comment);
		//$("#post_photo_comment").val($("#comment_icon_"+item_data.photo_uid).attr("data-comment"));
		$("#post_photo_comment").val('');

        $("#lwFeedCommentDialog").modal('show');
	}
	function onCommentFeedCallback(responseData){ 
        if (responseData.reaction == 1) {
			$("#comment_icon_"+responseData.data.photoUid).addClass("fas");
			$("#comment_icon_"+responseData.data.photoUid).removeClass("far");
			$("#comment_icon_"+responseData.data.photoUid).attr("data-comment", responseData.data.comment);
			$("#lwFeedCommentDialog").modal('hide');
			$("#collapseAllComments_"+responseData.data.photoUid+">div.photo_comments_container").append(
				`<div class=""> 
				<div class="chat-user-item d-flex position-relative"> 
					<div class="chat-user-avatar">
						<img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+responseData.data.profilePictureUrl+`">
					</div>
					<div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
						<div class="row" style="flex-direction:column;padding-top: 0.5rem;">
							<span class="chat-time" style="">`+responseData.data.create_at+`</span>
							<span class="chat-content" style="word-break: break-all;">`+responseData.data.comment+`</span>
							
						</div>
					</div>
				</div> 
			</div>`
			);
			$(".no_comment").hide();
			$("#headingAllComments_"+responseData.data.photoUid).show();
        }
    }
	function toggleViewComments(target){ 
        $child=$(target).children('i');
        $child.toggleClass("fa-chevron-right").toggleClass("fa-chevron-down");
    }
</script>

@endpush