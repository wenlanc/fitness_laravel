@if(!__isEmpty($likePhotosData))
@foreach($likePhotosData as $key => $photo)
	<div  class="col" style="padding:0.75rem;">
		<a href='javascript:showDetailViewPhoto(<?= json_encode($photo, JSON_HEX_QUOT | JSON_HEX_APOS)?>)'><img class="lw-user-photo lw-lazy-img" style="margin:0px;border-radius: 10px;width:100%;height:auto;min-height:130px;flex: 1 1 auto;" data-img-index="<?= $key; ?>" src="<?= imageOrNoImageAvailable($photo['image_url']); ?>" data-src="<?= imageOrNoImageAvailable($photo['image_url']); ?>"></a>
	</div>	
@endforeach
@else
<span class="no_image_found"><?= __tr('No images found...'); ?></span>
@endif