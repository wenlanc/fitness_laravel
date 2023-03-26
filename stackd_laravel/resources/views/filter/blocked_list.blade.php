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

<div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-4 pb-2" style="position:relative;">
    <div class="d-sm-flex align-items-center justify-content-between">
        <h5 style=" font-family: Nunito Sans;font-style: normal;font-weight: bold;font-size: 22px;line-height: 30px;/* identical to box height */color: #FF4141;"> Blocked </h5>
    </div>
    @include('filter.search_filter')
</div>
<div class="row row-cols-sm-1 row-cols-md-1 row-cols-lg-1" id="lwUserFilterContainer" style="margin-top:10px;justify-content: center;">
    @include('filter.ajax.blocked_list')
</div>

@include('modals.report')

<!-- User block Confirmation text html -->
<div id="lwUnBlockUserConfirmationText" style="display: none;">
	<h3><?= __tr('Are You Sure!'); ?></h3>
	<strong><?= __tr('You want to unblock this user.'); ?></strong>
</div>
<!-- /User block Confirmation text html -->

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
		$('#lwUserFilterContainer .lw-load-more-container').remove();    
        $('#lwUserFilterContainer').append(appendData);
		
        // $('#lwLoadMoreButton').data('action', requestData.nextPageUrl);
        // if (!requestData.hasMorePages) {
        //     $('#lw-load-more-container').hide();
        // } else {
		// 	$('#lw-load-more-container').show();
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
    
    /**************** User Like Dislike Fetch and Callback Block Start ******************/
    //add disabled anchor tag class on click
    $(".lw-like-action-btn, .lw-dislike-action-btn").on('click', function() {
        $('.lw-follow-box').addClass("lw-disable-anchor-tag");
    });
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
        var requestUrl = '<?= route('user.read.blocked_list'); ?>';
                 
        // post ajax request
        __DataRequest.get(requestUrl, formData, function(response) {
            if (response.reaction == 1) {
                $('#lwUserFilterContainer').html('');
                loadMoreUsers(response);
            }
        });
    }
    function requestSearchText(){
        let searchText = $("#filter_text").val();
        if(searchText.length < 2){
            //return;
        }
        var requestUrl = '<?= route('user.read.blocked_list'); ?>';
            
        // post ajax request
        __DataRequest.get(requestUrl, { 'search_text':searchText}, function(response) {
            if (response.reaction == 1) {
                $('#lwUserFilterContainer').html('');
                loadMoreUsers(response);
            }
        });

    }

    function unblockUser(userid, username) {
		var confirmText = $('#lwUnBlockUserConfirmationText');
		//show confirmation 
		showConfirmation(confirmText, function() {
			var requestUrl = '<?= route('user.write.unblock_user'); ?>',
				formData = {
					'block_user_id': userid,
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