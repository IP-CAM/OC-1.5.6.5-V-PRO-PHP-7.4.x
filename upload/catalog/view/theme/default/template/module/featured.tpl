<p>&nbsp;</p>
<div style="text-align:center;margin:10px 0 10px 0;"><img class="img-responsive center" src="catalog/view/theme/default/image/colorline.jpg" alt="Our Favourites" width="1512" height="10" title="Our Favourites" /></a></div>
<h3><?php echo $heading_title; ?></h3>
<div class="row">
  <?php foreach ($products as $product) { ?>
     <div class="product-layout col-lg-3 col-md-4 col-sm-6 col-xs-6">
<!-- 	<div class="product-layout col-lg-3 col-md-4 col-sm-6 col-xs-12"> -->
    <div class="product-thumb transition rounded"> 
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
      <div class="caption"style="min-height:180px;>
      <a href="<?php echo $product['href']; ?>"><strong><?php echo $product['name']; ?></strong></a>
      <p><?php echo $product['description']; ?></p>
        <div class="rating">
          <?php for ($i = 1; $i <= 5; $i++) { ?>
          <?php if ($product['rating'] < $i) { ?>
          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } else { ?>
          <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } ?>
          <?php } ?>
        </div>
        <?php if ($product['price']) { ?>
        <p class="price">
          <?php if (!$product['special']) { ?>
          <strong><?php echo $product['price']; ?></strong>
          <?php } else { ?>
          <span class="price-new"><strong><?php echo $product['special']; ?></strong></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>
          <?php if ($product['tax']) { ?>
          <?php if( $tax_status || $status == false) { ?><span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span><?php } ?>
          <?php } ?>
        </p>
        <?php } ?>
      </div>
      <div class="button-group">
        <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
      </div>
    </div>
      </div>
 <?php } ?>
</div>
<p>&nbsp;</p>
<div style="text-align:center; margin:10px 13px 15px 13px;"><img class="img-responsive center" src="catalog/view/theme/default/image/colorline.jpg" alt="Our Favourites" width="1512" height="10" title="Our Favourites" /></a></div>
</div>