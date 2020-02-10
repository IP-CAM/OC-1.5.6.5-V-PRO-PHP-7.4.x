<footer>
	<div class="container">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-3">
				<h5 class="media-heading"><strong><?php echo $text_service; ?></strong></h5>
				<ul>
					<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
					<li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
					<li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
				</ul>
			</div>
			
			<div class="col-xs-6 col-sm-6 col-md-3">
				<h5 class="media-heading"><strong><?php echo $text_extra; ?></strong></h5>
				<ul>
					<li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
					<li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
					<li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
					<li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
				</ul>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-3">
				<h5 class="media-heading"><strong><?php echo $text_account; ?></strong></h5>
				<ul>
					<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
					<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
					<li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
					<li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
				</ul>
			</div>
			<?php if ($informations) { ?>
			<div class="col-xs-6 col-sm-6 col-md-3">
					<h5 class="media-heading"><strong><?php echo $text_information; ?></strong></h5>
					<ul>
						<?php foreach ($informations as $information) { ?>
						<li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>			
		</div>
	</div>
<div>
<hr>
    <div><?php echo $powered; ?></div>
<div class="clearfix"></div>
</footer></div>
</body></html>