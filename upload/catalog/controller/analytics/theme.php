<?php  
class ControllerAnalyticsTheme extends Controller {
	public function index() {
	$this->document->setTitle($this->config->get('config_title'));
	$this->document->setDescription($this->config->get('config_meta_description'));

	$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox.js');
	$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');


	$this->data['heading_title'] = 'ThemeTest of ';
	$this->data['template'] = $this->config->get('config_template');
	//Common
	$this->data['home'] = $this->url->link('common/home');	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
	$this->data['template_home'] = true;
	}else{
	$this->data['template_home'] = false;
	}
	$this->data['maintenance'] = $this->url->link('common/maintenance');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/maintenance.tpl')) {
	$this->data['template_maintenance'] = true;
	}else{
	$this->data['template_maintenance'] = false;
	}
	$this->data['common_success'] = $this->url->link('common/success');	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
	$this->data['template_common_success'] = true;
	}else{
	$this->data['template_common_success'] = false;
	} 
	//Error
	$this->data['not_found'] = $this->url->link('error/not_found');	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
	$this->data['template_not_found'] = true;
	}else{
	$this->data['template_not_found'] = false;
	} 	
	//Product
	//product-category
	$this->data['category'] = $this->url->link('analytics/theme', 'category_full');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
	$this->data['template_category'] = true;
	}else{
	$this->data['template_category'] = false;
	}
	
	$this->load->model('catalog/category');
	$this->load->model('catalog/product');
	
	$this->data['categories'] = array();
	
	$categories_1 = $this->model_catalog_category->getCategories(0);
	
	foreach ($categories_1 as $category_1) {
	$level_2_data = array();
	
	$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);
	
	foreach ($categories_2 as $category_2) {
	$level_3_data = array();
	
	$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);
	
	foreach ($categories_3 as $category_3) {
	$level_3_data[] = array(
	'name' => $category_3['name'],
	'href' => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id'])
	);
	}
	
	$level_2_data[] = array(
	'name'     => $category_2['name'],
	'children' => $level_3_data,
	'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'])	
	);	
	}
	
	$this->data['categories'][] = array(
	'name'     => $category_1['name'],
	'children' => $level_2_data,
	'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'])
	);
	$category_id = $category_1['category_id'];
	}
	
	//product-product
	$data = array(
	'filter_category_id' => $category_id, 
	);
	
	
	$results = $this->model_catalog_product->getProducts($data);
	
	foreach ($results as $result) {
	
	$this->data['product'] = $this->url->link('product/product', '&product_id=' . $result['product_id']);
	break;
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/product.tpl')) {
	$this->data['template_product'] = true;
	}else{
	$this->data['template_product'] = false;
	}
	//product-manufacturer
	$this->data['manufacturer'] = $this->url->link('product/manufacturer');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer_list.tpl')) {
	$this->data['template_manufacturer_list'] = true;
	}else{
	$this->data['template_manufacturer_list'] = false;
	}
	$this->load->model('catalog/manufacturer');
	$results = $this->model_catalog_manufacturer->getManufacturers();
	
	foreach ($results as $result) {
	$this->data['manufacturers'][] = array(
	'name' => $result['name'],
	'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
	);
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer_info.tpl')) {
	$this->data['template_manufacturer_info'] = true;
	}else{
	$this->data['template_manufacturer_info'] = false;
	}
	
	$this->data['search'] = $this->url->link('product/search', 'filter_name=a');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/search.tpl')) {
	$this->data['template_search'] = true;
	}else{
	$this->data['template_search'] = false;
	}
	$this->data['special'] = $this->url->link('product/special');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/special.tpl')) {
	$this->data['template_special'] = true;
	}else{
	$this->data['template_special'] = false;
	}
	$this->data['compare'] = $this->url->link('product/compare');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/compare.tpl')) {
	$this->data['template_compare'] = true;
	}else{
	$this->data['template_compare'] = false;
	}
	
	//Checkout
	$this->data['cart'] = $this->url->link('checkout/cart');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/cart.tpl')) {
	$this->data['template_cart'] = true;
	}else{
	$this->data['template_cart'] = false;
	}
	$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout.tpl')) {
	$this->data['template_checkout'] = true;
	}else{
	$this->data['template_checkout'] = false;
	}
	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/login.tpl')) {
	$this->data['template_checkout_login'] = true;
	}else{
	$this->data['template_checkout_login'] = false;
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/guest.tpl')) {
	$this->data['template_checkout_guest'] = true;
	}else{
	$this->data['template_checkout_guest'] = false;
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/guest_shipping.tpl')) {
	$this->data['template_checkout_guest_shipping'] = true;
	}else{
	$this->data['template_checkout_guest_shipping'] = false;
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/register.tpl')) {
	$this->data['template_checkout_register'] = true;
	}else{
	$this->data['template_checkout_register'] = false;
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/shipping_address.tpl')) {
	$this->data['template_checkout_shipping_address'] = true;
	}else{
	$this->data['template_checkout_shipping_address'] = false;
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/payment_address.tpl')) {
	$this->data['template_checkout_payment_address'] = true;
	}else{
	$this->data['template_checkout_payment_address'] = false;
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/shipping_method.tpl')) {
	$this->data['template_checkout_shipping_method'] = true;
	}else{
	$this->data['template_checkout_shipping_method'] = false;
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/payment_method.tpl')) {
	$this->data['template_checkout_payment_method'] = true;
	}else{
	$this->data['template_checkout_payment_method'] = false;
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/confirm.tpl')) {
	$this->data['template_checkout_confirm'] = true;
	}else{
	$this->data['template_checkout_confirm'] = false;
	}
	
	//Payment
	$this->data['payments'] = array();
	$dir    = DIR_TEMPLATE . 'default/template/payment';
	$payments = scandir($dir, 1);
	foreach($payments as $payment) {
	if(strpos($payment, '.tpl')){
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/' . $payment)) {
	$payment_template = true;
	}else{
	$payment_template = false;
	}
	
	$this->data['payments'][] = array(
	'name' => substr($payment, 0, -4),
	'template' => $payment_template
	);
	}
	}
	//Information
	$this->load->model('catalog/information');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
	$this->data['template_information'] = true;
	}else{
	$this->data['template_information'] = false;
	}	
	$this->data['informations'] = array();
	
	foreach ($this->model_catalog_information->getInformations() as $result) {
	$this->data['informations'][] = array(
	'title' => $result['title'],
	'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id']) 
	);
	}
	$this->data['contact'] = $this->url->link('information/contact');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/contact.tpl')) {
	$this->data['template_contact'] = true;
	}else{
	$this->data['template_contact'] = false;
	}
	$this->data['sitemap'] = $this->url->link('information/sitemap');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/sitemap.tpl')) {
	$this->data['template_sitemap'] = true;
	}else{
	$this->data['template_sitemap'] = false;
	}
	
	//Account
	$this->data['account_login'] = $this->url->link('account/login');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/login.tpl')) {
	$this->data['template_account_login'] = true;
	}else{
	$this->data['template_account_login'] = false;
	}
	$this->data['account_register'] = $this->url->link('account/register');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/register.tpl')) {
	$this->data['template_account_register'] = true;
	}else{
	$this->data['template_account_register'] = false;
	}
	$this->data['account_forgotten'] = $this->url->link('account/forgotten');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/forgotten.tpl')) {
	$this->data['template_account_forgotten'] = true;
	}else{
	$this->data['template_account_forgotten'] = false;
	}
	$this->data['account_success'] = $this->url->link('account/success');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/success.tpl')) {
	$this->data['template_account_success'] = true;
	}else{
	$this->data['template_account_success'] = false;
	}

	$this->data['account_account'] = $this->url->link('account/account');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
	$this->data['template_account_account'] = true;
	}else{
	$this->data['template_account_account'] = false;
	}
	$this->data['account_edit'] = $this->url->link('account/edit');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/edit.tpl')) {
	$this->data['template_account_edit'] = true;
	}else{
	$this->data['template_account_edit'] = false;
	}
	$this->data['account_password'] = $this->url->link('account/password');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/password.tpl')) {
	$this->data['template_account_password'] = true;
	}else{
	$this->data['template_account_password'] = false;
	}
	$this->data['account_address_list'] = $this->url->link('account/address');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/address_list.tpl')) {
	$this->data['template_account_address_list'] = true;
	}else{
	$this->data['template_account_address_list'] = false;
	}
	$this->data['account_address_form'] = $this->url->link('account/address/update', 'address_id=4');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/address_form.tpl')) {
	$this->data['template_account_address_form'] = true;
	}else{
	$this->data['template_account_address_form'] = false;
	}
	
	$this->data['order_list'] = $this->url->link('account/order_list');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_list.tpl')) {
	$this->data['template_order_list'] = true;
	}else{
	$this->data['template_order_list'] = false;
	}
	$this->data['order_info'] = $this->url->link('account/order_info');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_info.tpl')) {
	$this->data['template_order_info'] = true;
	}else{
	$this->data['template_order_info'] = false;
	}
	$this->data['download'] = $this->url->link('account/download');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/download.tpl')) {
	$this->data['template_download'] = true;
	}else{
	$this->data['template_download'] = false;
	}
	$this->data['reward'] = $this->url->link('account/reward');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/reward.tpl')) {
	$this->data['template_reward'] = true;
	}else{
	$this->data['template_reward'] = false;
	}	

	$this->data['return_list'] = $this->url->link('account/return');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/return_list.tpl')) {
	$this->data['template_return_list'] = true;
	}else{
	$this->data['template_return_list'] = false;
	}	
	$this->data['return_info'] = $this->url->link('account/return_info');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/return_info.tpl')) {
	$this->data['template_return_info'] = true;
	}else{
	$this->data['template_return_info'] = false;
	}
	$this->data['return_form'] = $this->url->link('account/return_form');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/return_form.tpl')) {
	$this->data['template_return_form'] = true;
	}else{
	$this->data['template_return_form'] = false;
	}	
	$this->data['account_transaction'] = $this->url->link('account/transaction');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/transaction.tpl')) {
	$this->data['template_account_transaction'] = true;
	}else{
	$this->data['template_account_transaction'] = false;
	}	
	
	$this->data['wishlist'] = $this->url->link('account/wishlist');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/wishlist.tpl')) {
	$this->data['template_wishlist'] = true;
	}else{
	$this->data['template_wishlist'] = false;
	}
	$this->data['voucher'] = $this->url->link('account/voucher');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/voucher.tpl')) {
	$this->data['template_voucher'] = true;
	}else{
	$this->data['template_voucher'] = false;
	}
	$this->data['newsletter'] = $this->url->link('account/newsletter');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/newsletter.tpl')) {
	$this->data['template_newsletter'] = true;
	}else{
	$this->data['template_newsletter'] = false;
	}
	
	//Affiliate	
	$this->data['affiliate_login'] = $this->url->link('affiliate/login');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/login.tpl')) {
	$this->data['template_affiliate_login'] = true;
	}else{
	$this->data['template_affiliate_login'] = false;
	}
	$this->data['affiliate_register'] = $this->url->link('affiliate/register');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/register.tpl')) {
	$this->data['template_affiliate_register'] = true;
	}else{
	$this->data['template_affiliate_register'] = false;
	}
	$this->data['affiliate_forgotten'] = $this->url->link('affiliate/forgotten');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/forgotten.tpl')) {
	$this->data['template_affiliate_forgotten'] = true;
	}else{
	$this->data['template_affiliate_forgotten'] = false;
	}
	
	$this->data['affiliate_success'] = $this->url->link('affiliate/success');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/success.tpl')) {
	$this->data['template_affiliate_success'] = true;
	}else{
	$this->data['template_affiliate_success'] = false;
	}

	$this->data['affiliate_account'] = $this->url->link('affiliate/account');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/account.tpl')) {
	$this->data['template_affiliate_account'] = true;
	}else{
	$this->data['template_affiliate_account'] = false;
	}
	$this->data['affiliate_edit'] = $this->url->link('affiliate/edit');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/edit.tpl')) {
	$this->data['template_affiliate_edit'] = true;
	}else{
	$this->data['template_affiliate_edit'] = false;
	}	
	
	$this->data['affiliate_password'] = $this->url->link('affiliate/password');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/password.tpl')) {
	$this->data['template_affiliate_password'] = true;
	}else{
	$this->data['template_affiliate_password'] = false;
	}
	$this->data['affiliate_payment'] = $this->url->link('affiliate/payment');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/payment.tpl')) {
	$this->data['template_affiliate_payment'] = true;
	}else{
	$this->data['template_affiliate_payment'] = false;
	}
	$this->data['affiliate_tracking'] = $this->url->link('affiliate/tracking');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/tracking.tpl')) {
	$this->data['template_affiliate_tracking'] = true;
	}else{
	$this->data['template_affiliate_tracking'] = false;
	}
	$this->data['affiliate_transaction'] = $this->url->link('affiliate/transaction');
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/transaction.tpl')) {
	$this->data['template_affiliate_transaction'] = true;
	}else{
	$this->data['template_affiliate_transaction'] = false;
	}

	//Mail
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/order.tpl')) {
	$this->data['template_mail_order'] = true;
	}else{
	$this->data['template_mail_order'] = false;
	}
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/voucher.tpl')) {
	$this->data['template_mail_voucher'] = true;
	}else{
	$this->data['template_mail_voucher'] = false;
	}
	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/analytics/theme.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/analytics/theme.tpl';
	} else {
	$this->template = 'default/template/analytics/theme.tpl';
	}
	
	//Module
	$this->data['module'] = array();
	$dir    = DIR_TEMPLATE . 'default/template/module';
	$modules = scandir($dir, 1);
	foreach($modules as $module) {
	if(strpos($module, '.tpl')){
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $module)) {
	$module_template = true;
	}else{
	$module_template = false;
	}
	
	$this->data['modules'][] = array(
	'name' => substr($module, 0, -4),
	'template' => $module_template
	);
	}
	}
	
	//Other
	$this->data['others'] = array();
	$dir    = DIR_TEMPLATE . 'default/template';
	$others = scandir($dir, 1);
	
	$default = array('account', 'affiliate', 'checkout', 'common', 'error', 'information', 'mail', 'module', 'payment', 'product');
	foreach($others as $other) {
	if(!in_array($other, $default)){
	$dir    = DIR_TEMPLATE . 'default/template/'.$other;
	$other_extensions = scandir($dir, 1);
	foreach($other_extensions as $other_extension) {
	if(strpos($other_extension, '.tpl')){
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/'.$other.'/' . $other_extension)) {
	$other_extension_template = true;
	}else{
	$other_extension_template = false;
	}
	
	$this->data['others'][$other][] = array(
	'name' => substr($other_extension, 0, -4),
	'template' => $other_extension_template
	);
	}
	}
	
	
	}
	}
	
	
	$this->children = array(
	'common/column_left',
	'common/column_right',
	'common/content_top',
	'common/content_bottom',
	'common/footer',
	'common/header'
	);
	
	$this->response->setOutput($this->render());
	}
}
?>