@section('page-title', __tr('My Photos'))
@section('head-title', __tr('My Photos'))
@section('keywordName', __tr('My Photos'))
@section('keyword', __tr('My Photos'))
@section('description', __tr('My Photos'))
@section('keywordDescription', __tr('My Photos'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="h5 mb-0 text-gray-200">
        <span class="text-primary"><i class="far fa-images"></i></span> <?= __tr('My Photos') ?>
    </h4>
</div>

<div class="card mb-3">
    <div class="card-body">
        @if($photosCount <= 10) 
            <input type="file" class="lw-file-uploader" data-instant-upload="true" data-action="<?= route('user.upload_photos') ?>" data-default-image-url="" data-allowed-media='<?= getMediaRestriction('photos') ?>' multiple data-callback="afterFileUpload" data-remove-all-media="true">
        @endif

        <div class="row text-center text-lg-left lw-horizontal-container pl-2 lw-photoswipe-gallery" id="lwUserPhotos">
        </div>
    </div>
</div>

<div class="modal fade" id="lwPhotoEditDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color: #191919;padding: 20px; /*box-shadow: 0px 6px 58px rgba(121, 145, 173, 0.195504); */ border-radius: 24px; ">
			
			<div class="modal-header" style="border-bottom:none;display:none;">
				<h5 class="modal-title" style="color:#FFFFFF; font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 27px;line-height: 37px;color: #FFFFFF;">
					Edit photo posting
				</h5>
				<button type="button" style="color:#FFFFFF;margin-top: -20px; " class="close" data-dismiss="modal" aria-label="Close">
					<span style="padding: 5px 10px;background: #202020;border-radius: 14px;" aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body" style="color:#FFFFFF;">
                <form class="user lw-ajax-form lw-form" data-show-message="true" method="post" action="<?= route("user.upload_photos.write.edit") ?>" data-callback="onEditPhotoCallback">
                    <div class="d-flex">
                        <div class="p-1">
                            <div class="position-relative">
                                <img style="width:10rem;height:10rem;border:3px solid #FFFFFF!important;border-radius:10px;padding:0px;box-sizing: border-box;" class="lw-profile-thumbnail lw-photoswipe-gallery-img lw-lazy-img" id="lwPhotoStaticImage" src="">
                            </div>
                        </div>
                        <input type="hidden" name="post_photo_uid" id="post_photo_uid" value="">
                        <div class="p-1 ml-1" style="width:100%">
                            @if(0)
                                <div class="d-flex" style="position:relative;"> 
                                    
                                    <div class="" style="width:100%;">
                                        <div class="d-flex">
                                            <div class="" style="font-size:16px;line-height:24px;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
                                                Zyzz Bruh
                                            </div>
                                            <div class="" style="margin-left:3rem;color:#ff4141;font-size:16px;line-height:24px;font-family: Nunito Sans;font-style: normal;font-weight: bold;">
                                                Minato-Ku
                                            </div>
                                        </div>	
                                        <div class="d-flex">
                                            <div class="" style="font-family: Nunito Sans;font-style: normal;font-weight: normal;font-size: 14px;line-height: 19px;color: #91929E;">
                                                1 hour session
                                            </div>
                                            <div class="" style="margin-left:3rem;font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 16px;line-height: 24px;text-align: right;color: #AFAFAF;">
                                                ￥5,000
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="" style="right:0px;position:absolute;">
                                        <span class="pt_userrate_star" style="">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </span>
                                    </div>
                                </div>			
                            @endif
                            <div class="d-flex mt-2">
                                <div class="form-group" style="flex:1;">
                                    <label for="post_photo_comment">Comment</label>
                                    <textarea class="form-control form-control-user" name="comment" id="post_photo_comment" style="height:100%;" placeholder="Add a short message..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="padding: 5px 20px;height: 36px;background: #FF3F3F;border-radius: 5px;">Send</button>
                </form>
            </div>
		</div>
	</div>
</div>

<script type="text/_template" id="lwPhotosContainer">
    <% if(!_.isEmpty(__tData.userPhotos)) { %>
    <% _.forEach(__tData.userPhotos, function(item, index) { %>
       <div class="lw-photo-thumbnail position-relative ml-1">

        <div class="photo-tool-container" style="display: flex;position: absolute;right: -30px;top: -10px;flex-direction: column;">
            <!-- delete photo button -->
            <a class="col mt-1 btn btn-danger btn-sm lw-remove-photo-btn remove-photo-btn lw-ajax-link-action" href="<%- item.removePhotoUrl %>" data-callback="onDeletePhotoCallback" data-method="post"><i class="far fa-trash-alt"></i></a>
            <!-- /delete photo button -->

            <!-- like photo button -->
            <a class="col mt-1 btn btn-danger btn-sm lw-remove-photo-btn liked-photo-btn lw-ajax-link-action" title="Like/Unlike" href="<%- item.likePhotoUrl %>" data-callback="onLikedPhotoCallback" data-method="post">
                <% if( item.is_like) {%>
                 <i class="far fa-thumbs-down"></i>
                 <%} else {%>
                  <i class="far fa-thumbs-up"></i>   
                <%}%>    
            </a>
            <!-- /like photo button -->

            <!-- tag photo button -->
            <a class="col mt-1 btn btn-danger btn-sm lw-remove-photo-btn tagged-photo-btn lw-ajax-link-action" title="Tagging" href="<%- item.taggedPhotoUrl %>" data-callback="onTaggedPhotoCallback" data-method="post">
                
                <% if( item.is_tagged) {%>
                    <i class="fa fa-unlink"></i>
                 <%} else {%>
                    <i class="fa fa-link"></i>
                <%}%>   
            </a>
            <!-- /tag photo button -->
            <!-- edit photo button -->
            <a class="col mt-1 btn btn-danger btn-sm lw-remove-photo-btn edit-photo-btn" href="javascript:editPhotoModalShow( '<%- JSON.stringify(item) %>')">
                <i class="fa fa-edit"></i>
            </a>
            <!-- /edit photo button -->

        </div>

        <!-- user photos -->
        <img class="lw-user-photo lw-photoswipe-gallery-img lw-lazy-img mt-3" data-img-index="<%= index %>" src="<%= item.image_url %>" alt="">
        <!-- /user photos -->
       </div>
    <% }); %>
<% } else { %>
    <?= __tr('There are no photo found.') ?>
<% } %>
</script>

@push('appScripts')
<script>
    var userPhotos = <?= json_encode($userPhotos) ?>;

    function preparePhotosList() {
        var photoContainer = _.template($('#lwPhotosContainer').html()),
            compiledHtml = photoContainer({
                'userPhotos': userPhotos
            });
        $('#lwUserPhotos').html(compiledHtml);
    }
    preparePhotosList();

    // After successfully uploaded file
    function afterFileUpload(responseData) {
        if (!_.isUndefined(responseData.data.stored_photo)) {
            userPhotos.push(responseData.data.stored_photo);
            preparePhotosList();
        }
    }

    function onDeletePhotoCallback(responseData) {
        if (responseData.reaction == 1) {
            //remove value from array
            _.remove(userPhotos, function(photo) {
                return photo._uid === responseData.data.photoUid;
            });
            //reload list
            preparePhotosList();
        }
    }

    function onLikedPhotoCallback(responseData){
        if (responseData.reaction == 1) {
            _.forEach( userPhotos, function(item, index) {
                if(item._uid == responseData.data.photoUid){
                    item.is_like = responseData.data.is_like;
                }
            });
            preparePhotosList();
        }
    }
    function onTaggedPhotoCallback(responseData){
        if (responseData.reaction == 1) {
            _.forEach( userPhotos, function(item, index) {
                if(item._uid == responseData.data.photoUid){
                    item.is_tagged = responseData.data.is_tagged;
                }
            });
            preparePhotosList();
        }
    }
    function onEditPhotoCallback(responseData){
        if (responseData.reaction == 1) {
            _.forEach( userPhotos, function(item, index) {
                if(item._uid == responseData.data.photoUid){
                    item.comment = responseData.data.comment;
                }
            });
            preparePhotosList();
            $("#lwPhotoEditDialog").modal('hide');
        }
    }

    function editPhotoModalShow(item){
        console.log(item);
        let item_data = JSON.parse(item);
        $("#lwPhotoStaticImage").attr('src', item_data.image_url);
        $("#post_photo_uid").val(item_data._uid);
        $("#post_photo_comment").val(item_data.comment);
        $("#lwPhotoEditDialog").modal('show');
    }


</script>
@endpush