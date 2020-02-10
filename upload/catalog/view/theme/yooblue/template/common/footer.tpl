 

<footer class="container">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-3">
				<h5><i class="fa fa-info"></i> <?php echo $text_information; ?></h5>
				<ul class="list-unstyled">
				<?php foreach ($informations as $information) { ?>
				<li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
				<?php } ?>
				<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
				</ul>
			</div>
			
			<div class="col-xs-6 col-sm-6 col-md-3">
				<h5><i class="fa fa-gift"></i> <?php echo $text_extra; ?></h5>
				<ul class="list-unstyled">
					<li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
					<li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
					<li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
					<li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
					<li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
				</ul>
			</div>

			<div class="col-xs-6 col-sm-6 col-md-3">
				<h5><i class="fa fa-user"></i> <?php echo $text_account; ?></h5>
				<ul class="list-unstyled">
					<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
					<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
					<li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
					<li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
					<li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
				</ul>
			</div>
	
		<div class="col-xs-6 col-sm-6 col-md-3">
		<h5><i class="fa fa-users"></i> Contact Us !</h5>
		<ul class="list-unstyled">
			<li>123-456-7890</li>
			<li>info@demostore</li>
			<li><a href="#"><i class="fa fa-facebook"></i></a></li>
			<li><a href="#"><i class="fa fa-twitter"></i></a></li>
			<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
		</ul>
	</div>
</div>
</footer>

</div>
</div>
</div>
</div>
<div class="copyright">
	<div class="container">
		<div class="row">
    	<?php echo $powered; ?><br /> &nbsp;Designed by <a href="https://www.yoocart.net">YOOCART</a>
    	</div>
    </div>
</div>
</body></html>