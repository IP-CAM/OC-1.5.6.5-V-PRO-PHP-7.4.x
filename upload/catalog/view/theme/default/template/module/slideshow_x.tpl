<div class="col-md-12">
    <div id="slideshow<?php echo $module; ?>" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php 
            $i = 0;
            foreach ($banners as $banner) { ?>
                <div class="item <?php if ($i == 0) { echo "active"; } ?>">
                    <?php if ($banner['link']) { ?>
                        <a href="<?php echo $banner['link']; ?>">
                            <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
                        </a>
                    <?php } else { ?>
                        <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
                    <?php } ?>
                </div>
             <?php $i++; } ?>
        </div>
        <a class="left carousel-control" href="#slideshow<?php echo $module; ?>" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#slideshow<?php echo $module; ?>" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {        
	$('#slideshow<?php echo $module; ?>').carousel()
});
</script>
<!-- Uncomment the code below and delete everything above if you would rather use nivo slider than bootstrap carousel -->
<!--<div class="col-md-12 slideshow theme-default">
    <div id="slideshow<?php echo $module; ?>" class="nivoSlider">
        <?php foreach ($banners as $banner) {
            if ($banner['link']) { ?>
                <a href="<?php echo $banner['link']; ?>">
                    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
                </a>
            <?php } else { ?>
                <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
            <?php }
         } ?>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#slideshow<?php echo $module; ?>').nivoSlider({controlNav: false, effect: 'fade'});
});
</script>-->