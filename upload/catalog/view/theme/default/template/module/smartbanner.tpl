<div id="smartbanner<?php echo $module; ?>" class="<?php echo $custom_style; ?>">
  <?php foreach ($banners as $banner) { ?>
  <?php if ($banner['link']) { ?>
  <div><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></div>
  <?php } else { ?>
  <div><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></div>
  <?php } ?>
  <?php } ?>
</div>