<div id="slideshow<?php echo $module; ?>" class="carousel slide spacer" data-ride="carousel" data-interval="5000">
	<ol class="carousel-indicators hidden">
		<?php foreach ($banners as $i => $banner) { ?>
			<li data-target="#slideshow<?php echo $module; ?>" data-slide-to="<?php echo $i; ?>"<?php echo !$i ? ' class="active"' : ''; ?>></li>
		<?php } ?>
	</ol>
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
<p>