@if(!__isEmpty($photosData))
@foreach($photosData as $key => $photo)
	<div  class="col photo_posting_item photo_posting_item_<?= $photo["photoUId"]?>" style="padding:0.75rem;">
		<a href='javascript:showDetailViewPhoto(<?= json_encode($photo, JSON_HEX_QUOT | JSON_HEX_APOS)?>)'>
			<img class="lw-user-photo lw-lazy-img" style="margin:0px;border-radius: 10px;width:100%;height:auto;min-height:130px;flex: 1 1 auto;" data-img-index="<?= $key; ?>" src="<?= imageOrNoImageAvailable($photo['image_url']); ?>" data-src="<?= imageOrNoImageAvailable($photo['image_url']); ?>">
			@if($isOwnProfile)
			<a href="<?= $photo["removePhotoUrl"] ?>" data-callback="onDeletePhotoCallback" data-method="post" class="btn btn-danger btn-sm lw-remove-photo-btn remove-photo-btn lw-ajax-link-action" style="position: absolute;top: 0px;right: 0px;"><i class="far fa-trash-alt"></i></a>
			@endif
		</a>
	</div>
@endforeach
@else
<span class="no_image_found"><?= __tr('No images found...'); ?></span>
@endif