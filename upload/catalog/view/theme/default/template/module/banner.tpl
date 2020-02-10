<div id="banner<?php echo $module; ?>" class="carousel carousel-fade slide" data-ride="carousel" data-pause="false">
	<div class="carousel-inner">
		<?php foreach ($banners as $i => $banner) { ?>
			<div class="item<?php echo !$i ? ' active' : ''; ?>">
				<?php if ($banner['link']) { ?>
				<a href="<?php echo $banner['link']; ?>"><img class="img-rounded" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>"></a>
				<?php } else { ?>
				<img class="img-rounded" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>">
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>