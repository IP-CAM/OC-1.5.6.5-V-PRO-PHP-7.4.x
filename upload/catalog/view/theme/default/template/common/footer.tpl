<br />
<footer>
<div class="outerfooter">
  <div class="container">
	<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-3">
	  <h5><i class="fa fa-anchor"></i>&nbsp; <?php echo $text_service; ?></h5>
	  <ul class="list-unstyled">
	   <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
	   <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
	   <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
	  </ul>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
	  <h5><i class="fa fa-gift"></i>&nbsp; <?php echo $text_extra; ?></h5>
	  <ul class="list-unstyled">
	   <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
	   <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
	   <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
	   <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
	  </ul>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
	  <h5><i class="fa fa-user"></i>&nbsp; <?php echo $text_account; ?></h5>
	  <ul class="list-unstyled">
	   <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
	   <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
	   <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
	   <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
	  </ul>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
	  <h5><i class="fa fa-info-circle"></i>&nbsp; <?php echo $text_information; ?></h5>
	   <ul class="list-unstyled">
	    <?php foreach ($informations as $information) { ?>
	   <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
	   <?php } ?>
	   </ul>
	</div>
  </div>
    <div><hr /><?php echo $powered; ?><hr /></div>
  <div id="powered"><a data-toggle="tooltip" title="Ernie's OpenCart v.1.5.6.5 V-PRO" href="http://www.opencart.li" target="_blank">Ernie's OpenCart v.1.5.6.5 LIGHT + V-PRO &#169; Homepage</a></div>
</div>
</div>
</footer>
</body></html>
