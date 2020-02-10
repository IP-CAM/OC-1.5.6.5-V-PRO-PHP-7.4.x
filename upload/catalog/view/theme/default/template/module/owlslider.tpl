<?php if( count($banners) ) { ?>
<?php $id = rand(1,10);?>
     <div class="row">
	            <div class="span12">
              <div id="lb-owl-demo<?php echo $id;?>" class="owl-carousel">
				<?php foreach ($banners as $i => $banner) {  ?>
                <div class="item">
                	<?php if ($banner['link']) { ?>
                    <a href="<?php echo $banner['link']; ?>" title="<?php echo $banner['title']; ?>">
                    	<?php if($lazyload == 1) { ?>
                        <img class="lazyOwl" data-src="<?php echo $banner['thumb']; ?>" alt="<?php echo $banner['title']; ?>">
                        <?php } else { ?>
                        <img src="<?php echo $banner['thumb']; ?>" alt="<?php echo $banner['title']; ?>">
                        <?php } ?>
                    </a>
                    <?php } else { ?>
                    	<?php if($lazyload == 1) { ?>
                        <img class="lazyOwl" data-src="<?php echo $banner['thumb']; ?>" alt="<?php echo $banner['title']; ?>">
                        <?php } else { ?>
                        <img src="<?php echo $banner['thumb']; ?>" alt="<?php echo $banner['title']; ?>">
                        <?php } ?>
                    <?php } ?>
                </div>
				<?php } ?>
              </div>
            </div>
          </div>
  <style>
    #lb-owl-demo<?php echo $id;?> .item img {
		margin-top:20px;
        display: block;
        width: 100%!important;
        height: auto;
    }
    </style>
	

    <script>
    $(document).ready(function() {
      $("#lb-owl-demo<?php echo $id;?>").owlCarousel({

	  singleItem : true,
	  responsive : <?php if($responsive == 1) { ?>true<?php } else { ?>false<?php } ?>,	
	  autoHeight : <?php if($autoheight == 1) { ?>true<?php } else { ?>false<?php } ?>,	
	  autoPlay : <?php if($autoplay == 1) { ?>true<?php } else { ?>false<?php } ?>,	
	  stopOnHover : <?php if($stoponhover == 1) { ?>true<?php } else { ?>false<?php } ?>,
      transitionStyle : "<?php echo $transition; ?>",
	  pagination : <?php if($pagination == 1) { ?>true<?php } else { ?>false<?php } ?>,
	  paginationNumbers : <?php if($pagination_no == 1) { ?>true<?php } else { ?>false<?php } ?>,
	  navigation : <?php if($navigation == 1) { ?>true<?php } else { ?>false<?php } ?>,
	  <?php if(!empty($navigation_text)) {  ?>
	  navigationText : <?php echo $navigation_text; ?>,
	  <?php } ?>
	  rewindNav : <?php if($rewindnav == 1) { ?>true<?php } else { ?>false<?php } ?>,
	  <?php if(!empty($rewind_speed)) {  ?>
	  rewindSpeed : <?php echo $rewind_speed; ?>,
	  <?php } ?>
	  <?php if(!empty($slide_speed)) {  ?>
	  slideSpeed : <?php echo $slide_speed; ?>,
	  <?php } ?>
	  <?php if(!empty($pagination_speed)) {  ?>
	  paginationSpeed : <?php echo $pagination_speed; ?>,
	  <?php } ?>
	  lazyLoad : <?php if($lazyload == 1) { ?>true<?php } else { ?>false<?php } ?>,
	  	
      
      });
    });
    </script>
<?php } ?>