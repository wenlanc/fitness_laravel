@section('page-title', __tr('Find Matches'))
@section('head-title', __tr('Find Matches'))
@section('keywordName', __tr('Find Matches'))
@section('keyword', __tr('Find Matches'))
@section('description', __tr('Find Matches'))
@section('keywordDescription', __tr('Find Matches'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<?php
$lookingFor = getUserSettings('looking_for');
$minAge = getUserSettings('min_age');
$maxAge = getUserSettings('max_age');

if (request()->session()->has('userSearchData')) {
    $userSearchData = session('userSearchData');
    $lookingFor = $userSearchData['looking_for'];
    $minAge = $userSearchData['min_age'];
    $maxAge = $userSearchData['max_age'];
}
?>

<div class="row" style="position:relative;" id="matchesSearchContainer"> 
    <!-- Tab Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <nav class="nav">
            <a id="partner" data-toggle="tab" class="nav-link active" aria-current="page" href="#match_tab"><?= __tr('Matches'); ?></a>
            <a id="pending" data-toggle="tab" class="nav-link" href="#pending_tab"><?= __tr('Pending'); ?></a>
            <a id="visitors" data-toggle="tab" class="nav-link position-relative" href="#visitors_tab">
                <?= __tr('Visitors'); ?>
                <span class="match_visitors_count_badge"> <?= $profileVisitorCount?> </span>
            </a>
        </nav>

        @include('filter.search_filter')
    </div>
</div>
<div class="tab-content" style="padding-bottom:15px;padding-top:10px;">
    <div class="row tab-pane active in" id="match_tab" style="justify-content: center;">
        <div id="lwMatchedFilterContainer">
            @include('filter.ajax.matched_list')
        </div>
    </div>

    <div class="row tab-pane fade" id="pending_tab" style="justify-content: center;">
        <div id="lwPendingFilterContainer">
        </div>
    </div>

    <div class="row tab-pane fade" id="visitors_tab" style="justify-content: center;">
        <div id="lwVisitorFilterContainer"> </div>
    </div>
</div>

@include('modals.chat_unavailable')
@include('modals.report')

<!-- Found matches container -->
@push('appScripts')

@if(getStoreSettings('allow_google_map'))
<script src="https://maps.googleapis.com/maps/api/js?key=<?= getStoreSettings('google_map_key'); ?>&libraries=places&callback=initialize&language=en" async defer></script>
@endif

<script>
    function loadMoreUsers(responseData) {
        $(function() {
            applyLazyImages();
        });
        var requestData = responseData.data,
            appendData = responseData.response_action.content;

        $('#lwMatchedFilterContainer .lw-load-more-container').remove();
        $('#lwMatchedFilterContainer').append(appendData);
        makeStarRate();
    }

    let hasMorePagesPending = true;
    let hasMorePagesVisitor = true;
    function loadPending(responseData) {
        $(function() {
            applyLazyImages();
        });
        var requestData = responseData.data;
        var appendData = responseData.response_action.content;
        hasMorePagesPending = requestData.hasMorePages;

        $('#lwPendingFilterContainer .lw-load-more-container').remove();
        $('#lwPendingFilterContainer').append(appendData);
        // $('#lwLoadMoreButtonPending').data('action', requestData.nextPageUrl);
        // if (!hasMorePagesPending) {
        //     $('#lw-load-more-container-pending').hide();
        // } else {
        //     $('#lw-load-more-container-pending').show();
        // }
        makeStarRate();
    }

    function loadVisitors(responseData) {
        $(function() {
            applyLazyImages();
        });
        var requestData = responseData.data;
        var appendData = responseData.response_action.content;
        hasMorePagesVisitor = requestData.hasMorePages;

        $('#lwVisitorFilterContainer .lw-load-more-container').remove();
        $('#lwVisitorFilterContainer').append(appendData);
        // $('#lwLoadMoreButtonVisitors').data('action', requestData.nextPageUrl);
        // if (!hasMorePagesVisitor) {
        //     $('#lw-load-more-container-visitors').hide();
        // } else {
        //     $('#lw-load-more-container-visitors').show();
        // }

        makeStarRate();
    }


    // Show advance filter
    $('#lwShowAdvanceFilterLink').on('click', function(e) {
        e.preventDefault();
        $('.lw-advance-filter-container').addClass('lw-expand-filter');
        $('#lwShowAdvanceFilterLink').hide();
        $('#lwHideAdvanceFilterLink').show();
        // $('.lw-advance-filter-container').show();
    });
    // Hide advance filter
    $('#lwHideAdvanceFilterLink').on('click', function(e) {
        e.preventDefault();
        $('.lw-advance-filter-container').removeClass('lw-expand-filter');
        $('#lwShowAdvanceFilterLink').show();
        $('#lwHideAdvanceFilterLink').hide();
        // $('.lw-advance-filter-container').hide();
    });
    $('.nav-link').click(function(event) {
        let id = event.target.getAttribute('id');
        if (id == 'pending') {
            // load pt data
            if (hasMorePagesPending) {
                var requestUrl = '<?= route('user.read.pending_list') ?>',
                    formData = {

                    };
                // post ajax request
                __DataRequest.get(requestUrl, formData, function(response) {
                    if (response.reaction == 1) {
                        loadPending(response);
                    }
                });
            }
        } else if ( id == "visitors") {
            if (hasMorePagesVisitor) {
                var requestUrl = '<?= route('user.read.visitor_list') ?>',
                    formData = {

                    };
                // post ajax request
                __DataRequest.get(requestUrl, formData, function(response) {
                    if (response.reaction == 1) {
                        loadVisitors(response);
                    }
                });
            }
        }
    });

    /**************** User Like Dislike Fetch and Callback Block Start ******************/
    //add disabled anchor tag class on click
    $(".lw-like-action-btn, .lw-dislike-action-btn").on('click', function() {
        $('.lw-follow-box').addClass("lw-disable-anchor-tag");
    });

    function reloadContentMatchPending(){
        $('#lwPendingFilterContainer').html('');
        $('#lwMatchedFilterContainer').html('');

        var requestUrl = '<?= route('user.read.pending_list') ?>',
            formData = {

            };
        // post ajax request
        __DataRequest.get(requestUrl, formData, function(response) {
            if (response.reaction == 1) {
                loadPending(response);
            }
        });
    
        var requestUrl = '<?= route('user.read.match_list') ?>',
            formData = {

            };
        // post ajax request
        __DataRequest.get(requestUrl, formData, function(response) {
            if (response.reaction == 1) {
                loadMoreUsers(response);
            }
        });
    }

    //on like Callback function
    function onLikeCallback(response) {
        var requestData = response.data;
        //check reaction code is 1 and status created or updated and like status is 1
        if (response.reaction == 1 && requestData.likeStatus == 1 && (requestData.status == "created" || requestData.status == 'updated')) {
            $('#following-' + requestData.toUserUid).html('Following');
            //add class
            $(".lw-animated-like-heart").toggleClass("lw-is-active");
            //check if updated then remove class in dislike heart
            if (requestData.status == 'updated') {
                $(".lw-animated-broken-heart").toggleClass("lw-is-active");
            }
            $('#following-' + requestData.toUserUid).removeClass("follow_badge_tag");
            $('#following-' + requestData.toUserUid).addClass("pt_badge_tag");
        }
        //check reaction code is 1 and status deleted and like status is 1
        if (response.reaction == 1 && requestData.likeStatus == 1 && requestData.status == "deleted") {
            $('#following-' + requestData.toUserUid).html('Follow');
            $(".lw-animated-like-heart").toggleClass("lw-is-active");
            $('#following-' + requestData.toUserUid).removeClass("pt_badge_tag");
            $('#following-' + requestData.toUserUid).addClass("follow_badge_tag");
        }
        //remove disabled anchor tag class
        _.delay(function() {
            $('.lw-follow-box').removeClass("lw-disable-anchor-tag");
        }, 1000);


        reloadContentMatchPending();
      
    }

    function onHidePendingCallback(response)
    {
        if (response.reaction == 1 ) {
            reloadContentMatchPending();
        }
    }

    /**************** User Like Dislike Fetch and Callback Block End ******************/

    function makeStarRate(){
        $(".review-rating").starRating({
            strokeColor: '#FF3F3F',
            strokeWidth: 0,
            readOnly:true,
            starSize: 16,
            disableAfterRate: false,
            useFullStars: true,
            totalStars: 1,
            useFullStars:	false,
            emptyColor: 'white',
            hoverColor: '#FF3F3F',
            activeColor: '#FF3F3F',
            useGradient: false,
        });
    }
    makeStarRate();

    /**************   Search & Filter ******************/
    var $selectFilterExpertise = $('#selectFilterExpertise').selectize({
		//plugins: ['restore_on_backspace', 'remove_button'],
		valueField: '_id',
		labelField: 'title',
		searchField: [
			'title'
		],
        placeholder:"Please type interests...",
		//items: selected_items,
		options: JSON.parse(`<?= json_encode(getExpertiseList())?>`),
		create: false,
		// loadThrottle: 2000,
		maxItems: null,
		render: {
			option: function(item, escape) {
				return '<div><span class="title"><span class="name">' + escape(item.title) + '</span></span></div>';
			}
		},
		load: function(query, callback) {
			if (!query.length || (query.length < 2)) {
				return callback([]);
			} else {
				__DataRequest.post("<?= route('user.read.search_static_expertise'); ?>", {
					'search_query': query
				}, function(responseData) {
					callback(responseData.data.search_result);
				});
			}
		},
		onChange: function(value) {
			if (!value.length) {
				return;
			};
			$("#filter_expertise_selected_list").val(value);
		},

		onInitialize: function(){
			var selectize = this;
			// $.get("/api/selected_cities.php", function( data ) {
			// 	selectize.addOption(data); // This is will add to option
			// 	var selected_items = [];
			// 	$.each(data, function( i, obj) {
			// 		selected_items.push(obj.id);
			// 	});
			// 	selectize.setValue(selected_items); //this will set option values as default
			// });
            
            __DataRequest.post("<?= route('user.read.search_static_expertise'); ?>", {
                'search_query': ''
            }, function(responseData) {
                selectize.addOption(responseData);
            });
			
		}

	});

	function initialize() {
		@if(getStoreSettings('allow_google_map'))
		$('form').on('keyup keypress', function(e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode === 13) {
				e.preventDefault();
				return false;
			}
		});
		const locationInputs = document.getElementsByClassName("map-input");

		const autocompletes = [];
		const geocoder = new google.maps.Geocoder;
		for (let i = 0; i < locationInputs.length; i++) {

			const input = locationInputs[i];
			const fieldKey = input.id.replace("-input", "");
			const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

			const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || 35.6762;
			const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 139.6503;

			const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
				center: {
					lat: latitude,
					lng: longitude
				},
				zoom: 13
			});
			const marker = new google.maps.Marker({
				map: map,
				position: {
					lat: latitude,
					lng: longitude
				},
			});

			marker.setVisible(isEdit);

			const autocomplete = new google.maps.places.Autocomplete(input);
			autocomplete.key = fieldKey;
			autocompletes.push({
				input: input,
				map: map,
				marker: marker,
				autocomplete: autocomplete
			});
		}

		for (let i = 0; i < autocompletes.length; i++) {
			const input = autocompletes[i].input;
			const autocomplete = autocompletes[i].autocomplete;
			const map = autocompletes[i].map;
			const marker = autocompletes[i].marker;

			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				marker.setVisible(false);
				const place = autocomplete.getPlace();

				geocoder.geocode({
					'placeId': place.place_id
				}, function(results, status) {
					if (status === google.maps.GeocoderStatus.OK) {
						const lat = results[0].geometry.location.lat();
						const lng = results[0].geometry.location.lng();
						setLocationCoordinates(autocomplete.key, lat, lng, place);
					}
				});

				if (!place.geometry) {
					window.alert("No details available for input: '" + place.name + "'");
					input.value = "";
					return;
				}

				if (place.geometry.viewport) {
					map.fitBounds(place.geometry.viewport);
				} else {
					map.setCenter(place.geometry.location);
					map.setZoom(17);
				}
				marker.setPosition(place.geometry.location);
				marker.setVisible(true);

			});
		}
		@endif
	}

	function setLocationCoordinates(key, lat, lng, placeData) { 
        $("#"+key+"-formattedaddress").val( placeData.formatted_address );
        $("#"+key+"-latitude").val( lat );
        $("#"+key+"-longitude").val( lng );
        $("#"+key+"-placedata").val( JSON.stringify( placeData ));
	};

    $("#filter_add_location_btn").click(function(){
        if( $("#address-formattedaddress").val() == "") 
            return;
        let i = $("#filter_address_check_container div.custom-control").length;
        $("#filter_address_check_container").append(`
            <div class="custom-control custom-checkbox custom-control-inline" style="align-items:center;">
                <input type="hidden" name="filter_address[`+i+`]" value='`+$("#address-formattedaddress").val()+`'>
                <input type="hidden" name="filter_latlng[`+i+`]" value='` + $("#address-latitude").val() + `,`+ $("#address-longitude").val() + `'>
                <input type="checkbox" class="custom-control-input" id="filter_checkbox`+i+`" name="filter_location_checked[`+i+`]" value="`+i+`" checked="">
                <label class="custom-control-label" for="filter_checkbox`+i+`"> `+$("#address-formattedaddress").val()+` </label>
            </div>
        `);

        $("#address-formattedaddress").val('');
        $("#address-latitude").val('');
        $("#address-longitude").val('');
        $("#address-placedata").val('');
        $("#address-input").val('');
    
    });

    function requestFilter(){
        var formData = __Utils.queryConvertToObject($("#search_filter_form").serialize());
        var requestUrl = '<?= route('user.read.match_list'); ?>';
        var active_menu_id = $('.nav-link.active').attr("id");
        if (active_menu_id == "pending") {
            requestUrl = '<?= route('user.read.pending_list'); ?>';
        } else if(active_menu_id == "visitors"){
            requestUrl = '<?= route('user.read.visitor_list'); ?>';
        }            
        // post ajax request
        __DataRequest.get(requestUrl, formData, function(response) {
            if (response.reaction == 1) {
                if (active_menu_id == "pending") {
                    $('#lwPendingFilterContainer').html('');
                    loadPending(response);
                } else if(active_menu_id == "visitors"){
                    $('#lwVisitorFilterContainer').html('');
                    loadVisitors(response);
                } else {
                    $('#lwMatchedFilterContainer').html('');
                    loadMoreUsers(response);
                }   
            }
        });
    }
    function requestSearchText(){
        let searchText = $("#filter_text").val();
        if(searchText.length < 2){
            //return;
        }
        var requestUrl = '<?= route('user.read.match_list'); ?>';
        var active_menu_id = $('.nav-link.active').attr("id");
        if (active_menu_id == "pending") {
            requestUrl = '<?= route('user.read.pending_list'); ?>';
        } else if(active_menu_id == "visitors"){
            requestUrl = '<?= route('user.read.visitor_list'); ?>';
        }              
        // post ajax request
        __DataRequest.get(requestUrl, { 'search_text':searchText}, function(response) {
            if (response.reaction == 1) {
                if ( active_menu_id == "pending" ) {
                    $('#lwPendingFilterContainer').html('');
                    loadPending(response);
                } else if ( active_menu_id == "visitors" ) {
                    $('#lwVisitorFilterContainer').html('');
                    loadVisitors(response);
                } else {
                    $('#lwMatchedFilterContainer').html('');
                    loadMoreUsers(response);
                }   
            }
        });

    }

    function startChat( userID ) {
        var requestUrl = '<?= route('user.write.send_invite_message'); ?>',
                            formData = {
                                'user_id' : userID,
                                'type' : 1,
                                'message' : '' 
                            };   
        // post ajax request
        __DataRequest.post(requestUrl, formData, function(response) {
            if (response.reaction == 1) {
                var url ='<?= route('user.read.messenger')."?selected=" ?>'+response.data.user_id;
                window.open(url, '_blank');
            } else {
                $('#lwChatUnavailableDialog').modal('show');
            }
        });
    }

</script>
@endpush