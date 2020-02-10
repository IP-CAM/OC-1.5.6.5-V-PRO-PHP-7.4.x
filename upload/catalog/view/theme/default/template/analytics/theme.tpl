<?php echo $header; ?>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <div class="row">
     <div class="col-sm-12">

<!-- Theme Test 1.1-->
<style>
#content.content-analytics {
	max-width	:1200px;
	margin:20 auto;
}
#content.content-analytics .left {
	float:left;
	width:49%
}
#content.content-analytics .right {
	float:right;
	width:49%
}
#content.content-analytics .available {
	color:#2FCE00
}
#content.content-analytics .not-available {
	color:#FF3E3E
}
#content.content-analytics a {
	color: #38B0E3;
	text-decoration: none;
	
}
#content.content-analytics a:hover, #content.content-analytics a:active {
	outline: 0;
}
#content.content-analytics a:hover {
	text-decoration: underline;
	color: #005580;
}
#content.content-analytics h1, #content.content-analytics h2, #content.content-analytics h3, #content.content-analytics h4, #content.content-analytics h5, #content.content-analytics h6 {
	margin: 10px;
	font-family: inherit;
	font-weight: bold;
	line-height: 1;
	color: inherit;
	text-rendering: optimizelegibility;
}
#content.content-analytics h1 .highlight {
	font-weight:bold;
	color: #38B0E3;
	text-transform:capitalize;
	}
#content.content-analytics h2 {
	font-size: 30px;
	line-height: 40px;
	text-transform:capitalize
}
#content.content-analytics li {
	line-height: 20px;
	font-size: 14px;
}
#content.content-analytics li a, #content.content-analytics li {
	font-size: 14px;
}
#content.content-analytics hr {
	margin: 20px 0;
	border: 0;
	border-top: 1px solid #EEE;
	border-bottom: 1px solid white;
}
.created_by_dv {
	font-size:12px;
	display: table-cell;
	vertical-align:middle
}
.created_by_dv i {
	display:inline-block;
	padding-top:7px;
	margin-right:5px;
	float:left;
}
#content.content-analytics .about p{
	padding: 8px 35px 8px 35px;
	margin-bottom:10px ;
	font-size:14px;
	line-height:20px;
	}
#content.content-analytics .alert {
padding: 8px 35px 8px 14px;
margin-bottom: 20px;
text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
background-color: #FCF8E3;
border: 1px solid #FBEED5;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
color: #C09853;}
#content.content-analytics .alert-success{
	background-color: #DFF0D8;
border-color: #D6E9C6;
color: #000;
	}	
#about_text{
	display:none}
</style>
<div id="content" class="content-analytics"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?> <span class="highlight"><?php echo $template; ?></span></h1>
   <div class="alert alert-success"><strong>Below you will find all the tpl files, your theme carries. They will be sorted the way they are located in the folders of the theme. 
	Next to them you will see a green or red title - if green, that means, <span class="available">your template has a file for this page</span>, if red - then 
	<span class="not-available">the template doesn't have a custom tpl file, and it will look for one in the default theme</span>
  When you click on a link a <strong>pop up</strong> will show the page so you don't leave the test page. But if you must, there is a link next to it &rarr;.
  Below you will find all the tpl files, your theme carries. They will be sorted the way they are located in the folders of the theme. Next to them you will see a green or red title - if green, that means, <span class="available">your template has a file for this page</span>, if red - then <span class="not-available">the template doesn't have a custom tpl file, and it will look for one in the default theme</span>
  When you click on a link a <strong>pop up</strong> will show the page so you don't leave the test page. But if you must, there is a link next to it &rarr;.</div>
  
 <div style="clear:both"></div>

 <?php
