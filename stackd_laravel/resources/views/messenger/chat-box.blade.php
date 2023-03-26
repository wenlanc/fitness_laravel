@section('page-title', __tr('Find Matches'))
@section('head-title', __tr('Find Matches'))
@section('keywordName', __tr('Find Matches'))
@section('keyword', __tr('Find Matches'))
@section('description', __tr('Find Matches'))
@section('keywordDescription', __tr('Find Matches'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())
<div class="chat-messenger row p-1" style="min-height: 700px;">
    <div class="col-md-4 position-relative">

        <div class="chat-header row"> 
            <div> Chats </div> 
            <div class="d-flex" style="margin-left: auto;">
                <span class="chat-toolbar-icon ml-2 chat-search-user-btn" id="chat-search-user-btn"> <i class="fa fa-search"></i></span>
                <span class=" chat-toolbar-icon ml-2 primary-color-btn chat-add-newuser" id="chat-add-newuser"> <i class="fa fa-plus"></i></span>
            </div>
        </div>

        <div id="chat-main-user-list" class="chat-users-list row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" style="align-content:flex-start;"> 
            
            <div class="dropdown-user-list d-none col mt-2 chat-new-container" id="chat-new-container" style="height:fit-content;"> 
                <div class="p-2 mt-2 chat-user-item-container chat-user-item-active" style="width:100%;"> 
                    <div class="chat-user-item d-flex position-relative"> 
                        <div class="chat-user-avatar">
                            <span style="border-radius: 50%;width: 44px;height: 44px;background: #C4C4C4;border: 2px solid #FFFFFF;display: flex;justify-content: center;"><i class="fa fa-user" style="font-size:15px;color:white;align-self: center;"></i></span>
                        </div>
                        <div class="chat-item-username col d-flex" style="padding-left: 1.25rem; align-items: center; "> 
                            <div class="row" style="font-size: 16px;line-height: 24px;">
                                <span>New Message</span>
                            </div>
                            <span class="chat-close-new" style="margin-left:auto;background-color: transparent;padding: 5px 10px;border-radius: 10px;" aria-hidden="true">×</span>
                        </div>
                    </div> 
                </div> 
            </div> 

            <div class="dropdown-user-list col mt-2" style="height:100%;"> 
                <div id="accordion_pt">
                    <h6 class="mb-0 d-none chat-users-type-dropdownmenu">
                        <button class="btn" data-toggle="collapse" data-target="#messengerPtUserListContainer" aria-expanded="true" aria-controls="messengerPtUserListContainer">
                        <i class="fas fa-chevron-right"></i>
                        </button>
                        PTs
                    </h6>
                </div>
                <div style="">
                    <div id="messengerPtUserListContainer" style="height:100%;max-height:550px; overflow-y: auto; padding-right:10px;" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion_pt">
                    </div>
                </div>
            </div> 
            <div class="dropdown-user-list col mt-2 d-none"> 
                <div id="accordion_direct">
                    <h6 class="mb-0 chat-users-type-dropdownmenu">
                        <button class="btn" data-toggle="collapse" data-target="#collapseOneDirect" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fas fa-chevron-right"></i>
                        </button>
                        Direct Messages
                    </h6>
                </div>
                <div>
                    <div id="collapseOneDirect" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion_direct">
                        
                    <!--  Chat User Item --> 
                        <div class="p-2 mt-2" style="display:none;"> 
                            <div class="chat-user-item d-flex position-relative"> 
                                <div class="chat-user-avatar">
                                    <img class="" src="/dist/blackfit/images/rectangle-117@2x.png">
                                    <div class="chat-user-online-status-dot">
                                        <!-- <span class="lw-dot lw-dot-danger" title="Offline"></span> -->
                                    </div>
                                </div>
                                <div class="chat-item-username" style="padding-left: 1.25rem;"> 
                                    <span class="row" style="font-size: 16px;line-height: 24px;">Oscar Holloway</span>
                                    <span class="row" style="font-size: 14px;line-height: 19px;color: #91929E;">Minato-ku</span>
                                </div>
                            </div> 
                        </div>
                    </div>

                </div>
            </div> 
        </div>

        <div id="chat-filter-user-list" class="d-none chat-users-list row row-cols-sm-1 row-cols-md-1 row-cols-lg-1"> 

            <div class="chat-user-item d-flex p-3 position-relative chat-search-user-header" style="align-items: center;"> 
                <div class="chat-item-username"> 
                    <span class="row chat-search-back-btn" style="font-size: 22px;line-height: 24px;" id="chat-search-back-btn"><i class="fa fa-arrow-left"></i></span>
                </div>
                <div class="ml-2 pl-2 chat-searchuser-input-container" style="width:100%;" id="chat-searchuser-input-container">
                    <div class="form-control-user pt-1 pl-2 pr-4 position-relative" style="width:100%;">
                        <select class="chat-searchuser-input selectize-item" style="width:100%;color:white;" id="chat-searchuser-input" >
                        </select>
                        <i class="fa fa-search my-auto input-icon " style="right: 5px;font-size:16px; top:15px;"></i>
                    </div>
                </div>
            </div> 

            <div class="dropdown-user-list col mt-2"> 
            </div> 
        </div>

    </div>
    <div class="col-md-8" style="border-left:1px solid #393939;">
        <div class="row chat-header"> 
        
            <div class="chat-user-item d-none position-relative chat-title-header" > 
                <div class="chat-user-avatar">
                    <img class="lw-user-thumbnail lw-lazy-img" id="chat-user-header-img" data-src="<?= imageOrNoImageAvailable()?>">
                    <div class="chat-user-online-status-dot" style="top:25px;">
						<!-- <span class="lw-dot lw-dot-danger" title="Offline"></span> -->
					</div>
                </div>
                <div class="chat-item-username" style="padding-left: 1.25rem;"> 
                    <span class="row" id="chat-user-header-username" style="font-size: 16px;line-height: 24px;"></span>
                    <span class="row" id="chat-user-header-aboutme" style="font-size: 14px;line-height: 19px;color: #91929E;"></span>
                </div>
            </div> 

            <div class="chat-user-item position-relative chat-newuser-header" style="display:none;align-items: center;"> 
                <div class="chat-item-username" style="padding-left: 1.25rem;"> 
                    <span class="row" style="font-size: 22px;line-height: 24px;">To:</span>
                </div>
                <div class="ml-4 pl-2 chat-newuser-input-container" style="width:100%; min-width: 350px;" id="chat-newuser-input-container">
                    <select class="chat-newuser-input selectize-item" style="width:100%;color:white;" id="chat-newuser-input" >
                    </select>
                </div>
            </div> 

            <div class="chat-header-toolbar d-none" style="margin-left:auto;"> 

                <a class="chat-toolbar-icon ml-2 primary-color-btn chat-block-btn lw-ajax-link-action" id="chatBlockBtn" ><?= __tr('Block') ?></a>

                <span class="d-none chat-toolbar-icon ml-2"> <i class="fa fa-search"></i></span>
                <span class="d-none chat-toolbar-icon ml-2"> <i class="far fa-hourglass"></i></span>
                <!-- Dropdown menu sample on right top -->
                <div class="ml-2" style="">
                    <div class="dropdown">
                        <button class="chat-toolbar-icon btn btn-black dropdown-toggle lw-datatable-action-dropdown-toggle" style="padding: 5px 15px;" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu profile_dropdown_menu dropdown-menu-right" style="background:#1e1e1e;padding:0.25rem;" aria-labelledby="dropdownMenu2">
                            <!-- delete all chat button -->
                            <a class="d-none dropdown-item lw-disable-link" id="chatDeleteAllChatDisableButton" readonly><i class="fas fa-trash"></i> <?= __tr('Delete All Chat'); ?></a>
                            <a class="dropdown-item lw-ajax-link-action" id="chatDeleteAllChatActiveButton" type="button"  data-method="post" data-callback="chatGetContentResponse" style="color:white;"><i class="fas fa-trash"></i> <?= __tr('Delete All Chat'); ?></a>
                            <!-- /delete all chat button -->
                        </div>
                    </div>
                </div>
                <!-- / Dropdown menu sample on right top -->
            </div>
        </div>

        <div class="chat-users-list"> 
            <div class="chat-message-list" id="chat-message-list" style="min-height:550px;max-height:550px;overflow-y:auto;"> 
                <div class="p-2 mt-2 " > 
                    <div class="chat-user-item d-flex position-relative"> 
                        <div class="row chat-datetime-container" >
                            <span class="chat-datetime"><?=formatDate(time()) ?></span>
                        </div>
                    </div> 
                </div> 
            </div> 

            <div class="row m-2 p-3 chat-send-textbox-container" style="min-height: 64px;margin-right: -0.5rem!important;"> 
                <form id="chatMessageSendForm" class="lw-ajax-form lw-form d-flex position-relative col" method="post" data-show-message="true" data-user-id="0" data-callback="chatSendMessageResponse">
                    <div class="" style="position:absolute;left:0px;">
                        <span class="ml-1 d-none"> <i class="fa fa-link" style="color:#6D5DD3;"></i></span>
                        <span class="ml-1 d-none"> <i class="fa fa-paperclip" style="color:#15C0E6;"></i></span>
                        <span class="ml-1 d-none"> <i class="fa fa-at" style="color:#3F8CFF;"></i></span>
                    </div>
                    <div class="chat-message-input-container" style="padding-left:0.5rem;padding-top:0.25rem;">
                        <input class="ml-2 chat-message-input" name="message" id="chat-message-input"  placeholder="Type your message here…" > 
                        <!-- Message Type for Example: Text / Gif / Sticker / Uploaded Image etc. -->
                        <input type="hidden" name="type" value="1">
                        <!-- /Message Type for Example: Text / Gif / Sticker / Uploaded Image etc. -->
                    </div>
                    <div  class="d-flex" style="position:absolute;right:-10px;">
                        <span class="ml-1 d-none"> <i class="fa fa-smile" style="color:#FDC748;"></i></span>

                        <button class="input-group-text" id="chatUploadingLoader" style="display: none;">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only"><?= __tr('Loading...') ?></span>
                            </div>
                        </button>
                        <!-- Upload Media Button -->
                        <button class="btn lw-messenger-file-upload" type="button" id="chatMessengerFileUpload"></button>
                        <!-- Upload Media Button -->

                        <a  id="chatSendMessageButton" class="chat-toolbar-icon ml-2 primary-color-btn" style="margin-top: -5px;" type="button"> <i class="fa fa-send" style="color:white;"></i></a>
                    </div>
                </form>

                <div class="row m-1 chat-send-accept-decline-container d-none"> 
                    <!--  Accept Message Request Button -->
                    <a href="<?= route('user.write.accept_decline_message_request', ['userId' => 0]) ?>" class="ml-2 btn btn-success btn-sm lw-ajax-link-action" id="chatAcceptChatRequestBtn" data-post-data='<?= json_encode(['message_request_status' => 1]) ?>' data-method="post" data-callback="__ChatMessenger.acceptMessageRequest"><?= __tr('Accept') ?></a>
                    <!--  /Accept Message Request Button -->

                    <!--  Decline Message Request Button -->
                    <a href="<?= route('user.write.accept_decline_message_request', ['userId' => 0]) ?>" class="ml-2 btn btn-danger btn-sm lw-ajax-link-action" id="chatDeclineChatRequestBtn" data-post-data='<?= json_encode(['message_request_status' => 2]) ?>' data-method="post" data-callback="__ChatMessenger.declineMessageRequest"><?= __tr('Decline') ?></a>
                    <!--  Decline Message Request Button -->

                    <div class="text-white ml-2 d-none" id="chatDeclineMessage" style="align-items: center;">
                        <?= __tr('Message Request Declined') ?>
                    </div>
                </div>   
            </div> 

            <div id="lwBuyStickerText" data-message="<?= __('Are you sure to purchase this sticker') ?>"></div>
            <!-- Bottom sheet for Sticker / Gif Image -->
            <div class="lw-messenger-bottom-sheet">
                <div class="lw-heading"></div>
                <div class="lw-content">
                    <div id="lwStickerImagesContainer"></div>
                    <div id="lwGifImagesContainer"></div>
                    <!-- <div class="lw-overlay offset-md-4"></div> -->
                </div>
            </div>
            <!-- /Bottom sheet for Sticker / Gif Image -->
            <!-- Modal -->
            <div class="modal fade" id="lwUserNotAcceptedMsgRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close lw-not-accepted-dialog-close-btn" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-4 bg-white text-center">
                            <h5><?= __tr('User needs to accept chat request') ?></h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary lw-not-accepted-dialog-close-btn"><?= __tr('Close') ?></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>    
</div>

<div style="background: #1E1E1E;height:100px;margin-left:-2rem; margin-right:-2rem;">
    <div style="height: 2rem;
                background: #191919;
                border-radius: 0 0 2rem 2rem;
                margin-left: 0.5rem;
                margin-right: 0.5rem;
                display: flex;
            ">

    </div>
</div>

<!-- User block Confirmation text html -->
<div id="lwBlockUserConfirmationText" style="display: none;">
	<h3><?= __tr('Are You Sure!'); ?></h3>
	<strong><?= __tr('You want to unblock this user.'); ?></strong>
</div>
<!-- /User block Confirmation text html -->

@push('appScripts')

<script>

    
    // Create a object for messenger
    var __ChatMessenger = {
        sendMessageUrl: null,
        // Load Uploader instance
        loadUploaderInstance: function () {  
            var pond = null,
                uniqueId = Math.random().toString(36).substr(2, 9);
            if (_.isEmpty(pond)) {
                pond = FilePond.create({
                    name: 'filepond',
                    labelIdle: "<i class='fas fa-paperclip'></i>",
                    allowDrop: false,
                    allowImagePreview: false,
                    allowRevert: false,
                    server: {
                        process: {
                            url: __ChatMessenger.sendMessageUrl,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': appConfig.csrf_token
                            },
                            withCredentials: false,
                            onload: function (response) {
                                var responseData = JSON.parse(response);
                                var requestData = responseData.data;
                                var storedData = requestData.storedData;

                                if (responseData.reaction == 1) {
                                    __ChatMessenger.replaceMessage(storedData.type, storedData.message, storedData.unique_id, storedData.created_on);
                                } else {
                                    __ChatMessenger.removeMessage(storedData.type, storedData.unique_id);
                                    showErrorMessage(requestData.message);
                                }
                            },
                            ondata: function (formData) {
                                formData.append('type', 2);
                                formData.append('unique_id', uniqueId);
                                return formData;
                            }
                        }
                    },
                    onaddfilestart: function () {
                        __ChatMessenger.appendMessage(2, '', uniqueId);
                        $('#chatMessengerFileUpload').hide();
                        //$('#chatUploadingLoader').show();
                    },
                    onprocessfile: function (error, file) {
                        pond.removeFile(file.id);
                        $('#chatMessengerFileUpload').show();
                       // $('#chatUploadingLoader').hide();
                    }
                });
                $("#chatMessengerFileUpload").html('');
                pond.appendTo(document.getElementById("chatMessengerFileUpload"));
            }
        },

        $emojiElement: null,
        // Load emoji text box container
        loadEmojiContent: function () {
            __ChatMessenger.$emojiElement = $("#chat-message-input").emojioneArea({
                //placeholder: __Utils.getTranslation('chat_placeholder', "Type message..."),
                hidePickerOnBlur: true,
                //emojiPlaceholder: ":smile_cat:",
                //tones: true,
                //tonesStyle: 'bullet',
                shortnames: true,
                //saveEmojisAs: 'unicode',   // 'unicode' | 'shortname' | 'image'
                events: {
                    keyup: function (editor, event) {
                        if (event.which == 13) { // On Enter
                            __ChatMessenger.sendMessage(1, {
                                message: this.getText(),
                                type: 1,
                            });
                            this.hidePicker();
                        }
                    }
                }
            });
        },

        // Open sticker bottom-sheet
        openStickerBottomSheet: function () {
            $(".lw-messenger").on("click", ".lw-open-stickers-action, .lw-open .lw-overlay", function () {
                $('.lw-messenger-bottom-sheet').toggleClass("lw-open");
                __ChatMessenger.getStickers();
            });
        },

        // Show bottom-sheet fro stickers
        getStickers: function () {
            var $lwBottomSheetHeadingContainer = $('.lw-heading'),
                $lwStickerImagesContainer = $("#lwStickerImagesContainer");

            $lwBottomSheetHeadingContainer.html("");
            $lwStickerImagesContainer.html("");
            $('#lwGifImagesContainer').html("");

            // Set Heading of bottom sheet
            $lwBottomSheetHeadingContainer.append('<h5><i class="fas fa-sticky-note text-success"></i> ' + __Utils.getTranslation('sticker_name_label', 'Stickers') + '</h5>');
        },

        // Fetch Stickers from server
        fetchStickers: function (responseData) {
            // Get sticker response data from server
            var stickers = responseData.data.stickers;
            // check if stickers exists
            if (!_.isEmpty(stickers)) {
                _.forEach(stickers, function (sticker) {
                    // Create Image tag
                    stickerImageTag = "<span class='lw-buy-sticker-container'><img height='100px' width='110px' src='" + sticker.image_url + "' id='" + sticker.id + "' class='lw-sticker-image' data-is-free='" + sticker.is_free + "' data-is-purchased='" + sticker.is_purchased + "'>";

                    // check if sticker is free
                    if (sticker.is_free) {
                        stickerImageTag += "<span class='text-center'>Free</span>";
                    } else if (!sticker.is_purchased) {
                        stickerImageTag += "<div id='lwBuyNowStickerBtn-" + sticker.id + "' class='text-center'><span>" + sticker.formatted_price + "</span><br><button type='button' class='btn btn-secondary btn-sm' onclick='__ChatMessenger.buySticker(" + sticker.id + ")'>Buy Now</button></span></div>";
                    } else if (sticker.is_purchased) {
                        stickerImageTag += "<span class='text-center'>Purchased</span>";
                    }

                    $('#lwStickerImagesContainer').append(stickerImageTag);
                });
            } else {
                $('#lwStickerImagesContainer').append("<?= __tr('No result found.') ?>");
            }
            // Send selected sticker
            $('.lw-sticker-image').on('click', function () {
                if ($(this).data('is-free') || $(this).data('is-purchased')) {
                    __ChatMessenger.sendMessage(12, {
                        message: this.currentSrc,
                        type: 12,
                        item_id: this.id
                    });
                    $('.lw-messenger-bottom-sheet').toggleClass("lw-open");
                } else {
                    __ChatMessenger.buySticker(this.id);
                }
            });
        },

        // Buy sticker
        buySticker: function (stickerId) {
            showConfirmation($('#lwBuyStickerText').data('message'), function () {
                __DataRequest.post(__ChatMessenger.buyStickerUrl, {
                    sticker_id: stickerId
                }, function (responseData) {
                    if (responseData.reaction == 1) {
                        $("#lwTotalCreditWalletAmt").html(responseData.data.availableCredits)
                        $('#lwBuyNowStickerBtn-' + stickerId).replaceWith("<span class='text-center'>Purchased</span>");
                    }
                });
            }, {
                id: 'lwBuyStickerAlert'
            });
        },

        // Open gif bottom-sheet
        openGifBottomSheet: function () {
            $(".lw-messenger").on("click", ".lw-open-gif-action, .lw-open .lw-overlay", function () {
                $('.lw-messenger-bottom-sheet').toggleClass("lw-open");
                __ChatMessenger.getGifImagesContent();
            });
        },

        // Get gif images
        getGifImagesContent: function () {
            var $lwBottomSheetHeadingContainer = $('.lw-heading');
            $lwBottomSheetHeadingContainer.html("");
            // Set Heading of bottom sheet
            $lwBottomSheetHeadingContainer.append('<h5><i class="fa fa-images text-success"></i> Send Gif</h5><div class="input-group lw-gif-search-input"><input type="text" class="form-control" name="search" id="lwSearchInput" value="" placeholder="Search GIF"><div class="input-group-append"><button type="button" class="btn btn-secondary" onclick="__ChatMessenger.searchGifImages()"><i class="fas fa-search"></i></button></div></div>');
            __ChatMessenger.fetchGifImages();
        },

        // Search for images
        searchGifImages: function () {
            var searchValue = $('#lwSearchInput').val();
            __ChatMessenger.fetchGifImages({ searchValue: searchValue });
        },

        // Fetch Gif Images
        fetchGifImages: function (queryOptions) {
            $("#lwStickerImagesContainer").html("");
            $lwGifImagesContainer = $('#lwGifImagesContainer');
            $lwGifImagesContainer.html('<div class="lw-messenger-image-loading"></div>');
            var queryURL = '';
            params = {
                limit: 50,
                api_key: __ChatMessenger.giphyKey,
                fmt: "json"
            };

            // check if query options exists
            if (!_.isUndefined(queryOptions)) {
                queryURL = "https://api.giphy.com/v1/gifs/search?";
                params.q = queryOptions.searchValue;
            } else {
                queryURL = "https://api.giphy.com/v1/gifs/trending?";
            }
            // Get data from gify server
            __DataRequest.get(queryURL + $.param(params), {}, function (response) {
                var gifImages = response.data;
                $lwGifImagesContainer.html('');
                if (!_.isEmpty(gifImages)) {
                    _.forEach(gifImages, function (gif) {
                        imageTag = $("<img>");
                        imageTag.attr({
                            height: "100px",
                            width: "100px",
                            src: gif.images.preview_gif.url,
                            class: 'lw-gif-image lw-lazy-img'
                        });
                        $lwGifImagesContainer.append(imageTag);
                    });
                } else {
                    $lwGifImagesContainer.append(__Utils.getTranslation('gif_no_result', 'Result Not Found'));
                }
                // after click on gif image perform some action
                $('.lw-gif-image').on('click', function () {
                    var gifImage = $("<img>");
                    gifImage.attr({
                        height: "100px",
                        width: "100px",
                        src: this.currentSrc
                    });

                    __ChatMessenger.sendMessage(12, {
                        message: this.currentSrc,
                        type: 8
                    });
                    $('.lw-messenger-bottom-sheet').toggleClass("lw-open");
                });
            }, { csrf: false });
        },

        // Accept message request
        acceptMessageRequest: function () {
            showFlex($('#chatSendMessageForm'));
            hideFlex($(".chat-send-accept-decline-container"));
            __ChatMessenger.hideShowDropdownButtons(true);
        },

        // Decline Message Request
        declineMessageRequest: function () {
            $('#chatDeclineChatRequestBtn').addClass("disabled");
            $('#chatBlockBtn').addClass("disabled");
            showFlex($("#chatDeclineMessage"));
            __ChatMessenger.hideShowDropdownButtons(false);
        },

        // Prepare send button instance
        createSendButtonInstance: function () {
            $('#chatSendMessageButton').on('click', function () {
                __ChatMessenger.sendMessageViaForm();
            });
        },

        // send message via form
        sendMessageViaForm: function () {
            var message = '',
                messageFormData = $('#chatMessageSendForm').serializeArray(); 
            _.forEach(messageFormData, function (item, index) {
                if (item.name == 'message') {
                    message = item.value;
                }
            });
            __ChatMessenger.sendMessage(1, {
                message: message,
                type: 1,
            });
        },

        // Send message
        sendMessage: function (type, formData) {
            var uniqueId = Math.random().toString(36).substr(2, 9),
                message = formData.message;
            if (!_.isEmpty(message)) {
                __ChatMessenger.appendMessage(type, message, uniqueId);
            } else {
                showErrorMessage(__Utils.getTranslation('message_is_required', 'Message is required'));
                __Utils.throwError('Message is required');
            }
            formData.unique_id = uniqueId;
            __DataRequest.post(__ChatMessenger.sendMessageUrl, formData, function (responseData) {
                var requestData = responseData.data,
                    storedData = requestData.storedData;
                if (responseData.reaction == 1) {
                    __ChatMessenger.replaceMessage(storedData.type, storedData.message, storedData.unique_id, storedData.created_on);
                } else {
                    __ChatMessenger.removeMessage(storedData.type, storedData.unique_id);
                }
            });
        },

        // Append message to message board
        appendMessage: function (type, message, uniqueId) {
            var $messengerChatWindow = $('.chat-message-list'),
                appendText = '';

            if (type == 1) {
                //appendText = '<div class="lw-messenger-chat-message lw-messenger-chat-sender row col-md-12" id="' + uniqueId + '"><p class="lw-messenger-chat-item">' + message + '<span class="lw-messenger-chat-meta">Now</span></p><img src="' + __ChatMessenger.loggedInUserProfilePicture + '" class="lw-profile-picture lw-online" alt=""></div>';
                appendText = `
                                <div class="p-2 mt-2" id="`+ uniqueId+`"> 
                                    <div class="chat-user-item d-flex position-relative"> 
                                        <div class="chat-user-avatar">
                                            <img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+ __ChatMessenger.loggedInUserProfilePicture +`">
                                            
                                        </div>
                                        <div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
                                            <div class="row" style="">
                                                <span class="chat-content">`+ message +`</span>
                                                <span class="chat-time" style="margin-left:auto;">Now</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                                `;
            } else {
                //appendText = '<div class="lw-messenger-chat-message lw-messenger-chat-sender row col-md-12" id="' + uniqueId + '"><p class="lw-messenger-chat-item"><p class="lw-messenger-chat-item col-md-8"><span class="lw-messenger-image-loading"> loading ...please wait</span><span class="lw-messenger-chat-meta">10 February 2020 at 4:00 pm</span></p><span class="lw-messenger-chat-meta">Now</span></p><img src="' + __ChatMessenger.loggedInUserProfilePicture + '" class="lw-profile-picture lw-online" alt=""></div>';
                appendText = `
                                <div class="p-2 mt-2" id="`+ uniqueId+`"> 
                                    <div class="chat-user-item d-flex position-relative"> 
                                        <div class="chat-user-avatar">
                                            <img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+ __ChatMessenger.loggedInUserProfilePicture +`">
                                            
                                        </div>
                                        <div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
                                            <div class="row" style="">
                                                <span class="chat-content"><span class="lw-messenger-image-loading"> loading ...please wait</span></span>
                                                <span class="chat-time" style="margin-left:auto;">Now</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                                `;
            }

            $messengerChatWindow.append(appendText);
            __ChatMessenger.$emojiElement[0].emojioneArea.setText('');
            $(".chat-message-list").scrollTop(1000000);
        },

        // replace message with existing message
        replaceMessage: function (type, message, uniqueId, createdOn) {
            if (type == 1) {
                // var replaceContainer = '<div class="lw-messenger-chat-message lw-messenger-chat-sender row col-md-12"><p class="lw-messenger-chat-item"><img src="' + message + '" alt=""><span class="lw-messenger-chat-meta">' + createdOn + '</span></p><img src="' + __ChatMessenger.loggedInUserProfilePicture + '" class="lw-profile-picture lw-online" alt=""></div>';
                var replaceContainer = `
                                <div class="p-2 mt-2" id="`+ uniqueId+`"> 
                                    <div class="chat-user-item d-flex position-relative"> 
                                        <div class="chat-user-avatar">
                                            <img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+ __ChatMessenger.loggedInUserProfilePicture +`">
                                           
                                        </div>
                                        <div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
                                            <div class="row" style="">
                                                <span class="chat-content">`+ message +`</span>
                                                <span class="chat-time" style="margin-left:auto;">`+createdOn+`</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                                `;
                $('#' + uniqueId).replaceWith(replaceContainer);
            } else {
                var replaceContainer = `
                                <div class="p-2 mt-2" > 
                                    <div class="chat-user-item d-flex position-relative"> 
                                        <div class="chat-user-avatar">
                                            <img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+ __ChatMessenger.loggedInUserProfilePicture +`">
                                            
                                        </div>
                                        <div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
                                            <div class="row" style="">
                                                <img class="chat-content-img chat-lazy-item" src="`+message+`" />
                                                <span class="chat-time" style="margin-left:auto;">`+createdOn+`</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                                `;
                $('#' + uniqueId).replaceWith(replaceContainer);
            }
        },

        // Remove message from message board
        removeMessage: function (type, uniqueId) {
            if (type != 1) {
                $('#' + uniqueId).remove();
            }
        },

        // Append received message
        appendReceivedMessage: function (type, message, createdOn) {
            var $messengerChatWindow = $('.chat-message-list'),
                appendText = '';
            if (type == 1) {
                //appendText = '<div class="lw-messenger-chat-message align-self-center row col-md-12 lw-messenger-chat-recipient"><img src="' + __ChatMessenger.recipientUserProfilePicture + '" class="lw-profile-picture lw-online" alt=""><p class="lw-messenger-chat-item col-md-8">' + message + '<span class="lw-messenger-chat-meta">' + createdOn + '</span></p></div>';
                appendText = `
                                <div class="p-2 mt-2" > 
                                    <div class="chat-user-item d-flex position-relative"> 
                                        <div class="chat-user-avatar">
                                            <img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+ __ChatMessenger.recipientUserProfilePicture +`">
                                            
                                        </div>
                                        <div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
                                            <div class="row" style="">
                                                <span class="chat-content">`+ message +`</span>
                                                <span class="chat-time" style="margin-left:auto;">`+createdOn+`</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                                `;
            } else {
                //appendText = '<div class="lw-messenger-chat-message align-self-center row col-md-12 lw-messenger-chat-recipient"><img src="' + __ChatMessenger.recipientUserProfilePicture + '" class= "lw-profile-picture lw-online" alt=""><p class="lw-messenger-chat-item col-md-8"><img src="' + message + '" alt=""><span class="lw-messenger-chat-meta">' + createdOn + '</span></p></div>';
                appendText = `
                                <div class="p-2 mt-2" > 
                                    <div class="chat-user-item d-flex position-relative"> 
                                        <div class="chat-user-avatar">
                                            <img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+ __ChatMessenger.recipientUserProfilePicture +`">
                                            
                                        </div>
                                        <div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
                                            <div class="row" style="">
                                                <img class="chat-content-img chat-lazy-item" src="`+message+`" />
                                                <span class="chat-time" style="margin-left:auto;">Now</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                                `;
            }
            $messengerChatWindow.append(appendText);
            $(".chat-message-list").scrollTop(1000000);
        },

        // Hide / Show sidebar on mobile view
        toggleSidebarOnMobileView: function () {
            if ($('.lw-messenger').hasClass('lw-messenger-sidebar-opened')) {
                $('.lw-messenger').removeClass('lw-messenger-sidebar-opened');
            } else {
                $('.lw-messenger').addClass('lw-messenger-sidebar-opened');
            }
        },

        // Click on toggle button
        hideShowChatSidebar: function () {
            $('#lwChatSidebarToggle').on('click', function () {
                __ChatMessenger.toggleSidebarOnMobileView();
            });
        },

        // Show hide disable enable buttons
        hideShowDropdownButtons: function (showButtons) {
            if (showButtons) {
                // For delete all chat button
                $('#lwDeleteAllChatActiveButton').show();
                $('#lwDeleteAllChatDisableButton').hide();

                // Audio call button 
                $('#lwAudioCallBtn').show();
                $('#lwAudioCallDisableBtn').hide();

                // video Call button
                $('#lwVideoCallBtn').show();
                $('#lwVideoCallDisableBtn').hide();
            } else {
                // For delete all chat button
                $('#lwDeleteAllChatActiveButton').hide();
                $('#lwDeleteAllChatDisableButton').show();

                // Audio call button 
                $('#lwAudioCallBtn').hide();
                $('#lwAudioCallDisableBtn').show();

                // video Call button
                $('#lwVideoCallBtn').hide();
                $('#lwVideoCallDisableBtn').show();
            }
        },
        showMessageRequestNotification: function () {
            //show dialog
            $(".lw-messenger #lwAudioCallDisableBtn, .lw-messenger #lwVideoCallDisableBtn").on("click", function () {
                $('.lw-messenger #lwUserNotAcceptedMsgRequest').modal({
                    keyboard: false
                });
            });

            //hide dialog
            $(".lw-messenger .lw-not-accepted-dialog-close-btn, .lw-messenger .lw-not-accepted-dialog-close-btn").on("click", function () {
                $('.lw-messenger #lwUserNotAcceptedMsgRequest').modal('hide');
            });
        }
    };

    $(function() {
		chatInitNewUserList();
        $(".chat-add-newuser").on("click", function() {
            addNewChatUser();
        });
        $(".chat-search-user-btn").on("click", function() {
            showSearchChatUser();
        });
        $(".chat-search-back-btn").on("click", function(){
            hideSearchChatUser();
        });
        $(".chat-close-new").on("click", function() {
            closeNewChatUser();
        });
	});

    function showFlex(el){
        el.addClass("d-flex");
        el.removeClass("d-none");
    }
    function hideFlex(el){
        el.addClass("d-none");
        el.removeClass("d-flex");
    }
    
    function addNewChatUser() {
        showFlex($(".chat-new-container"));
        hideFlex($("#chat-filter-user-list"));
        showFlex($("#chat-main-user-list"));
        $("a>div.chat-user-item-container").removeClass("chat-user-item-active");
        hideFlex($(".chat-title-header"));
        hideFlex($(".chat-header-toolbar"));
        showFlex($(".chat-newuser-header"));
        hideFlex($(".chat-send-textbox-container"));

        $('.chat-message-list').html(`
            <div class="chat-user-item mt-4 d-flex position-relative"> 
                <div class="row chat-datetime-container" >
                    <span class="chat-datetime"><?=formatDate(time()) ?></span>
                </div>
            </div> 
        `);
    }

    function closeNewChatUser() {
        hideFlex($(".chat-new-container"));
        hideFlex($(".chat-newuser-header"));
        $("#messengerPtUserListContainer>a.chat-user-list-item:first-child").trigger("click");
    }

    function showSearchChatUser(){
        hideFlex($(".chat-new-container"));
        hideFlex($(".chat-newuser-header"));
        hideFlex($(".chat-title-header"));
        hideFlex($(".chat-header-toolbar"));
        showFlex($("#chat-filter-user-list"));
        hideFlex($("#chat-main-user-list"));
        hideFlex($(".chat-send-textbox-container"));
    }

    function hideSearchChatUser(){
        hideFlex($("#chat-filter-user-list"));
        showFlex($("#chat-main-user-list"));
        showFlex($(".chat-title-header"));
        showFlex($(".chat-header-toolbar"));
        showFlex($(".chat-send-textbox-container"));
        if( $("a>div.chat-user-item-container.chat-user-item-active").length < 1) {
            $("#messengerPtUserListContainer>a.chat-user-list-item:first-child").trigger("click");
        }
    }

    function getAllChatUserList() {
        $("#messengerPtUserListContainer").html('');
        var requestUrl = '<?= route('user.read.all_conversation'); ?>';
        __DataRequest.get(requestUrl, {}, function(response) {
            console.log(response);
            if (response.reaction == 1) {
                if(response.data.messengerUsers.length > 0) {
                    for(var i=0;i<response.data.messengerUsers.length;i++){
                        var chatContentUrl = '<?= route('user.read.user_conversation', ['userId' => 0]) ?>';
                        chatContentUrl = chatContentUrl.replace('/0/', "/" + response.data.messengerUsers[i].user_id + "/");    
                        var userOnlineStatus = response.data.messengerUsers[i].is_online;
                        var onlineStatusTag = "";
                        if(userOnlineStatus == 1)
                            onlineStatusTag = `<span class="lw-dot lw-dot-success float-none" title="<?= __tr('Online'); ?>"></span>`;
                        else if(userOnlineStatus == 2)
                            onlineStatusTag = `<span class="lw-dot lw-dot-warning float-none" title="<?= __tr('Idle'); ?>"></span>`;
                        else if(userOnlineStatus == 3)
                            onlineStatusTag = `<span class="lw-dot lw-dot-danger float-none" title="<?= __tr('Offline'); ?>"></span>`;
                        
                        $("#messengerPtUserListContainer").append(`
                            <a class="lw-ajax-link-action chat-user-list-item" style="color:white;" data-action="`+chatContentUrl+`" id="`+response.data.messengerUsers[i].user_id+`" data-callback="chatGetContentResponse">
                                <div class="p-2 mt-2 chat-user-item-container" > 
                                    <div class="chat-user-item d-flex position-relative"> 
                                        <div class="chat-user-avatar">
                                            <img class="lw-profile-thumbnail lw-lazy-img" src="` + response.data.messengerUsers[i].profile_picture + `">
                                            <div class="chat-user-online-status-dot">
                                                `+
                                                onlineStatusTag
                                                +`
                                            </div>
                                        </div>
                                        <div class="chat-item-username col" style="padding-left: 1.25rem;"> 
                                            <div class="row" style="font-size: 16px;line-height: 24px;">
                                                <span>` + response.data.messengerUsers[i].user_kanji_name + `</span>
                                                <span class="chat-time" style="margin-left:auto;">`+response.data.messengerUsers[i].last_message_time+`</span>
                                            </div>
                                            <div class="row" style="font-size: 14px;line-height: 19px;color: #91929E;">
                                                <span>`+response.data.messengerUsers[i].last_message_hint+`</span>
                                                <span class="chat-unread-count-badge ` + ((response.data.messengerUsers[i].unread_count == 0)?`d-none`:``) + `" style="margin-left:auto;">`+response.data.messengerUsers[i].unread_count+`</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                            </a>
                        `);
                    }

                    var url = new URL(window.location.href);
                    var c = url.searchParams.get("selected");
                    if(c) {
                        if( $("#messengerPtUserListContainer>a#"+c).length ){
                            $("#messengerPtUserListContainer>a#"+c).trigger("click");
                        } else {
                            showAlert("Chat user does not exist.");
                            $("#messengerPtUserListContainer>a.chat-user-list-item:first-child").trigger("click");
                        }
                    } else {
                        $("#messengerPtUserListContainer>a.chat-user-list-item:first-child").trigger("click");
                    }
                    showFlex($(".chat-send-textbox-container"));
                } else {
                    $("#messengerPtUserListContainer").append(` <span> No chat user exist </span>`);
                    hideFlex($(".chat-title-header"));
                    hideFlex($(".chat-header-toolbar"));
                    hideFlex($(".chat-send-textbox-container"));
                }
                chatInitSearchUser(response.data.messengerUsers);
            }
        });
    }

    function chatInitNewUserList () {
        $("#chat-newuser-input-container").html('<select class="chat-newuser-input selectize-item" style="width:100%;color:white;" id="chat-newuser-input" ></select>');
        var requestUrl = '<?= route('user.read.get_candidates'); ?>';
        __DataRequest.post(requestUrl, {}, function(response) {
            if (response.reaction_code == 1) {
                $('.chat-newuser-input').selectize({
                    valueField: 'user_id',
                    labelField: 'user_kanji_name',
                    searchField: ['user_kanji_name'],
                    persist: true,
                    allowEmptyOption: false,
                    createOnBlur: true,
                    create: false,
                    closeAfterSelect: true,
                    hideSelected    : true,
                    openOnFocus     : true,
                    maxOptions      : 10,
                    maxItems           : null,
                    //placeholder     : "Neighborhood, Street, School, Zip, MLS",
                    //plugins         : ['remove_button'],
                    options         : response.data,
                    render          : {
                        option: function (item, escape) {
                            console.log(item);

                            var userOnlineStatus = item.is_online;
                            var onlineStatusTag = "";
                            if(userOnlineStatus == 1)
                                onlineStatusTag = `<span class="lw-dot lw-dot-success float-none" title="<?= __tr('Online'); ?>"></span>`;
                            else if(userOnlineStatus == 2)
                                onlineStatusTag = `<span class="lw-dot lw-dot-warning float-none" title="<?= __tr('Idle'); ?>"></span>`;
                            else if(userOnlineStatus == 3)
                                onlineStatusTag = `<span class="lw-dot lw-dot-danger float-none" title="<?= __tr('Offline'); ?>"></span>`;

                            var template = `<div class="p-2 chat-user-item d-flex position-relative " > 
                                                <div class="chat-user-avatar position-relative">
                                                    <img src="`+item.profile_picture+`">
                                                    <div class="chat-user-online-status-dot" style="">
                                                        `+onlineStatusTag+`
                                                    </div>
                                                </div>
                                                <div class="chat-item-username" style="padding-left: 1rem;align-items:center;display: flex;"> 
                                                `+ item.user_kanji_name+`
                                                </div>
                                                <span class="chat-item-username primari-color-btn chat-toolbar-icon" style="margin-left:auto;margin-top: auto;margin-bottom: auto;border-radius: 7px;font-size: 12px;height:20px;background:#FF4141;align-items:center;display: flex;"> 
                                                `+ item.role_name+`
                                                </span>
                                            </div> `;
                            return template;
                        }
                    },
                    //load            : searchHandler,
                    //onKeydown       : keyHandler,
                    //onDelete        : deleteHandler,
                    //onFocus         : textHandler('focus'),
                    onChange       : function(value) {
                        if(!value)
                            return;

                        var requestUrl = '<?= route('user.write.send_invite_message'); ?>',
                            formData = {
                                'user_id' : value,
                                'type' : 1,
                                'message' : '' 
                            };  

                        // var requestUrl = __Utils.apiURL("<?= route('user.write.send_message', ['userId' => 'userId']) ?>", {
						// 				'userId': value
						// 			}),
                        //     formData = {
                        //         'type' : 1,
                        //         'message' : '&#8203;'   // 😀 , &#160; &nbsp; &ZeroWidthSpace;
                        //     };  

                        // post ajax request
                        __DataRequest.post(requestUrl, formData, function(response) {
                            if (response.reaction == 1) {
                                closeNewChatUser();
                                chatInitNewUserList();
                            }
                        });
                        
                    }
                });
            }
        });
        getAllChatUserList();
    }

    var chatSelectedUserId = null,
        chatSelectedUserUid = null,
        selectedUserOnlineStatusTag = "";
    // After getting response from selected user
    function chatGetContentResponse(responseData) { 
        console.log(responseData); 
        if (responseData.reaction == 1) {
            var chatUserData = responseData.data.userData;
            var chatSelectedUserId = chatUserData.user_id;
            chatSelectedUserUid = chatUserData.user_uid;
            
            // chat user list as active
            $("a>div.chat-user-item-container").removeClass("chat-user-item-active");
            $("a#"+chatSelectedUserId+">div.chat-user-item-container").addClass("chat-user-item-active");
            if ( responseData.data.unread_count == 0 ){
                $("a#"+chatSelectedUserId+">div.chat-user-item-container span.chat-unread-count-badge").addClass('d-none');
                $("a#"+chatSelectedUserId+">div.chat-user-item-container span.chat-unread-count-badge").html('');
            } else {
                $("a#"+chatSelectedUserId+">div.chat-user-item-container span.chat-unread-count-badge").removeClass('d-none');
            }
            //var incomingMsgEl = $('.lw-incoming-message-count-' + $(this).attr('id'));
            //if (!_.isEmpty(incomingMsgEl.text())) {
                //incomingMsgEl.text(null);
            //}
            
            // chat header image and username change
            $("#chat-user-header-img").attr("src",chatUserData.profile_picture_image);

            var userOnlineStatus = chatUserData.is_online;
            var onlineStatusTag = "";
            if(userOnlineStatus == 1)
                onlineStatusTag = `<span class="lw-dot lw-dot-success float-none" title="<?= __tr('Online'); ?>"></span>`;
            else if(userOnlineStatus == 2)
                onlineStatusTag = `<span class="lw-dot lw-dot-warning float-none" title="<?= __tr('Idle'); ?>"></span>`;
            else if(userOnlineStatus == 3)
                onlineStatusTag = `<span class="lw-dot lw-dot-danger float-none" title="<?= __tr('Offline'); ?>"></span>`;
            $("div.chat-title-header .chat-user-online-status-dot").html(onlineStatusTag);

            __ChatMessenger.recipientUserProfilePicture = chatUserData.profile_picture_image;

            $("#chat-user-header-username").html(chatUserData.username?chatUserData.username:chatUserData.user_kanjiname);
            $("#chat-user-header-aboutme").html(chatUserData.about_me?chatUserData.about_me15:"Unknown");

            // Accept Decline Button user id setting
            var chatAcceptDeclineUrl = '<?= route('user.write.accept_decline_message_request', ['userId' => 0]) ?>';
            chatAcceptDeclineUrl = chatAcceptDeclineUrl.replace('/0/', "/" + chatUserData.user_id + "/");    
            $("#chatDeclineChatRequestBtn").attr('href',chatAcceptDeclineUrl);
            $("#chatAcceptChatRequestBtn").attr('href',chatAcceptDeclineUrl);
            
            //$("#chatBlockBtn").attr('href',chatAcceptDeclineUrl);

            // Message send form url setting
            var formActionUrl = "<?= route('user.write.send_message', ['userId' => 0]) ?>";
            formActionUrl = formActionUrl.replace('/0/', "/" + chatUserData.user_id + "/");    
            $("form#chatMessageSendForm").attr('action', formActionUrl);

            // Delete chat button setting for user_id
            $("a#chatDeleteAllChatActiveButton").attr('data-post-data', JSON.stringify( {'to_user_id' : chatUserData.user_id }));
            var chatDeleteUrl = '<?= route('user.write.delete_all_messages', ['userId' => 0]); ?>';
            chatDeleteUrl = chatDeleteUrl.replace('/0/', "/" + chatUserData.user_id + "/");    
            $("a#chatDeleteAllChatActiveButton").attr('href',chatDeleteUrl);

            $("#chat-message-list").html('');
            var chatContent = responseData.data.userConversations;
            var chatItem;
            for( var i=0;i<chatContent.length;i++ ){
                chatItem = chatContent[i];
                if(chatItem.is_message_received){
                    if( chatItem.type == 1 ) {
                        $("#chat-message-list").append(`
                            <div class="p-2 mt-2 " > 
                                <div class="chat-user-item d-flex position-relative"> 
                                    <div class="chat-user-avatar">
                                        <img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+chatUserData.profile_picture_image+`">
                                        
                                    </div>
                                    <div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
                                        <div class="row" style="">
                                            <span class="chat-content">`+chatItem.message+`</span>
                                            <span class="chat-time" style="margin-left:auto;">`+chatItem.created_on+`</span>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        `);
                    } else if( chatItem.type == 2 || chatItem.type == 8 || chatItem.type == 12 ) {
                        $("#chat-message-list").append(`
                            <div class="p-2 mt-2 " > 
                                <div class="chat-user-item d-flex position-relative"> 
                                    <div class="chat-user-avatar">
                                        <img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+chatUserData.profile_picture_image+`">
                                        
                                    </div>
                                    <div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
                                        <div class="row" style="">
                                            <img class="chat-content-img chat-lazy-item" src="`+chatItem.message+`" />
                                            <span class="chat-time" style="margin-left:auto;">`+chatItem.created_on+`</span>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        `);
                        // For website link 
                        // <span class="chat-link-container row"> <i class="fa fa-link"> </i> pt-r-us.com </span>
                    }
                    
                } else {
                    if( chatItem.type == 1 ) {
                        $("#chat-message-list").append(`
                            <div class="p-2 mt-2 " > 
                                <div class="chat-user-item d-flex position-relative"> 
                                    <div class="chat-user-avatar">
                                        <img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+responseData.data.loggedInUserProfilePicture+`">
                                        
                                    </div>
                                    <div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
                                        <div class="row" style="">
                                            <span class="chat-content">`+chatItem.message+`</span>
                                            <span class="chat-time" style="margin-left:auto;">`+chatItem.created_on+`</span>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        `);
                    } else if( chatItem.type == 2 || chatItem.type == 8 || chatItem.type == 12 ) {
                        $("#chat-message-list").append(`
                            <div class="p-2 mt-2 " > 
                                <div class="chat-user-item d-flex position-relative"> 
                                    <div class="chat-user-avatar">
                                        <img class="" style="margin-left:5px;margin-top:5px;width:40px;height:40px;" src="`+responseData.data.loggedInUserProfilePicture+`">
                                        
                                    </div>
                                    <div class="chat-item-username col" style="padding-left: 1.25rem;align-self: center;"> 
                                        <div class="row" style="">
                                            <img class="chat-content-img chat-lazy-item" src="`+chatItem.message+`" />
                                            <span class="chat-time" style="margin-left:auto;">`+chatItem.created_on+`</span>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        `);
                    }
                }
            }
            showFlex($('.chat-title-header'));
            showFlex($('.chat-header-toolbar'));
            showFlex($('.chat-send-textbox-container'));
            hideFlex($(".chat-new-container"));
            hideFlex($(".chat-newuser-header"));
            chatGetContentDetailResponse(responseData);
        }
    };

    function chatSendMessageResponse(responseData) {
        console.log(responseData);
    }

    __ChatMessenger.sendMessageRawUrl = "<?= route('user.write.send_message', ['userId' => 'userId']) ?>";
    __ChatMessenger.buyStickerUrl = "<?= route('user.write.buy_stickers') ?>";
    __ChatMessenger.giphyKey = "<?= getStoreSettings('giphy_key') ?>";
    __ChatMessenger.loggedInUserProfilePicture = "<?= $currentUserData['logged_in_user_profile_picture'] ?>";
    __ChatMessenger.loggedInUserUid = "<?= getUserUID() ?>";
    __ChatMessenger.pusherAppKey = "<?= getStoreSettings('pusher_app_key') ?>";

    
    // lwFilterUsers
    $("#lwFilterUsers").on("keyup", function() {
        var filterQuery = $(this).val().toLowerCase();
        $(".lw-messenger-contact-list a").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(filterQuery) > -1)
        });
    });

    function handleChatMessageActionContainer(messageRequestStatus, loadUploaderInstance) { 
        if (messageRequestStatus == 'MESSAGE_REQUEST_ACCEPTED'
            || messageRequestStatus == 'SEND_NEW_MESSAGE') {
            if (loadUploaderInstance) {
                __ChatMessenger.loadUploaderInstance();
            }
            __ChatMessenger.hideShowDropdownButtons(true);

            showFlex($('#chatMessageSendForm'));
            hideFlex($(".chat-send-accept-decline-container"));
            
        } else if (messageRequestStatus == 'MESSAGE_REQUEST_RECEIVED') {

            hideFlex($('#chatMessageSendForm'));
            showFlex($(".chat-send-accept-decline-container"));

            __ChatMessenger.hideShowDropdownButtons(false);
            if (loadUploaderInstance) {
                __ChatMessenger.loadUploaderInstance();
            }

        } else if (messageRequestStatus == 'MESSAGE_REQUEST_DECLINE') {
            __ChatMessenger.hideShowDropdownButtons(false);

            hideFlex($('#chatMessageSendForm'));
            showFlex($(".chat-send-accept-decline-container"));
            $("#chatDeclineChatRequestBtn").addClass("disabled");
            showFlex($("#chatDeclineMessage"));

        } else if (messageRequestStatus == 'MESSAGE_REQUEST_DECLINE_BY_USER') {

            hideFlex($('#chatMessageSendForm'));
            showFlex($(".chat-send-accept-decline-container"));
            hideFlex($('#chatAcceptChatRequestBtn'));
            hideFlex($('#chatDeclineChatRequestBtn'));
            showFlex($('#chatDeclineMessage'));

        } else if (messageRequestStatus == 'MESSAGE_REQUEST_SENT') {
            if (loadUploaderInstance) {
                __ChatMessenger.loadUploaderInstance();
            }
            __ChatMessenger.hideShowDropdownButtons(false);
            showFlex($('#chatMessageSendForm'));
            hideFlex($(".chat-send-accept-decline-container"));
        }
    }


    // After getting response from selected user
    
    function chatGetContentDetailResponse(responseData) {  
        if (responseData.reaction == 1) {
            chatSelectedUserId = responseData.data.userData.user_id;
            chatSelectedUserUid = responseData.data.userData.user_uid;

            var sendMessageUrl = "<?= route('user.write.send_message', ['userId' => 0]) ?>";
            sendMessageUrl = sendMessageUrl.replace('/0/', "/" + chatSelectedUserId + "/");   
            __ChatMessenger.sendMessageUrl = sendMessageUrl; 
            _.defer(function () {
                $(".chat-message-list").scrollTop(1000000);
                var messageRequestStatus = responseData.data.userData.messageRequestStatus;
                handleChatMessageActionContainer(messageRequestStatus, true);
                __ChatMessenger.hideShowChatSidebar();
                __ChatMessenger.loadEmojiContent();
                __ChatMessenger.openStickerBottomSheet();
                __ChatMessenger.openGifBottomSheet();
                __ChatMessenger.createSendButtonInstance();
                _.delay(function () {
                    __ChatMessenger.hideShowDropdownButtons(responseData.data.userData.enableAudioVideoLinks);
                }, 100);
                __ChatMessenger.showMessageRequestNotification();
            });
        }
    };

    function chatInitSearchUser( userData ) {

        $('.chat-searchuser-input').selectize({
            valueField: 'user_id',
            labelField: 'user_kanji_name',
            searchField: ['user_kanji_name'],
            persist: true,
            allowEmptyOption: false,
            createOnBlur: true,
            create: false,
            closeAfterSelect: true,
            hideSelected    : true,
            openOnFocus     : true,
            maxOptions      : 10,
            //placeholder     : "Neighborhood, Street, School, Zip, MLS",
            //plugins         : ['remove_button'],
            options         : userData,
            render          : {
                option: function (item, escape) {
                    console.log(item);
                    var userOnlineStatus = item.is_online;
                        var onlineStatusTag = "";
                        if(userOnlineStatus == 1)
                            onlineStatusTag = `<span class="lw-dot lw-dot-success float-none" title="<?= __tr('Online'); ?>"></span>`;
                        else if(userOnlineStatus == 2)
                            onlineStatusTag = `<span class="lw-dot lw-dot-warning float-none" title="<?= __tr('Idle'); ?>"></span>`;
                        else if(userOnlineStatus == 3)
                            onlineStatusTag = `<span class="lw-dot lw-dot-danger float-none" title="<?= __tr('Offline'); ?>"></span>`;
                        
                    var template = `<a class="lw-ajax-link-action chat-user-list-item" style="color:white;" data-action="" id="" data-callback="">
                                        <div class="p-2 mt-2 chat-user-item-container" > 
                                            <div class="chat-user-item d-flex position-relative"> 
                                                <div class="chat-user-avatar">
                                                    <img class="lw-profile-thumbnail lw-lazy-img" src="` + item.profile_picture + `">
                                                    <div class="chat-user-online-status-dot">
                                                        `+onlineStatusTag+`
                                                    </div>
                                                </div>
                                                <div class="chat-item-username col" style="padding-left: 1.25rem;"> 
                                                    <div class="row" style="font-size: 16px;line-height: 24px;">
                                                        <span>` + item.user_kanji_name + `</span>
                                                        <span class="chat-time d-none" style="margin-left:auto;">12:00</span>
                                                    </div>
                                                    <div class="row" style="font-size: 14px;line-height: 19px;color: #91929E;">
                                                        <span>...</span>
                                                        <span class="chat-unread-count-badge d-none" style="margin-left:auto;">12</span>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 
                                    </a>`;
                                    
                    return template;
                }
            },
            //load            : searchHandler,
            //onKeydown       : keyHandler,
            //onDelete        : deleteHandler,
            //onFocus         : textHandler('focus'),
            onChange       : function(value) {
                console.log(value);
                $("a#" + value).trigger("click");               
            }
        });
    }

   __ChatMessenger.recipientUserProfilePicture = "<?= getUserAuthInfo('profile.profile_picture_url') ?>";

    var lazyInstance = $('.chat-lazy-item').lazy({
        // called once all elements was handled
        onFinishedAll: function() {
            // console.log('finished loading all images');
        }
    });

    $("#chatBlockBtn").on('click', function(e) {
		var confirmText = $('#lwBlockUserConfirmationText');
		//show confirmation 
		showConfirmation(confirmText, function() {
			var requestUrl = '<?= route('user.write.block_user'); ?>',
				formData = {
					'block_user_id': $('.chat-user-item-active').parent().attr("id"),
				};
			// post ajax request
			__DataRequest.post(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					__Utils.viewReload();
				}
			});
		});
	});

</script>

@endpush