$template = '<small class="available">' . $template . '</small>';
$default = '<small class="not-available">only default</small>';	 
?>
  <div style="clear:both"></div>
  <div class="left">
    <h2>Common</h2>
    <ul>
      <li><a href="<?php echo $home; ?>" class="colorbox" rel="colorbox" title="common/home.tpl">Home</a> <?php echo($template_home) ?  $template :  $default; ?> <a href="<?php echo $home; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $maintenance; ?>" class="colorbox" rel="colorbox" title="common/maintenance.tpl" >Maintenance</a> <?php echo($template_maintenance) ?  $template :  $default; ?> <a href="<?php echo $maintenance; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $common_success; ?>" class="colorbox" rel="colorbox" title="common/success.tpl" >Success</a> <?php echo($template_common_success) ?  $template :  $default; ?> <a href="<?php echo $common_success; ?>" target="_blank">&rarr;</a></li>
    </ul>
    <h2>Error</h2>
    <ul>
      <li><a href="<?php echo $not_found; ?>" class="colorbox" rel="colorbox" title="error/not_found.tpl" >Not found</a> <?php echo($template_not_found) ?  $template :  $default; ?> <a href="<?php echo $not_found; ?>" target="_blank">&rarr;</a></li>
    </ul>
    <h2>Product</h2>
    <ul>
      <li><a href="<?php echo $category; ?>">Category (see full list)</a> <?php echo($template_category) ?  $template :  $default; ?>
        <ul>
          <?php foreach ($categories as $category_1) { ?>
          <li><a href="<?php echo $category_1['href']; ?>" class="colorbox" rel="colorbox" title="product/category.tpl" ><?php echo $category_1['name']; ?></a> <a href="<?php echo  $category_1['href'] ?>" target="_blank">&rarr;</a>
            <?php if ($category_1['children'] && isset($_GET['category_full'])) { ?>
            <ul>
              <?php foreach ($category_1['children'] as $category_2) { ?>
              <li><a href="<?php echo $category_2['href']; ?>" class="colorbox" rel="colorbox" title="product/category.tpl"  ><?php echo $category_2['name']; ?></a> <a href="<?php echo  $category_2['href'] ?>" target="_blank">&rarr;</a>
                <?php if ($category_2['children']) { ?>
                <ul>
                  <?php foreach ($category_2['children'] as $category_3) { ?>
                  <li><a href="<?php echo $category_3['href']; ?>" class="colorbox" rel="colorbox" title="product/category.tpl"  ><?php echo $category_3['name']; ?></a> <a href="<?php echo  $category_3['href'] ?>" target="_blank">&rarr;</a></li>
                  <?php } ?>
                </ul>
                <?php } ?>
              </li>
              <?php } ?>
            </ul>
            <?php } ?>
          </li>
          <?php } ?>
        </ul>
      </li>
      <li><a href="<?php echo $product; ?>" class="colorbox" rel="colorbox" title="product/product.tpl">Product</a> <?php echo($template_category) ?  $template :  $default; ?> <a href="<?php echo  $product; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $manufacturer; ?>" class="colorbox" rel="colorbox" title="product/manufacturer_list.tpl">Manufacturer_list</a> <?php echo($template_manufacturer_list) ?  $template :  $default; ?> <a href="<?php echo  $manufacturer; ?>" target="_blank">&rarr;</a>
        <ul>
          <?php foreach ($manufacturers as $manufacturer) { ?>
          <li><a href="<?php echo $manufacturer['href']; ?>" class="colorbox" rel="colorbox" title="product/manufacturer_info.tpl"><?php echo $manufacturer['name']; ?></a> (manufacturer_info.tpl) <?php echo($template_manufacturer_info) ?  $template :  $default; ?> <a href="<?php echo  $manufacturer['href']; ?>" target="_blank">&rarr;</a></li>
          <?php } ?>
        </ul>
      </li>
      <li><a href="<?php echo $search; ?>" class="colorbox" rel="colorbox" title="product/search.tpl">Search</a> <?php echo($template_search) ?  $template :  $default; ?> <a href="<?php echo $search; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $special; ?>" class="colorbox" rel="colorbox" title="product/special.tpl">Special</a> <?php echo($template_special) ?  $template :  $default; ?> <a href="<?php echo  $special; ?>" target="_blank">&rarr;</a></li>
            <li><a href="<?php echo $compare; ?>" class="colorbox" rel="colorbox" title="product/compare.tpl">Compare</a> <?php echo($template_compare) ?  $template :  $default; ?> <a href="<?php echo  $compare; ?>" target="_blank">&rarr;</a></li>
    </ul>
    <h2>Checkout</h2>
    <ul>
      <li><a href="<?php echo $cart; ?>" class="colorbox" rel="colorbox" title="checkout/cart.tpl">Cart</a> <?php echo($template_cart) ?  $template :  $default; ?> <a href="<?php echo  $cart; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $checkout; ?>" class="colorbox" rel="colorbox" title="checkout/checkout.tpl">Checkout</a> <?php echo($template_checkout) ?  $template :  $default; ?> <a href="<?php echo  $checkout; ?>" target="_blank">&rarr;</a>
        <ul>
          <li>login <?php echo($template_checkout_login) ?  $template :  $default; ?></li>
          <li>guest <?php echo($template_checkout_guest) ?  $template :  $default; ?></li>
          <li>guest_shipping <?php echo($template_checkout_guest_shipping) ?  $template :  $default; ?></li>
          <hr />
          <li>register <?php echo($template_checkout_register) ?  $template :  $default; ?></li>
          <li>shipping_address <?php echo($template_checkout_shipping_address) ?  $template :  $default; ?></li>
          <li>payment_address <?php echo($template_checkout_payment_address) ?  $template :  $default; ?></li>
          <li>shipping_method <?php echo($template_checkout_shipping_method) ?  $template :  $default; ?></li>
          <li>payment_method <?php echo($template_checkout_payment_method) ?  $template :  $default; ?></li>
          <li>confirm <?php echo($template_checkout_confirm) ?  $template :  $default; ?></li>
        </ul>
      </li>
    </ul>
    <h2>Payment</h2>
    <ul>
      <?php foreach ($payments as $payment){ ?>
      <li> <?php echo $payment['name'] . ' ' ; 
         echo ($payment['template']) ?  $template :  $default ;
         ?> </li>
      <?php } ?>
    </ul>
  </div>
  <div class="right">
    <h2>Account</h2>
    <ul>
      <li><a href="<?php echo $account_login; ?>" class="colorbox" rel="colorbox" title="account/login.tpl" >Login</a> <?php echo($template_account_login) ?  $template :  $default; ?> <a href="<?php echo  $account_login; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $account_register; ?>" class="colorbox" rel="colorbox"  title="account/register.tpl" >Register</a> <?php echo($template_account_register) ?  $template :  $default; ?> <a href="<?php echo  $account_register; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $account_forgotten; ?>" class="colorbox" rel="colorbox"  title="account/forgotten.tpl">Forgotten</a> <?php echo($template_account_forgotten) ?  $template :  $default; ?> <a href="<?php echo  $account_forgotten; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $account_success; ?>" class="colorbox" rel="colorbox"  title="common/success.tpl">Success</a> <?php echo($template_common_success) ?  $template :  $default; ?> <a href="<?php echo  $account_success; ?>" target="_blank">&rarr;</a></li>
      <hr />
      <li><a href="<?php echo $account_account; ?>" class="colorbox" rel="colorbox"  title="account/account.tpl" >Account</a> <?php echo($template_account_account) ?  $template :  $default; ?> <a href="<?php echo  $account_account; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $account_edit; ?>" class="colorbox" rel="colorbox"  title="account/edit.tpl" >Edit</a> <?php echo($template_account_edit) ?  $template :  $default; ?> <a href="<?php echo  $account_edit; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $account_password; ?>" class="colorbox" rel="colorbox" title="account/password.tpl" >Password</a> <?php echo($template_account_password) ?  $template :  $default; ?> <a href="<?php echo  $account_password; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $account_address_list; ?>" class="colorbox" rel="colorbox" title="account/address_list.tpl" >Address list</a> <?php echo($template_account_address_list) ?  $template :  $default; ?> <a href="<?php echo  $account_address_list; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $account_address_form; ?>" class="colorbox" rel="colorbox" title="account/address_form.tpl" >Address form</a> <?php echo($template_account_address_form) ?  $template :  $default; ?> <a href="<?php echo  $account_address_form; ?>" target="_blank">&rarr;</a></li>
      <hr />
      <li><a href="<?php echo $order_list; ?>" class="colorbox" rel="colorbox" title="account/order_list.tpl" >Order_list</a> <?php echo($template_order_list) ?  $template :  $default; ?> <a href="<?php echo  $order_list; ?>" target="_blank">&rarr;</a>
        <ul>
          <li><a href="<?php echo $order_info; ?>" class="colorbox" rel="colorbox" title="account/order_info.tpl" >Order_info</a> <?php echo($template_order_info) ?  $template :  $default; ?> <a href="<?php echo  $order_info; ?>" target="_blank">&rarr;</a></li>
        </ul>
      </li>
      <li><a href="<?php echo $download; ?>" class="colorbox" rel="colorbox" title="account/download.tpl" >Download</a> <?php echo($template_download) ?  $template :  $default; ?> <a href="<?php echo  $download; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $reward; ?>" class="colorbox" rel="colorbox" title="account/reward.tpl">Reward</a> <?php echo($template_reward) ?  $template :  $default; ?> <a href="<?php echo  $reward; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $return_list; ?>" class="colorbox" rel="colorbox" title="account/return_list.tpl" >Return_list</a> <?php echo($template_return_list) ?  $template :  $default; ?> <a href="<?php echo  $return_list; ?>" target="_blank">&rarr;</a>
        <ul>
          <li><a href="<?php echo $return_info; ?>" class="colorbox" rel="colorbox" title="account/return_info.tpl" >Return_info</a> <?php echo($template_return_info) ?  $template :  $default; ?> <a href="<?php echo  $return_info; ?>" target="_blank">&rarr;</a></li>
          <li><a href="<?php echo $return_form; ?>" class="colorbox" rel="colorbox" title="account/return_form.tpl" >Return_form</a> <?php echo($template_return_form) ?  $template :  $default; ?> <a href="<?php echo  $return_form; ?>" target="_blank">&rarr;</a></li>
        </ul>
      </li>
      <li><a href="<?php echo $account_transaction; ?>" class="colorbox" rel="colorbox" title="account/transaction.tpl" >Transaction</a> <?php echo($template_account_transaction) ?  $template :  $default; ?> <a href="<?php echo  $account_transaction; ?>" target="_blank">&rarr;</a></li>
      <hr />
      <li><a href="<?php echo $wishlist; ?>" class="colorbox" rel="colorbox" title="account/wishlist.tpl">Wishlist</a> <?php echo($template_wishlist) ?  $template :  $default; ?> <a href="<?php echo  $wishlist; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $voucher; ?>" class="colorbox" rel="colorbox" title="account/voucher.tpl" >Voucher</a> <?php echo($template_voucher) ?  $template :  $default; ?> <a href="<?php echo  $voucher; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $newsletter; ?>" class="colorbox" rel="colorbox" title="account/newsletter.tpl">Newsletter</a> <?php echo($template_newsletter) ?  $template :  $default; ?> <a href="<?php echo  $newsletter; ?>" target="_blank">&rarr;</a></li>
    </ul>
    <h2>Affiliate</h2>
    <ul>
      <li><a href="<?php echo $affiliate_login; ?>" class="colorbox" rel="colorbox"  title="affiliate/login.tpl" >Login</a> <?php echo($template_affiliate_login) ?  $template :  $default; ?> <a href="<?php echo  $affiliate_login; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $affiliate_register; ?>" class="colorbox" rel="colorbox" title="affiliate/register.tpl" >Register</a> <?php echo($template_affiliate_register) ?  $template :  $default; ?> <a href="<?php echo  $affiliate_register; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $affiliate_forgotten; ?>" class="colorbox" rel="colorbox" title="affiliate/forgotten.tpl" >Forgotten</a> <?php echo($template_affiliate_forgotten) ?  $template :  $default; ?> <a href="<?php echo  $affiliate_forgotten; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $affiliate_success; ?>" class="colorbox" rel="colorbox" title="common/success.tpl" >Success</a> <?php echo($template_common_success) ?  $template :  $default; ?> <a href="<?php echo  $affiliate_success; ?>" target="_blank">&rarr;</a></li>
      <hr />
      
      <li><a href="<?php echo $affiliate_account; ?>" class="colorbox" rel="colorbox" title="affiliate/account.tpl" >Account</a> <?php echo($template_affiliate_account) ?  $template :  $default; ?> <a href="<?php echo  $affiliate_account; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $affiliate_edit; ?>" class="colorbox" rel="colorbox" title="affiliate/edit.tpl" >Edit</a> <?php echo($template_affiliate_edit) ?  $template :  $default; ?> <a href="<?php echo  $affiliate_edit; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $affiliate_password; ?>" class="colorbox" rel="colorbox" title="affiliate/password.tpl" >Password</a> <?php echo($template_affiliate_password) ?  $template :  $default; ?> <a href="<?php echo  $affiliate_password; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $affiliate_payment; ?>" class="colorbox" rel="colorbox" title="affiliate/payment.tpl" >Payment</a> <?php echo($template_affiliate_payment) ?  $template :  $default; ?> <a href="<?php echo  $affiliate_payment; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $affiliate_tracking; ?>" class="colorbox" rel="colorbox" title="affiliate/tracking.tpl" >Tracking</a> <?php echo($template_affiliate_tracking) ?  $template :  $default; ?> <a href="<?php echo  $affiliate_tracking; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $affiliate_transaction; ?>" class="colorbox" rel="colorbox" title="affiliate/transaction.tpl" >Transaction</a> <?php echo($template_affiliate_transaction) ?  $template :  $default; ?> <a href="<?php echo  $affiliate_transaction; ?>" target="_blank">&rarr;</a></li>
    </ul>
    <h2>Mail</h2>
    <ul>
      <li>Order <?php echo($template_mail_order) ?  $template :  $default; ?></li>
      <li>Voucher <?php echo($template_mail_voucher) ?  $template :  $default; ?></li>
    </ul>
    <h2>Information</h2>
    <ul>
      <li>Information <?php echo($template_information) ?  $template :  $default; ?>
        <ul>
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>" class="colorbox" rel="colorbox" title="information/information.tpl" ><?php echo $information['title']; ?></a> <a href="<?php echo $information['href']; ?>" target="_blank">&rarr;</a></li>
          <?php } ?>
        </ul>
      </li>
      <li><a href="<?php echo $contact; ?>" class="colorbox" rel="colorbox" title="information/contact.tpl" >Contact</a> <?php echo($template_contact) ?  $template :  $default; ?> <a href="<?php echo  $contact; ?>" target="_blank">&rarr;</a></li>
      <li><a href="<?php echo $sitemap; ?>" class="colorbox" rel="colorbox" title="information/sitemap.tpl" >Sitemap</a> <?php echo($template_sitemap) ?  $template :  $default; ?> <a href="<?php echo  $sitemap; ?>" target="_blank">&rarr;</a></li>
    </ul>
    <h2>Module</h2>
    <ul>
      <?php foreach ($modules as $module){ ?>
      <li> <?php echo $module['name'] . ' ' ; 
         echo ($module['template']) ?  $template :  $default ;
         ?> </li>
      <?php } ?>
    </ul>
    <?php foreach ($others as $title => $other){ ?>
    <h2><?php echo $title; ?></h2>
    <ul>
      <?php foreach ($other as $other_extention){ ?>
      <li> <?php echo $other_extention['name'] . ' ' ; 
         echo ($other_extention['template']) ?  $template :  $default ;
         ?> </li>
      <?php } ?>
    </ul>
    <?php } ?>
  </div>
  <script type="text/javascript"><!--
<?php $versions = array('1.5.6','1.5.6.1', '1.5.6.2', '1.5.6.3', '1.5.6.4', '1.5.6.5'); 
	if(in_array(VERSION, $versions)){ ?> 
$('.colorbox').fancybox({
	
	opacity: 0.5,
	width:"100%", 
    height:"100%",
	iframe:true, 
	
	onLoad:function() {
		$('#colorbox').css('top', '0')
        $('html, body').css('overflow', 'hidden'); // page scrollbars off
		
    }, 
    onClosed:function() {
        $('html, body').css('overflow', ''); // page scrollbars on
    }
});
$('.trigger').click(function(){
	$('#'+$(this).attr('rel')).toggle()
	return false
	
})
<?php } ?>
//--></script> 
         </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>